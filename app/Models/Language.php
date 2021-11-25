<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'project_id'];
    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
