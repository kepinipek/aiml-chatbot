<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMissingQuestionRequest;
use App\Http\Requests\UpdateMissingQuestionRequest;
use App\Models\MissingQuestion;

class MissingQuestionController extends Controller
{

    public function index()
    {
        $missingQuestions = MissingQuestion::latest()
                        ->search(request(['q']))
                        ->paginate(10)
                        ->withQueryString();

        return view('missing-questions.index', compact('missingQuestions'));
    }

    public function show(MissingQuestion $missingQuestion)
    {
        //
    }

    public function destroy(MissingQuestion $missingQuestion)
    {
        $missingQuestion->update(['status' => true]);

        return redirect()->route('missing-questions.index')->with('success','Status telah berhasil diubah.');
    }
}
