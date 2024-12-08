
<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ageRange = $_POST['age_range'];
    if ($book->createAgeRecommendation($ageRange)) {
        echo '<div class="alert alert-success">Age recommendation created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create age recommendation.</div>';
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
</div>

<?php
include_once 'includes/footer.php';
?>