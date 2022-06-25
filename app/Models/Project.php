<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['image', 'image_delete_url', 'title', 'description', 'repo', 'demo'];
    protected $appends = ['languages'];
    public $timestamps = false;

    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    public function getLanguagesAttribute()
    {
        return $this->languages()->get('name');
    }
}
