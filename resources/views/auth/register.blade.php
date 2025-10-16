<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-center mb-4">Register</h4>

                    <div id="alert"></div>

                    <form id="registerForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Register as</label>
                            <select name="role" class="form-control" required>
                                <option value="buyer">Buyer</option>
                                <option value="seller">Seller</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register</button>
                        <div class="text-center mt-3">
                            <a href="{{ route('login.form') }}">Already have an account? Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#registerForm').on('submit', function(e){
    e.preventDefault();//ye fun Default form submit hone se rokta hai issey page rrelaod nhi hota 
    let form = $(this);
    $('#alert').html('<div class="alert alert-info">Please wait...</div>');

    $.ajax({
        url: "{{ route('register') }}",
        type: "POST",
        data: form.serialize(),//Form data serialize karke bhejty hai like name pass role
        success: function(res){
            $('#alert').html('<div class="alert alert-success"> Registered successfully! Redirecting...</div>');
            setTimeout(() => window.location.href = "{{ route('dashboard') }}", 1000);
        },
        error: function(xhr){
            let errors = xhr.responseJSON?.errors;
            if(errors){
                let list = Object.values(errors).flat().join('<br>');//Errors ko ek string me convert karta hai line by line.
                $('#alert').html('<div class="alert alert-danger">'+list+'</div>');
            } else {
                $('#alert').html('<div class="alert alert-danger"> Something went wrong.</div>');
            }
        }
    });
});
</script>
</body>
</html>
