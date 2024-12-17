<?php
include_once '../includes/config.php';
include_once '../includes/class.book.php';

header('Content-Type: application/json');

// Initialize the variables
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$author = isset($_GET['author']) ? trim($_GET['author']) : '';
$illustrator = isset($_GET['illustrator']) ? trim($_GET['illustrator']) : '';
$genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';
$series = isset($_GET['series']) ? trim($_GET['series']) : '';
$age = isset($_GET['age']) ? trim($_GET['age']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$publisher = isset($_GET['publisher']) ? trim($_GET['publisher']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';

$bookClass = new Book($pdo);

// Get the filtered books from the database
$results = $bookClass->filterBooks($query, $author, $illustrator, $genre, $series, $age, $category, $publisher, $status);

if (empty($results)) {
    echo '<p class="text-center">No books found.</p>';
} else {
    echo '<div class="row">';
    foreach ($results as $book) {
        $bookImageUrl = !empty($book['img_url']) ? htmlspecialchars($book['img_url'], ENT_QUOTES, 'UTF-8') : '../images/default.webp';
        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">';
        echo '<div class="card text-center h-100" style="width: 100%;">';
        echo '<img src="' . $bookImageUrl . '" class="card-img-top thumbnail-img mx-auto d-block" alt="' . htmlspecialchars($book['book_title'], ENT_QUOTES, 'UTF-8') . '">';
        echo '<div class="card-body d-flex flex-column">';
        echo '<h5 class="card-title">' . htmlspecialchars($book['book_title'], ENT_QUOTES, 'UTF-8') . '</h5>';
        echo '<p class="card-text"><strong>Price:</strong> $' . htmlspecialchars($book['books_price'], ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id'], ENT_QUOTES, 'UTF-8') . '" class="btn btn-primary mt-auto">View Details</a>';
        echo '</div></div></div>';
    }
    echo '</div>';
}
?>