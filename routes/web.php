<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductDisplayController;
use App\Http\Controllers\ProviderProductController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\StandDisplayController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\VendorProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\OrderController;

// Rutas públicas (home, login, register, etc.) se generan con Laravel UI

Route::get('/', function () {
    return view('home');
})->name('home');

// Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Logout (se protege con CSRF)
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registro
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Recuperación de contraseña
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Rutas para mostrar productos según rol
Route::get('products', [ProductDisplayController::class, 'index'])
     ->name('products.display');

// Rutas para mostrar puestos
Route::get('stands', [StandDisplayController::class, 'index'])
     ->name('stands.display');


// Rutas protegidas para Cliente
Route::group(['middleware' => ['auth', 'checkRole:cliente']], function () {
    Route::get('/cliente/perfil', [ClientController::class, 'profile'])->name('client.profile');
    Route::post('/cliente/perfil/actualizar', [ClientController::class, 'updateProfile'])->name('client.profile.update');
});

// Rutas protegidas para Vendedor
Route::group(['middleware' => ['auth', 'checkRole:vendedor']], function () {
    Route::get('/vendedor/perfil', [VendorController::class, 'profile'])->name('vendor.profile');
    Route::post('/vendedor/perfil/actualizar', [VendorController::class, 'updateProfile'])->name('vendor.profile.update');

    // Rutas adicionales para gestionar su puesto, productos y pedidos
    Route::resource('/vendedor/pedidos', VendorOrderController::class);
    
        Route::resource('vendor/products', VendorProductController::class, ['as' => 'vendor']);
        // Ruta para actualizar stock (se puede definir como POST o PUT según convenga)
        Route::post('vendor/products/{id}/update-stock', [VendorProductController::class, 'updateStock'])
             ->name('vendor.products.updateStock');
    
});

// Rutas protegidas para Proveedor
Route::group(['middleware' => ['auth', 'checkRole:proveedor']], function () {
    Route::get('/proveedor/perfil', [ProviderController::class, 'profile'])->name('provider.profile');
    Route::post('/proveedor/perfil/actualizar', [ProviderController::class, 'updateProfile'])->name('provider.profile.update');

    // Rutas adicionales para gestionar su puesto, productos y pedidos
    Route::resource('provider/products', ProviderProductController::class, ['as' => 'provider']);
    Route::post('provider/products/{id}/update-stock', [ProviderProductController::class, 'updateStock'])
         ->name('provider.products.updateStock');
    Route::resource('/proveedor/pedidos', ProviderOrderController::class);
});

Route::group(['middleware' => ['auth', 'checkRole:vendedor,proveedor']], function () {
    Route::resource('stand', StandController::class);
});



// Rutas para el carrito
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Rutas para el proceso de checkout
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Rutas para el pago
Route::get('payment/process/{orderId}', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::post('payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');


Route::get('orders/history', [OrderHistoryController::class, 'index'])
     ->name('order.history')
     ->middleware('auth');

     Route::middleware('auth')->group(function () {
        Route::get('/order/{order}/edit', [OrderController::class, 'edit'])
            ->name('order.edit');
        Route::put('/order/{order}', [OrderController::class, 'update'])
            ->name('order.update');
    });

     Route::get('/order/{order}', [OrderController::class, 'show'])
     ->name('order.show')
     ->middleware('auth');


     Route::middleware('auth')->group(function () {
        // Mostrar formulario de pago
        Route::get('payment/form', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
        
        // Procesar el pago
        Route::post('payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
    });
    
    // Ruta para el webhook de Stripe (configúrala en Stripe Dashboard)
    Route::post('stripe/webhook', [PaymentController::class, 'handleWebhook'])->name('stripe.webhook');

    Route::middleware('auth')->prefix('social/mensajes')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/usuarios', [MessageController::class, 'users'])->name('messages.users');
        Route::get('/{receiver}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/{receiver}', [MessageController::class, 'store'])->name('messages.store');
    });

    Route::middleware('auth')->prefix('social')->group(function () {
        // Foros
        Route::get('/foros', [ForumController::class, 'index'])->name('forums.index');
        Route::get('/foros/create', [ForumController::class, 'create'])->name('forums.create');
        Route::post('/foros', [ForumController::class, 'store'])->name('forums.store');
        Route::get('/foros/{forum}', [ForumController::class, 'show'])->name('forums.show');
        
        // Temas
        Route::get('/foros/{forum}/temas/create', [TopicController::class, 'create'])->name('topics.create');
        Route::post('/foros/{forum}/temas', [TopicController::class, 'store'])->name('topics.store');
        Route::get('/foros/{forum}/temas/{topic}', [TopicController::class, 'show'])->name('topics.show');
        
        // Comentarios
        Route::post('/foros/{forum}/temas/{topic}/comentarios', [CommentController::class, 'store'])->name('comments.store');
    });
// Rutas para ver el pedido (historial de pedidos) se pueden agregar según convenga