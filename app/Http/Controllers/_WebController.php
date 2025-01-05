<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Room;
use App\Models\User;
class WebController extends Controller
{
    public function dashboard()
    {
        
        $myRooms = Room::where('owner', auth()->user()->id)->get();
        $suscribedRooms = auth()->user()->rooms;
        return Inertia::render('Dashboard', [
            'myRooms' => $myRooms,
            'suscribedRooms' => $suscribedRooms,
        ]);
    }

    public function login(): Response
    {
        return Inertia::render('Login', [
            'status' => session('status'),
        ]);
    }

    public function chatRoom($room_hash)
    {
        $room = Room::where('hash', $room_hash)->first();
        if (!$room) {
            return redirect()->route('dashboard');
        }
        $user = auth()->user();
        if (!$room->users()->where('user_id', $user->id)->exists()) {
            $room->users()->attach($user->id);
        }
        return Inertia::render('Chat', [
            'room' => $room->load('users'),
        ]);
    }

    public function newRoom()
    {
        return Inertia::render('NewRoom');
    }


}
