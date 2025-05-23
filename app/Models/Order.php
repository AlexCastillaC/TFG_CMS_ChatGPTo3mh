<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'buyer_id', 'seller_id', 'total', 'status', 'payment_method', 'payment_status', 'shipping_address'
    ];

    // Relación: Pedido pertenece a un cliente
    public function client()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // Relación: Pedido es atendido por un vendedor
    public function vendor()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Relación 1:N: Un pedido tiene múltiples items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accesor para obtener el total con IVA (21%)
    public function getTotalWithIvaAttribute()
    {
        return $this->total * 1.21;
    }
}
