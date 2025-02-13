<!DOCTYPE html>
<html lang="en">
@include('partials.head')

<body class="sb-nav-fixed">
    @include('partials.nav')
    <div id="layoutSidenav">
        @include('partials.sidenav')
        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-4">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white d-flex align-items-center">
                            <i class="fas fa-users me-2"></i> Influencer Management
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab" aria-controls="form" aria-selected="true">
                                        <i class="fas fa-user-plus me-1"></i> Add Influencer
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="table-tab" data-bs-toggle="tab" data-bs-target="#table" type="button" role="tab" aria-controls="table" aria-selected="false">
                                        <i class="fas fa-list me-1"></i> Influencer List
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
                                    <form action="{{ route('influencer.store') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="influencer" class="form-label"><i class="fas fa-user"></i> Name</label>
                                                <input type="text" class="form-control" id="influencer" name="influencer" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="location" class="form-label"><i class="fas fa-map-marker-alt"></i> Location</label>
                                                <input type="text" class="form-control" id="location" name="location" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="insta" class="form-label"><i class="fab fa-instagram"></i> Instagram</label>
                                                <input type="text" class="form-control" id="insta" name="insta">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="facebook" class="form-label"><i class="fab fa-facebook"></i> Facebook</label>
                                                <input type="text" class="form-control" id="facebook" name="facebook">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="youtube" class="form-label"><i class="fab fa-youtube"></i> YouTube</label>
                                                <input type="text" class="form-control" id="youtube" name="youtube">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="offers" class="form-label"><i class="fas fa-gift"></i> Offers</label>
                                                <input type="text" class="form-control" id="offers" name="offers">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="price" class="form-label"><i class="fas fa-rupee-sign"></i> Price</label>
                                                <input type="number" class="form-control" id="price" name="price" value="0" required>
                                            </div>
                                            <div class="col-md-6 d-flex align-items-center">
                                                <input type="checkbox" class="form-check-input me-2" id="available" name="available" checked>
                                                <label class="form-check-label" for="available"> Available</label>
                                            </div>
                                            <div class="col-12">
                                                <label for="details" class="form-label"><i class="fas fa-info-circle"></i> Details</label>
                                                <textarea class="form-control" id="details" name="details" rows="2" required></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-paper-plane"></i> Submit</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="table-tab">
                                    <table class="table table-bordered mt-3">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th><i class="fas fa-user"></i> Influencer</th>
                                                <th><i class="fab fa-instagram"></i> Instagram</th>
                                                <th><i class="fab fa-facebook"></i> Facebook</th>
                                                <th><i class="fab fa-youtube"></i> YouTube</th>
                                                <th><i class="fas fa-map-marker-alt"></i> Location</th>
                                                <th><i class="fas fa-rupee-sign"></i> Price</th>
                                                <th><i class="fas fa-check-circle"></i> Available</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $index => $influencer)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $influencer['influencer'] }}</td>
                                                <td>{{ $influencer['insta'] }}</td>
                                                <td>{{ $influencer['facebook'] }}</td>
                                                <td>{{ $influencer['youtube'] }}</td>
                                                <td>{{ $influencer['location'] }}</td>
                                                <td>₹{{ $influencer['price'] }}</td>
                                                <td>{!! $influencer['available'] ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>' !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
