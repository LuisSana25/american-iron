<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'plan_id', 'starts_at', 'expires_at', 'status'])]
class Subscription extends Model
{
    /**
     * Obtener el plan asociado a esta suscripción.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}