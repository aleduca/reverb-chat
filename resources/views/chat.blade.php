@extends('layout')

@section('content')

<h2>Chat</h2>
<div>
  <div class="w-full p-2 border border-gray-300 rounded messages-sent h-28 bg-gray-100 scroll-smooth md:scroll-auto overflow-auto"></div>
  <form @submit.prevent="send" id="chat-form" class="chat-messages mt-2" x-data="{
    message:'',
    loading: false,
    typingTimeout: null,
    users:[],
    init(){
      window.Echo.join('chat')
      .here((users) => {
        this.users = users;
        console.log('total users ',users);
      })
      .joining((user) => {
          this.users.push(user);
          console.log('joining '+user.name);
      })
      .leaving((user) => {
          {{-- this.users = this.users.filter(u => u.id !== user.id); --}}
          this.users.splice(this.users.indexOf(user),1);
          console.log('leaving '+user.name);
      })
      .error((error) => {
          console.error(error);
      }).listen('Chat', (e) => {
        let messageElement = document.createElement('span');
        messageElement.className = 'p-2 bg-gray-200 block my-2';
        messageElement.innerHTML = `<strong>${e.user.name} disse:</strong> ${e.message}`;
        const messages = document.querySelector('.messages-sent');
        messages.append(messageElement);
        messages.scrollTop = messages.scrollHeight;
        this.loading = false;
      });

      window.Echo.private('chat').listenForWhisper('typing', (e) => {
       document.getElementById('typing').innerHTML = `<strong>${e.name}</strong> está digitando...`
      })

      window.Echo.private('chat').listenForWhisper('stopTyping', (e) => {
       document.getElementById('typing').innerHTML ='';
      })
    },
    typing(){
      window.Echo.private('chat').whisper('typing', {
        'name': `{{ auth()->user()->name }}`
      });

      if(this.typingTimeout){
        clearTimeout(this.typingTimeout);
        this.typingTimeout = null;
      }

      this.typingTimeout = setTimeout(() => {
        window.Echo.private('chat').whisper('stopTyping');
      }, 1000)
    },
    send(){
      this.loading = true;
      fetch('chat', {
        method: 'POST'
        , headers: {
          'Content-Type': 'application/json'
          , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        , body: JSON.stringify({
          message: this.message
        })
      }).then(response => response.json())
      .then(data => {
        this.message = '';
      }).catch((error) =>{
        console.log('error', error);
        this.loading = false;
      });
    }
  }">
    <span class="text-sm text-gray-500 mr-2">Online Users: <small x-text="users.length" class="text-green-400 font-bold"></small></span>
    <ul>
      <template x-for="user in users" :key="user.id">
        <li x-text="user.name"></li>
      </template>
    </ul>
    <template x-if="loading">
      <div class="p-2 bg-gray-200 rounded my-2 flex items-center justify-items-start">
        <strong>Enviando...</strong>
        <x-loading />
      </div>
    </template>
    <div id="typing"></div>
    <input type="text" @keydown.throttle.300ms="typing" x-model="message" placeholder="Type your message..." class="w-full p-2 border border-gray-300 rounded" />
    <button type="submit" class="bg-red-800 rounded cursor-pointer p-1 text-white hover:bg-red-700 mt-2">Send</button>
  </form>
</div>

@endsection
