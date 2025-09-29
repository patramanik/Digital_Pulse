@extends('layouts.master')
@section('title', 'Quiz Entry | Quiz Admin')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Subject</h4>
            </div>
            <div class="card-body">
                <form id="subjectForm">
                    @csrf
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name <span class="text-danger">*</span></label>
                        <input type="text" id="subject_name" name="subject_name" class="form-control"
                            placeholder="Enter subject name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Subjects List</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0" id="subjectsTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Subject Name</th>
                            <th>Entry Time</th>
                            <th>Entry By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr>
                                <td>{{ $subject->id }}</td>
                                <td>{{ $subject->subject_name }}</td>
                                <td>{{ $subject->entry_ts }}</td>
                                <td>{{ $subject->entry_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('subjectForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            // Show confirmation popup
            Swal.fire({
                icon: 'question',
                title: 'Confirm Submission',
                text: 'Are you sure you want to add this subject?',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User clicked "Yes", proceed with AJAX
                    fetch("{{ route('subjects.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Append new row to table
                                const table = document.getElementById('subjectsTable').querySelector(
                                    'tbody');
                                const newRow = table.insertRow(0);
                                newRow.innerHTML = `
                        <td>${data.subject.id}</td>
                        <td>${data.subject.subject_name}</td>
                        <td>${data.subject.entry_ts}</td>
                        <td>${data.subject.entry_id}</td>
                    `;

                                form.reset();

                                // Success popup
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                    showConfirmButton: true
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to add subject.',
                            });
                        });
                }
            });
        });
    </script>
@endsection
