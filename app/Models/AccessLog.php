<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'access_granted'])]
class AccessLog extends Model
{
    /**
     * Obtener el atleta que generó este registro de acceso.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}