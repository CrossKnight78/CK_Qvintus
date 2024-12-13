<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: book-management.php');
    exit();
}

$bookId = (int)$_GET['id'];
$bookData = $book->getBookById($bookId);

// Fetch all necessary data for dropdowns
$series = $book->selectAllSeries();
$ageRecommendations = $book->selectAllAgeRecommendations();
$categories = $book->selectAllCategories();
$publishers = $book->selectAllPublishers();
$statuses = $book->selectAllStatuses();
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
            <select class="form-select" id="bookSeries" name="book_series_fk" required>
                <?php foreach ($series as $serie): ?>
                    <option value="<?= $serie['serie_id'] ?>" <?= $bookData['book_series_fk'] == $serie['serie_id'] ? 'selected' : '' ?>><?= htmlspecialchars($serie['serie_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="ageRecommendation" class="form-label">Age Recommendation</label>
            <select class="form-select" id="ageRecommendation" name="age_recommendation_fk" required>
                <?php foreach ($ageRecommendations as $age): ?>
                    <option value="<?= $age['age_id'] ?>" <?= $bookData['age_recommendation_fk'] == $age['age_id'] ? 'selected' : '' ?>><?= htmlspecialchars($age['age_range']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category_fk" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>" <?= $bookData['category_fk'] == $category['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <select class="form-select" id="publisher" name="publisher_fk" required>
                <?php foreach ($publishers as $publisher): ?>
                    <option value="<?= $publisher['publisher_id'] ?>" <?= $bookData['publisher_fk'] == $publisher['publisher_id'] ? 'selected' : '' ?>><?= htmlspecialchars($publisher['publisher_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status_fk" required>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= $status['s_id'] ?>" <?= $bookData['status_fk'] == $status['s_id'] ? 'selected' : '' ?>><?= htmlspecialchars($status['s_name']) ?></option>
                <?php endforeach; ?>
            </select>
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