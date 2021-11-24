<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController
{
    public function index()
    {
        $projects = Project::all();

        return response()->json($projects, 200);
    }

    public function store(Request $request)
    {
        $project = new Project();

        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $filename = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();

            $allowedExtensions = ['png'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $file->move('assets/images', $filename);
                $filepath = 'assets/images/' . $filename;

                $project->img_path = $filepath;
            }
        }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->repo = $request->repo;
        $project->demo = $request->demo;
        $project->save();

        return response()->json($project, 201);
    }

    public function show(int $id)
    {
        $project = Project::find($id);

        if (is_null($project)) return response()->json('Project not found', 404);

        return response()->json($project, 200);
    }
}
