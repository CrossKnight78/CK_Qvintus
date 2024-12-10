<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

// Check if the source is set, otherwise assign a default value
$source = isset($_GET['source']) ? $_GET['source'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seriesName = $_POST['serie_name'];
    if ($book->createSeries($seriesName)) {
        echo '<div class="alert alert-success">Series created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create series.</div>';
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
    <h2 class="text-center mb-4">Add New Series</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="serie_name" class="form-label">Series Name</label>
            <input type="text" class="form-control" id="serie_name" name="serie_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Series</button>
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