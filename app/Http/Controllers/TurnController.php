<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Turn;
use App\Models\User;
use App\Http\Requests\StoreTurnRequest;
use App\Services\AimlService;
use Illuminate\Support\Facades\Storage;
use Redirect;

class TurnController extends Controller
{
    public function index()
    {
        $turns = Turn::All();
        return $turns;
    }

    public function store(StoreTurnRequest $request)
    {
        if (!Storage::exists('chatbot.aiml')){
            return Redirect::back()->with('error','Chatbot belum tersedia mohon menghubungi admin untuk informasi lebih lanjut.');
        }
        if (!empty($request->input('input'))) {
            $services = new AimlService;
            $services->talk($request->input('input'));

            return redirect()->route('conversations.show', $request->slug);
        }
        return Redirect::back()->with('error','Pertanyaan tidak boleh kosong/harus diisi.');
    }
}
