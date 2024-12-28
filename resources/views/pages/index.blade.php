<!DOCTYPE html>
<html lang="en">
@include('partials.head')

<body class="sb-nav-fixed">
    @include('partials.nav')
    <div id="layoutSidenav">
        @include('partials.sidenav')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>


                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Restaurant</th>
                                            <th>Email</th>
                                            <th>Otp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $users)
                                            <tr>
                                                <td>{{ $users['id'] ?? 'N/A' }}</td>
                                                <td>{{ $users['name'] ?? 'N/A' }}</td>
                                                <td>{{ $users['email'] ?? 'N/A' }}</td>
                                                <td>{{ $users['otp'] ?? 'N/A' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </main>

        </div>
    </div>
    @include('partials.js')
</body>

</html>
