<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Mis afinaciones guardadas</h2>
        <p class="mt-1 text-sm text-gray-600">Gestiona tus afinaciones.</p>
    </header>

    <div class="mt-6 overflow-x-auto">
        @if ($tunings->isEmpty())
            <p class="text-sm text-gray-600">Aún no has guardado afinaciones.</p>
        @else
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2 pr-4">Nombre</th>
                        <th class="py-2 pr-4">Notas</th>
                        <th class="py-2 pr-4">Calibres</th>
                        <th class="py-2 pr-4">Tensión total</th>
                        <th class="py-2 pr-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tunings as $tuning)
                        <tr class="border-b">
                            <td class="py-2 pr-4">{{ $tuning->name }}</td>
                            <td class="py-2 pr-4">{{ $tuning->notes }}</td>
                            <td class="py-2 pr-4">{{ $tuning->gauges }}</td>
                            <td class="py-2 pr-4">{{ $tuning->total_tension }}</td>
                            <td class="py-2 pr-4 flex gap-3">
                                <a href="{{ route('tunings.edit', $tuning) }}" class="text-blue-600 hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('tunings.destroy', $tuning) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar esta afinación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>
