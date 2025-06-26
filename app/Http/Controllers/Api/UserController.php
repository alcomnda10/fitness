<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        return response()->json(Auth::user());
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'string|max:255',
            'email'    => 'email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string',
            'location' => 'nullable|string',
            'bio'      => 'nullable|string',
            'avatar'   => 'nullable|url',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'location', 'bio', 'avatar'
        ]));

        return response()->json($user);
    }
}
