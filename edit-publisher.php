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
    $publisherId = $_POST['publisher_id'];
    $publisherData = [
        'publisher_name' => $_POST['publisher_name']
    ];

    if ($book->updatePublisher($publisherId, $publisherData)) {
        $message = "Publisher updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update publisher.";
        $alertType = "danger";
    }
} else {
    // Display form
    $publisherId = $_GET['id'];
    $publisher = $book->getPublisherById($publisherId);

    if (!$publisher) {
        echo '<div class="alert alert-danger">Publisher not found.</div>';
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
                <h2 class="text-center mb-4">Edit Publisher</h2>
                <form method="post" action="edit-publisher.php?id=<?= htmlspecialchars($publisherId) ?>">
                    <input type="hidden" name="publisher_id" value="<?= htmlspecialchars($publisher['publisher_id']) ?>">
                    <div class="mb-3">
                        <label for="publisher_name" class="form-label">Publisher Name</label>
                        <input type="text" class="form-control" id="publisher_name" name="publisher_name" value="<?= htmlspecialchars($publisher['publisher_name']) ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Publisher</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>