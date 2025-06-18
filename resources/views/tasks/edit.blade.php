@extends('layout')

@section('content')
    <h2>Editar Tarea</h2>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <strong>¡Ups! Ha habido algunos problemas:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="title" value="{{ $task->title }}" class="form-control" value="{{ old('title') }}"
                required>
            @error('title')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control">{{ $task->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Fecha Límite</label>
            <input type="datetime-local" name="due_date" value="{{ $task->due_date }}" class="form-control"
                value="{{ old('due_date') }}">
            @error('due_date')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>¿Completada?</label>
            <select name="completed" class="form-control">
                <option value="0" {{ !$task->completed ? 'selected' : '' }}>No</option>
                <option value="1" {{ $task->completed ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Prioridad</label>
            <select name="priority" class="form-control">
                <option value="alta" {{ old('priority', $task->priority) == 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="media" {{ old('priority', $task->priority) == 'media' ? 'selected' : '' }}>Media</option>
                <option value="baja" {{ old('priority', $task->priority) == 'baja' ? 'selected' : '' }}>Baja</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Etiquetas</label><br>
            @foreach ($tags as $tag)
                <label style="margin-right: 10px;">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                        {{ in_array($tag->id, old('tags', $task->tags->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                    {{ $tag->name }}
                </label>
            @endforeach
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Volver</a>
    </form>
@endsection
