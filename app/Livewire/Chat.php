<?php

namespace App\Livewire;

use App\Events\Chat as ChatEvent;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
  public $message;

  public function render()
  {
    // dump('view loaded');
    return view('livewire.chat');
  }

  public function send()
  {
    // broadcast(new ChatEvent($this->message));
    ChatEvent::dispatch($this->message);
    $this->message = '';
    $this->skipRender();
  }

  // #[On('echo:chat,.message_sent')]
  // public function echoEvent()
  // {
  //   dd('listening');
  // }
}
