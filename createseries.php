<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seriesName = $_POST['serie_name'];
    if ($book->createSeries($seriesName)) {
        echo '<div class="alert alert-success">Series created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create series.</div>';
    }
    echo '<div class="text-center">
            <a href="book-management.php" class="btn btn-primary">Go to Book Management</a>
          </div>';
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
</div>

<?php
include_once 'includes/footer.php';
?>