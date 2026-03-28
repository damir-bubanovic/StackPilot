<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return response()->json([
            'data' => TaskResource::collection(
                $project->tasks()->latest()->get()
            ),
        ]);
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'in:todo,doing,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        // defaults if not provided
        $data['status'] = $data['status'] ?? 'todo';
        $data['due_date'] = $data['due_date'] ?? null;

        $task = $project->tasks()->create($data);

        return response()->json([
            'data' => new TaskResource($task),
        ], 201);
    }

    public function update(Task $task)
    {
        $this->authorize('update', $task);

        // simple cycle: todo → doing → done → todo
        $nextStatus = match ($task->status) {
            'todo' => 'doing',
            'doing' => 'done',
            default => 'todo',
        };

        $task->update([
            'status' => $nextStatus,
        ]);

        return response()->json([
            'data' => new TaskResource($task),
        ]);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->noContent();
    }
}