<?php
include_once 'includes/header.php';
?>

<div class="container text-center">
    <h1 class="my-5">Admin</h1>
    <div class="row justify-content-center"> <!-- Added justify-content-center here -->
        <!-- Card 1: Worker List -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Worker List</h5>
                    <p class="card-text">View and manage the list of workers.</p>
                    <a href="admin-workerlist.php" class="btn btn-primary">Go to Worker List</a>
                </div>
            </div>
        </div>
        <!-- Card 2: Book Management -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Book Management</h5>
                    <p class="card-text">Manage and organize books.</p>
                    <a href="book-management.php" class="btn btn-primary">Go to Book Management</a>
                </div>
            </div>
        </div>
        <!-- Card 3: Author Management -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Author Management</h5>
                    <p class="card-text">Manage and organize authors.</p>
                    <a href="author-management.php" class="btn btn-primary">Go to Author Management</a>
                </div>
            </div>
        </div>
        <!-- Card 4: Genre Management -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Genre Management</h5>
                    <p class="card-text">Manage and organize genres.</p>
                    <a href="genre-management.php" class="btn btn-primary">Go to Genre Management</a>
                </div>
            </div>
        </div>
        <!-- Card 5: Illustrator Management -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Illustrator Management</h5>
                    <p class="card-text">Manage and organize illustrators.</p>
                    <a href="illustrator-management.php" class="btn btn-primary">Go to Illustrator Management</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>