<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'subcategory_id'
    ];

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function variants() {
        return $this->hasMany(Variant::class);
    }

    // Relacion muchos a muchos
    public function options() {
        return $this->belongsToMany(Option::class)
            ->withPivot('value')
            ->withTimestamps();
    }
}
