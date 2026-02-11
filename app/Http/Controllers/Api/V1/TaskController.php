<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        abort_unless($project->user_id === auth()->id(), 403);

        return response()->json([
            'data' => $project->tasks()->latest()->get(),
        ]);
    }

    public function store(Request $request, Project $project)
    {
        abort_unless($project->user_id === auth()->id(), 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
        ]);

        $task = $project->tasks()->create($data);

        return response()->json(['data' => $task], 201);
    }

    public function update(Task $task)
    {
        abort_unless($task->project->user_id === auth()->id(), 403);

        $task->update([
            'status' => $task->status === 'done' ? 'todo' : 'done',
        ]);

        return response()->json(['data' => $task]);
    }

    public function destroy(Task $task)
    {
        abort_unless($task->project->user_id === auth()->id(), 403);

        $task->delete();

        return response()->noContent();
    }
}
