<?php
include_once 'includes/header.php';
?>

<!-- Page Title -->
<div class="container mt-5" style="max-width: 1200px;">
    <!-- Page Title -->
    <h2 class="text-center">Book Management</h2>

    <!-- Search Form -->
    <form method="POST" action="book-management.php" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search_query" placeholder="Search for books..." aria-label="Search for books">
            <button class="btn btn-primary" type="submit" name="search">Search</button>
        </div>
    </form>

   
    <!-- Button Row: Create Book, Add Author, Add Genre, Add Illustrator -->
    <div class="d-flex justify-content-between mb-4">
        <a href="create-book.php" class="btn btn-success mr-2">Add New Book</a>
        <a href="create-author.php" class="btn btn-info mr-2">Add Author</a>
        <a href="create-genre.php" class="btn btn-primary mr-2">Add Genre</a>
        <a href="create-illustrator.php" class="btn btn-warning">Add Illustrator</a>
    </div>

    <!-- Book List Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Illustrator</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example Book Row 1 -->
            <tr>
                <td>
                    Book Title 1
                    <a href="edit-title.php?id=1" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-title.php?id=1" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
                <td>
                    Author Name 1
                    <a href="edit-author.php?id=1" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-author.php?id=1" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
                <td>
                    Genre 1
                    <a href="edit-genre.php?id=1" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-genre.php?id=1" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
                <td>
                    Illustrator 1
                    <a href="edit-illustrator.php?id=1" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-illustrator.php?id=1" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
            </tr>

            <!-- Example Book Row 2 -->
            <tr>
                <td>
                    Book Title 2
                    <a href="edit-title.php?id=2" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-title.php?id=2" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
                <td>
                    Author Name 2
                    <a href="edit-author.php?id=2" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-author.php?id=2" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
                <td>
                    Genre 2
                    <a href="edit-genre.php?id=2" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-genre.php?id=2" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
                <td>
                    Illustrator 2
                    <a href="edit-illustrator.php?id=2" class="btn btn-warning btn-sm ml-2">Edit</a>
                    <a href="delete-illustrator.php?id=2" class="btn btn-danger btn-sm ml-2">Delete</a>
                </td>
            </tr>

            <!-- More rows can go here -->
        </tbody>
    </table>
</div>

<?php
include_once 'includes/footer.php';
?>