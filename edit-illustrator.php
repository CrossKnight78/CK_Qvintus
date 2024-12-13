<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);
$illustratorId = $_GET['id'];
$illustratorData = $book->getIllustratorById($illustratorId);

if (!$illustratorData) {
    echo '<div class="alert alert-danger">Illustrator not found.</div>';
    include_once 'includes/footer.php';
    exit;
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Illustrator</h2>
    <form action="update-illustrator.php" method="post">
        <input type="hidden" name="illustrator_id" value="<?= htmlspecialchars($illustratorData['illustrator_id']) ?>">
        <div class="mb-3">
            <label for="illustratorName" class="form-label">Illustrator Name</label>
            <input type="text" class="form-control" id="illustratorName" name="illustrator_name" value="<?= htmlspecialchars($illustratorData['illustrator_name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Illustrator</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>