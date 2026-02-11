<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => $request->user()->projects()->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
        ]);

        $project = $request->user()->projects()->create($data);

        return response()->json(['data' => $project], 201);
    }

    public function destroy(Project $project)
    {
        abort_unless($project->user_id === auth()->id(), 403);

        $project->delete();

        return response()->noContent();
    }
}
