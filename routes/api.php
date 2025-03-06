<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ChurchController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\ScopeBouncer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Illuminate\Support\Facades\Broadcast;



Route::prefix('v1')->middleware([
    InitializeTenancyByDomain::class,
])->group(function () {

    Route::middleware([
        ScopeBouncer::class,
        'auth:sanctum'
    ])
    ->group(function () {
        Route::resource("/members", MemberController::class);
        Route::resource("/events", EventController::class);
        Route::resource("/churches", ChurchController::class);
        Route::post("/chats/{chat}/message", [ChatController::class, 'saveChatMessage'])->name('chats.message');
        Route::resource("/chats", ChatController::class);
        Route::resource("/users", UserController::class);
        Route::get("/user", function (Request $request) {
            $user = User::first();
            $user->load("churches");
            return response()->json(compact("user"));
        });

        Route::post('/broadcasting/auth', function(Request $request) {
            if ($request->hasSession()) {
                $request->session()->reflash();
            }
            return Broadcast::auth($request);
        });
    });

    Route::post('/login', [AuthController::class, 'store']);
    Route::get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show'])->name('sanctum.csrf-cookie');
});
