@extends('layouts.master')
@section('title', 'Users List')
@section('content')
    <style>
        .btn-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1;
            border-radius: 0.2rem;
        }
    </style>
    <div class="container mt-4">
        <div class="card">
             <div class="card-header bg-white text-center">
                    <h4 class="fw-bold" style="
                        background: linear-gradient(90deg, #28a745, #0d6efd);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        display: inline-block;
                        margin: 0;
                    ">
                      Users List
                    </h4>
                </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="usersTable" class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Users Status</th>
                                <th>Users Role</th>
                                <th>Created At</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <?php
                                //   dd($user);
                                ?>

                                <tr>
                                    {{-- <td>{{ $user->id }}</td> --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="btn btn-{{ $user->user_status == 1 ? 'success' : 'danger' }} btn-xs">
                                            {{ $user->user_status == 1 ? 'Active' : 'Suspended' }}
                                        </span>
                                    </td>


                                    <td>
                                        @if ($user->user_role == 1)
                                            <span class="btn btn-primary btn-xs">Developer</span>
                                        @elseif($user->user_role == 2)
                                            <span class="btn btn-primary btn-xs">User</span>
                                        @endif
                                    </td>

                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>

                                    <td>
                                        @if ($user->user_status == 1)
                                            <button class="btn btn-danger btn-xs suspend-user"
                                                data-user-id="{{ $user->id }}">Suspend</button>
                                        @elseif($user->user_status == 0)
                                            <button class="btn btn-success btn-xs active-user"
                                                data-user-id="{{ $user->id }}">Active</button>
                                        @endif
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();
            // Ajax request to suspend user with SweetAlert confirmation
            $('.suspend-user').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');

                // SweetAlert2 confirmation prompt
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to suspend this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, suspend it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/suspend/' + userId,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Update the status cell if applicable
                                var statusCell = $('tr[data-user-id="' + userId +
                                    '"] .user-status');
                                statusCell.html(
                                    '<span class="btn btn-danger btn-xs">Suspended</span>'
                                );

                                Swal.fire(
                                    'Suspended!',
                                    'User suspended successfully.',
                                    'success'
                                ).then(() => {

                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Error suspending user.',
                                    'error'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
            $('.active-user').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');

                // SweetAlert2 confirmation prompt
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to active this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, active it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/active/' + userId,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Update the status cell if applicable
                                var statusCell = $('tr[data-user-id="' + userId +
                                    '"] .user-status');
                                statusCell.html(
                                    '<span class="btn btn-danger btn-xs">Suspended</span>'
                                );

                                Swal.fire(
                                    'Activated!',
                                    'User Active successfully.',
                                    'success'
                                ).then(() => {

                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Error Active user.',
                                    'error'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();

            // Unified function to handle user status changes
            function changeUserStatus(userId, action) {
                let actionText = action === 'suspend' ? 'Suspend' : 'Activate';
                let actionUrl = '/' + action + '/' + userId;
                let newStatusText = action === 'suspend' ? 'Suspended' : 'Active';
                let newStatusClass = action === 'suspend' ? 'btn-danger' : 'btn-success';

                Swal.fire({
                    title: `Are you sure?`,
                    text: `Do you really want to ${actionText.toLowerCase()} this user?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: `Yes, ${actionText} it!`,
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(`${actionText}d!`,
                                        `User ${newStatusText.toLowerCase()} successfully.`,
                                        'success')
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire('Error!',
                                    `Error ${actionText.toLowerCase()}ing user.`, 'error');
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            }

            // Event listener for suspend and activate buttons
            $('.suspend-user, .active-user').click(function(e) {
                e.preventDefault();
                let userId = $(this).data('user-id');
                let action = $(this).hasClass('suspend-user') ? 'suspend' : 'active';
                changeUserStatus(userId, action);
            });
        });
    </script>


@endsection
