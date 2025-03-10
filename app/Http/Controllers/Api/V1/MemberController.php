<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::with(['churches', 'location']);
        if ($request->has('q')) {
            $search = $request->q;
            $members = $members->where(function ($query) use ($search) {
                $query
                    ->whereLike('first_name', '%'.$search.'%')
                    ->orWhereLike('last_name', '%'.$search.'%')
                    ->orWhereLike('email', '%'.$search.'%');
            });
        }

        // Filter by church_id (if provided)
        if ($request->has('church_id')) {
            $churchId = $request->church_id;
            $members = $members->whereHas('churches', function ($query) use (
                $churchId
            ) {
                $query->where('churches.id', $churchId);
            });
        }

        $members = $members->paginate(50);

        return MemberResource::collection($members);
    }
}
