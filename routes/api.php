<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clima', [ApiController::class, 'clima']);
Route::get('/productos/destacados', [ApiController::class, 'featuredProducts']);
Route::get('/productos/buscar', [ApiController::class, 'productSearch']);

// Opcionalmente:
Route::get('/usuarios', [ApiController::class, 'users']);
Route::get('/puestos', [ApiController::class, 'stands']);
