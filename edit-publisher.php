<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

$publisherId = $_GET['id'];
$publisher = $book->getPublisherById($publisherId);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Publisher</h2>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success" role="alert">
            Publisher updated successfully!
        </div>
    <?php endif; ?>
    <form method="post" action="update-publisher.php">
        <input type="hidden" name="publisher_id" value="<?= htmlspecialchars($publisher['publisher_id']) ?>">
        <div class="mb-3">
            <label for="publisher_name" class="form-label">Publisher Name</label>
            <input type="text" class="form-control" id="publisher_name" name="publisher_name" value="<?= htmlspecialchars($publisher['publisher_name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Publisher</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>