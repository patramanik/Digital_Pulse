@extends('layouts.master')
@section('title', 'Class Subject Assignment')

@section('content')
    <div class="container py-5">

        <!-- Assignment Form -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Assign Subject to Class</div>
            <div class="card-body">
                <form id="classSubjectForm">
                    @csrf
                    <div class="mb-3">
                        <label for="class_id">Class</label>
                        <select name="class_id" id="class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-select" required>
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Assign</button>
                </form>
            </div>
        </div>

        <!-- Class Filter -->
        <div class="mb-3 d-flex justify-content-center">
            <div style="width: 20%;">
                <label for="filter_class" class="form-label">Filter by Class</label>
                <select id="filter_class" class="form-select">
                    <option value="">All Classes</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <!-- Assigned Subjects Table -->
        <div class="card">
            <div class="card-header bg-secondary text-white">Assigned Subjects</div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0" id="assignedTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classSubjects as $entry)
                            <tr data-class-id="{{ $entry->class->id }}">
                                <td>{{ $entry->id }}</td>
                                <td>{{ $entry->class->class_name }}</td>
                                <td>{{ $entry->subject->subject_name }}</td>
                                <td>{{ $entry->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Assign Subject Form
            document.getElementById('classSubjectForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Assignment',
                    text: 'Assign this subject to class?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, assign it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('class_subject.store') }}", {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'input[name="_token"]').value
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    const table = document.getElementById('assignedTable')
                                        .querySelector('tbody');
                                    const row = table.insertRow(0);
                                    row.setAttribute('data-class-id', data.entry.class
                                    .id); // add class ID for filtering
                                    row.innerHTML = `
                            <td>${data.entry.id}</td>
                            <td>${data.entry.class.class_name}</td>
                            <td>${data.entry.subject.subject_name}</td>
                            <td>${new Date().toLocaleString()}</td>
                        `;
                                    this.reset();
                                    Swal.fire('Success', data.message, 'success');
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire('Error', 'Failed to assign subject', 'error');
                            });
                    }
                });
            });

            // Frontend-only Class Filter
            document.getElementById('filter_class').addEventListener('change', function() {
                const selectedClass = this.value;
                const rows = document.querySelectorAll('#assignedTable tbody tr');

                rows.forEach(row => {
                    if (selectedClass === "" || row.dataset.classId === selectedClass) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

        });
    </script>
@endsection
