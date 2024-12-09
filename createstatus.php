<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statusName = $_POST['s_name'];
    if ($book->createStatus($statusName)) {
        echo '<div class="alert alert-success">Status created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create status.</div>';
    }
    echo '<div class="text-center">
            <a href="book-management.php" class="btn btn-primary">Go to Book Management</a>
          </div>';
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Status</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="s_name" class="form-label">Status Name</label>
            <input type="text" class="form-control" id="s_name" name="s_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Status</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>