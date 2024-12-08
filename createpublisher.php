
<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $publisherName = $_POST['publisher_name'];
    if ($book->createPublisher($publisherName)) {
        echo '<div class="alert alert-success">Publisher created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create publisher.</div>';
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Publisher</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="publisher_name" class="form-label">Publisher Name</label>
            <input type="text" class="form-control" id="publisher_name" name="publisher_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Publisher</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>