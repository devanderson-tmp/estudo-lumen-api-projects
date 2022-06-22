<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\CreateProject;
use Illuminate\Http\Request;

class ProjectController
{
    public function index()
    {
        $projects = Project::all();

        return response()->json($projects, 200);
    }

    public function store(Request $request, CreateProject $createProject)
    {
        $image = null;

        if ($request->has('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();

            $allowedExtensions = ['jpg', 'png'];

            if (!in_array($fileExtension, $allowedExtensions)) {
                return response()->json('File format not supported', 415);
            }
        }

        $project = $createProject->create(
            $request->image,
            $request->title,
            $request->description,
            $request->repo,
            $request->demo,
            $request->languages
        );

        return response()->json($project, 201);
    }

    public function show(int $id)
    {
        $project = Project::find($id);

        if (is_null($project)) return response()->json('Project not found', 404);

        return response()->json($project, 200);
    }

    public function update(int $id, Request $request)
    {
        $project = Project::find($id);

        if (is_null($project)) return response()->json('Project not found', 404);

        $project->fill($request->all());
        $project->save();

        return response()->json($project, 200);
    }

    public function destroy(int $id)
    {
        $project = Project::find($id);

        if ($project) {
            Project::destroy($project->id);

            return response()->json('', 204);
        } else {
            return response()->json('Project not found', 404);
        }
    }
}
