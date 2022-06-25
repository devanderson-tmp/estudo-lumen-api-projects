<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class CreateProject
{
    public function create(?string $image, ?string $image_delete_url, string $title, ?string $description, string $repo, ?string $demo, array $languages): Project
    {
        $project = null;

        DB::beginTransaction();
        $project = Project::create([
            'image' => $image,
            'image_delete_url' => $image_delete_url,
            'title' => $title,
            'description' => $description,
            'repo' => $repo,
            'demo' => $demo
        ]);
        $this->createLanguages($languages, $project);
        DB::commit();

        return $project;
    }

    private function createLanguages(array $languages, Project $project)
    {
        foreach ($languages as $language) {
            $project->languages()->create(['name' => $language]);
        }
    }
}
