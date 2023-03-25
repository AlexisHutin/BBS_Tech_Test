<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
</head>

<body class="antialiased">

    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand text-light mb-0 h1">
                Username : {{ $userInfo['username'] ?? 'None' }} - User Id : {{ $userInfo['user_id'] ?? 'None' }}
            </span>
        </div>
    </nav>

    <div class="container p-5">
        @if (!empty($errors))
            <div class="alert alert-danger" role="alert">
                An errors occurred. Please try again later.
            </div>
        @endif

        @if (empty($pictures))
            <div class="alert alert-warning" role="alert">
                There is pictures to display for this user.
            </div>
        @else
            <div class="container-fluid d-flex flex-wrap">
                @foreach ($pictures as $picture)
                    <div class="card m-1" style="width: 18rem;">
                        <img src="{{ $picture['media_url'] }}" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">{{ $picture['caption'] }}</p>
                            <a 
                                href="{{ $picture['permalink'] }}" 
                                target="_blank"
                                class="btn btn-outline-secondary btn-sm" 
                            >
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>

</html>
