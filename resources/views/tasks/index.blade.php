@extends('layout')

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tareas') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">

                    {{-- Mensaje de éxito --}}
                    @if (session('success'))
                        <div
                            style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Botón crear nueva tarea -->
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Crear Nueva Tarea</a>

                    <!-- Botones de exportar -->
                    <a href="{{ route('tasks.export.csv') }}" class="btn btn-sm btn-success mb-3 ms-2">Exportar CSV</a>
                    <a href="{{ route('tasks.export.pdf') }}" class="btn btn-sm btn-danger mb-3 ms-2">Exportar PDF</a>

                    <!-- Filtro de tareas -->
                    <div class="mb-3">
                        <label>Filtrar por etiqueta:</label>
                        @foreach ($tags as $tag)
                            <a href="{{ route('tasks.filterByTag', $tag->id) }}" class="btn btn-sm btn-secondary"
                                style="margin: 2px;">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-primary" style="margin: 2px;">Mostrar
                            todas</a>
                    </div>

                    <!-- Listado de tareas -->
                    @if ($tasks->isEmpty())
                        <p>No hay tareas aún.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Completada</th>
                                    <th>Fecha Límite</th>
                                    <th>Prioridad</th>
                                    <th>Etiquetas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>
                                            <form action="{{ route('tasks.toggle', $task->id) }}" method="POST"
                                                style="display:inline">
                                                @csrf
                                                @method('PATCH')
                                                <label>
                                                    <input type="checkbox" onchange="this.form.submit()"
                                                        {{ $task->completed ? 'checked' : '' }}>
                                                </label>
                                            </form>
                                        </td>
                                        <td>{{ $task->due_date }}</td>
                                        <td>
                                            @php
                                                switch ($task->priority) {
                                                    case 'alta':
                                                        $class = 'badge bg-danger';
                                                        break;
                                                    case 'media':
                                                        $class = 'badge bg-warning text-dark';
                                                        break;
                                                    case 'baja':
                                                        $class = 'badge bg-success';
                                                        break;
                                                    default:
                                                        $class = 'badge bg-secondary';
                                                }
                                            @endphp
                                            <span class="{{ $class }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </td>

                                        <td>
                                            @foreach ($task->tags as $tag)
                                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                                            @endforeach
                                        </td>

                                        <td>
                                            <form method="GET" action="{{ route('tasks.index') }}">
                                                <select name="tag" onchange="this.form.submit()">
                                                    <option value="">-- Todas las etiquetas --</option>
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag->id }}"
                                                            {{ request('tag') == $tag->id ? 'selected' : '' }}>
                                                            {{ $tag->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>

                                        </td>

                                        <td>
                                            <a href="{{ route('tasks.edit', $task) }}"
                                                class="btn btn-sm btn-warning">Editar</a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Seguro de eliminar?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                {{ $tasks->links() }}
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
