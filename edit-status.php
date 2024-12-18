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
    $statusId = $_POST['status_id'];
    $statusData = [
        's_name' => $_POST['status_name']
    ];

    if ($book->updateStatus($statusId, $statusData)) {
        $message = "Status updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update status.";
        $alertType = "danger";
    }
} else {
    // Display form
    $statusId = $_GET['id'];
    $status = $book->getStatusById($statusId);

    if (!$status) {
        echo '<div class="alert alert-danger">Status not found.</div>';
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
                <h2 class="text-center mb-4">Edit Status</h2>
                <form method="post" action="edit-status.php?id=<?= htmlspecialchars($statusId) ?>">
                    <input type="hidden" name="status_id" value="<?= htmlspecialchars($status['s_id']) ?>">
                    <div class="mb-3">
                        <label for="status_name" class="form-label">Status Name</label>
                        <input type="text" class="form-control" id="status_name" name="status_name" value="<?= htmlspecialchars($status['s_name']) ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>