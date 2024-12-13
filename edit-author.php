<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);
$authorId = $_GET['id'];
$authorData = $book->getAuthorById($authorId);

if (!$authorData) {
    echo '<div class="alert alert-danger">Author not found.</div>';
    include_once 'includes/footer.php';
    exit;
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Author</h2>
    <form action="update-author.php" method="post">
        <input type="hidden" name="author_id" value="<?= htmlspecialchars($authorData['author_id']) ?>">
        <div class="mb-3">
            <label for="authorName" class="form-label">Author Name</label>
            <input type="text" class="form-control" id="authorName" name="author_name" value="<?= htmlspecialchars($authorData['author_name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Author</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>