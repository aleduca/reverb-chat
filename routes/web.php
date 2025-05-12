<?php

use App\Events\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/chat', function () {
  // Auth::loginUsingId(2);
  return view('chat');
});

Route::post('/chat', function () {
  broadcast(new Chat(request()->message, Auth::user()));
  return response()->json(['status' => 'ok']);
})->name('chat');
