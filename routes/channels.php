<?php

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat', function ($user) {
    return auth()->check(); // Ensure user is authenticated
});

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return $user->chats()->where('chats.id', $chatId)->exists();
});

