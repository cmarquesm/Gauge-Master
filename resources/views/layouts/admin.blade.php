<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gauge Master — Admin</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
  {{-- Bootstrap 5 for Tabs --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
  {{-- Topbar --}}
  <nav class="bg-white border-b px-6 py-4 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-3">
        <a href="{{ route('main') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('images/LOGO editar.png') }}" alt="Logo" class="h-8 w-auto">
            <h1 class="text-xl font-bold text-gray-800 mb-0">Gauge Master</h1>
        </a>
        <span class="text-gray-400">|</span>
        <div class="text-lg font-semibold text-gray-500 italic">ADMINISTRACION</div>
        <span class="text-gray-400 mx-2">|</span>
        <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold text-gray-500 hover:text-gray-700 no-underline transition uppercase">Dashboard</a>
    </div>

    <div class="flex items-center gap-4">
      <div class="text-end hidden md:block">
        <div class="font-semibold text-sm">{{ Auth::user()->name }}</div>
        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
      </div>
      <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" class="w-10 h-10 rounded-full border" alt="avatar">
      
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition">Salir</button>
      </form>
    </div>
  </nav>

  {{-- Main Content (No Sidebar) --}}
  <main class="w-full">
    <section class="p-4 md:p-8">
      @yield('content')
    </section>
  </main>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
