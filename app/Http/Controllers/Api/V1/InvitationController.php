<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationStoreRequest;
use App\Mail\InvitationMail;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function store(InvitationStoreRequest $request)
    {
        $modelClass = $request->invitable_type;
        $invitable = $modelClass::findOrFail($request->invitable_id);

        $invitation = Invitation::create([
            'invited_by' => auth()->id(),
            'token' => $request->token,
            'invitable_id' => $invitable->id,
            'invitable_type' => $modelClass,
        ]);

        $url = route('invitations.show', $invitation->token);

        // Mail::to($request->email)->send(new InvitationMail($invitation));

        return response()->json(['url' => $url]);
    }

    public function show($token)
    {
        $invitation = Invitation::with('invitable')->where('token', $token)->firstOrFail();

        if (now()->greaterThan($invitation->expires_at)) {
            return response()->json(['message' => 'Invitation expired'], 400);
        }

        return response()->json($invitation);
    }



}
