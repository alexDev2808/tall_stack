<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subarea_id',
    ];


    public function subarea()
    {
        return $this->belongsTo(Subarea::class);
    }

    public function users() 
    {
        return $this->hasMany(User::class);
    }
}
