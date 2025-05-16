<?php

use App\Events\Chat;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  // Auth::loginUsingId(2);
  return view('home', [
    'users' => User::all(),
  ]);
})->name('home');

Route::get('/chat', function () {
  // Auth::loginUsingId(2);
  return view('chat');
})->name('chat');

Route::post('/notificate', function () {
  $user = User::find(request()->selectedUser);
  $user->notify(new UserNotification);
  return response()->json(['user' => request()->selectedUser]);
});


Route::post('/chat', function () {
  broadcast(new Chat(request()->message, Auth::user()));
  return response()->json(['status' => 'ok']);
});
