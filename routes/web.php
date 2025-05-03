<?php

use App\Events\Chat;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/chat', function () {
  return view('chat');
});

Route::post('/chat', function () {
  broadcast(new Chat(request()->message));
  return response()->json(['status' => 'ok']);
})->name('chat');
