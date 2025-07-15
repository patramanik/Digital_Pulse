<!-- Header -->
<div class="header d-flex justify-content-between align-items-center p-3 bg-light shadow-sm">
    <!-- Left -->
    <div class="header-left d-flex align-items-center">
        <div class="menu-toggle me-3">
            <i class="fas fa-bars fs-4"></i>
        </div>
        <h1 class="h4 m-0">Dashboard</h1>
    </div>

    <!-- Right -->
    <div class="header-right d-flex align-items-center">
        <!-- User Dropdown -->
        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                    style="width: 36px; height: 36px; font-weight: bold;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                @auth
                <span class="text-dark fw-semibold">
                    {{ auth()->user()->name }}
                </span>
                @endauth
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ url('/profile') }}">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i> {{ __('Log Out') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
