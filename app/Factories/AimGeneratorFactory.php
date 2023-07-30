<?php

namespace App\Factories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class AimGeneratorFactory
{
    public static function RegenerateAiml()
    {
        try{
            if(Storage::exists('chatbot.aiml')){
                Storage::delete('chatbot.aiml');
            }

            $categoriesArr = Category::selectRaw('pattern, topic, that, template')->orderBy('id')->get()->toArray();
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><aiml version="1.0"></aiml>');
            foreach ($categoriesArr as $index => $category) {
                if ($category['topic']!='') {
                    $subnode = $xml->addChild('topic');
                    $subnode->addAttribute('name', $category['topic']);
                    $subnode = $subnode->addChild('category');
                } else {
                    $subnode = $xml->addChild('category');
                }
                $subnode->addChild('pattern', $category['pattern']);
                if ($category['that']!='') {
                    $subnode->addChild('that', $category['that']);
                }
                $subnode->addChild('template', $category['template']);
            }

            $stringXml = $xml->asXML();
            $stringXml = str_replace("&gt;", ">", $stringXml);
            $stringXml = str_replace("&lt;", "<", $stringXml);
            $stringXml = str_replace("</aiml", "\n</aiml", $stringXml);
            $stringXml = str_replace("<topic", "\n\n\t<topic", $stringXml);
            $stringXml = str_replace("<category", "\n\n\t<category", $stringXml);
            $stringXml = str_replace("<pattern", "\n\t\t<pattern", $stringXml);
            $stringXml = str_replace("<template", "\n\t\t<template", $stringXml);
            $stringXml = str_replace("</category", "\n\t</category", $stringXml);
            $stringXml = str_replace("</topic", "\n\t</topic", $stringXml);
            $stringXml = str_replace("<random", "\n\t\t\t<random", $stringXml);
            $stringXml = str_replace("<that", "\n\t\t<that", $stringXml);
            $stringXml = str_replace("</random>", "\n\t\t\t</random>", $stringXml);
            $stringXml = str_replace("</random></template>", "</random>\n\t\t</template>", $stringXml);
            $stringXml = str_replace("<li", "\n\t\t\t\t<li", $stringXml);

            $aiml = <<<XML
            $stringXml
            XML;

            Storage::put('chatbot.aiml', $aiml);
        } catch (\Exception $e) {
            return false;
        }
        return true;

    }
}