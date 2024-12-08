<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);
$bookId = $_GET['id'];
$bookData = $book->getBookById($bookId);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Book</h2>
    <form action="updatebook.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="book_id" value="<?= htmlspecialchars($bookData['book_id']) ?>">
        <div class="mb-3">
            <label for="bookTitle" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="bookTitle" name="book_title" value="<?= htmlspecialchars($bookData['book_title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="bookDesc" class="form-label">Book Description</label>
            <textarea class="form-control" id="bookDesc" name="book_desc" rows="3" required><?= htmlspecialchars($bookData['book_desc']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="bookLanguage" class="form-label">Book Language</label>
            <input type="text" class="form-control" id="bookLanguage" name="book_language" value="<?= htmlspecialchars($bookData['book_language']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="bookReleaseDate" class="form-label">Book Release Date</label>
            <input type="date" class="form-control" id="bookReleaseDate" name="book_release_date" value="<?= htmlspecialchars($bookData['book_release_date']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="bookPages" class="form-label">Book Pages</label>
            <input type="number" class="form-control" id="bookPages" name="book_pages" value="<?= htmlspecialchars($bookData['book_pages']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="booksPrice" class="form-label">Book Price</label>
            <input type="number" step="0.01" class="form-control" id="booksPrice" name="books_price" value="<?= htmlspecialchars($bookData['books_price']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="bookSeries" class="form-label">Book Series</label>
            <input type="number" class="form-control" id="bookSeries" name="book_series_fk" value="<?= htmlspecialchars($bookData['book_series_fk']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="ageRecommendation" class="form-label">Age Recommendation</label>
            <input type="number" class="form-control" id="ageRecommendation" name="age_recommendation_fk" value="<?= htmlspecialchars($bookData['age_recommendation_fk']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="number" class="form-control" id="category" name="category_fk" value="<?= htmlspecialchars($bookData['category_fk']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="number" class="form-control" id="publisher" name="publisher_fk" value="<?= htmlspecialchars($bookData['publisher_fk']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="number" class="form-control" id="status" name="status_fk" value="<?= htmlspecialchars($bookData['status_fk']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="bookImg" class="form-label">Book Image</label>
            <input type="file" class="form-control" id="bookImg" name="book-img">
            <img src="<?= htmlspecialchars($bookData['img_url']) ?>" alt="Book Image" class="img-thumbnail mt-2" width="150">
        </div>
        <button type="submit" class="btn btn-primary">Update Book</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>