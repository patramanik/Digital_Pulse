@extends('layouts.master')
@section('title', 'Digital Pulse-services')
@section('content')
<!-- Content -->
<div class="content">

    @if (session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card shadow mt-3">
        <div class="card-header bg-white text-center">
            <h4 class="fw-bold text-dark">Job Openings List</h4>
            <button class="btn px-4 float-end text-white bg-dark fw-semibold border-0" data-bs-toggle="modal"
                data-bs-target="#addCareerModal">Add Jobs</button>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table id="subject-table" class="table table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Sno.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($careers as $career)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $career->career_title }}</td>
                            <td>{{ $career->career_desc }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-dark btn-m btn-edit-career" data-id="{{ $career->id }}">
                                        <i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-m delete-career"
                                        data-id="{{ $career->id }}"><i class="fa fa-trash"></i></button>
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
    <div class="modal fade" id="addCareerModal" tabindex="-1" aria-labelledby="addCareerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="addCareerModalLabel">Add Career</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="careerForm" action="{{ route('admin.careers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="career_title" id="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="career_desc" id="description" class="form-control" required
                                rows="3"></textarea>
                        </div>
                        <div id="careerFormMsg" class="mt-2"></div>
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
    <div class="modal fade" id="editCareerModal" tabindex="-1" aria-labelledby="editCareerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Edit Career</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editCareerForm" method="POST" >
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editCareerId" name="id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" name="career_title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea name="career_desc" id="edit_description" class="form-control" required
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#subject-table').DataTable({
        "lengthMenu": [5, 10, 20, 25, 50, 100],
        "order": [
            [0, "desc"]
        ]
    });

    // ADD Career AJAX
    $('#careerForm').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', 'Career added successfully!', 'success')
                        .then(() => location.reload());
                } else if (response.errors) {
                    let errorText = Object.values(response.errors).join("\n");
                    Swal.fire('Validation Error', errorText, 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Server error. Try again.', 'error');
            }
        });
    });

    // LOAD DATA IN EDIT MODAL
    $(document).on('click', '.btn-edit-career', function() {
        let id = $(this).data('id');
        $.ajax({
            url: "/admin/edit-career/" + id,
            type: "GET",
            success: function(res) {
                if (res.success) {
                    $('#editCareerId').val(res.data.id);
                    $('#edit_title').val(res.data.career_title);
                    $('#edit_description').val(res.data.career_desc);
                    $('#editCareerModal').modal('show');
                } else {
                    Swal.fire('Error', 'Career not found.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Could not load data.', 'error');
            }
        });
    });
    // DELETE Career
    $('.delete-career').on('click', function() {
        var careerId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this career?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/delete-career/' + careerId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(res) {
                        Swal.fire('Deleted!', 'The career has been deleted.',
                                'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Failed', 'Unable to delete.', 'error');
                    }
                });
            }
        });
    });
});

$(document).ready(function() {
    // Validate and submit
    $('#editCareerForm').validate({
        rules: {
            career_title: {
                required: true,
                minlength: 2
            },
            career_desc: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            career_title: {
                required: "Please enter a career title",
                minlength: "At least 2 characters required"
            },
            career_desc: {
                required: "Please enter a description",
                minlength: "At least 5 characters required"
            }
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },
        submitHandler: function(form) {
            let formData = new FormData(form);
            let careerId = $('#editCareerId').val();
            $.ajax({
                type: 'POST',
                url: '/admin/update-career/'+careerId,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Updated!',
                        text: 'Career updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message ||
                            'Something went wrong.'
                    });
                }
            });
        }
    });
});
</script>
@endsection
