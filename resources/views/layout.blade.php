<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="mx-auto container">
    <div class="mb-3 bg-gray-200 p-2">
      @if(auth()->check())
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
        <a href="{{ route('home') }}" class="text-blue-500">Home</a>
        <a href="{{ route('chat') }}" class="text-blue-500">Go to chat</a>
      </div>
      @else
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">Guest</h2>
      </div>
      @endif
    </div>
    @yield('content')
  </div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>
</html>
