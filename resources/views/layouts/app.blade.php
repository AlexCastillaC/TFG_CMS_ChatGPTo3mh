<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Meta viewport para responsividad -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CMS Mercado Local')</title>
    <link href="css/app.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Navbar principal -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Mercado Local</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registro</a>
                        </li>
                    @else
                        <!-- Enlaces comunes para usuarios autenticados -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.display') }}">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('stands.display') }}">Puestos</a>
                        </li>
                        @if(Auth::user()->role !== 'proveedor')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">Carrito</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('order.history') }}">Historial de Pedidos</a>
                        </li>
                        <!-- Enlaces específicos según rol -->
                        @if(Auth::user()->role === 'cliente')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client.profile') }}">Perfil</a>
                            </li>

                        @endif
                        @if(Auth::user()->role === 'vendedor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vendor.products.index') }}">Mis Productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vendor.profile') }}">Perfil</a>
                            </li>

                        @endif
                        @if(Auth::user()->role === 'proveedor')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('provider.products.index') }}">Mis Productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('provider.profile') }}">Perfil</a>
                            </li>

                        @endif
                        @if(in_array(Auth::user()->role, ['vendedor', 'proveedor']))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('stand.index') }}">Mi Puesto</a>
                            </li>
                        @endif
                         <!-- Enlaces a la red social -->
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('messages.index') }}">
                                <i class="fas fa-envelope"></i> Mensajes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('forums.index') }}">
                                <i class="fas fa-comments"></i> Foros
                            </a>
                        </li>
                        <!-- Enlace para cerrar sesión -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>

        <!-- Contenedor principal -->
        <div class="container mt-4">
            <!-- Mensaje de éxito con botón de cierre -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer sencillo -->
        <footer class="bg-dark text-light mt-4 py-3">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Mercado Local. Todos los derechos reservados.</p>
            </div>
        </footer>

        
  
        @yield('scripts')
</body>

</html>