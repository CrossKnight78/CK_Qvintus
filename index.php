<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$book = new Book($pdo); // Initialize the Book class
$query = isset($_GET['q']) ? $_GET['q'] : ''; // Check for search query


// Fetch all books, then filter by s_id = 4
$allBooks = $query ? $book->searchBooks($query) : $book->selectAllBooks();
$rareBooks = array_filter($allBooks, function ($book) {
    return $book['status_fk'] == 4; // Filter for rare books with s_id = 4
});

// Fetch popular genres
$popularGenres = $book->getPopularGenres();

// Fetch popular books dynamically
$popularBooks = $book->getPopularBooks();
$popularBooks = array_filter($allBooks, function ($book) {
  return $book['status_fk'] == 5; // Filter for books with status_fk = 5
});

?>

<div id="hero" class="text-center">
<div class="container my-5">
    <h1>What are you Searching for?</h1>
    <div class="search-container">
    <!-- Search input field -->
    <input type="text" class="form-control form-control-lg" placeholder="Search..." id="searchInput">
    
    <!-- Hidden dropdown container for search results -->
    <div id="searchResults" class="dropdown-list" style="display: none;">
        <!-- Search results will be dynamically populated here -->
    </div>
</div>
</div>

<div id="exclusive-section" class="container mt-5">
    <h2>Most Exclusive Items</h2>
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            if (!empty($rareBooks)) {
                $chunks = array_chunk($rareBooks, 3); // Divide books into groups of 3 for carousel items
                $isActive = true;

                foreach ($chunks as $chunk) {
                    echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                    $isActive = false; // Only the first item should be active
                    echo '<div class="row g-3">';

                    foreach ($chunk as $book) {
                        echo '<div class="col-md-4">';
                        echo '<div class="card">';
                        echo '<img src="' . htmlspecialchars($book['img_url']) . '" class="card-img-top" alt="' . htmlspecialchars($book['book_title']) . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($book['book_title']) . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($book['book_desc']) . '</p>';
                        echo '<p class="card-text"><strong>Price:</strong> $' . htmlspecialchars($book['books_price']) . '</p>';
                        echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id']) . '" class="btn btn-primary">View Details</a>';
                        echo '</div></div></div>';
                    }

                    echo '</div></div>';
                }
            } else {
                echo '<p class="text-center">No rare books found.</p>';
            }
            ?>
        </div>
        <!-- Carousel controls (invisible but clickable) -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>


