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
        ]);

        $task = $project->tasks()->create($data);

        return response()->json([
            'data' => new TaskResource($task),
        ], 201);
    }

    public function update(Task $task)
    {
        $this->authorize('update', $task);

        $task->update([
            'status' => $task->status === 'done' ? 'todo' : 'done',
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
