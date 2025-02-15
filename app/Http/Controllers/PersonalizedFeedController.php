<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\UserPreference;
use App\Models\User;

class PersonalizedFeedController extends Controller
{
    public function index()
    {
        $user = User::find(2);
        $preferences['source'] = UserPreference::get('preferred_sources')->where('user_id',$user->id);
        $preferences['category'] = UserPreference::get('preferred_categories')->where('user_id',$user->id);
        $query = Article::query();

        if ($preferences) {
            if ($preferences['source']) {
                $query->whereIn('source', $preferences['source']);
            }
            if ($preferences['category']) {
                // Assuming articles have categories
                $query->whereIn('category', $preferences['category']);
            }
        }

        return response()->json($query->paginate(20));
    }
}
