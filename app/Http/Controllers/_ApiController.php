<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Str;
class ApiController extends Controller
{

    public function login(LoginRequest $request): RedirectResponse
    {

        $user = User::where('telegram_id', $request->telegram_id)->first();

        if (!$user) {

            $user = User::create([$request->all()]);

            event(new Registered($user));
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function createRoom(Request $request)
    {

        $room = Room::create([
            ...$request->all(),
            'hash' => Str::uuid()->toString(),
        ]);
        return redirect()->route('dashboard');
    }
}
