<<<<<<< HEAD
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
=======
<div class="header">
    <div class="header-left">
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <h1>Dashboard</h1>
    </div>
    <div class="header-right">
        <i class="fas fa-bell" style="font-size: 18px; color: var(--gray); cursor: pointer;"></i>
        <div class="user-profile">
            <div class="user-avatar" id="userAvatarDropdown">AD</div>
            <span>Admin User</span>
            <div class="dropdown-content" id="dropdownContent">
                <a href="#">Profile</a>
                <a href="#">Change Password</a>
                <form action="{{ route('logout') }}" method="POST" style="all: unset;">
                    @csrf
                    <button type="submit"
                        style="all: unset; cursor: pointer; width: 100%; text-align: left; padding: 12px 16px; font-size: 14px; color: #333;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    const avatarDropdown = document.getElementById('userAvatarDropdown');
    const dropdownContent = document.getElementById('dropdownContent');

    avatarDropdown.addEventListener('click', (e) => {
        e.stopPropagation(); // prevent window click event
        dropdownContent.classList.toggle('show');
    });

    window.addEventListener('click', () => {
        if (dropdownContent.classList.contains('show')) {
            dropdownContent.classList.remove('show');
        }
    });
</script>


<style>
    /* Basic header styling (keep yours if you already have) */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background: #fff;
        border-bottom: 1px solid #e0e0e0;
    }

    .user-profile {
        position: relative;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-avatar {
        background-color: #4a90e2;
        /* nice blue */
        color: #fff;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .user-avatar:hover {
        background-color: #357ab8;
    }

    /* Dropdown styling */
    .dropdown-content {
        display: none;
        position: absolute;
        top: 45px;
        /* adds space above dropdown */
        right: 0;
        background-color: #fff;
        min-width: 160px;
        border-radius: 8px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        z-index: 100;
        overflow: hidden;
    }

    .dropdown-content a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
        transition: background-color 0.2s, color 0.2s;
    }

    .dropdown-content a:hover {
        background-color: #f5f5f5;
        color: #007bff;
    }

    /* Show dropdown */
    .show {
        display: block;
    }

    /* Style logout button to look like dropdown items */
    .dropdown-content form button {
        display: flex;
        align-items: center;
        width: 100%;
        background: none;
        border: none;
        padding: 12px 16px;
        font-size: 14px;
        color: #333;
        text-align: left;
        transition: background-color 0.2s, color 0.2s;
    }

    .dropdown-content form button:hover {
        background-color: #f5f5f5;
        color: #007bff;
    }
</style>
>>>>>>> 7f890b514c985d1d215c3925da3266b3a97d7296
