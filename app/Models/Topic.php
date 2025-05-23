<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
        'forum_id', 'user_id', 'title', 'content'
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un tema puede tener múltiples comentarios
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
