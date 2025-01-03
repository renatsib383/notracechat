<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class ChatController extends Controller
{
    public function index($room_hash)
    {
        return Inertia::render('Chat', [
            'room_hash' => $room_hash,
        ]);
    }
}
