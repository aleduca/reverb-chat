@extends('layout')

@section('content')

<h2>Chat</h2>
<div>
  <div class="w-full p-2 border border-gray-300 rounded messages-sent h-28 bg-gray-100 scroll-smooth md:scroll-auto overflow-auto"></div>
  <form id="chat-form" class="chat-messages mt-2">
    <input type="text" id="message" placeholder="Type your message..." class="w-full p-2 border border-gray-300 rounded" />
    <button type="submit" class="bg-red-800 rounded cursor-pointer p-1 text-white hover:bg-red-700 mt-2">Send</button>
  </form>
</div>

<script>
  document.getElementById('chat-form').addEventListener('submit', function(event) {
    event.preventDefault();

    let message = document.getElementById('message').value;

    fetch('chat', {
        method: 'POST'
        , headers: {
          'Content-Type': 'application/json'
          , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        , body: JSON.stringify({
          message
        })
      }).then(response => response.json())
      .then(data => {
        document.getElementById('message').value = '';
      }).catch(error => console.log('error', error));
  });

  window.onload = function() {
    window.Echo.channel('chat').listen('.message_sent', function(e) {
      let messageElement = document.createElement('span');
      messageElement.className = 'p-2 bg-gray-200 block my-2';
      messageElement.innerHTML = `<strong>Enviado:</strong> ${e.message}`;
      const messages = document.querySelector('.messages-sent');
      messages.append(messageElement);
      messages.scrollTop = messages.scrollHeight;
    })
  }

</script>

@endsection
