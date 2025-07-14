 <!-- Sidebar Overlay (Mobile Only) -->
 <div class="sidebar-overlay"></div>

 <!-- Sidebar -->
<div class="sidebar">
     <div class="sidebar-header">
         <h3>DIGITAL PULSE</h3>
     </div>

     <div class="sidebar-menu">
         <div class="menu-item">
             <i class="fas fa-wrench"></i>
             <span>Services</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-briefcase"></i>
             <span>Our Work</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-user-tie"></i>
             <span>Career</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-search"></i>
             <span>SEO</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-hashtag"></i>
             <span>Social Media</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-user-secret"></i>
             <span>PR Agent</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-user-friends"></i>
             <span>Influencer</span>
         </div>
         <div class="menu-item">
             <i class="fas fa-envelope"></i>
             <span>Contact</span>
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
 </div>
