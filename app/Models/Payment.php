<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'subscription_id', 'amount', 'payment_method', 'wompi_transaction_id', 'status', 'pos_reference'])]
class Payment extends Model
{
    /**
     * Obtener el atleta dueño de este pago.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la suscripción asociada a este pago.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}