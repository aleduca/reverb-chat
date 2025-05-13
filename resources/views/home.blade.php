@extends('layout')

@section('content')

<h2 class="mb-1">Send Notification to the user</h2>
<div x-data="{
  selectedUser:null,
  init(){
    window.Echo.private(`notificate.{{ auth()->id() }}`).notification((e) => {
      if(e.type === 'user.created'){
         Toastify({
                text:'Notificação recebida de '+e.sentFrom.name,
                duration:3000
               }).showToast()
      }
    })
  },
  sendNotification(){
    if(!this.selectedUser){
      alert('Please select an user');
      return false;
    }
    fetch('notificate', {
        method: 'POST'
        , headers: {
          'Content-Type': 'application/json'
          , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        , body: JSON.stringify({
          selectedUser: this.selectedUser
        })
      }).then(response => response.json())
      .then(data => {
        console.log(data);
        this.selectedUser = null;
      }).catch((error) =>{
        console.log('error', error);
        this.loading = false;
      });

  }
}">
  <span x-text="selectedUser"></span>
  <select name="user" id="user" x-model="selectedUser" class="mb-2">
    <option value="">Select User</option>
    @foreach($users as $user)
    @if(auth()->id() !== $user->id)
    <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endif
    @endforeach
  </select>
  <hr>
  <button @click="sendNotification" class="p-1 rounded text-white text-sm flex items-center border-1 mt-2" :class="selectedUser ? 'cursor-pointer bg-red-500 border-red-800' : 'cursor-not-allowed bg-gray-300 border-gray-500'">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
      <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
    </svg>

    Send Notification
  </button>

</div>
@endsection
