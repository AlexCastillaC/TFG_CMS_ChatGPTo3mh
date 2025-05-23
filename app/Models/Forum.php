<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'role_access'
    ];

    // El foro es creado por un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un foro puede tener múltiples temas
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
