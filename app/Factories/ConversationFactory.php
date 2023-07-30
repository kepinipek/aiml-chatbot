<?php

namespace App\Factories;

use App\Models\Conversation;

class ConversationFactory
{
    public static function storeOrGetConversation($user, $forceNew = true)
    {
        if (!$forceNew){
            $conversation = Conversation::where('user_id', $user)->latest('id')->first();
        } else {
            $conversation = Conversation::create([
                'user_id' => $user,
            ]);
        }

        return $conversation;
    }
}
