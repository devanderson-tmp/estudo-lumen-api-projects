<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['img_path', 'title', 'description', 'repo', 'demo'];
    public $timestamps = false;
}
