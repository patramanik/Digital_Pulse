@extends('layouts.master')
@section('title', 'Digital Pulse-works')
@section('content')
    <!-- Content -->
    <div class="container mt-4">
        <!-- Services Form -->
        <div class="card mx-auto" style="max-width: 500px; margin-bottom: 30px;">
            <div class="card-header">
                <div class="card-title h4 mb-0">Add Work</div>
            </div>
            <div class="card-body">
                <form id="workForm">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="work_title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="work_desc" id="description" class="form-control" required rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <div id="formMessage" class="mt-3"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<!-- Bootstrap JS (via CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

    // AJAX form submission
    document.getElementById('workForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let form = e.target;
        let formData = new FormData(form);
        let csrfToken = document.querySelector('input[name="_token"]').value;

        fetch("{{ route('admin.works.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                document.getElementById('formMessage').innerHTML = '<span class="text-success">Work added successfully!</span>';
                form.reset();
            }else{
                document.getElementById('formMessage').innerHTML = '<span class="text-danger">'+(data.message || 'Error occurred')+'</span>';
            }
        })
        .catch(error => {
            document.getElementById('formMessage').innerHTML = '<span class="text-danger">Error occurred</span>';
        });
    });
</script>
@endsection

