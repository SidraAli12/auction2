<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Hello, {{ auth()->user()->name }}</h3>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h4>Your Dashboard</h4>
            <p>Now you can create and manage auctions here.</p>
            <a href="{{ route('auctions.index') }}" class="btn btn-primary">Go to Auctions</a>
        </div>
    </div>
</div>
</body>
</html>
