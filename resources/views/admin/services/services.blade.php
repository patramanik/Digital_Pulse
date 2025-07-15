@extends('layouts.master')
@section('title', 'Digital Pulse - Services')

@section('content')
<div class="content">
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card shadow mt-3">
        <div class="card-header bg-white text-center">
            <h4 class="fw-bold text-dark">Services List</h4>
            <button class="btn px-4 float-end text-white bg-dark fw-semibold border-0" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add Service</button>
        </div>

        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="service-table" class="table table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Sno.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $service->service_title }}</td>
                                <td>{{ $service->service_desc }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-dark btn-sm btn-edit-service" data-id="{{ $service->id }}">
                                            <i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm delete-service" data-id="{{ $service->id }}">
                                            <i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Add Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="serviceForm" action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="service_title" class="form-label">Title</label>
                            <input type="text" name="service_title" id="service_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="service_desc" class="form-label">Description</label>
                            <textarea name="service_desc" id="service_desc" class="form-control" required rows="3"></textarea>
                        </div>
                        <div id="serviceFormMsg" class="mt-2"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Edit Service</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editServiceForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editServiceId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_service_title" class="form-label">Title</label>
                            <input type="text" name="service_title" id="edit_service_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_service_desc" class="form-label">Description</label>
                            <textarea name="service_desc" id="edit_service_desc" class="form-control" required rows="3"></textarea>
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
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#service-table').DataTable(
        {
        "lengthMenu": [5, 10, 20, 25, 50, 100],
        "order": [
            [0, "desc"]
        ]
        }
    );

    // Add Service
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);

        $.ajax({
            url: form.action,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(res) {
                if (res.success) {
                    Swal.fire('Success', res.message, 'success')
                        .then(() => location.reload());
                } else {
                    $('#serviceFormMsg').html(`<div class="alert alert-danger">${res.message || 'Validation error'}</div>`);
                }
            },
            error: function() {
                $('#serviceFormMsg').html('<div class="alert alert-danger">Something went wrong!</div>');
            }
        });
    });

    // Load Edit Service
    $(document).on('click', '.btn-edit-service', function() {
        let id = $(this).data('id');
        $.ajax({
            url: '/admin/edit-service/'+ id,
            type: "GET",
            success: function(res) {
                if (res.success) {
                    $('#editServiceId').val(res.data.id);
                    $('#edit_service_title').val(res.data.service_title);
                    $('#edit_service_desc').val(res.data.service_desc);
                    $('#editServiceModal').modal('show');
                } else {
                    Swal.fire('Error', 'Service not found.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Could not load service.', 'error');
            }
        });
    });

    // Update Service
    $('#editServiceForm').validate({
        rules: {
            service_title: { required: true, minlength: 2 },
            service_desc: { required: true, minlength: 5 }
        },
        submitHandler: function(form) {
            const formData = new FormData(form);
            const id = $('#editServiceId').val();

            $.ajax({
                url: `/admin/update-service/${id}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Updated!', res.message, 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', res.message || 'Update failed', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Server error occurred.', 'error');
                }
            });
        }
    });

    // Delete service
    $('.delete-service').click(function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently delete the service.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/delete-service/'+id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (res) {
                        Swal.fire('Deleted!', res.message, 'success').then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire('Error', 'Unable to delete.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection
