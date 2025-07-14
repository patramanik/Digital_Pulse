@extends('layouts.master')
@section('title', 'Digital Pulse-Dashbord')
@section('content')
<!-- Content -->
<div class="content">
    <!-- Stats Cards -->
    <div class="card-grid">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Contact Messages</div>
                    <div class="card-value">{{ $contact_count }}</div>
                </div>
                <div class="card-icon primary">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Works</div>
                    <div class="card-value">{{ $work_count }}</div>
                </div>
                <div class="card-icon success">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Careers</div>
                    <div class="card-value">{{ $careers_count }}</div>
                </div>
                <div class="card-icon warning">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Services</div>
                    <div class="card-value">{{ $services_count }}</div>
                </div>
                <div class="card-icon danger">
                    <i class="fas fa-cogs"></i>
                </div>
            </div>
        </div>

        <!-- <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">New Users</div>
                    <div class="card-value">1,254</div>
                    <div class="card-change positive">
                        <i class="fas fa-arrow-up"></i> 8.3% from last month
                    </div>
                </div>
                <div class="card-icon success">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Pending Orders</div>
                    <div class="card-value">86</div>
                    <div class="card-change negative">
                        <i class="fas fa-arrow-down"></i> 3.2% from last month
                    </div>
                </div>
                <div class="card-icon warning">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Support Tickets</div>
                    <div class="card-value">32</div>
                    <div class="card-change positive">
                        <i class="fas fa-arrow-up"></i> 5.7% from last month
                    </div>
                </div>
                <div class="card-icon danger">
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Chart Section -->
    <div class="chart-container">
        <div class="chart-header">
            <div class="chart-title">Revenue Overview</div>
            <div>
                <select style="padding: 6px 10px; border-radius: 5px; border: 1px solid #ddd; font-size: 14px;">
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option selected>Last 90 Days</option>
                </select>
            </div>
        </div>
        <div
            style="height: 250px; background-color: #f9f9f9; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
            <p style="color: var(--gray);">Chart would be displayed here</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="activity-list">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Recent Message</h3>

        <!-- <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="activity-details">
                <div class="activity-title">New user registered: John Doe with email john@example.com</div>
                <div class="activity-time">15 minutes ago</div>
            </div>
        </div> -->
        @if(isset($contacts) && count($contacts))
        @foreach($contacts as $contact)
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="activity-details">
                <div class="activity-title">{{$contact->full_name}}</div>
                <div class="activity-title">{{$contact->email}}</div>
                <div class="activity-time">{{$contact->message}}</div>
            </div>
        </div>
        @endforeach
        @else
        <p>No job openings available.</p>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<script>
// Toggle sidebar on mobile
document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.sidebar-overlay').classList.toggle('active');
});

// Close sidebar when clicking on overlay
document.querySelector('.sidebar-overlay').addEventListener('click', function() {
    document.querySelector('.sidebar').classList.remove('active');
    this.classList.remove('active');
});

// Close sidebar when clicking on menu item (mobile)
const menuItems = document.querySelectorAll('.menu-item');
menuItems.forEach(item => {
    item.addEventListener('click', function() {
        if (window.innerWidth < 768) {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.sidebar-overlay').classList.remove('active');
        }
    });
});

// Adjust layout on window resize
window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) {
        document.querySelector('.sidebar').classList.remove('active');
        document.querySelector('.sidebar-overlay').classList.remove('active');
    }
});
</script>
@endsection
