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
        $projects = Project::all(['id', 'image', 'title', 'description', 'repo', 'demo']);

        return response()->json($projects);
    }

    public function store(Request $request, CreateProject $createProject)
    {
        $image = null;
        $image_delete_url = null;

        if ($request->has('image')) {
            $file = $request->file('image');
            $file_extension = $file->getClientOriginalExtension();

            $allowed_extensions = ['jpg', 'png'];

            if (!in_array($file_extension, $allowed_extensions)) {
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

                $data = json_decode($response->getBody()->getContents())->data;
                $image = $data->url;
                $image_delete_url = $data->delete_url;
            } catch (ClientException $e) {
                $message = json_decode($e->getResponse()->getBody()->getContents())->error->message;
                return response()->json($message, $e->getCode());
            }
        }

        $project = $createProject->create(
            $image,
            $image_delete_url,
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

        return response()->json($project);
    }

    public function update(int $id, Request $request)
    {
        $project = Project::find($id);

        if (is_null($project)) return response()->json('Project not found', 404);

        $project->fill($request->all());
        $project->save();

        return response()->json($project);
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

    public function privateProjects()
    {
        return response()->json(Project::all());
    }
}
