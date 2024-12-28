<!DOCTYPE html>
<html lang="en">
@include('partials.head')

<body class="sb-nav-fixed bg-light">
    @include('partials.nav')
    <div id="layoutSidenav">
        @include('partials.sidenav')
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-5 d-flex justify-content-center">
                    <div class="card shadow-lg" style="width: 100%; max-width: 500px;">
                        <div class="card-header text-center bg-primary text-white">
                            <h3 class="mb-0">Register Restaurant</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="/addUser" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="restaurantName" class="form-label">Restaurant Name</label>
                                    <input type="text" class="form-control" id="restaurantName" name="restaurantName" placeholder="Enter restaurant name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('partials.js')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
</body>

</html>
