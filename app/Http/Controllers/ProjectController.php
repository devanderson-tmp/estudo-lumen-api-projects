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
        $img_path = null;

        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $filename = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();

            $allowedExtensions = ['jpg', 'png'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $file->move('assets/images', $filename);
                $filepath = 'assets/images/' . $filename;

                $img_path = $filepath;
            }
        }

        $project = $createProject->create(
            $img_path,
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
}
