<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

$ageId = $_GET['id'];
$age = $book->getAgeById($ageId);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Age Recommendation</h2>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success" role="alert">
            Age recommendation updated successfully!
        </div>
    <?php endif; ?>
    <form method="post" action="update-age.php">
        <input type="hidden" name="age_id" value="<?= htmlspecialchars($age['age_id']) ?>">
        <div class="mb-3">
            <label for="age_range" class="form-label">Age Range</label>
            <input type="text" class="form-control" id="age_range" name="age_range" value="<?= htmlspecialchars($age['age_range']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Age Recommendation</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>