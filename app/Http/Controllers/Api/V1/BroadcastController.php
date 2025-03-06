<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class BroadcastController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasSession()) {
            $request->session()->reflash();
        }
        return Broadcast::auth($request);
    }
}
