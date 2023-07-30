<?php

namespace App\Services;

use App\Services\AimlService;
use App\Services\AimlStrService;
use App\Models\Conversation;
use App\Models\ConversationProperty;
use App\Models\MissingQuestion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AimlParserService
{
    static private $_responseData = array();

    static protected $aimlDom;
    static protected $aimlDomX;
    protected $conversation;
    protected $input;
    protected $user;
    protected $turn;

    function __construct($user)
    {
        $this->conversation = Conversation::where('user_id', $user)->latest('id')->first();
        $this->user = $user;

        self::$aimlDom = new \DOMDocument();
        self::$aimlDom->preserveWhiteSpace = false;
        self::$aimlDom->loadXML(file_get_contents(Storage::path('chatbot.aiml')));
        self::$aimlDomX = new \DomXPath(self::$aimlDom);
        self::$aimlDom = self::includeMerge(self::$aimlDom);
    }

    function Parse($input)
    {
        $clean_input = AimlStrService::cleanUpPattern($input);
        $this->input = $clean_input;
        $this->turn = AimlService::initTurn($this->conversation, $this->input);

        $responseString = self::getResponseString($this->input);
        $this->turn->update(['output' => $responseString]);
        return $responseString;
    }

    private function includeMerge($domDoc)
    {
        $xpathQuery = '//include';
        $includeDomDocs = array();
        // get inlude nodes
        foreach (self::$aimlDomX->query($xpathQuery, $domDoc) as $includeNode) {
            if ($includeNode->hasAttributes()) {
                foreach ($includeNode->attributes as $attr) {
                    switch ($attr->nodeName) {
                        case 'file':
                            $fileFullName = Storage::path($attr->nodeValue);
                            if (!file_exists($fileFullName))
                                throw new \Exception("Include file AIML not found in : " . $fileFullName);

                            $aimlString = file_get_contents($fileFullName);
                            $includeDoc = new \DOMDocument;
                            $includeDoc->loadXML($aimlString);
                            $includeDomDocs[] = $includeDoc;
                            break;
                    }
                }
            }
        }

        foreach ($includeDomDocs as $includeDoc) {
            $includeTags = array('category', 'topic');
            $domXPath = new \DomXPath($includeDoc);

            foreach ($includeTags as $tag) {
                foreach ($domXPath->query('/aiml/' . $tag, $includeDoc) as $node) {
                    $node = $domDoc->importNode($node, true);
                    $domDoc->documentElement->appendChild($node);
                }
            }
        }

        return $domDoc;
    }

    private function getResponseString($input)
    {
        $responseString = "";
        $this->input = $input;

        $topic = $this->conversation->getTopic();
        if (isset($topic)) {
            $xpathQuery = "./aiml/topic[@name='" . $topic->value . "']";
            if ($oneTopic = self::$aimlDomX->query($xpathQuery, self::$aimlDom)->item(0)) {
                if ($category = self::searchCategory($oneTopic)) {
                    $responseString = self::processDomElement(
                        self::getAllTagsByName($category, './template', true)
                    );
                }
            }
        }

        if ($responseString == '') {
            if ($category = self::searchCategory(self::$aimlDomX->query("./aiml", self::$aimlDom)->item(0))) {
                $responseString = self::processDomElement(
                    self::getAllTagsByName($category, './template', true)
                );
            } else {
                //
                $xpathQuery = "./aiml/topic";
                foreach (self::$aimlDomX->query($xpathQuery, self::$aimlDom) as $oneTopic) {
                    if ($category = self::searchCategory($oneTopic)) {
                        $responseString = self::processDomElement(
                            self::getAllTagsByName($category, './template', true)
                        );
                        if ($responseString != "") {
                            break;
                        }
                    }
                }
            }
        }

        if ($responseString == "" && isset($topic)) {
            $xpathQuery = "./aiml/topic[@name='" . $topic->value . "']/default";
            if ($default = self::$aimlDomX->query($xpathQuery, self::$aimlDom)->item(0)) {
                $responseString = self::processDomElement($default);
            }
        }

        if ($responseString == "") {
            if ($default = self::$aimlDomX->query('./aiml/default', self::$aimlDom)->item(0)) {
                $responseString = self::processDomElement($default);
            } else {
                $responseString = "Belum ada topic yang cocok dan jawaban default dari bot.";
            }

            MissingQuestion::create([
                                'input' => $this->input,
                                'conversation_id' => $this->conversation->id,
                            ]);
        }

        return $responseString;
    }

    private function searchCategory($domNode)
    {
        if (!$categories = self::getAllTagsByName($domNode, './category')) {
            return false;
        }

        $result = null;
        $tmpCategories = [];
        foreach ($categories as $category) {
            if (self::CheckPattern($category)) {
                self::addTopicToData($domNode);
                array_push($tmpCategories, $category);
            }
        }
        $maxScore = -1;
        foreach ($tmpCategories as $tmpCategory) {
            $score = 0;
            $score += $tmpCategory->nodeValue[0]=='$' ? 100 : 0;
            $score += substr_count($tmpCategory->nodeValue, '#') * 6;
            $score += substr_count($tmpCategory->nodeValue, '_') * 5;
            $score += substr_count($tmpCategory->nodeValue, '^') * 2;
            $score += substr_count($tmpCategory->nodeValue, '*') * 1;
            if ($maxScore < $score) {
                $result = $tmpCategory;
                $maxScore = $score;
            }
        }

        if ($result){
            return $result;
        }

        return false;
    }

    private function CheckPattern($category)
    {
        $patterns = self::getAllTagsByName($category, './pattern');
        $template = self::getAllTagsByName($category, './template', true);

        foreach ($patterns as $pattern) {
            if (self::ValidatePattern($this->input, $pattern->nodeValue, $template)) {
                if ($that = self::getAllTagsByName($category, './that', true)) {
                    $c_that = $this->conversation->getThat()->output;
                    if ($c_that != '') {
                        return self::ValidatePattern($c_that, $that->nodeValue, $template);
                    }
                    return false;
                } else {
                    return true;
                }
            }
        }
        return false;
    }

    private function ValidatePattern($input, $pattern, $template)
    {
        $input = trim($input);
        $input = strtolower($input);
        $input = AimlStrService::cleanUpPattern($input);

        $is_star = str_contains($pattern, '*');
        $pattern = trim($pattern);
        $pattern = strtolower($pattern);
        $pattern = str_replace(' * ', 'SpaceStarSpace', $pattern);
        $pattern = str_replace('* ', 'StarSpace', $pattern);
        $pattern = str_replace(' *', 'SpaceStar', $pattern);
        $pattern = str_replace('*', 'Star', $pattern);
        $pattern = str_replace(' # ', 'SpaceWellSpace', $pattern);
        $pattern = str_replace(' #', 'SpaceWell', $pattern);
        $pattern = str_replace('# ', 'WellSpace', $pattern);
        $pattern = str_replace('#', 'Well', $pattern);
        $pattern = str_replace(' _ ', 'SpaceLineSpace', $pattern);
        $pattern = str_replace('_ ', 'LineSpace', $pattern);
        $pattern = str_replace(' _', 'SpaceLine', $pattern);
        $pattern = str_replace('_', 'Line', $pattern);
        $pattern = str_replace(' ^ ', 'SpaceCaretSpace', $pattern);
        $pattern = str_replace('^ ', 'CaretSpace', $pattern);
        $pattern = str_replace(' ^', 'SpaceCaret', $pattern);
        $pattern = str_replace('^', 'Caret', $pattern);
        $pattern = str_replace('$', '', $pattern);
        $pattern = AimlStrService::cleanUpPattern($pattern);

        $pattern = str_replace('SpaceStarSpace', '(.+)', $pattern);
        $pattern = str_replace('StarSpace', '(.+)', $pattern);
        $pattern = str_replace('SpaceStar', '(.+)', $pattern);
        $pattern = str_replace('Star', '(.+)', $pattern);
        $pattern = str_replace('SpaceWellSpace', '(.*)?', $pattern);
        $pattern = str_replace('SpaceWell', '(.*)?', $pattern);
        $pattern = str_replace('WellSpace', '(.*)?', $pattern);
        $pattern = str_replace('Well', '(.*)?', $pattern);
        $pattern = str_replace('SpaceLineSpace', '(.+)', $pattern);
        $pattern = str_replace('LineSpace', '(.+)', $pattern);
        $pattern = str_replace('SpaceLine', '(.+)', $pattern);
        $pattern = str_replace('Line', '(.+)', $pattern);
        $pattern = str_replace('SpaceCaretSpace', '(.*)?', $pattern);
        $pattern = str_replace('CaretSpace', '(.*)?', $pattern);
        $pattern = str_replace('SpaceCaret', '(.*)?', $pattern);
        $pattern = str_replace('Caret', '(.*)?', $pattern);

        $regex = '/^' . $pattern . '$/i';
        $is_match = preg_match($regex, $input, $matches) ? true : false;
        if (count($matches) > 1 && $is_star) {
            foreach($matches as $match){
                if ($match != $input) {
                    $this->conversation->setVar('star', $match);
                }
            }
            self::compileStar($template);
        }

        return $is_match;
    }

    private function addTopicToData($node)
    {
        $topic = $this->conversation->getVar('topic');

        if ($node->nodeName == 'topic' &&
                $topic == '' && $topic->value != $node->getAttribute('name')) {
            $this->conversation->setVar('topic', $node->getAttribute('name'));
        }
        return;
    }

    public function processDomElement($template)
    {
        self::compileThink($template);
        self::compileSystem($template);
        self::compileSrai($template);
        self::compileRandom($template);
        self::compileInput($template);
        self::compileStar($template);
        self::compileSet($template);
        self::compileGet($template);
        self::compileUser($template);
        self::compileBot($template);
        self::compileCondition($template);
        self::compileLowercase($template);
        self::compileUppercase($template);
        self::compileDel($template);

        return (string)$template->nodeValue;
    }

    private function compileThink($node)
    {
        if ($thinkNodes = self::getAllTagsByName($node, './think')) {
            foreach ($thinkNodes as $think) {
                self::processDomElement($think);
                $node->removeChild($think);
            }
        }
    }

    private function compileSystem($node)
    {
        if ($SytemNodes = self::getAllTagsByName($node, './system')) {
            foreach ($SytemNodes as $system) {
                $output = eval(self::processDomElement($system));
                $newNode = self::$aimlDom->createTextNode(strval($output));
                $node->replaceChild($newNode, $system);
            }
        }
    }

    private function compileSrai($node)
    {
        if ($srais = self::getAllTagsByName($node, './srai')) {
            foreach ($srais as $srai) {
                AimlService::initTurn($this->conversation, $this->input, 'srai');

                $newNode = self::$aimlDom->createTextNode(self::getResponseString(self::processDomElement($srai)));
                $node->replaceChild($newNode, $srai);
            }
        }
    }

    private function compileRandom($domNode)
    {
        if ($randomNodes = self::getAllTagsByName($domNode, './random')) {
            foreach ($randomNodes as $rNode) {
                if ($liNodes = self::getAllTagsByName($rNode, './li')) {
                    $lis = array();
                    foreach ($liNodes as $lNode) {
                        $lis[] = $lNode;
                    }

                    $selectedLi = $lis[array_rand($lis, 1)];
                    foreach ($lis as $lnode){
                        if (!$lnode->isSameNode($selectedLi)){
                            $rNode->removeChild($lnode);
                        }
                    }

                    $domNode->replaceChild(
                        self::$aimlDom->createTextNode(self::processDomElement($selectedLi)),
                        $rNode
                    );

                }
            }
        }
    }

    private function compileInput($node)
    {
        if ($inputs = self::getAllTagsByName($node, './input')) {
            foreach ($inputs as $inputNode) {
                $index = 0;
                if ($inputNode->hasAttributes() && $inputNode->getAttribute('index') != '') {
                    $index = intval($inputNode->getAttribute('index'));
                    $index--;
                }

                $value = $this->conversation->getInput($index);
                $node->replaceChild(self::$aimlDom->createTextNode($value), $inputNode);
            }
        }
    }

    private function compileStar($templateNode)
    {
        if ($stars = self::getAllTagsByName($templateNode, './star')) {
            foreach ($stars as $starNode) {
                $index = 0;
                if ($starNode->getAttribute('index') != '') {
                    $index = count($stars) - intval($starNode->getAttribute('index'));
                }

                $value = $this->conversation->getVar('star', $index);
                if ($value == false) {
                    $value = '';
                }

                $starNode->parentNode->replaceChild(self::$aimlDom->createTextNode($value), $starNode);
            }
        }
    }

    private function compileSet($node)
    {
        if ($sets = self::getAllTagsByName($node, 'set')) {
            foreach ($sets as $setNode) {
                $type = $setNode->getAttribute('type');
                $name = $setNode->getAttribute('name');
                $attributeValue = $setNode->getAttribute('value');
                $nodeValue = self::processDomElement($setNode);
                $value = $attributeValue != '' ? $attributeValue : ($nodeValue != '' ? $nodeValue : '');

                if ($name != "" && $type != '' && $value != '') {
                    $this->conversation->setVar($type . " - " . $name, $value);
                } else if ($name != "" && $value != '') {
                    $this->conversation->setVar($name, $value);
                }

                $node->replaceChild(self::$aimlDom->createTextNode($value), $setNode);
            }
        }
    }

    private function compileGet($node)
    {
        if ($gets = self::getAllTagsByName($node, 'get')) {
            foreach ($gets as $getNode) {
                $type = $getNode->getAttribute('type');
                $name = $getNode->getAttribute('name');
                $res = '';

                if ($name != "" && $type != '') {
                    $res = $this->conversation->getVar($type . " - " . $name);
                } else if ($name != "") {
                    $res = $this->conversation->getVar($name);
                }

                $node->replaceChild(self::$aimlDom->createTextNode($res), $getNode);
            }
        }
    }

    private function compileUser($node)
    {
        if ($users = self::getAllTagsByName($node, 'user')) {
            foreach ($users as $userNode) {
                $name = $userNode->getAttribute('name');
                $attributeValue = $userNode->getAttribute('value');
                $nodeValue = self::processDomElement($userNode);
                $value = $attributeValue != '' ? $attributeValue : ($nodeValue != '' ? $nodeValue : '');
                $res = '';
                if ($name != "") {
                    if ($value == '') {
                        $res = $this->conversation->getVar("user - ".$name);
                    } else {
                        $this->conversation->setVar("user - ".$name, $value);
                        $res = $value;
                    }
                }

                $node->replaceChild(self::$aimlDom->createTextNode($res), $userNode);
            }
        }
    }

    private function compileBot($node)
    {
        if ($bots = self::getAllTagsByName($node, 'bot')) {
            foreach ($bots as $botNode) {
                $name = $botNode->getAttribute('name');
                $attributeValue = $botNode->getAttribute('value');
                $nodeValue = self::processDomElement($botNode);
                $value = $attributeValue != '' ? $attributeValue : ($nodeValue != '' ? $nodeValue : '');
                $res = '';

                if ($name != "") {
                    if ($value == '') {
                        $res = $this->conversation->getVar("bot - ".$name);
                    } else {
                        $this->conversation->setVar("bot - ".$name, $value);
                        $res = $value;
                    }
                }

                $node->replaceChild(self::$aimlDom->createTextNode($res), $botNode);
            }
        }
    }

    private function compileCondition($node)
    {
        if ($conditions = self::getAllTagsByName($node, './condition')) {
            foreach ($conditions as $condition) {
                $res = "";
                $type = $condition->getAttribute('type');
                $name = $condition->getAttribute('name');
                $valueInCondition = $condition->getAttribute('value');
                $lis = self::getAllTagsByName($condition, 'li');


                if ($name == '' || ($lis == false && $valueInCondition == '')) {
                    continue;
                } else if ($valueInCondition != '' && $lis == false) {
                    if ($type == "user" && $this->conversation->getVar("user - ".$name) == $valueInCondition) {
                        $res = self::processDomElement($condition);
                    } else if ($type == "bot" && $this->conversation->getVar("bot - ".$name) == $valueInCondition) {
                        $res = self::processDomElement($condition);
                    } else if ($this->conversation->getVar($name) == $valueInCondition){
                        $res = self::processDomElement($condition);
                    }
                } else if ($valueInCondition == '' && $lis != false) {
                    foreach ($lis as $li_1) {
                        $lisForRandom = array();
                        $valueInLi = $li_1->getAttribute('value');
                        if ($valueInLi != '') {
                            if ($type == "user" && $this->conversation->getVar("user - ".$name) == $valueInLi) {
                                $res = self::processDomElement($condition);
                                break;
                            } else if ($type == "bot" && $this->conversation->getVar("bot - ".$name) == $valueInLi) {
                                $res = self::processDomElement($condition);
                                break;
                            } else if ($this->conversation->getVar($name) == $valueInLi){
                                $res = self::processDomElement($condition);
                                break;
                            }
                        } else {
                            $lisForRandom[] = $li_1;
                        }
                        if ($res == '') {
                            $selectedLi = $lisForRandom[array_rand($lisForRandom, 1)];
                            $res = self::processDomElement($selectedLi);
                        }
                    }
                }
                $newNode = self::$aimlDom->createTextNode($res);
                $node->replaceChild($newNode, $condition);
            }
        }
    }

    private function compileLowercase($node)
    {
        if ($lowers = self::getAllTagsByName($node, './lowercase')) {
            foreach ($lowers as $lowerTag) {
                $newNode = self::$aimlDom->createTextNode(
                    strtolower(
                        self::processDomElement($lowerTag)
                    )
                );

                $node->replaceChild($newNode, $lowerTag);
            }
        }
    }

    private function compileUppercase($node)
    {
        if ($uppers = self::getAllTagsByName($node, './uppercase')) {
            foreach ($uppers as $upperTag) {
                $newNode = self::$aimlDom->createTextNode(
                    strtoupper(
                        self::processDomElement($upperTag)
                    )
                );

                $node->replaceChild($newNode, $upperTag);
            }
        }
    }

    private function compileDel($node)
    {
        if ($dels = self::getAllTagsByName($node, 'del')) {
            foreach ($dels as $delNode) {
                $type = $delNode->getAttribute('type');
                $name = $delNode->getAttribute('name');

                if ($name != "" && $type != '') {
                    $res = $this->conversation->getVar($type." - ".$name);
                    $this->conversation->delVar($type." - ".$name);
                } else if ($name != "") {
                    $res = $this->conversation->getVar($name);
                    $this->conversation->delVar($name);
                }
                $node->replaceChild(self::$aimlDom->createTextNode($res), $delNode);
            }
        }
    }

    private function getAllTagsByName($domNode, $tagName, $getOne = false)
    {
        $arrResponse = array();
        foreach (self::$aimlDomX->query($tagName, $domNode) as $node) {
            $arrResponse[] = $node;
        }

        if(count($arrResponse) > 0){
            return $getOne ? $arrResponse[0] : $arrResponse;
        } else {
            return false;
        }
    }
}
