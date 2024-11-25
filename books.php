<?php
include_once 'includes/functions.php';    
include_once 'includes/header.php';
$bookClass = new Book($pdo);
?>

<div class="container my-5">
    <h1 class="mb-4 text-center">Books</h1>
    <div class="mb-4">
        <input 
            type="text" 
            id="searchInput" 
            class="form-control" 
            placeholder="Search by title or author" />
    </div>
    <div id="resultContainer">
        <?php 
            // Display all books initially, but only if no search query is present
            if (empty($_GET['query'])) {
                $bookClass->displayAllBooks();
            }
        ?>
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
        fetch(`includes/findBook.php?query=${encodeURIComponent(query)}`)
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
                    <a class="result-item-link" href="singlebook.php?id=${book.book_id}">
                        <div class="result-item" data-book-id="${book.book_id}">
                            <strong>${book.book_title}</strong> 
                            <span class="text-muted">($${book.books_price})</span>
                        </div>
                    </a>
                `).join('');

                // Add click events to each result item
                const resultItems = resultsContainer.querySelectorAll('.result-item');
                resultItems.forEach(item => {
                    item.addEventListener('click', () => {
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