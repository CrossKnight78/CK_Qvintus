<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$source = isset($_GET['source']) ? $_GET['source'] : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $illustratorName = $_POST['illustrator_name'];
    if ($book->createIllustrator($illustratorName)) {
        echo '<div class="alert alert-success">Illustrator created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create illustrator.</div>';
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
    <h2 class="text-center mb-4">Add New Illustrator</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="illustrator_name" class="form-label">Illustrator Name</label>
            <input type="text" class="form-control" id="illustrator_name" name="illustrator_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Illustrator</button>
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