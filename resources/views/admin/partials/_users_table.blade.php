<div class="table-responsive">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Listado de Usuarios</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Nuevo Usuario</a>
    </div>

    <table class="table table-hover align-middle shadow-sm rounded overflow-hidden">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td class="fw-medium">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning me-1">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $users->appends(['products_page' => request('products_page'), 'orders_page' => request('orders_page')])->links() }}
    </div>
</div>
