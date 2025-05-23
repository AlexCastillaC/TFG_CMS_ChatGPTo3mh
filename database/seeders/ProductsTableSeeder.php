<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Productos para vendedores
        $vendors = User::where('role', 'vendedor')->get();
        foreach ($vendors as $vendor) {
            Product::create([
                'user_id'      => $vendor->id,
                'name'         => 'Producto del Vendedor ' . $vendor->name,
                'description'  => 'Descripción del producto',
                'price'        => 10.99,
                'stock'        => 15,
                'category'     => 'Categoría A',
                'is_available' => true,
            ]);
        }
        
        // Productos para proveedores
        $providers = User::where('role', 'proveedor')->get();
        foreach ($providers as $provider) {
            Product::create([
                'user_id'      => $provider->id,
                'name'         => 'Producto del Proveedor ' . $provider->name,
                'description'  => 'Descripción del producto',
                'price'        => 20.50,
                'stock'        => 8,
                'category'     => 'Categoría B',
                'is_available' => true,
            ]);
        }
    }
}
