@extends('layout')

@if (session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

@section('content')
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Crear Nueva Tarea</a>

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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            {{-- {{ $task->is_completed ? 'Sí' : 'No' }} --}}
                            <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" style="display:inline">
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
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Seguro de eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach




            </tbody>
        </table>
    @endif
@endsection
