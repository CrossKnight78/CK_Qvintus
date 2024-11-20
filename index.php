<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$book = new Book($pdo);
$query = isset($_GET['q']) ? $_GET['q'] : '';
$results = $book->searchBooks($query);


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
            <div class="carousel-item active">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 1">
                            <div class="card-body">
                                <h5 class="card-title">Card 1</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 2">
                            <div class="card-body">
                                <h5 class="card-title">Card 2</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 3">
                            <div class="card-body">
                                <h5 class="card-title">Card 3</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 1">
                            <div class="card-body">
                                <h5 class="card-title">Card 1</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 2">
                            <div class="card-body">
                                <h5 class="card-title">Card 2</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 3">
                            <div class="card-body">
                                <h5 class="card-title">Card 3</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 1">
                            <div class="card-body">
                                <h5 class="card-title">Card 1</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 2">
                            <div class="card-body">
                                <h5 class="card-title">Card 2</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card 3">
                            <div class="card-body">
                                <h5 class="card-title">Card 3</h5>
                                <p class="card-text">Card description goes here.</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
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
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Genre">
                <div class="card-body">
                    <h5 class="card-title">Action</h5>
                </div>
            </div>
        </div>
    <!-- Genre 2 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Adventure</h5>
        </div>
      </div>
    </div>
    <!-- Genre 3 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Comedy</h5>
        </div>
      </div>
    </div>
    <!-- Genre 4 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Drama</h5>
        </div>
      </div>
    </div>
    <!-- Genre 5 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Horror</h5>
        </div>
      </div>
    </div>
    <!-- Genre 6 -->
    <div class="col-6 col-md-4 col-lg-2 mb-4">
      <div class="card text-center">
        <img src="https://via.placeholder.com/150" alt="Genre Image" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Romance</h5>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div id="popular-section" class="container my-5">
    <h2 class="h5 text-center my-4">Most Popular Books</h2>
    <div class="row g-3">
        <div class="col-md-2">
            <div class="card my-2">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 1">
                <div class="card-body">
                    <h5 class="card-title">Book Title 1</h5>
                </div>
            </div>
        </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 2">
        <div class="card-body">
          <h5 class="card-title">Book Title 2</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 3</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 4</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 5</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 6</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 7</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 8</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 9</h5>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card my-2">
        <img src="https://via.placeholder.com/150" class="card-img-top" alt="Book 3">
        <div class="card-body">
          <h5 class="card-title">Book Title 10</h5>
        </div>
      </div>
    </div>
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
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
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
        <img src="https://via.placeholder.com/150" alt="Pekka" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Pekka</h5>
          <p class="card-text">Pekka's review goes here.</p>
        </div>
      </div>
    </div>
    
    <div class="col-12 col-md-4 mb-4">
      <div class="card text-center h-100">
        <img src="https://via.placeholder.com/150" alt="Dr. William" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Dr. William</h5>
          <p class="card-text">Dr. William's review goes here.</p>
        </div>
      </div>
    </div>
    
    <div class="col-12 col-md-4 mb-4">
      <div class="card text-center h-100">
        <img src="https://via.placeholder.com/150" alt="Jin-din" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Jin-din</h5>
          <p class="card-text">Jin-din's review goes here.</p>
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
                    <div class="result-item" data-book-id="${book.book_id}">
                        <strong>${book.book_title}</strong> <span class="text-muted">($${book.books_price})</span>
                    </div>
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