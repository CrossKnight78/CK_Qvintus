<?php
include_once '../includes/config.php';
include_once '../includes/class.book.php';

// Initialize book class
$bookClass = new Book($pdo);

// Get the search query
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Search for books based on title or author
$books = $bookClass->findBook($query);

// Return the results as a JSON response
echo json_encode($books);
    // Check if any books are found and output the results
    if (empty($books)) {
        echo '<p class="text-center">No books found matching your search.</p>';
    } else {
        echo '<div class="row">';
        foreach ($books as $bookItem) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="' . htmlspecialchars($bookItem['img_url']) . '" class="card-img-top" alt="' . htmlspecialchars($bookItem['book_title']) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($bookItem['book_title']) . '</h5>';
            echo '<p class="card-text"><strong>Price:</strong> $' . htmlspecialchars($bookItem['books_price']) . '</p>';
            echo '<p class="card-text"><strong>Author:</strong> ' . htmlspecialchars($bookItem['book_author']) . '</p>';
            echo '<a href="singlebook.php?id=' . htmlspecialchars($bookItem['book_id']) . '" class="btn btn-primary">View Details</a>';
            echo '</div></div></div>';
        }
        echo '</div>';
    }
}
?>