<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

if (!isset($_GET['id'])) {
    header('Location: book-management.php');
    exit();
}

$genreId = $_GET['id'];
$genre = $book->getGenreById($genreId);

if (!$genre) {
    echo "<div class='alert alert-danger'>Genre not found.</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $genreData = [
        'genre_name' => $_POST['genre_name'],
        'genre_status' => $_POST['genre_status']
    ];

    // Handle image upload
    if (isset($_FILES['genre_img']) && $_FILES['genre_img']['error'] == UPLOAD_ERR_OK) {
        include 'uploadgenre.php';
        if (isset($_SESSION['uploaded_image'])) {
            $genreData['genre_img'] = $_SESSION['uploaded_image'];
        }
    }

    $book->updateGenre($genreId, $genreData);
    header('Location: book-management.php');
    exit();
}
?>

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Edit Genre</h2>
    <form action="edit-genre.php?id=<?= htmlspecialchars($genreId) ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="genre_name" class="form-label">Genre Name</label>
            <input type="text" class="form-control" id="genre_name" name="genre_name" value="<?= htmlspecialchars($genre['genre_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="genre_status" class="form-label">Genre Status</label>
            <select class="form-select" id="genre_status" name="genre_status" required>
                <option value="1" <?= $genre['genre_status'] == 1 ? 'selected' : '' ?>>Popular</option>
                <option value="0" <?= $genre['genre_status'] == 0 ? 'selected' : '' ?>>Not Popular</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="genre_img" class="form-label">Genre Image</label>
            <input type="file" class="form-control" id="genre_img" name="genre_img">
            <?php if (!empty($genre['genre_img'])): ?>
                <img src="<?= htmlspecialchars($genre['genre_img']) ?>" alt="Genre Image" class="img-thumbnail mt-2" style="max-width: 200px;">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Update Genre</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>