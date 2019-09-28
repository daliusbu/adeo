<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img id="app-icon" src="{{ asset('icons/products.svg') }}" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('product.index') }}">Products
                    <span class="sr-only">(current)</span></a>
            </li>

            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Admin
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.product.index') }}">List products</a>
                        <a class="dropdown-item" href="{{ route('admin.product.add') }}">Add Product</a>
                    </div>
                </li>
            @endauth
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                {{ env('APP_TITLE') }}
            </li>
            @auth
                <li class="nav-item navbar-text text-white">
                    {{ Auth::user()->name }},
                    <a class="nav-item navbar-text nav-link" href="#" id="button-logout"
                       onclick="event.preventDefault();
                           document.getElementById('form-logout').submit();">Logout</a>
                    <form id="form-logout" method="POST" action="{{ route('logout') }}"
                          style="display: none;">@csrf
                    </form>
                    @else
                        <a class="nav-item navbar-text nav-link" href="{{ route('login') }}">Login</a>
                    @endauth
                </li>
        </ul>
    </div>
</nav>
