@extends('layouts.master')
@section('title', 'Digital Pulse-services')
@section('content')
    <!-- Content -->
    <div class="content">
        <!-- Services Form -->
        <div class="card" style="max-width: 500px; margin-bottom: 30px;">
        <div class="card-header">
            <div class="card-title">Add Service</div>
        </div>
        <div class="card-body">
            <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required rows="3" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 8px 20px; border-radius: 4px;">Submit</button>
            </form>
        </div>
        </div>
        <!-- Existing dashboard content below -->
        <!-- Stats Cards -->
        <div class="card-grid">
        <!-- ... existing cards ... -->
        </div>
        <!-- Chart Section -->
        <div class="chart-container">
        <!-- ... existing chart ... -->
        </div>
        <!-- Recent Activity -->
        <div class="activity-list">
        <!-- ... existing activity ... -->
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
