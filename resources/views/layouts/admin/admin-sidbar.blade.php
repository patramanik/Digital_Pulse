 <!-- Sidebar Overlay (Mobile Only) -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>DIGITAL PULSE</h3>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-box-open"></i>
                <span>Products</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
           <div class="menu-item">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" style="all: unset; cursor: pointer;">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </button>
    </form>
</div>

        </div>
    </div>
