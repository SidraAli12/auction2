<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-center mb-4">Login</h4>

                    <div id="alert"></div>

                    <form id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <div class="text-center mt-3">
                            <a href="{{ route('register.form') }}">Create new account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#loginForm').on('submit', function(e){ //jab login form submit hota hai, tab ye event listner function chalta hai.
    e.preventDefault();
    let form = $(this);
    $('#alert').html('<div class="alert alert-info">Logging in...</div>'); //User ko “Logging in message show karta hai jab tak response nahi aata.

    $.ajax({
        url: "{{ route('login') }}",//it is going to call logincontroller func
        type: "POST",
        data: form.serialize(),
        success: function(){
            $('#alert').html('<div class="alert alert-success"> Login successful</div>');
            setTimeout(() => window.location.href = "{{ route('dashboard') }}", 1000); //1 second baad user ko dashboard par redirect karenga
        },
        error: function(xhr){
            $('#alert').html('<div class="alert alert-danger"> Invalid email or password.</div>');
        }
    });
});
</script>
</body>
</html>
