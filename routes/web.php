<?php

use App\Events\Chat;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::post('/chat', function () {
  broadcast(new Chat(request()->message));
  return response()->json(['status' => 'ok']);
})->name('chat');
