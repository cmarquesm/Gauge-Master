<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gauge Master</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    <header class="bg-white text-gray-900 border-b shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto flex justify-between items-center py-4 px-4">
            <a href="{{ route('main') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/LOGO editar.png') }}" alt="Logo Gauge Master" class="h-12 w-auto">
                <h1 class="text-2xl font-bold tracking-tight text-gray-800">Gauge Master</h1>
            </a>
            <ul class="flex items-center space-x-6 text-sm font-semibold uppercase">
                <li><a href="{{ route('main') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Calculadora</a></li>
                <li><a href="{{ route('info') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Información</a></li>
                <li><a href="{{ route('store') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Tienda</a></li>

                @auth
                    <li><a href="{{ route('cart.show') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Carrito</a></li>

                    @if (Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="text-amber-600 hover:text-amber-500">Admin</a></li>
                    @endif
                    <li class="relative group">
                        <a href="{{ route('profile.edit') }}"
                            class="block w-9 h-9 rounded-full overflow-hidden border-2 border-gray-200 hover:border-indigo-400 transition-colors">
                            <img src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="avatar"
                                class="w-full h-full object-cover">
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-500 transition-colors">Salir</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Login</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-600 hover:text-indigo-600 transition-colors">Registro</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="bg-gray-100 text-center py-4 text-sm text-gray-500 border-t">
        &copy; {{ date('Y') }} Gauge Master
    </footer>
    
    @yield('scripts')

    <x-chat-widget />
</body>

</html>
