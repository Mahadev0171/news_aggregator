<?php

namespace App\Http\Controllers;

use App\Models\UserPreference;
use App\Models\User;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    public function update(Request $request)
    {
        $preferences = UserPreference::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'preferred_sources' => json_encode($request->preferred_sources),
                'preferred_categories' => json_encode($request->preferred_categories),
            ]
        );

        return response()->json($preferences);
    }

    public function show()
    {
        $user = User::find(2);
        $preferences = UserPreference::get()->where('user_id',$user->id);
        return response()->json($preferences);
    }
}
