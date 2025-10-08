<!DOCTYPE html>
<html>
<head>
    <title>Auctions App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-light bg-light mb-4 px-4">
    <a href="/dashboard" class="navbar-brand">Auctions</a>
    <div>
        @auth
            <span class="me-3">Hi, {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        @endauth
    </div>
</nav>

@yield('content')

</body>
</html>
