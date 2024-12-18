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
    $illustratorId = $_POST['illustrator_id'];
    $illustratorData = [
        'illustrator_name' => $_POST['illustrator_name']
    ];

    if ($book->updateIllustrator($illustratorId, $illustratorData)) {
        $message = "Illustrator updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update illustrator.";
        $alertType = "danger";
    }
} else {
    // Display form
    $illustratorId = $_GET['id'];
    $illustratorData = $book->getIllustratorById($illustratorId);

    if (!$illustratorData) {
        echo '<div class="alert alert-danger">Illustrator not found.</div>';
        include_once 'includes/footer.php';
        exit;
    }
}
?>

<div class="container mt-5">
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
                <h2 class="text-center mb-4">Edit Illustrator</h2>
                <form action="edit-illustrator.php?id=<?= htmlspecialchars($illustratorId) ?>" method="post">
                    <input type="hidden" name="illustrator_id" value="<?= htmlspecialchars($illustratorId) ?>">
                    <div class="mb-3">
                        <label for="illustratorName" class="form-label">Illustrator Name</label>
                        <input type="text" class="form-control" id="illustratorName" name="illustrator_name" value="<?= htmlspecialchars($illustratorData['illustrator_name']) ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Illustrator</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>