<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authorName = $_POST['author_name'];
    if ($book->createAuthor($authorName)) {
        echo '<div class="alert alert-success">Author created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create author.</div>';
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Author</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="author_name" class="form-label">Author Name</label>
            <input type="text" class="form-control" id="author_name" name="author_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Author</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>