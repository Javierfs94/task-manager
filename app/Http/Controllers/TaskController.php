<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all tasks.
     */
    public function index()
    {
        // $tasks = Task::all(); // Trae todas las tareas
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('tasks.index', compact('tasks'));
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        $validated['user_id'] = auth()->id();


        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', '¡Tarea creada con éxito!');
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
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


    public function toggleCompleted(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada correctamente.');
    }
}
