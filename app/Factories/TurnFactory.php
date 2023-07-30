<?php

namespace App\Factories;

use App\Models\Turn;


class TurnFactory
{
    public static function createTurn($conversation_id, $input, $source)
    {
        $turn = Turn::create([
            'conversation_id' => $conversation_id,
            'input' => $input,
            'source' => $source
        ]);
        return $turn;
    }
}
