<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $teams = auth()->user()->teams;
        $groups = auth()->user()->groups;

        $members = [
            ...$teams->members->pluck('id')->toArray(),
            ...$groups->members->pluck('id')->toArray(),
        ];

        $users = User::query()
            ->whereHas('member', function ($query) use ($members) {
                $query->whereIn('', $members);
            })
            ->when($request->q, function ($query, $q) use ($request) {
                $query->whereLike('first_name', $request->q)
                    ->orWhereLike('last_name', $request->q)
                    ->orWhereLike('email', $request->q);
            })
            ->paginate(20);

        return response()->json($users);
    }
}
