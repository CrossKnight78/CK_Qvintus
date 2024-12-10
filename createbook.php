<?php
include_once 'includes/header.php';

// Assume $pdo is already instantiated and passed to this script
$book = new Book($pdo);

if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in. Please log in to create a book.");
}

$userId = $_SESSION['user_id'];
// Fetch authors, illustrators, genres, series, categories, publishers, age recommendations, and status
$authors = $book->selectAllAuthors();
$illustrators = $book->selectAllIllustrators();
$genres = $book->selectAllGenres();
$series = $book->selectAllSeries();
$categories = $book->selectAllCategories();
$publishers = $book->selectAllPublishers();
$ageRecommendations = $book->selectAllAgeRecommendations();
$statuses = $book->selectAllStatuses(); // Add this method to fetch statuses from the database

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'upload.php'; // Handle the image upload

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
        'created_by_fk' => $userId, // Add this
        'status_fk' => $_POST['status_fk'],
        'img_url' => isset($_SESSION['uploaded_image']) ? $_SESSION['uploaded_image'] : '',
    ];

    $authors = $_POST['authors'] ?? [];
    $illustrators = $_POST['illustrators'] ?? [];
    $genres = $_POST['genres'] ?? [];

    if ($book->validateBookData($bookData) && !empty($authors) && !empty($illustrators) && !empty($genres)) {
        $newBookId = $book->createBook($bookData, $authors, $illustrators, $genres);
        if ($newBookId) {
            echo "<div class='alert alert-success'>Book created successfully with ID: $newBookId</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to create book.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please fill in all required fields, including authors, illustrators, and genres.</div>";
    }
}

?>
<div class="container mt-4">
    <h2>Create a New Book</h2>
    <?php
    if (isset($_SESSION['upload_error'])) {
        echo "<div class='alert alert-danger'>{$_SESSION['upload_error']}</div>";
        unset($_SESSION['upload_error']);
    }
    ?>
    <form method="POST" action="createbook.php" enctype="multipart/form-data" id="createBookForm">
        <div class="mb-3">
            <label for="book_title" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="book_title" name="book_title" required>
        </div>
        <div class="mb-3">
            <label for="book_desc" class="form-label">Description</label>
            <textarea class="form-control" id="book_desc" name="book_desc" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label for="book_language" class="form-label">Language</label>
            <input type="text" class="form-control" id="book_language" name="book_language" required>
        </div>
        <div class="mb-3">
            <label for="book_release_date" class="form-label">Release Date</label>
            <input type="date" class="form-control" id="book_release_date" name="book_release_date" required>
        </div>
        <div class="mb-3">
            <label for="book_pages" class="form-label">Pages</label>
            <input type="number" class="form-control" id="book_pages" name="book_pages" required>
        </div>
        <div class="mb-3">
            <label for="books_price" class="form-label">Price</label>
            <input type="number" class="form-control" id="books_price" name="books_price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="book_series_fk" class="form-label">Series</label>
            <select class="form-control" id="book_series_fk" name="book_series_fk">
                <?php foreach ($series as $serie): ?>
                    <option value="<?= $serie['serie_id'] ?>"><?= htmlspecialchars($serie['serie_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="createseries.php?source=createbook" class="btn btn-secondary mt-2">Add New Series</a>
        </div>
        <div class="mb-3">
            <label for="age_recommendation_fk" class="form-label">Age Recommendation</label>
            <select class="form-control" id="age_recommendation_fk" name="age_recommendation_fk">
                <?php foreach ($ageRecommendations as $age): ?>
                    <option value="<?= $age['age_id'] ?>"><?= htmlspecialchars($age['age_range']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="createage.php?source=createbook" class="btn btn-secondary mt-2">Add New Age Recommendation</a>
        </div>
        <div class="mb-3">
            <label for="category_fk" class="form-label">Category</label>
            <select class="form-control" id="category_fk" name="category_fk">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="createcategory.php?source=createbook" class="btn btn-secondary mt-2">Add New Category</a>
        </div>
        <div class="mb-3">
            <label for="publisher_fk" class="form-label">Publisher</label>
            <select class="form-control" id="publisher_fk" name="publisher_fk">
                <?php foreach ($publishers as $publisher): ?>
                    <option value="<?= $publisher['publisher_id'] ?>"><?= htmlspecialchars($publisher['publisher_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="createpublisher.php?source=createbook" class="btn btn-secondary mt-2">Add New Publisher</a>
        </div>
        <div class="mb-3">
            <label for="status_fk" class="form-label">Status</label>
            <select class="form-control" id="status_fk" name="status_fk">
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= $status['s_id'] ?>"><?= htmlspecialchars($status['s_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="createstatus.php?source=createbook" class="btn btn-secondary mt-2">Add New Status</a>
        </div>
        <div class="mb-3">
            <label for="authors" class="form-label">Authors</label>
            <select class="form-control selectpicker" id="authors" name="authors[]" multiple data-live-search="true">
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author['author_id'] ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="createauthor.php?source=createbook" class="btn btn-secondary mt-2">Add New Author</a>
        </div>
        <div class="mb-3">
            <label for="illustrators" class="form-label">Illustrators</label>
            <select class="form-control selectpicker" id="illustrators" name="illustrators[]" multiple data-live-search="true">
                <?php foreach ($illustrators as $illustrator): ?>
                    <option value="<?= $illustrator['illustrator_id'] ?>"><?= htmlspecialchars($illustrator['illustrator_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="createillustrator.php?source=createbook" class="btn btn-secondary mt-2">Add New Illustrator</a>
        </div>
        <div class="mb-3">
            <label for="genres" class="form-label">Genres</label>
            <select class="form-control selectpicker" id="genres" name="genres[]" multiple data-live-search="true">
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre['genre_id'] ?>"><?= htmlspecialchars($genre['genre_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a href="creategenre.php?source=createbook" class="btn btn-secondary mt-2">Add New Genre</a>
        </div>
        <button type="submit" class="btn btn-primary my-3">Create Book</button>
    </form>
</div>

<!-- Include jQuery, Bootstrap, and Bootstrap Select CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<script>
    // Save form data to session storage
    $(document).ready(function() {
        $('#createBookForm').on('change', 'input, select, textarea', function() {
            let formData = $('#createBookForm').serializeArray();
            sessionStorage.setItem('createBookFormData', JSON.stringify(formData));
        });

        // Load form data from session storage
        if (sessionStorage.getItem('createBookFormData')) {
            let formData = JSON.parse(sessionStorage.getItem('createBookFormData'));
            $.each(formData, function(i, field) {
                $('[name="' + field.name + '"]').val(field.value);
            });
        }
    });
</script>

<?php
include_once 'includes/footer.php';
?>