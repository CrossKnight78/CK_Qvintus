<?php
include_once 'includes/header.php';

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
</div>

<?php
include_once 'includes/footer.php';
?>