@extends('layout')

@section('content')
    <h2>Editar Tarea</h2>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" value="{{ $task->title }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control">{{ $task->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Fecha Límite</label>
            <input type="datetime-local" name="due_date" value="{{ $task->due_date }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>¿Completada?</label>
            <select name="is_completed" class="form-control">
                <option value="0" {{ !$task->is_completed ? 'selected' : '' }}>No</option>
                <option value="1" {{ $task->is_completed ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Volver</a>
    </form>
@endsection
