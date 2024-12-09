<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}
?>

<div class="container mt-5">
    <div class="alert alert-<?= $alertType ?> text-center" role="alert">
        <?= $message ?>
    </div>
    <div class="text-center">
        <a href="book-management.php" class="btn btn-primary">Back to Book Management</a>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>