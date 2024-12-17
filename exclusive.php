<?php
include_once 'includes/header.php';

$bookClass = new Book($pdo);
$books = $bookClass->getExclusiveBooks(4);

if (empty($books)) {
    echo '<p class="text-center">No books available.</p>';
} else {
    echo '<div class="container my-5">';
    echo '<h1 class="mb-4 text-center">Exclusive Books</h1>';
    echo '<div class="row">';
    foreach ($books as $book) {
        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">';
        echo '<div class="card h-100">';
        echo '<img src="' . htmlspecialchars($book['img_url']) . '" class="card-img-top" alt="' . htmlspecialchars($book['book_title']) . '">';
        echo '<div class="card-body d-flex flex-column">';
        echo '<h5 class="card-title">' . htmlspecialchars($book['book_title']) . '</h5>';
        echo '<p class="card-text"><strong>Price:</strong> $' . htmlspecialchars($book['books_price']) . '</p>';
        echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id']) . '" class="btn btn-primary mt-auto">View Details</a>';
        echo '</div></div></div>';
    }
    echo '</div></div>';
}
?>

<?php
include_once 'includes/footer.php';
?>