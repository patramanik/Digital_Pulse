@extends('layouts.master')
@section('title', 'Digital Pulse-services')
@section('content')
<!-- Content -->
<div class="content">
    <!-- Services Form -->
    <div class="card mx-auto mb-4" style="max-width: 500px;">
        <div class="card-header">
            <div class="card-title h4 mb-0">Add Career</div>
        </div>
        <div class="card-body">
            <form id="careerForm" action="{{ route('admin.careers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="career_title" id="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="career_desc" id="description" class="form-control" required rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <div id="careerFormMsg" class="mt-2"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('careerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const msgDiv = document.getElementById('careerFormMsg');
    msgDiv.innerHTML = '';

    fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                msgDiv.innerHTML = '<div class="alert alert-success">Career added successfully!</div>';
                form.reset();
            } else if (data.errors) {
                let errors = Object.values(data.errors).map(e => `<div>${e}</div>`).join('');
                msgDiv.innerHTML = `<div class="alert alert-danger">${errors}</div>`;
            } else {
                msgDiv.innerHTML = '<div class="alert alert-danger">Something went wrong.</div>';
            }
        })
        .catch(() => {
            msgDiv.innerHTML = '<div class="alert alert-danger">Server error. Please try again.</div>';
        });
    });

    // Sidebar JS (unchanged)
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
        document.querySelector('.sidebar-overlay').classList.toggle('active');
    });
    document.querySelector('.sidebar-overlay').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.remove('active');
        this.classList.remove('active');
    });
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                document.querySelector('.sidebar').classList.remove('active');
                document.querySelector('.sidebar-overlay').classList.remove('active');
            }
        });
    });
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.sidebar-overlay').classList.remove('active');
        }
    });
</script>
@endsection
