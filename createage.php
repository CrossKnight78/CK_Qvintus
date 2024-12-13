<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

$source = isset($_GET['source']) ? $_GET['source'] : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ageRange = $_POST['age_range'];
    if ($book->createAgeRecommendation($ageRange)) {
        echo '<div class="alert alert-success">Age recommendation created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create age recommendation.</div>';
    }
        if ($source === 'createbook') {
            echo '<div class="text-center">
                    <a href="createbook.php" class="btn btn-primary">Resume Book Creation</a>
                  </div>';
        } else {
            echo '<div class="text-center">
                    <a href="book-management.php" class="btn btn-primary">Go to Book Management</a>
                  </div>';
        }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Age Recommendation</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="age_range" class="form-label">Age Range</label>
            <input type="text" class="form-control" id="age_range" name="age_range" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Age Recommendation</button>
    </form>
    <div class="text-center mt-3">
        <?php if ($source === 'createbook'): ?>
            <a href="createbook.php" class="btn btn-secondary">Resume Book Creation</a>
        <?php else: ?>
            <a href="book-management.php" class="btn btn-secondary">Go to Book Management</a>
        <?php endif; ?>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>