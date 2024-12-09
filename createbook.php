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

    if (isset($_POST['new_author_name']) && !empty($_POST['new_author_name'])) {
        $newAuthorId = $book->createAuthor($_POST['new_author_name']);
        if ($newAuthorId) {
            echo json_encode(['success' => true, 'author_id' => $newAuthorId, 'author_name' => $_POST['new_author_name']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create author.']);
        }
        exit;
    }

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
    <form method="POST" action="createbook.php" enctype="multipart/form-data">
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
            <select class="form-select" id="book_series_fk" name="book_series_fk">
                <?php foreach ($series as $serie): ?>
                    <!-- Use htmlspecialchars to prevent XSS vulnerabilities -->
                    <option value="<?= htmlspecialchars($serie['serie_id']) ?>">
                        <?= htmlspecialchars($serie['serie_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="age_recommendation_fk" class="form-label">Age Recommendation</label>
            <select class="form-select" id="age_recommendation_fk" name="age_recommendation_fk" required>
                <?php foreach ($ageRecommendations as $age): ?>
                    <option value="<?= $age['age_id'] ?>"><?= htmlspecialchars($age['age_range']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_fk" class="form-label">Category</label>
            <select class="form-select" id="category_fk" name="category_fk" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="publisher_fk" class="form-label">Publisher</label>
            <select class="form-select" id="publisher_fk" name="publisher_fk" required>
                <?php foreach ($publishers as $publisher): ?>
                    <option value="<?= $publisher['publisher_id'] ?>"><?= htmlspecialchars($publisher['publisher_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="status_fk" class="form-label">Status</label>
            <select class="form-select" id="status_fk" name="status_fk" required>
                <option value="">Select Status</option>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= htmlspecialchars($status['s_id']) ?>">
                        <?= htmlspecialchars($status['s_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="img_url" class="form-label">Image URL</label>
            <input type="file" class="form-control" id="img_url" name="book-img">
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label for="authors" class="form-label">Authors</label><br>
                <select class="form-select select2-multiple" style="width: 100%" id="authors" name="authors[]" multiple required>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author['author_id'] ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" id="new_author_name" class="form-control mt-2" placeholder="New Author Name">
                <button type="button" id="add-author-btn" class="btn btn-secondary mt-2">Add Author</button>
            </div>
            <div class="col-sm-4">
                <label for="illustrators" class="form-label">Illustrators</label><br>
                <select class="form-select select2-multiple" style="width: 100%" id="illustrators" name="illustrators[]" multiple required>
                    <?php foreach ($illustrators as $illustrator): ?>
                        <option value="<?= $illustrator['illustrator_id'] ?>"><?= htmlspecialchars($illustrator['illustrator_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label for="genres" class="form-label">Genres</label><br>
                <select class="form-select select2-multiple" style="width: 100%" id="genres" name="genres[]" multiple required>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= $genre['genre_id'] ?>"><?= htmlspecialchars($genre['genre_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary my-3">Create Book</button>
    </form>
</div>

<!-- Include Select2 JavaScript and CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-multiple').select2({
            placeholder: "Select options",
            allowClear: true
        });

        $('#add-author-btn').click(function() {
            var newAuthorName = $('#new_author_name').val();
            if (newAuthorName) {
                $.post('createbook.php', { new_author_name: newAuthorName }, function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        var newOption = new Option(data.author_name, data.author_id, false, true);
                        $('#authors').append(newOption).trigger('change');
                        $('#new_author_name').val('');
                    } else {
                        alert(data.message);
                    }
                });
            }
        });
    });
</script>

<?php
include_once 'includes/footer.php';
?>
