<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id());

        if ($request->has('tag')) {
            $tagId = $request->get('tag');
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);
            });
        }

        $tasks = $query->orderByRaw("FIELD(priority, 'alta', 'media', 'baja')")->paginate(10);
        $tags = Tag::all();

        return view('tasks.index', compact('tasks', 'tags'));
    }


    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('tasks.create', compact('tags'));
    }

    /**
     * Show the form for editing a specified task.
     */
    public function edit(Task $task)
    {
        $tags = Tag::all();
        return view('tasks.edit', compact('task', 'tags'));
    }

    /**
     * Save a new task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:alta,media,baja',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['user_id'] = auth()->id();
        $task = Task::create($validated);

        // Sincroniza etiquetas
        if ($request->has('tags')) {
            $task->tags()->sync($request->tags);
        }

        return redirect()->route('tasks.index')->with('success', '¡Tarea creada con éxito!');
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date|after_or_equal:today',
            'priority' => 'required|in:alta,media,baja',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $task->update($validated);

        // Sincroniza etiquetas
        if ($request->has('tags')) {
            $task->tags()->sync($request->tags);
        }

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

    public function filterByTag(Tag $tag)
    {
        $tasks = $tag->tasks()->where('user_id', auth()->id())->paginate(10);
        $tags = Tag::all();

        // Añadir 'tag' al request para que la vista lo detecte como id
        request()->merge(['tag' => $tag->id]);

        return view('tasks.index', compact('tasks', 'tags'));
    }

    public function exportCsv(): StreamedResponse
    {
        $tasks = Task::where('user_id', auth()->id())->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=tasks.csv",
        ];

        $callback = function () use ($tasks) {
            $handle = fopen('php://output', 'w');
            // Encabezados CSV
            fputcsv($handle, ['ID', 'Título', 'Descripción', 'Completada', 'Fecha Límite', 'Prioridad']);

            foreach ($tasks as $task) {
                fputcsv($handle, [
                    $task->id,
                    $task->title,
                    $task->description,
                    $task->completed ? 'Sí' : 'No',
                    $task->due_date,
                    $task->priority,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        $pdf = Pdf::loadView('tasks.exportpdf', compact('tasks'));

        return $pdf->download('tasks.pdf');
    }
}
