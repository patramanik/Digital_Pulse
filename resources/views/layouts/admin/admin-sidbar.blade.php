 <!-- Sidebar Overlay (Mobile Only) -->
 <div class="sidebar-overlay"></div>

 <!-- Sidebar -->
 <div class="sidebar">
     <div class="sidebar-header">
         <h3>DIGITAL PULSE</h3>
     </div>
<<<<<<< HEAD
     <div class="sidebar-menu">
        <a href="/admin" data-path="/admin" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </div>
        </a>
        <a href="/admin/services" data-path="/admin/services" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-wrench"></i>
                <span>Services</span>
            </div>
        </a>
        <a href="/admin/works" data-path="/admin/works" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-briefcase"></i>
                <span>Our Work</span>
            </div>
        </a>
        <a href="/admin/careers" data-path="/admin/careers" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-user-tie"></i>
                <span>Career</span>
            </div>
        </a>
        <a href="#" data-path="" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-search"></i>
                <span>SEO</span>
            </div>
        </a>
        <a href="#" data-path="" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-hashtag"></i>
                <span>Social Media</span>
            </div>
        </a>
        <a href="#" data-path="" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-user-secret"></i>
                <span>PR Agent</span>
            </div>
        </a>
        <a href="#" data-path="" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-user-friends"></i>
                <span>Influencer</span>
            </div>
        </a>
        <a href="#" data-path="" class="menu-link">
            <div class="menu-item">
                <i class="fas fa-envelope"></i>
                <span>Contact</span>
            </div>
        </a>
     </div>
 </div>
 </div>
=======

     <div class="sidebar-menu">
         <div class="menu-item active">
             <i class="fas fa-tachometer-alt"></i>
             <span>Dashboard</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-users"></i>
             <span>Users</span>
         </div>
         <form action="{{ route('subjects.index') }}" method="GET">
             <button type="submit" class="menu-item">
                 <i class="fas fa-users"></i>
                 <span>Subjects</span>
             </button>
         </form>


         <form action="{{ route('quiz.formview') }}" method="GET">
             <button type="submit" class="menu-item">
                 <i class="fas fa-users"></i>
                 <span>Quiz</span>
             </button>
         </form>
         <form action="{{ route('class_subject.view') }}" method="GET">
             <button type="submit" class="menu-item">
                 <i class="fas fa-users"></i>
                 <span>Class Subject Mapping</span>
             </button>
         </form>
         {{-- <div class="menu-item">
             <i class="fas fa-shopping-cart"></i>
             <span>Orders</span>
         </div> --}}
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
>>>>>>> 7f890b514c985d1d215c3925da3266b3a97d7296
