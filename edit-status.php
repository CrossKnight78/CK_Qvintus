<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

$statusId = $_GET['id'];
$status = $book->getStatusById($statusId);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="text-center mb-4">Edit Status</h2>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success" role="alert">
                    Status updated successfully!
                </div>
            <?php endif; ?>
            <form method="post" action="update-status.php">
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
</div>

<?php
include_once 'includes/footer.php';
?>