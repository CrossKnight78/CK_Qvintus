<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $authorId = $_POST['author_id'];
    $authorData = [
        'author_name' => $_POST['author_name']
    ];

    if ($book->updateAuthor($authorId, $authorData)) {
        $message = "Author updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update author.";
        $alertType = "danger";
    }
} else {
    // Display form
    $authorId = $_GET['id'];
    $authorData = $book->getAuthorById($authorId);

    if (!$authorData) {
        echo '<div class="alert alert-danger">Author not found.</div>';
        include_once 'includes/footer.php';
        exit;
    }
}
?>

<div class="container mt-5 mb-5">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-<?= $alertType ?> text-center" role="alert">
            <?= $message ?>
        </div>
        <div class="text-center">
            <a href="book-management.php" class="btn btn-primary">Back to Book Management</a>
        </div>
    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h2 class="text-center mb-4">Edit Author</h2>
                <form method="post" action="">
                    <input type="hidden" name="author_id" value="<?= htmlspecialchars($authorData['author_id']) ?>">
                    <div class="mb-3">
                        <label for="authorName" class="form-label">Author Name</label>
                        <input type="text" class="form-control" id="authorName" name="author_name" value="<?= htmlspecialchars($authorData['author_name']) ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Author</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>