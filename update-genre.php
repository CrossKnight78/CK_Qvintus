<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $genreId = $_POST['genre_id'];
    $genreData = [
        'genre_name' => $_POST['genre_name']
    ];

    // Handle image upload
    if (isset($_FILES['genre-img']) && $_FILES['genre-img']['error'] == UPLOAD_ERR_OK) {
        include 'uploadgenre.php';
        if (isset($_SESSION['uploaded_image'])) {
            $genreData['genre_img'] = $_SESSION['uploaded_image'];
        }
    }

    if ($book->updateGenre($genreId, $genreData)) {
        $message = "Genre updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update genre.";
        $alertType = "danger";
    }
}
?>

<div class="container mt-5">
    <div class="alert alert-<?= $alertType ?> text-center" role="alert">
        <?= $message ?>
    </div>
    <div class="text-center">
        <a href="book-management.php" class="btn btn-primary">Back to Book Management</a>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>