<?php

namespace App\Http\Controllers;

use App\Factories\ConversationFactory;
use App\Models\Conversation;
use App\Repositories\ConversationRepository;
use Illuminate\Support\Facades\Storage;
use App\Factories\AimGeneratorFactory;
use Auth;
use Redirect;

class ConversationController extends Controller
{
    public function index()
    {
        $user = Auth::check() ? Auth::user()->id : ip2long(request()->ip());
        $conversation = ConversationFactory::storeOrGetConversation($user);
        return redirect()->route('conversations.show', $conversation->slug);
    }

    public function show($conversationSlug)
    {
        if (!Storage::exists('chatbot.aiml')){
            try {
                AimGeneratorFactory::RegenerateAiml();
            } catch (\Throwable $th) {
                return Redirect::back()->with('error','Chatbot belum tersedia mohon menghubungi admin untuk informasi lebih lanjut.');
            }
        }
        $repo = new ConversationRepository;
        $conversation = $repo->getBySlug($conversationSlug);
        $turns = $conversation->turns()->get();
        $user = Auth::check() ? Auth::user()->id : ip2long(request()->ip());
        $conversations = [];
        $latestConversationSlug = '';
        if ($conversation->user_id == $user) {
            $conversations = Conversation::where('user_id', $user)->latest('id')->get();
            $latestConversationSlug = $conversations->first()->slug;
        }

        return view('conversations.show')->with(compact('conversations', 'latestConversationSlug', 'conversation', 'turns'));
    }
}
