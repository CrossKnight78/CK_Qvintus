<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seriesId = $_POST['series_id'];
    $seriesData = [
        'serie_name' => $_POST['series_name']
    ];

    if ($book->updateSeries($seriesId, $seriesData)) {
        $message = "Series updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update series.";
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