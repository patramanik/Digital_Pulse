@extends('layouts.master')
@section('title', 'Digital Pulse-services')
@section('content')
    <!-- Content -->
    <div class="content container mt-4">
        <!-- Services Form -->
        <div class="card mx-auto" style="max-width: 500px; margin-bottom: 30px;">
            <div class="card-header">
                <div class="card-title h4 mb-0">Add Service</div>
            </div>
            <div class="card-body">
                <form id="serviceForm" action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="service_title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="service_desc" id="description" class="form-control" required rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <div id="serviceFormMsg" class="mt-2"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Bootstrap JS (via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        document.getElementById('serviceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const url = form.action;
            const formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                let msgDiv = document.getElementById('serviceFormMsg');
                if (data.success) {
                    msgDiv.innerHTML = '<div class="alert alert-success">Service added successfully!</div>';
                    form.reset();
                } else {
                    msgDiv.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Error adding service.') + '</div>';
                }
            })
            .catch(error => {
                document.getElementById('serviceFormMsg').innerHTML = '<div class="alert alert-danger">An error occurred.</div>';
            });
        });

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

