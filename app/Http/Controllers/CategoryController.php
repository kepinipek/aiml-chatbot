<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\AimlStrService;
use App\Factories\AimGeneratorFactory;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()
                        ->search(request(['q']))
                        ->paginate(10)
                        ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            'pattern' => $request->pattern,
            'topic' => $request->topic,
            'that' => $request->that,
            'template' => $request->template,
        ]);

        AimGeneratorFactory::RegenerateAiml();
        return redirect()->route('categories.index')->with('success', 'Pengetahuan telah berhasil ditambah.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update([
            'pattern' => $request->pattern,
            'topic' => $request->topic,
            'that' => $request->that,
            'template' => $request->template,
        ]);

        AimGeneratorFactory::RegenerateAiml();
        return redirect()->route('categories.index')->with('success', 'Pengetahuan berhasil diperbaharui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        AimGeneratorFactory::RegenerateAiml();
        return redirect()->route('categories.index')->with('success', 'Pengetahuan telah berhasil dihapus.');
    }

    public function regenerate()
    {
        $success = AimGeneratorFactory::RegenerateAiml();
        if ($success){
            return redirect()->route('categories.index')->with('success', 'Berkas AIML telah berhasil diperbaharui silahkan mencoba.');
        } else {
            return redirect()->route('categories.index')->with('error', 'Terjadi kesalahan saat memperbaharui berkas, mohon dicoba kembali.');
        }
    }

    public function download()
    {
        $file = storage_path('app/chatbot.aiml');
        return Response::download($file, 'chatbot.aiml', ['Content-Type: text/xml']);
    }
}
