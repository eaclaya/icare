<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BroadcastController;
use App\Http\Controllers\Api\V1\ChurchController;
use App\Http\Controllers\Api\V1\CommunityController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\MemberPermission;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\InvitationController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;

Route::prefix('v1')->group(function () {

    Route::middleware([
        InitializeTenancyByRequestData::class,
        'auth:sanctum',
    ])
        ->group(function () {
            Route::resource('/members', MemberController::class);
            Route::resource('/events', EventController::class);
            Route::get('/churches/{church}/invite', [ChurchController::class, 'invite'])->name('churches.invite');
            Route::resource('/churches', ChurchController::class);
            Route::resource('/communities', CommunityController::class);
            Route::resource('invitations', InvitationController::class);
            Route::post('/chats/{chat}/message', [ChatController::class, 'saveChatMessage'])->name('chats.message');
            Route::resource('/chats', ChatController::class);
            Route::resource('/users', UserController::class);
            Route::resource('/member-permissions', MemberPermission::class);
            Route::post('/broadcasting/auth', [BroadcastController::class, 'store'])->name('broadcasting.auth');
        });

    Route::post('/login', [AuthController::class, 'store']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show'])->name('sanctum.csrf-cookie');
});
