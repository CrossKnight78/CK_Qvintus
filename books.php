<?php
include_once 'includes/functions.php';    
include_once 'includes/header.php';
$bookClass = new Book($pdo);

// Fetch filter options
$authors = $bookClass->selectAllAuthors();
$illustrators = $bookClass->selectAllIllustrators();
$genres = $bookClass->selectAllGenres();
$series = $bookClass->selectAllSeries();
$ageRecommendations = $bookClass->selectAllAgeRecommendations();
$categories = $bookClass->selectAllCategories();
$publishers = $bookClass->selectAllPublishers();
$statuses = $bookClass->selectAllStatuses();

// Get the selected genre from the URL parameter
$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
?>

<div class="container my-5">
    <h1 class="mb-4 text-center">Books</h1>
    <div class="mb-4">
        <input 
            type="text" 
            id="searchInput" 
            class="form-control" 
            placeholder="Search by title" 
            onkeyup="searchBooks()" />
    </div>
    <h5 class="mb-3">Filters</h5>
    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterMenu" aria-expanded="false" aria-controls="filterMenu">
        Toggle Filters
    </button>
    <div class="collapse" id="filterMenu">
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="authorFilter" class="form-label">Author</label>
                    <select id="authorFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Authors</option>
                        <?php foreach ($authors as $author): ?>
                            <option value="<?= $author['author_id'] ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="illustratorFilter" class="form-label">Illustrator</label>
                    <select id="illustratorFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Illustrators</option>
                        <?php foreach ($illustrators as $illustrator): ?>
                            <option value="<?= $illustrator['illustrator_id'] ?>"><?= htmlspecialchars($illustrator['illustrator_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="genreFilter" class="form-label">Genre</label>
                    <select id="genreFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Genres</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['genre_id'] ?>" <?= $selectedGenre == $genre['genre_name'] ? 'selected' : '' ?>><?= htmlspecialchars($genre['genre_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="seriesFilter" class="form-label">Series</label>
                    <select id="seriesFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Series</option>
                        <?php foreach ($series as $serie): ?>
                            <option value="<?= $serie['serie_id'] ?>"><?= htmlspecialchars($serie['serie_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="ageFilter" class="form-label">Age Recommendation</label>
                    <select id="ageFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Ages</option>
                        <?php foreach ($ageRecommendations as $age): ?>
                            <option value="<?= $age['age_id'] ?>"><?= htmlspecialchars($age['age_range']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="categoryFilter" class="form-label">Category</label>
                    <select id="categoryFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="publisherFilter" class="form-label">Publisher</label>
                    <select id="publisherFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Publishers</option>
                        <?php foreach ($publishers as $publisher): ?>
                            <option value="<?= $publisher['publisher_id'] ?>"><?= htmlspecialchars($publisher['publisher_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="statusFilter" class="form-label">Status</label>
                    <select id="statusFilter" class="form-select" onchange="searchBooks()">
                        <option value="">All Statuses</option>
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?= $status['s_id'] ?>"><?= htmlspecialchars($status['s_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="resultContainer">
        <?php 
            $bookClass->displayAllBooks();
        ?>
    </div>
</div>

<script>
function searchBooks() {
    // Get the search input value
    const query = document.getElementById('searchInput').value;
    const author = document.getElementById('authorFilter').value;
    const illustrator = document.getElementById('illustratorFilter').value;
    const genre = document.getElementById('genreFilter').value;
    const series = document.getElementById('seriesFilter').value;
    const age = document.getElementById('ageFilter').value;
    const category = document.getElementById('categoryFilter').value;
    const publisher = document.getElementById('publisherFilter').value;
    const status = document.getElementById('statusFilter').value;

    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Configure it: GET-request for the URL /findBook.php?query=value
    xhr.open('GET', `ajax/findBook.php?query=${encodeURIComponent(query)}&author=${author}&illustrator=${illustrator}&genre=${genre}&series=${series}&age=${age}&category=${category}&publisher=${publisher}&status=${status}`, true);

    // Set up a callback to handle the response
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Update the resultContainer with the response
            document.getElementById('resultContainer').innerHTML = xhr.responseText;
        } else {
            console.error('Error fetching books.');
        }
    };

    // Send the request
    xhr.send();
}

// Trigger searchBooks function on page load if a genre is selected
document.addEventListener('DOMContentLoaded', function() {
    const selectedGenre = "<?= $selectedGenre ?>";
    if (selectedGenre) {
        searchBooks();
    }
});
</script>

<?php
include_once 'includes/footer.php';
?>