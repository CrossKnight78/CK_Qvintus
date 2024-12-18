<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
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
} else {
    // Display form
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
    $authors = $book->selectAllAuthors();
    $illustrators = $book->selectAllIllustrators();
    $genres = $book->selectAllGenres();

    // Fetch selected authors, illustrators, and genres for the book
    $selectedAuthors = explode(', ', $bookData['authors']);
    $selectedIllustrators = explode(', ', $bookData['illustrators']);
    $selectedGenres = explode(', ', $bookData['genres']);
}
?>

<div class="container mt-4">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-<?= $alertType ?> text-center" role="alert">
            <?= $message ?>
        </div>
        <div class="text-center">
            <a href="book-management.php" class="btn btn-primary">Back to Book Management</a>
        </div>
    <?php else: ?>
        <h2 class="text-center mb-4">Edit Book</h2>
        <form action="editbook.php" method="post" enctype="multipart/form-data" id="editBookForm">
            <input type="hidden" name="book_id" value="<?= htmlspecialchars($bookData['book_id']) ?>">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="bookTitle" class="form-label">Book Title</label>
                    <input type="text" class="form-control" id="bookTitle" name="book_title" value="<?= htmlspecialchars($bookData['book_title']) ?>" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="bookImg" class="form-label">Book Image</label>
                    <input type="file" class="form-control" id="bookImg" name="book-img">
                    <?php if (!empty($bookData['img_url'])): ?>
                        <img src="<?= htmlspecialchars($bookData['img_url']) ?>" alt="Book Image" class="img-thumbnail mt-2" width="150">
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="bookDesc" class="form-label">Description</label>
                <textarea class="form-control" id="bookDesc" name="book_desc" rows="4" required><?= htmlspecialchars($bookData['book_desc']) ?></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="bookLanguage" class="form-label">Language</label>
                    <input type="text" class="form-control" id="bookLanguage" name="book_language" value="<?= htmlspecialchars($bookData['book_language']) ?>" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="bookReleaseDate" class="form-label">Release Date</label>
                    <input type="date" class="form-control" id="bookReleaseDate" name="book_release_date" value="<?= htmlspecialchars($bookData['book_release_date']) ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="bookPages" class="form-label">Pages</label>
                    <input type="number" class="form-control" id="bookPages" name="book_pages" value="<?= htmlspecialchars($bookData['book_pages']) ?>" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="booksPrice" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="booksPrice" name="books_price" value="<?= htmlspecialchars($bookData['books_price']) ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="bookSeries" class="form-label">Series</label>
                    <select class="form-control" id="bookSeries" name="book_series_fk">
                        <?php foreach ($series as $serie): ?>
                            <option value="<?= $serie['serie_id'] ?>" <?= $bookData['book_series_fk'] == $serie['serie_id'] ? 'selected' : '' ?>><?= htmlspecialchars($serie['serie_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="ageRecommendation" class="form-label">Age Recommendation</label>
                    <select class="form-control" id="ageRecommendation" name="age_recommendation_fk">
                        <?php foreach ($ageRecommendations as $age): ?>
                            <option value="<?= $age['age_id'] ?>" <?= $bookData['age_recommendation_fk'] == $age['age_id'] ? 'selected' : '' ?>><?= htmlspecialchars($age['age_range']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category_fk">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>" <?= $bookData['category_fk'] == $category['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="publisher" class="form-label">Publisher</label>
                    <select class="form-control" id="publisher" name="publisher_fk">
                        <?php foreach ($publishers as $publisher): ?>
                            <option value="<?= $publisher['publisher_id'] ?>" <?= $bookData['publisher_fk'] == $publisher['publisher_id'] ? 'selected' : '' ?>><?= htmlspecialchars($publisher['publisher_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status_fk">
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?= $status['s_id'] ?>" <?= $bookData['status_fk'] == $status['s_id'] ? 'selected' : '' ?>><?= htmlspecialchars($status['s_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <label for="authors" class="form-label">Authors</label>
                    <select class="form-control select2" id="authors" name="authors[]" multiple>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= $author['author_id'] ?>" <?= in_array($author['author_name'], $selectedAuthors) ? 'selected' : '' ?>><?= htmlspecialchars($author['author_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label for="illustrators" class="form-label">Illustrators</label>
                    <select class="form-control select2" id="illustrators" name="illustrators[]" multiple>
                        <?php foreach ($illustrators as $illustrator): ?>
                            <option value="<?= $illustrator['illustrator_id'] ?>" <?= in_array($illustrator['illustrator_name'], $selectedIllustrators) ? 'selected' : '' ?>><?= htmlspecialchars($illustrator['illustrator_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label for="genres" class="form-label">Genres</label>
                    <select class="form-control select2" id="genres" name="genres[]" multiple>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['genre_id'] ?>" <?= in_array($genre['genre_name'], $selectedGenres) ? 'selected' : '' ?>><?= htmlspecialchars($genre['genre_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary my-3">Update Book</button>
        </form>
    <?php endif; ?>
</div>

<!-- Include jQuery and Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#authors').select2({
            placeholder: "Select authors",
            allowClear: true,
            dropdownAutoWidth: true,
            width: '100%'
        });
        $('#illustrators').select2({
            placeholder: "Select illustrators",
            allowClear: true,
            dropdownAutoWidth: true,
            width: '100%'
        });
        $('#genres').select2({
            placeholder: "Select genres",
            allowClear: true,
            dropdownAutoWidth: true,
            width: '100%'
        });
    });
</script>

<?php
include_once 'includes/footer.php';
?>