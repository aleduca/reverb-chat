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
      Olá {{ auth()->user()->name }}
      @else
      Olá Visitante.
      @endif
    </div>
    @yield('content')
  </div>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>
</html>
