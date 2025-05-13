<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UserNotification extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   */
  public function __construct()
  {
    //
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['broadcast'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toBroadcast(object $notifiable): BroadcastMessage
  {
    return (new BroadcastMessage([
      'message' => 'Hello from the notification',
      'user' => $notifiable,
      'sentFrom' => Auth::user()
    ]));
  }

  public function broadcastType()
  {
    return 'user.created';
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }
}
