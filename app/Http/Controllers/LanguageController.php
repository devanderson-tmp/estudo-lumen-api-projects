<?php

namespace App\Http\Controllers;

use App\Models\Language;

class LanguageController
{
    public function index(int $id)
    {
        $languages = Language::query()->where('project_id', $id)->get('name');

        return response()->json($languages);
    }
}
