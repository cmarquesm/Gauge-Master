<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Información del perfil
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Actualiza tu información personal y foto de perfil.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Avatar --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Avatar actual</label>
            <div class="mt-2">
                @if ($user->profile && $user->profile->avatar)
                    <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover">
                @endif
            </div>
        </div>

        <div>
            <label for="avatar" class="block text-sm font-medium text-gray-700">Cambiar avatar</label>
            <input type="file" name="avatar" id="avatar" accept="image/*" class="mt-2">
        </div>

        {{-- Nombre --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('name', $user->name) }}" required>
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('email', $user->email) }}" required>
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Teléfono --}}
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input id="phone" name="phone" type="text" class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('phone', $user->profile->phone ?? '') }}">
            @error('phone') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Dirección --}}
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
            <input id="address" name="address" type="text" class="mt-1 block w-full border-gray-300 rounded-md"
                   value="{{ old('address', $user->profile->address ?? '') }}">
            @error('address') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Guardar cambios</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600">Perfil actualizado correctamente.</p>
            @endif
        </div>
    </form>
</section>
