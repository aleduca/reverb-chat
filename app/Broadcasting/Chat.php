<?php

namespace App\Broadcasting;

use App\Models\User;

class Chat
{
  /**
   * Create a new channel instance.
   */
  public function __construct()
  {
    //
  }

  /**
   * Authenticate the user's access to the channel.
   */
  public function join(User $user): array|bool
  {
    if ($user !== null) {
      return ['id' => $user->id, 'name' => $user->name];
    }
  }
}
