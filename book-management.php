<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
$book = new Book($pdo);

$books = $book->selectAllBooks();
$authors = $book->selectAllAuthors();
$illustrators = $book->selectAllIllustrators();
$genres = $book->selectAllGenres();
?>

<!-- Page Title -->
<div class="container mt-5" style="max-width: 1200px;">
    <!-- Page Title -->
    <h2 class="text-center mb-4">Book Management</h2>

    <!-- Button Row: Create Book, Add Author, Add Genre, Add Illustrator -->
    <div class="d-flex justify-content-between mb-4">
        <a href="createbook.php" class="btn btn-success">Add New Book</a>
        <a href="createauthor.php" class="btn btn-info">Add Author</a>
        <a href="creategenre.php" class="btn btn-primary">Add Genre</a>
        <a href="createillustrator.php" class="btn btn-warning">Add Illustrator</a>
    </div>

    <!-- Searchable Dropdown Lists -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="bookSelect" class="form-label">Books</label>
            <select class="form-select select2" id="bookSelect">
                <option value="">Select a Book</option>
                <?php foreach ($books as $book): ?>
                    <option value="<?= $book['book_id'] ?>"><?= htmlspecialchars($book['book_title']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2">
                <a href="editbook.php?id=" class="btn btn-warning btn-sm edit-book">Edit</a>
                <a href="confirm-delete.php?type=book&id=" class="btn btn-danger btn-sm delete-book">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="authorSelect" class="form-label">Authors</label>
            <select class="form-select select2" id="authorSelect">
                <option value="">Select an Author</option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author['author_id'] ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2">
                <a href="edit-author.php?id=" class="btn btn-warning btn-sm edit-author">Edit</a>
                <a href="confirm-delete.php?type=author&id=" class="btn btn-danger btn-sm delete-author">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="illustratorSelect" class="form-label">Illustrators</label>
            <select class="form-select select2" id="illustratorSelect">
                <option value="">Select an Illustrator</option>
                <?php foreach ($illustrators as $illustrator): ?>
                    <option value="<?= $illustrator['illustrator_id'] ?>"><?= htmlspecialchars($illustrator['illustrator_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2">
                <a href="edit-illustrator.php?id=" class="btn btn-warning btn-sm edit-illustrator">Edit</a>
                <a href="confirm-delete.php?type=illustrator&id=" class="btn btn-danger btn-sm delete-illustrator">Delete</a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <label for="genreSelect" class="form-label">Genres</label>
            <select class="form-select select2" id="genreSelect">
                <option value="">Select a Genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= $genre['genre_id'] ?>"><?= htmlspecialchars($genre['genre_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mt-2">
                <a href="edit-genre.php?id=" class="btn btn-warning btn-sm edit-genre">Edit</a>
                <a href="confirm-delete.php?type=genre&id=" class="btn btn-danger btn-sm delete-genre">Delete</a>
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
    });
</script>

<?php
include_once 'includes/footer.php';
?>