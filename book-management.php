<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

$books = $book->selectAllBooks();
$authors = $book->selectAllAuthors();
$illustrators = $book->selectAllIllustrators();
$genres = $book->selectAllGenres();
$series = $book->selectAllSeries();
$ageRecommendations = $book->selectAllAgeRecommendations();
$categories = $book->selectAllCategories();
$publishers = $book->selectAllPublishers();
$statuses = $book->selectAllStatuses();
?>

<!-- Page Title -->
<div class="container mt-5" style="max-width: 1200px;">
    <!-- Page Title -->
    <h2 class="text-center mb-4">Book Management</h2>

    <!-- Button Row: Create Book, Add Author, Add Genre, Add Illustrator -->
    <div class="d-flex flex-wrap justify-content-between mb-4">
        <div class="d-flex flex-wrap justify-content-between w-100 mb-2">
            <a href="createbook.php" class="btn btn-success mb-2">Add New Book</a>
            <a href="createauthor.php" class="btn btn-info mb-2">Add Author</a>
            <a href="creategenre.php" class="btn btn-primary mb-2">Add Genre</a>
            <a href="createillustrator.php" class="btn btn-warning mb-2">Add Illustrator</a>
            <a href="createseries.php" class="btn btn-secondary mb-2">Add Series</a>
        </div>
        <div class="d-flex flex-wrap justify-content-between w-100">
            <a href="createage.php" class="btn btn-dark mb-2">Add Age Recommendation</a>
            <a href="createcategory.php" class="btn btn-light mb-2">Add Category</a>
            <a href="createpublisher.php" class="btn btn-danger mb-2">Add Publisher</a>
            <a href="createstatus.php" class="btn btn-success mb-2">Add Status</a>
        </div>
    </div>

    <!-- Searchable Dropdown Lists -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="bookSelect" class="form-label">Books</label>
            <select class="form-select select2" id="bookSelect" style="width: 100%;">
                <option value="">Select a Book</option>
                <?php foreach ($books as $book): ?>
                    <option value="<?= $book['book_id'] ?>"><?= htmlspecialchars($book['book_title']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="editbook.php?id=" class="btn btn-warning btn-sm edit-book">Edit</a>
                <a href="confirm-delete.php?type=book&id=" class="btn btn-danger btn-sm delete-book">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="authorSelect" class="form-label">Authors</label>
            <select class="form-select select2" id="authorSelect" style="width: 100%;">
                <option value="">Select an Author</option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author['author_id'] ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-author.php?id=" class="btn btn-warning btn-sm edit-author">Edit</a>
                <a href="confirm-delete.php?type=author&id=" class="btn btn-danger btn-sm delete-author">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="illustratorSelect" class="form-label">Illustrators</label>
            <select class="form-select select2" id="illustratorSelect" style="width: 100%;">
                <option value="">Select an Illustrator</option>
                <?php foreach ($illustrators as $illustrator): ?>
                    <option value="<?= $illustrator['illustrator_id'] ?>"><?= htmlspecialchars($illustrator['illustrator_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-illustrator.php?id=" class="btn btn-warning btn-sm edit-illustrator">Edit</a>
                <a href="confirm-delete.php?type=illustrator&id=" class="btn btn-danger btn-sm delete-illustrator">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="genreSelect" class="form-label">Genres</label>
            <select class="form-select select2" id="genreSelect" style="width: 100%;">
                <option value="">Select a Genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre['genre_id'] ?>"><?= htmlspecialchars($genre['genre_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-genre.php?id=" class="btn btn-warning btn-sm edit-genre">Edit</a>
                <a href="confirm-delete.php?type=genre&id=" class="btn btn-danger btn-sm delete-genre">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="seriesSelect" class="form-label">Series</label>
            <select class="form-select select2" id="seriesSelect" style="width: 100%;">
                <option value="">Select a Series</option>
                <?php foreach ($series as $serie): ?>
                    <option value="<?= $serie['serie_id'] ?>"><?= htmlspecialchars($serie['serie_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-series.php?id=" class="btn btn-warning btn-sm edit-series">Edit</a>
                <a href="confirm-delete.php?type=series&id=" class="btn btn-danger btn-sm delete-series">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="ageSelect" class="form-label">Age Recommendations</label>
            <select class="form-select select2" id="ageSelect" style="width: 100%;">
                <option value="">Select an Age Recommendation</option>
                <?php foreach ($ageRecommendations as $age): ?>
                    <option value="<?= $age['age_id'] ?>"><?= htmlspecialchars($age['age_range']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-age.php?id=" class="btn btn-warning btn-sm edit-age">Edit</a>
                <a href="confirm-delete.php?type=age&id=" class="btn btn-danger btn-sm delete-age">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="categorySelect" class="form-label">Categories</label>
            <select class="form-select select2" id="categorySelect" style="width: 100%;">
                <option value="">Select a Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-category.php?id=" class="btn btn-warning btn-sm edit-category">Edit</a>
                <a href="confirm-delete.php?type=category&id=" class="btn btn-danger btn-sm delete-category">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="publisherSelect" class="form-label">Publishers</label>
            <select class="form-select select2" id="publisherSelect" style="width: 100%;">
                <option value="">Select a Publisher</option>
                <?php foreach ($publishers as $publisher): ?>
                    <option value="<?= $publisher['publisher_id'] ?>"><?= htmlspecialchars($publisher['publisher_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-publisher.php?id=" class="btn btn-warning btn-sm edit-publisher">Edit</a>
                <a href="confirm-delete.php?type=publisher&id=" class="btn btn-danger btn-sm delete-publisher">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="statusSelect" class="form-label">Statuses</label>
            <select class="form-select select2" id="statusSelect" style="width: 100%;">
                <option value="">Select a Status</option>
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= $status['status_id'] ?>"><?= htmlspecialchars($status['s_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2 d-flex justify-content-between">
                <a href="edit-status.php?id=" class="btn btn-warning btn-sm edit-status">Edit</a>
                <a href="confirm-delete.php?type=status&id=" class="btn btn-danger btn-sm delete-status">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Include Select2 JavaScript and CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        $('#bookSelect').on('change', function() {
            var bookId = $(this).val();
            $('.edit-book').attr('href', 'editbook.php?id=' + bookId);
            $('.delete-book').attr('href', 'confirm-delete.php?type=book&id=' + bookId);
        });

        $('#authorSelect').on('change', function() {
            var authorId = $(this).val();
            $('.edit-author').attr('href', 'edit-author.php?id=' + authorId);
            $('.delete-author').attr('href', 'confirm-delete.php?type=author&id=' + authorId);
        });

        $('#illustratorSelect').on('change', function() {
            var illustratorId = $(this).val();
            $('.edit-illustrator').attr('href', 'edit-illustrator.php?id=' + illustratorId);
            $('.delete-illustrator').attr('href', 'confirm-delete.php?type=illustrator&id=' + illustratorId);
        });

        $('#genreSelect').on('change', function() {
            var genreId = $(this).val();
            $('.edit-genre').attr('href', 'edit-genre.php?id=' + genreId);
            $('.delete-genre').attr('href', 'confirm-delete.php?type=genre&id=' + genreId);
        });

        $('#seriesSelect').on('change', function() {
            var seriesId = $(this).val();
            $('.edit-series').attr('href', 'edit-series.php?id=' + seriesId);
            $('.delete-series').attr('href', 'confirm-delete.php?type=series&id=' + seriesId);
        });

        $('#ageSelect').on('change', function() {
            var ageId = $(this).val();
            $('.edit-age').attr('href', 'edit-age.php?id=' + ageId);
            $('.delete-age').attr('href', 'confirm-delete.php?type=age&id=' + ageId);
        });

        $('#categorySelect').on('change', function() {
            var categoryId = $(this).val();
            $('.edit-category').attr('href', 'edit-category.php?id=' + categoryId);
            $('.delete-category').attr('href', 'confirm-delete.php?type=category&id=' + categoryId);
        });

        $('#publisherSelect').on('change', function() {
            var publisherId = $(this).val();
            $('.edit-publisher').attr('href', 'edit-publisher.php?id=' + publisherId);
            $('.delete-publisher').attr('href', 'confirm-delete.php?type=publisher&id=' + publisherId);
        });

        $('#statusSelect').on('change', function() {
            var statusId = $(this).val();
            $('.edit-status').attr('href', 'edit-status.php?id=' + statusId);
            $('.delete-status').attr('href', 'confirm-delete.php?type=status&id=' + statusId);
        });

        // Add click event to check if a book is selected before editing or deleting
        $('.edit-book, .delete-book').on('click', function(e) {
            if ($('#bookSelect').val() === "") {
                e.preventDefault();
                alert("Please select a book to edit or delete.");
            }
        });

        // Add click event to check if an author is selected before editing or deleting
        $('.edit-author, .delete-author').on('click', function(e) {
            if ($('#authorSelect').val() === "") {
                e.preventDefault();
                alert("Please select an author to edit or delete.");
            }
        });

        // Add click event to check if an illustrator is selected before editing or deleting
        $('.edit-illustrator, .delete-illustrator').on('click', function(e) {
            if ($('#illustratorSelect').val() === "") {
                e.preventDefault();
                alert("Please select an illustrator to edit or delete.");
            }
        });

        // Add click event to check if a genre is selected before editing or deleting
        $('.edit-genre, .delete-genre').on('click', function(e) {
            if ($('#genreSelect').val() === "") {
                e.preventDefault();
                alert("Please select a genre to edit or delete.");
            }
        });

        // Add click event to check if a series is selected before editing or deleting
        $('.edit-series, .delete-series').on('click', function(e) {
            if ($('#seriesSelect').val() === "") {
                e.preventDefault();
                alert("Please select a series to edit or delete.");
            }
        });

        // Add click event to check if an age recommendation is selected before editing or deleting
        $('.edit-age, .delete-age').on('click', function(e) {
            if ($('#ageSelect').val() === "") {
                e.preventDefault();
                alert("Please select an age recommendation to edit or delete.");
            }
        });

        // Add click event to check if a category is selected before editing or deleting
        $('.edit-category, .delete-category').on('click', function(e) {
            if ($('#categorySelect').val() === "") {
                e.preventDefault();
                alert("Please select a category to edit or delete.");
            }
        });

        // Add click event to check if a publisher is selected before editing or deleting
        $('.edit-publisher, .delete-publisher').on('click', function(e) {
            if ($('#publisherSelect').val() === "") {
                e.preventDefault();
                alert("Please select a publisher to edit or delete.");
            }
        });

        // Add click event to check if a status is selected before editing or deleting
        $('.edit-status, .delete-status').on('click', function(e) {
            if ($('#statusSelect').val() === "") {
                e.preventDefault();
                alert("Please select a status to edit or delete.");
            }
        });
    });
</script>

<?php
include_once 'includes/footer.php';
?>