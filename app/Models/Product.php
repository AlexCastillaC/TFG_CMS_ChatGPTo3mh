<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'stand_id', 'name', 'description', 'price',
        'stock', 'image', 'category', 'is_available'
    ];

    // Relación: El producto es creado por un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación opcional: El producto puede pertenecer a un stand
    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }

    // Relación 1:N: Un producto puede estar en múltiples items de pedido
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
