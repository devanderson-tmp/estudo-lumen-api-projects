<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\CreateProject;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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

            $client = new Client(['base_uri' => 'https://api.imgbb.com/1/']);

            try {
                $response = $client->post(
                    'upload',
                    [
                        'form_params' => [
                            'image' => base64_encode(file_get_contents($file)),
                            'key' => env('IMGBB_KEY')
                        ]
                    ]
                );

                $image = json_decode($response->getBody()->getContents())->data->url;
            } catch (ClientException $e) {
                $message = json_decode($e->getResponse()->getBody()->getContents())->error->message;
                return response()->json($message, $e->getCode());
            }
        }

        $project = $createProject->create(
            $image,
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
