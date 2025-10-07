<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gauge Master</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    <header class="bg-gray-900 text-black">
        <nav class="container mx-auto flex justify-between items-center py-4 px-4">
            <h1 class="text-2xl font-bold">Gauge Master</h1>
            <ul class="flex items-center space-x-6 text-sm uppercase">
                <li><a href="{{ route('main') }}" class="hover:text-blue-400">Calculadora</a></li>
                <li><a href="{{ route('info') }}" class="hover:text-blue-400">Información</a></li>
                <li><a href="{{ route('store') }}" class="hover:text-blue-400">Tienda</a></li>

                @auth
                    @if (Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="text-yellow-400 hover:text-yellow-300">Admin</a>
                        </li>
                    @endif
                    <li class="relative group">
                        <a href="{{ route('profile.edit') }}"
                            class="block w-9 h-9 rounded-full overflow-hidden border-2 border-gray-300">
                            <img src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" alt="avatar"
                                class="w-full h-full object-cover">
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="hover:text-red-400">Salir</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-blue-400">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-blue-400">Registro</a></li>
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
</body>

</html>
