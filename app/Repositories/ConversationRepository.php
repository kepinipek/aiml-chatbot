<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ConversationRepository extends BaseRepository
{
    public function model()
    {
        return Conversation::class;
    }
}
