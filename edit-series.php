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
} else {
    // Display form
    $seriesId = $_GET['id'];
    $series = $book->getSeriesById($seriesId);

    if (!$series) {
        echo '<div class="alert alert-danger">Series not found.</div>';
        include_once 'includes/footer.php';
        exit;
    }
}
?>

<div class="container mt-5">
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
                <h2 class="text-center mb-4">Edit Series</h2>
                <form method="post" action="edit-series.php?id=<?= htmlspecialchars($seriesId) ?>">
                    <input type="hidden" name="series_id" value="<?= htmlspecialchars($series['serie_id']) ?>">
                    <div class="mb-3">
                        <label for="series_name" class="form-label">Series Name</label>
                        <input type="text" class="form-control" id="series_name" name="series_name" value="<?= htmlspecialchars($series['serie_name']) ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Series</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>