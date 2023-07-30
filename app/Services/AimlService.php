<?php

namespace App\Services;

use App\Factories\TurnFactory;
use App\Services\AimlParserService;
use Auth;

class AimlService
{
    protected $parser;
    protected $user;

    function __construct()
    {
        $this->user = Auth::check() ? Auth::user()->id : ip2long(request()->ip());
        $this->parser = new AimlParserService($this->user);
    }

    function talk($userInput)
    {
        $response = $this->parser->Parse($userInput);
        return $response . "";
    }

    public function initTurn($conversation, $input, $source = 'human')
    {
        $turn = TurnFactory::createTurn($conversation->id, $input, $source);
        return $turn;
    }
}
