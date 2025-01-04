<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Room;

class AppController extends Controller
{
    public function index()
    {
        $myRooms = Room::where('owner', auth()->user()->id)->get();
        $suscribedRooms = auth()->user()->rooms;
        return Inertia::render('Dashboard', [
            'myRooms' => $myRooms,
            'suscribedRooms' => $suscribedRooms,
        ]);
    }

    public function chat($room_hash)
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

    public function saveRoom(Request $request)
    {

        $room = Room::create($request->all());
        return redirect()->route('dashboard');
    }
}
