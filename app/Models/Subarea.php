<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function departaments()
    {
        return $this->hasMany(Departament::class);
    }

}
