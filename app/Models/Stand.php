<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'location', 'category', 'stand_picture'
    ];

    // Relación inversa: Cada stand pertenece a un usuario
    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación 1:N: Un stand puede tener muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
