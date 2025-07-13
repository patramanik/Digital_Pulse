<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Profile</title>
</head>

<body class="bg-light">
    <header class="py-3 bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand ps-3" href="{{ url('/dashboard') }}">
                <img src="{{ asset('public/assets/img/medicallearner_logo.png') }}" alt="Logo" width="135" height="40">
            </a>
        </div>
    </header>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="p-4 bg-white shadow rounded">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="p-4 bg-white shadow rounded">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-4 bg-white shadow rounded">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
