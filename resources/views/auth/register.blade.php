@extends('layouts.app')

@section('styles')
    <style>
        .login-card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 15px;
        }

        .login-header {
            font-size: 2rem;
            background: linear-gradient(90deg, #28a745, #0d6efd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .btn-gradient {
            background: linear-gradient(to right, #28a745, #0d6efd);
            border: none;
            color: white;
        }

        .btn-gradient:hover {
            background: linear-gradient(to right, #218838, #0b5ed7);
        }
    </style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card">
                <div class="card-body p-5">
                    <h2 class="login-header mb-4">{{ __('Create Your Account') }}</h2>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-2">
                            <label for="name" class="form-label">{{ __('Full Name') }}</label>
                            <input id="name" type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-2">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-2">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-2">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password"
                                class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-gradient btn-lg">
                                {{ __('Sign Up') }}
                            </button>
                        </div>

                        {{-- Login Link --}}
                        <div class="text-center mt-3">
                            <small>{{ __('Already have an account?') }}
                                <a href="{{ route('login') }}">{{ __('Login here') }}</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
