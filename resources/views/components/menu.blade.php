<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

    <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">Shopcenter</a>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>

        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto"></ul>

            <form class="d-flex" action="{{ route('products.search') }}" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Buscar" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </form>


            <ul class="navbar-nav ms-auto">

                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                Inicio de Sesion
                            </a>
                        </li>
                    @endif


                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registro</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->full_name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                Cerrar sesión
                            </a>

                            @role('admin')
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    Usuarios
                                </a>
                            @endrole

                            @role('admin')
                                <a class="dropdown-item" href="{{ route('products.index') }}">
                                    Productos
                                </a>
                            @endrole

                            @role('admin')
                                <a class="dropdown-item" href="{{ route('categories.index') }}">
                                    Categorias
                                </a>
                            @endrole

                            @auth

                                <a class="dropdown-item" href="{{ route('cart.show') }}">
                                    Carrito
                                </a>

                            @endauth

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
