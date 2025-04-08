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
                            Restaurant DataTable
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
                                            <th>Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $users)
                                            <tr data-id="{{ $users['id'] }}" data-rest="{{ $users['restaurantId'] }}"
                                                class="users-row" style="cursor: pointer;">
                                                <td>{{ $users['id'] ?? 'N/A' }}</td>
                                                <td>{{ $users['name'] ?? 'N/A' }}</td>
                                                <td>{{ $users['email'] ?? 'N/A' }}</td>
                                                <td>{{ $users['otp'] ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($users['user_profile']['permission'] == 1)
                                                        All
                                                    @else
                                                        Only Order
                                                    @endif
                                                </td>
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

    <!-- Modal -->
    <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionModalLabel">Update Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="permissionSelect" class="form-label">Select Permission</label>
                        <select class="form-select" id="permissionSelect">
                            <option value="0">Only Order</option>
                            <option value="1">All</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="savePermission">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.js')
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedRestaurantId = null;
        const modal = new bootstrap.Modal(document.getElementById('permissionModal'));

        // Add click event to all rows
        document.querySelectorAll(".users-row").forEach(function(row) {
            row.addEventListener("click", function() {
                selectedRestaurantId = this.getAttribute("data-rest");
                const currentPermission = this.cells[4].textContent.trim() === 'All' ? '1' :
                '0';
                document.getElementById('permissionSelect').value = currentPermission;
                modal.show();
            });
        });

        // Save button handler
        document.getElementById('savePermission').addEventListener('click', function() {
            const permission = document.getElementById('permissionSelect').value;

            fetch('/update-permission', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content
                    },
                    method: "PUT",
                    body: JSON.stringify({
                        "restaurantId": selectedRestaurantId,
                        "permission": parseInt(permission)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.original.success) {
                        // Redirect to root (refresh)
                        alert("updated successfully");
                        window.location.href = "/dashboard";
                    } else {
                        console.error('Update failed:', data.message);
                        // Optionally show error message to user
                        alert('Failed to update permission: ' + data.message);
                    }
                    modal.hide();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating permission');
                    modal.hide();
                });
        });
    });
</script>

</html>
