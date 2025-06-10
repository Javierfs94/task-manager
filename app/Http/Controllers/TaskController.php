<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display all tasks.
     */
    public function index()
    {
        $tasks = Task::all(); // Trae todas las tareas
        return view('tasks.index', compact('tasks')); // Muestra la vista con las tareas

    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Save a new task.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', '¡Tarea creada con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing a specified task.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', '¡Tarea actualizada!');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', '¡Tarea eliminada!');
    }
}
