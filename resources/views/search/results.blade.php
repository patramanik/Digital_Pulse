@extends('layouts.master')

@section('title', 'Search Results')

@section('content')
    <div class="container-fluid px-4 py-4">
        <h2 class="mb-4">Search Results for: <span class="text-primary">"{{ $query }}"</span></h2>

        {{-- Posts Section --}}
        <div class="mb-5">
            <h3 class="mb-3"><i class="bi bi-file-earmark-text"></i> Posts</h3>
            @if($posts->count())
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($posts as $post)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ url('/post/'.$post->id) }}" class="text-decoration-none text-dark">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted">{{ Str::limit($post->description, 100) }}</p>
                                </div>
                                <div class="card-footer bg-light">
                                    <small class="text-muted">Posted on {{ $post->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning mt-3">No posts found.</div>
            @endif
        </div>

        {{-- Categories Section --}}
        <div class="mb-5">
            <h3 class="mb-3"><i class="bi bi-folder"></i> Categories</h3>
            @if($categories->count())
                <div class="row row-cols-2 row-cols-md-4 g-3">
                    @foreach ($categories as $category)
                        <div class="col">
                            <a href="{{ url('/category/'.$category->id) }}" class="btn btn-outline-secondary w-100">
                                {{ $category->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info mt-3">No categories found.</div>
            @endif
        </div>
    </div>
@endsection
