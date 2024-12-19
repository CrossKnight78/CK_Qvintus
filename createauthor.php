<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$source = isset($_GET['source']) ? $_GET['source'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authorName = $_POST['author_name'];
    if ($book->createAuthor($authorName)) {
        echo '<div class="alert alert-success">Author created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create author.</div>';
    }
    if ($source === 'createbook') {
        echo '<div class="text-center">
                <a href="createbook.php" class="btn btn-primary">Resume Book Creation</a>
              </div>';
    } else {
        echo '<div class="text-center">
                <a href="book-management.php" class="btn btn-primary">Go to Book Management</a>
              </div>';
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="text-center mb-4">Add New Author</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="author_name" class="form-label">Author Name</label>
                    <input type="text" class="form-control" id="author_name" name="author_name" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Create Author</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <?php if ($source === 'createbook'): ?>
                    <a href="createbook.php" class="btn btn-secondary">Resume Book Creation</a>
                <?php else: ?>
                    <a href="book-management.php" class="btn btn-secondary">Go to Book Management</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>