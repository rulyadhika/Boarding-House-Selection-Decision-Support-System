<nav class="navbar navbar-expand-lg bg-transparent position-absolute w-100 py-3 navbar-dark" style="z-index: 2;">
    <div class="container-fluid container">
        <a class="navbar-brand" href="/">Cari Kost</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto me-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kost') ? 'active' : '' }}"
                        href="{{ route('explore-kost') }}">Cari Kost</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                @if (auth()->check())
                    <div class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                            @csrf
                            <a class="nav-link" href="#" onclick="document.querySelector('#logoutForm').submit();">Logout</a>
                        </form>
                    </div>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
