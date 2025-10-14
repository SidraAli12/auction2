<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auctions App</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .container {
            background: #fff;
            border-radius: 10px;
            padding: 20px 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 py-3">
        <a href="{{ route('dashboard') }}" class="navbar-brand fw-bold text-primary">
             Auctions
        </a>

        <div class="ms-auto">
            @auth
                <span class="me-3 text-secondary">
                    Hi, <strong>{{ auth()->user()->name }}</strong>
                    <span class="badge bg-info text-dark ms-1">{{ ucfirst(auth()->user()->role) }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    
    <div class="container mt-4 mb-5">
        @yield('content')
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>