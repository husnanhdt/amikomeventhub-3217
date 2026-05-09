<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // 1 Kategori bisa punya banyak Event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}