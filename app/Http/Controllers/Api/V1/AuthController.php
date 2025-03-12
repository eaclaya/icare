<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserLoginResource;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (! auth()->attempt($request->only('email', 'password'))) {
            return response()->json(
                [
                    'message' => 'Invalid login details',
                ],
                401
            );
        }

        $user = auth()->user()->load('member', 'affiliates');

        if ($user->affiliates->isEmpty()) {
            return response()->json(
                [
                    'message' => 'You are not assigned to any affiliate. Please contact support',
                ],
                401
            );
        }

        return response()->json([
            'user' => new UserLoginResource($user)
        ]);

    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', Password::default()],
            'token' => ['required', 'exists:invitations,token']
        ]);

        $invitation = Invitation::where('token', $request->token)->firstOrFail();

        if (now()->greaterThan($invitation->expires_at)) {
            return response()->json(['message' => 'Invitation expired'], 400);
        }

        User::create($request->validated());

        $user = auth()->user()->load('member');

        return response()->json(compact('user'));

    }
}
