<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
