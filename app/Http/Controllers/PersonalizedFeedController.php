<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserPreference;

class PersonalizedFeedController extends Controller
{
    public function index()
    {
        $preferences = auth()->user()->preferences;
        $query = Article::query();

        if ($preferences) {
            if ($preferences->preferred_sources) {
                $query->whereIn('source_name', $preferences->preferred_sources);
            }
            if ($preferences->preferred_categories) {
                // Assuming articles have categories
                $query->whereIn('category', $preferences->preferred_categories);
            }
        }

        return response()->json($query->paginate(20));
    }
}
