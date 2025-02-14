<?php

namespace App\Http\Controllers;

use App\Models\UserPreference;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    public function update(Request $request)
    {
        $preferences = UserPreference::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'preferred_sources' => $request->preferred_sources,
                'preferred_categories' => $request->preferred_categories,
            ]
        );

        return response()->json($preferences);
    }

    public function show()
    {
        return response()->json(auth()->user()->preferences);
    }
}
