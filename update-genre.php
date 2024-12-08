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

    $book->updateGenre($genreId, $genreData);
    header('Location: book-management.php');
}
?>