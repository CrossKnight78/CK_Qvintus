<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

$statusId = $_GET['id'];
$status = $book->getStatusById($statusId);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Status</h2>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success" role="alert">
            Status updated successfully!
        </div>
    <?php endif; ?>
    <form method="post" action="update-status.php">
        <input type="hidden" name="status_id" value="<?= htmlspecialchars($status['status_id']) ?>">
        <div class="mb-3">
            <label for="status_name" class="form-label">Status Name</label>
            <input type="text" class="form-control" id="status_name" name="status_name" value="<?= htmlspecialchars($status['s_name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>