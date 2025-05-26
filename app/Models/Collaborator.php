<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    protected $fillable = [
        'id_collaborator',
        'app',
        'apm',
        'nombre',
        'activo',
        'pass',
        'tc',
        'mail',
        'perm_fsm',
        'tipoPuesto'
    ];
}
