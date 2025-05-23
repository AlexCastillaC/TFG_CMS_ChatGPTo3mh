<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'            => 'Cliente Prueba',
            'email'           => 'cliente@ejemplo.com',
            'password'        => Hash::make('password123'),
            'role'            => 'cliente',
        ]);

        User::create([
            'name'            => 'Vendedor Prueba',
            'email'           => 'vendedor@ejemplo.com',
            'password'        => Hash::make('password123'),
            'role'            => 'vendedor',
        ]);

        User::create([
            'name'            => 'Proveedor Prueba',
            'email'           => 'proveedor@ejemplo.com',
            'password'        => Hash::make('password123'),
            'role'            => 'proveedor',
        ]);
    }
}
