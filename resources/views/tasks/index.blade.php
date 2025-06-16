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

                    <!-- Botón de crear -->
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Crear Nueva Tarea</a>

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
