<h2>Lista de Tareas</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Completada</th>
            <th>Fecha Límite</th>
            <th>Prioridad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->completed ? 'Sí' : 'No' }}</td>
                <td>{{ $task->due_date }}</td>
                <td>{{ $task->priority }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
