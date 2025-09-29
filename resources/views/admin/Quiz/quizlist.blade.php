@extends('layouts.master')

@section('title', 'All Quizzes')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">All Quiz Questions</h2>

    <div class="row">
        @forelse($quizzes as $quiz)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Class:</strong> {{ $quiz->classSubject->class->class_name ?? 'N/A' }} |
                        <strong>Subject:</strong> {{ $quiz->classSubject->subject->subject_name ?? 'N/A' }}
                    </div>
                    <div class="card-body">
                        <p><strong>Question:</strong> {{ $quiz->question }}</p>

                        <p><strong>Options:</strong></p>
                        <ul>
                            @foreach($quiz->formatted_options as $option)
                                <li>{{ $option }}</li>
                            @endforeach
                        </ul>

                        <p><strong>Correct Answer:</strong> 
                            {{ $quiz->formatted_options[$quiz->corr_ans - 1] ?? 'N/A' }}
                        </p>

                        @if($quiz->expl)
                            <p><strong>Explanation:</strong> {{ $quiz->expl }}</p>
                        @endif

                        <p><small>Level: {{ ucfirst($quiz->level) }}</small></p>
                    </div>
                </div>
            </div>
        @empty
            <p>No quizzes found.</p>
        @endforelse
    </div>
</div>
@endsection
