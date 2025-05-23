<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, Billable, SoftDeletes;
    

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'profile_picture', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relación 1:1 - Un usuario vendedor/proveedor puede tener un único stand
    public function stand()
    {
        return $this->hasOne(Stand::class);
    }

    // Relación 1:N - Un usuario (vendedor/proveedor) crea muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relación 1:N - Un cliente realiza muchos pedidos
    public function clientOrders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    // Relación 1:N - Un vendedor recibe muchos pedidos
    public function vendorOrders()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }

    // Relación 1:N - Un usuario puede crear múltiples foros
    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    // Relación 1:N - Mensajes enviados y recibidos
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
