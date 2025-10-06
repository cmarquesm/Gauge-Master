<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gauge Master — Admin</title>
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r">
      <div class="p-6">
        <h1 class="text-xl font-bold">Gauge Master</h1>
      </div>

      <nav class="px-4 py-2 space-y-2">
        <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Panel de control</a>
        <a href="{{ url('/admin/products') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Productos</a>
        <a href="{{ url('/admin/users') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Usuarios</a>
        <a href="{{ url('/admin/orders') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Pedidos</a>
      </nav>

      <div class="p-4 mt-auto">
        <a href="{{ url('/') }}" class="block px-4 py-2 rounded hover:bg-gray-100">Salir</a>
      </div>
    </aside>

    <!-- Contenido -->
    <main class="flex-1">
      <!-- Topbar -->
      <nav class="bg-white border-b px-6 py-4 flex items-center justify-between">
        <div class="text-lg font-semibold">Panel de Administración</div>

        <div class="flex items-center gap-4">
          <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" class="w-10 h-10 rounded-full" alt="avatar">
          <div class="text-sm">
            <div class="font-semibold">{{ Auth::user()->name }}</div>
            <div class="text-gray-500">{{ Auth::user()->email }}</div>
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
          </form>
        </div>
      </nav>

      <section class="p-8">
        @yield('content')
      </section>
    </main>
  </div>
</body>
</html>
