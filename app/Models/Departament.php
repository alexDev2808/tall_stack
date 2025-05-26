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


    public function subareas()
    {
        return $this->hasMany(Subarea::class);
    }
}
