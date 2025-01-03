<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{room_hash}', function ($user, $room_hash) {
    return ['id' => $user->id, 'name' => $user->name];
});
