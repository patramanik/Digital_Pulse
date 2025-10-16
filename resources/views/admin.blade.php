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
                    <div class="card-title h6">Contact Messages</div>
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
                    <div class="card-title h6">Works</div>
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
                    <div class="card-title h6">Careers</div>
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
                    <div class="card-title h6">Services</div>
                    <div class="card-value">{{ $services_count }}</div>
                </div>
                <div class="card-icon danger">
                    <i class="fas fa-cogs"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Recent Activity -->
    <div class="activity-list">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Recent Message</h3>
        @if(isset($contacts) && count($contacts))
        @foreach($contacts as $contact)
        <div class="d-flex align-items-start justify-content-between border-bottom py-3"
            id="contact-{{ $contact->id }}">
            <div class="d-flex align-items-start gap-3">
                <div class="text-primary fs-4">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h6 class="mb-1">{{ $contact->full_name }}</h6>
                    <p class="mb-1 text-muted small">{{ $contact->email }}</p>
                    <p class="mb-0">{{ $contact->message }}</p>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-danger delete-contact ms-3" data-id="{{ $contact->id }}">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        @endforeach
        @else
        <div class="border p-3 text-center text-muted">No message available.</div>
        @endif

    </div>
</div>
@endsection
@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-contact').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const confirmed = confirm('Are you sure you want to delete this message?');

            if (!confirmed) return;

            fetch(`/admin/contacts/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    return response.json().then(data => {
                        alert(data.message || 'Failed to delete the message.');
                    });
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
                console.error(error);
            });
        });
    });
});
</script>

@endsection
