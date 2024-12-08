<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $genreName = $_POST['genre_name'];
    $genreStatus = $_POST['genre_status'];
    $genreImg = $_FILES['genre_img']['name'];

    // Handle image upload
    if ($genreImg) {
        include_once 'uploadgenre.php';
        $genreImg = $_SESSION['uploaded_image'] ?? null;
    }

    if ($book->createGenre($genreName, $genreStatus, $genreImg)) {
        echo '<div class="alert alert-success">Genre created successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to create genre.</div>';
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Genre</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="genre_name" class="form-label">Genre Name</label>
            <input type="text" class="form-control" id="genre_name" name="genre_name" required>
        </div>
        <div class="mb-3">
            <label for="genre_status" class="form-label">Popular</label>
            <select class="form-select" id="genre_status" name="genre_status" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
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