<!-- Genres Section -->
<div id="genres-section" class="container my-5">
    <h2 class="h5 text-center my-4">Most Popular Genres</h2>
    <div class="row text-center g-3">

    <?php
    // Loop through each popular genre and generate the HTML
    foreach ($popularGenres as $genre) {
        echo '<div class="col-6 col-md-4 col-lg-2 mb-4">';
        echo '  <div class="card text-center">';
        echo '    <img src="' . htmlspecialchars($genre['genre_img']) . '" alt="Genre Image" class="card-img-top">';
        echo '    <div class="card-body">';
        echo '      <h5 class="card-title">' . htmlspecialchars($genre['genre_name']) . '</h5>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
    ?>

    </div>
</div>

<div id="popular-section" class="container my-5">
    <h2 class="h5 text-center my-4">Most Popular Books</h2>
    <div class="row g-3">
        <?php
        if (!empty($popularBooks)) {
            foreach ($popularBooks as $book) {
                echo '<div class="col-md-2">';
                echo '<div class="card my-2">';
                echo '<img src="' . htmlspecialchars($book['img_url']) . '" class="card-img-top" alt="' . htmlspecialchars($book['book_title']) . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($book['book_title']) . '</h5>';
                echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id']) . '" class="btn btn-primary btn-sm">View Details</a>';
                echo '</div></div></div>';
            }
        } else {
            echo '<p class="text-center">No popular books found.</p>';
        }
        ?>
    </div>
</div>

<!-- Contact Section -->
<div id="contact-section" class="container text-center my-5">
    <h2>Did you find what you need?</h2>
    <p>We take all requests to heart, big or small.</p>
    <a href="contact.php" class="btn btn-primary btn-lg">Make a Request</a>
</div>

<!-- About Section -->
<div id="about-section" class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2>About Qvintus</h2>
            <p>Nestled in the heart of Tampere, Finland, Qvintus is no ordinary bookstore. With a carefully curated collection, we cater to readers of all tastes—offering everything from beloved classics and contemporary novels to rare, exclusive treasures like the Gutenberg Bible. As a haven for book enthusiasts and collectors alike, Qvintus is proud to blend accessibility with exclusivity. With an annual revenue of €4 million, we are more than a bookstore; we are a cultural institution dedicated to preserving the timeless magic of the written word.</p>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="images/qvintus.webp" alt="About Us" class="img-fluid">
        </div>
    </div>
</div>

<div id="customer-section" class="container text-center">
  <h2 class="h5 my-4">Customer Stories</h2>
  <div class="row text-center my-5">
    <!-- Ensure correct spacing between cards -->
    <div class="col-12 col-md-4 mb-4">
      <div class="card text-center h-100">
        <div class="card-body">
          <h5 class="card-title">Pekka</h5>
          <p class="card-text">"Qvintus is a true gem! I discovered a first-edition Finnish classic here that I never thought I’d find. The staff's knowledge and passion for books are unmatched."</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4 mb-4">
      <div class="card text-center h-100">
        <div class="card-body">
          <h5 class="card-title">Dr. William</h5>
          <p class="card-text">"The rare book selection is extraordinary. Qvintus feels like stepping into a literary treasure trove. I found an original Gutenberg Bible here—simply breathtaking!"</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4 mb-4">
      <div class="card text-center h-100">
        <div class="card-body">
          <h5 class="card-title">Jin-din</h5>
          <p class="card-text">"I love how Qvintus caters to everyone. Whether you're a casual reader or a serious collector, there's something special waiting for you. The atmosphere is warm and inviting."</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector('#searchInput');
    const resultsContainer = document.querySelector('#searchResults');

    // Trigger search on input event in the search field
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();

        // Hide the results container if the input is empty
        if (query === "") {
            resultsContainer.style.display = 'none';
            return;
        }

        // Show loading spinner while fetching results
        resultsContainer.innerHTML = `
            <div class="loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        resultsContainer.style.display = 'block'; // Show the results container

        // Perform AJAX request to fetch search results
        fetch(`ajax/searchBooks.php?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to fetch results.");
                }
                return response.json();
            })
            .then(books => {
                // If no results are found, display a message
                if (books.length === 0) {
                    resultsContainer.innerHTML = "<p>No books found matching your query.</p>";
                    return;
                }

                // Populate the results container with search results
                resultsContainer.innerHTML = books.map(book => `
                    <a class="result-item-link" href=singlebook.php?id=${book.book_id}><div class="result-item" data-book-id="${book.book_id}">
                        <strong>${book.book_title}</strong> <span class="text-muted">($${book.books_price})</span>
                    </div></a>
                `).join('');

                // Add click events to each result item
                const resultItems = resultsContainer.querySelectorAll('.result-item');
                resultItems.forEach(item => {
                    item.addEventListener('click', () => {
                        // Optionally, you can perform an action when an item is clicked (e.g., fill the search input)
                        searchInput.value = item.querySelector('strong').innerText;
                        resultsContainer.style.display = 'none'; // Hide the results after selection
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                resultsContainer.innerHTML = "<p>Failed to fetch results. Please try again later.</p>";
            });
    });

    // Hide results if the user clicks outside the search area
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.search-container')) {
            resultsContainer.style.display = 'none';
        }
    });
});


</script>

<?php
include_once 'includes/footer.php';
?>