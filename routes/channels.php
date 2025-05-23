<?php

use App\Broadcasting\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//   return (int) $user->id === (int) $id;
// });

Broadcast::channel('notificate.{id}', function ($user, $id) {
  return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', Chat::class);
