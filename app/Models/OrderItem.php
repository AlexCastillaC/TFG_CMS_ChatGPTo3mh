<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

    // Cada item pertenece a un pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Cada item se relaciona con un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
