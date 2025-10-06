@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Editar Usuario</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label>Nueva contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <select name="role" class="form-control" required>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
