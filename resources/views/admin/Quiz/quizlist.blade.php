@extends('layouts.master')

@section('title', 'All Quizzes')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">All Quiz Questions</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="quizTable">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th>Correct Answer</th>
                        <th>Explanation</th>
                        <th>Level</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $index => $quiz)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $quiz->classSubject->class->class_name ?? 'N/A' }}</td>
                            <td>{{ $quiz->classSubject->subject->subject_name ?? 'N/A' }}</td>
                            <td>{{ $quiz->question }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach ($quiz->formatted_options as $option)
                                        <li>{{ $option }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $quiz->formatted_options[$quiz->corr_ans - 1] ?? 'N/A' }}</td>
                            <td>{{ $quiz->expl ?? '-' }}</td>
                            <td>{{ ucfirst($quiz->level) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No quizzes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    {{-- jQuery (required for DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#quizTable').DataTable({
                "pageLength": 10, // Show 10 rows by default
                "lengthMenu": [5, 10, 25, 50, 100], // Dropdown options
                "ordering": true, // Enable sorting
                "searching": true, // Enable searching
            });
        });
    </script>
@endpush
