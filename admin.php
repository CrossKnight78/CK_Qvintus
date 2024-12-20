<?php
// Include the header file
include_once 'includes/header.php';

// Check if the user is logged in
if (!$user->checkLoginStatus()) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the user has the admin role
if (!$user->checkUserRole(200)) {
    // Redirect to home page if not an admin
    header("Location: index.php");
    exit();
}
?>

<div class="container mt-2 mb-5 text-center">
    <h1 class="my-5">Admin</h1>
    <div class="row justify-content-center">
        <!-- Card 1: Worker List -->
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Worker List</h5>
                    <p class="card-text">View and manage the list of workers.</p>
                    <a href="admin-workerlist.php" class="btn btn-primary mt-auto">Go to Worker List</a>
                </div>
            </div>
        </div>
        <!-- Card 2: Book Management -->
        <div class="col-12 col-sm-6 col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Book Management</h5>
                    <p class="card-text">Manage and organize books.</p>
                    <a href="book-management.php" class="btn btn-primary mt-auto">Go to Book Management</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include the footer file
include_once 'includes/footer.php';
?>