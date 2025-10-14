<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
< class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="text-center mb-4">Register</h4>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="mb-3">
    <label for="role" class="form-label">Register as</label>
    <select name="role" id="role" class="form-control" required>
        <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buyer</option>
        <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller</option>
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
document.querySelector('#registerForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const form = e.target;
  const alertBox = document.querySelector('#alert');

  alertBox.textContent = 'Please wait...';
  const data = new FormData(form);

  const res = await fetch("{{ route('register') }}", {
    method: "POST",
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: data
  });

  if (res.ok) {
    alertBox.textContent = ' Registered successfully! Redirecting...';
    setTimeout(() => window.location.href = '/dashboard', 1000);
  } else {
    const result = await res.json();
    alertBox.textContent = result.message || ' Error! Please try again.';
  }
});
</script>



</body>
</html>