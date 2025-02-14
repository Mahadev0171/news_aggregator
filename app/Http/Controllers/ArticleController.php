<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Search by keyword, category, and source
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('source')) {
            $query->where('source_name', $request->source);
        }

        if ($request->has('date')) {
            $query->whereDate('published_at', $request->date);
        }

        return response()->json($query->paginate(20));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }
}
