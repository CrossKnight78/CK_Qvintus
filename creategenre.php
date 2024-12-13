<?php
include_once 'includes/header.php';

$source = isset($_GET['source']) ? $_GET['source'] : '';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'uploadgenre.php';

    if (isset($_SESSION['uploaded_image'])) {
        // Create genre in the database
        include_once 'includes/class.book.php';
        $book = new Book($pdo);
        $genreName = $_POST['genre_name'];
        $genreStatus = $_POST['genre_status'];
        $genreImg = $_SESSION['uploaded_image'];
        $book->createGenre($genreName, $genreStatus, $genreImg);
        echo '<div class="alert alert-success">Genre created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create genre.</div>';
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
    <h2 class="text-center mb-4">Add New Genre</h2>
    <form method="POST" action="creategenre.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="genre_name" class="form-label">Genre Name</label>
            <input type="text" class="form-control" id="genre_name" name="genre_name" required>
        </div>
        <div class="mb-3">
            <label for="genre_status" class="form-label">Genre Status</label>
            <select class="form-control" id="genre_status" name="genre_status" required>
                <option value="1">Popular</option>
                <option value="0">Not Popular</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="genre_img" class="form-label">Genre Image</label>
            <input type="file" class="form-control" id="genre_img" name="genre_img">
        </div>
        <button type="submit" class="btn btn-primary">Create Genre</button>
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