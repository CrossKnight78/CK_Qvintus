<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = $_POST['book_id'];
    $bookData = [
        'book_title' => $_POST['book_title'],
        'book_desc' => $_POST['book_desc'],
        'book_language' => $_POST['book_language'],
        'book_release_date' => $_POST['book_release_date'],
        'book_pages' => $_POST['book_pages'],
        'books_price' => $_POST['books_price'],
        'book_series_fk' => $_POST['book_series_fk'],
        'age_recommendation_fk' => $_POST['age_recommendation_fk'],
        'category_fk' => $_POST['category_fk'],
        'publisher_fk' => $_POST['publisher_fk'],
        'status_fk' => $_POST['status_fk'],
        'img_url' => $_POST['img_url'] ?? '' // Ensure img_url key exists
    ];

    // Handle image upload if a new image is provided
    if (isset($_FILES['book-img']) && $_FILES['book-img']['error'] == 0) {
        include 'upload.php';
        if (isset($_SESSION['uploaded_image'])) {
            $bookData['img_url'] = $_SESSION['uploaded_image'];
        }
    }

    if ($book->updateBook($bookId, $bookData)) {
        $message = "Book updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update book.";
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