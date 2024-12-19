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
    $ageId = $_POST['age_id'];
    $ageData = [
        'age_range' => $_POST['age_range']
    ];

    if ($book->updateAgeRecommendation($ageId, $ageData)) {
        $message = "Age recommendation updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update age recommendation.";
        $alertType = "danger";
    }
} else {
    // Display form
    $ageId = $_GET['id'];
    $age = $book->getAgeById($ageId);

    if (!$age) {
        echo '<div class="alert alert-danger">Age recommendation not found.</div>';
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
                <h2 class="text-center mb-4">Edit Age Recommendation</h2>
                <form method="post" action="">
                    <input type="hidden" name="age_id" value="<?= htmlspecialchars($age['age_id']) ?>">
                    <div class="mb-3">
                        <label for="age_range" class="form-label">Age Range</label>
                        <input type="text" class="form-control" id="age_range" name="age_range" value="<?= htmlspecialchars($age['age_range']) ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Age Recommendation</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>