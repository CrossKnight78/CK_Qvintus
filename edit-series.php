<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

$seriesId = $_GET['id'];
$series = $book->getSeriesById($seriesId);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="text-center mb-4">Edit Series</h2>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success" role="alert">
                    Series updated successfully!
                </div>
            <?php endif; ?>
            <form method="post" action="update-series.php">
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
</div>

<?php
include_once 'includes/footer.php';
?>