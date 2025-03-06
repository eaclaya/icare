<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Http\Requests\ChatMessageStoreRequest;
use App\Http\Requests\ChatStoreRequest;
use App\Http\Resources\ChatMessageResource;
use App\Http\Resources\ChatResource;
use App\Http\Requests\ChatUpdateRequest;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $chats = auth()
            ->user()
            ->chats()
            ->with(["users.profile"])
            ->paginate(20);

        return ChatResource::collection($chats);
    }

    public function store(ChatStoreRequest $request)
    {

        $chat = Chat::create($request->all());
        $users = array_unique([...$request->users, auth()->id()]);
        $chat->users()->attach($users);
        return new ChatResource($chat);
    }

    public function show(Chat $chat)
    {
        $messages = Message::with(['user.profile'])
            ->where('messageable_id', $chat->id)
            ->where('messageable_type', Chat::class)
            ->paginate(20);
        return ChatMessageResource::collection($messages);
    }

    public function update(ChatUpdateRequest $request, Chat $chat)
    {
        $chat->update($request->all());
    }

    public function saveChatMessage(ChatMessageStoreRequest $request, Chat $chat)
    {
        $data = [
            'user_id' => auth()->id(),
            ...$request->all()
        ];

        $message = $chat->messages()->create($data);

        $message->load(['user.profile']);

        broadcast(new NewChatMessage($message))->toOthers();

        return new ChatMessageResource($message);
    }
}
