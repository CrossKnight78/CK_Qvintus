<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['category_name'];
    if ($book->createCategory($categoryName)) {
        echo '<div class="alert alert-success">Category created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create category.</div>';
    }
    echo '<div class="text-center">
            <a href="book-management.php" class="btn btn-primary">Go to Book Management</a>
          </div>';
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Category</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>