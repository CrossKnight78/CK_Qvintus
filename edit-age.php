<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

$ageId = $_GET['id'];
$age = $book->getAgeById($ageId);

if (!$age) {
    echo '<div class="alert alert-danger">Age recommendation not found.</div>';
    include_once 'includes/footer.php';
    exit;
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Age Recommendation</h2>
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