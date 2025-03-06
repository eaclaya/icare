<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "email"=> "required",
            "password"=> "required",
        ]);

        if (!auth()->attempt($request->only("email", "password"))) {
            return response()->json(
                [
                    "message" => "Invalid login details",
                ],
                401
            );
        }
        // $request->session()->regenerate();

        return ["user" => auth()->user()];

    }
}
