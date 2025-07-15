@extends('layouts.master')
@section('title', 'Digital Pulse - Works')

@section('content')
<div class="content">
    @if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card shadow mt-3">
        <div class="card-header bg-white text-center">
            <h4 class="fw-bold text-dark">Work List</h4>
            <button class="btn px-4 float-end text-white bg-dark fw-semibold border-0" data-bs-toggle="modal"
                data-bs-target="#addWorkModal">Add Work</button>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="work-table" class="table table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Sno.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($works as $work)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $work->work_title }}</td>
                            <td>{{ $work->work_desc }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-dark btn-sm btn-edit-work" data-id="{{ $work->id }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-work" data-id="{{ $work->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addWorkModal" tabindex="-1" aria-labelledby="addWorkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Add Work</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="workForm" action="{{ route('admin.works.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="work_title" class="form-label">Title</label>
                            <input type="text" name="work_title" id="work_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="work_desc" class="form-label">Description</label>
                            <textarea name="work_desc" id="work_desc" class="form-control" required rows="3"></textarea>
                        </div>
                        <div id="workFormMsg" class="mt-2"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editWorkModal" tabindex="-1" aria-labelledby="editWorkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Edit Work</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editWorkForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editWorkId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_work_title" class="form-label">Title</label>
                            <input type="text" name="work_title" id="edit_work_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_work_desc" class="form-label">Description</label>
                            <textarea name="work_desc" id="edit_work_desc" class="form-control" required
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#work-table').DataTable(

        {
            "lengthMenu": [5, 10, 20, 25, 50, 100],
            "order": [
                [0, "desc"]
            ]
        }

    );

    // Add Work
    $('#workForm').submit(function(e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', data.message, 'success').then(() => location.reload());
                } else {
                    $('#workFormMsg').html(`<div class="alert alert-danger">${data.message}</div>`);
                }
            })
            .catch(() => {
                $('#workFormMsg').html(
                    '<div class="alert alert-danger">Something went wrong!</div>');
            });
    });

    // Load Edit Modal
    $(document).on('click', '.btn-edit-work', function() {
        let id = $(this).data('id');
        $.ajax({

            url: '/admin/edit-work/'+ id,
            type: "GET",
            success: function(res) {
                if (res.success !== false) {
                $('#editWorkId').val(res.id);
                $('#edit_work_title').val(res.work_title);
                $('#edit_work_desc').val(res.work_desc);
                $('#editWorkModal').modal('show');
            } else {
                Swal.fire('Error', res.message || 'Not found', 'error');
            }
            },
            error: function() {
                Swal.fire('Error', 'Could not load service.', 'error');
            }

        });
    });

    // Update Work
    $('#editWorkForm').validate({
        rules: {
            work_title: {
                required: true,
                minlength: 2
            },
            work_desc: {
                required: true,
                minlength: 5
            }
        },
        submitHandler: function(form) {
            let formData = new FormData(form);
            const id = $('#editWorkId').val();
            $.ajax({
                url: '/admin/update-work/'+id,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(res) {
                    Swal.fire('Updated!', 'Work updated successfully!', 'success')
                        .then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error', 'Update failed!', 'error');
                }
            });
        }
    });

    // Delete Work
    $(document).on('click', '.delete-work', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this work?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/delete-work/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function() {
                        Swal.fire('Deleted!', 'Work deleted successfully.',
                                'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'Could not delete.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection
