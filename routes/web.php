<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use Inertia\Inertia;
use App\Http\Controllers\AppController;


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [AppController::class, 'index'])->name('dashboard');

    Route::get('/chat/{room_hash}', [AppController::class, 'chat'])->name('chat');
    Route::get('/newroom', [AppController::class, 'newRoom'])->name('room.new');
    Route::post('/save_room', [AppController::class, 'saveRoom'])->name('room.save');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Broadcast::routes(['middleware' => ['web', 'auth']]);

require __DIR__.'/auth.php';
