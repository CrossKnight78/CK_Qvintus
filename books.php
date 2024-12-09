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
            placeholder="Search by title" 
            onkeyup="searchBooks()" />
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

    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Configure it: GET-request for the URL /findBook.php?query=value
    xhr.open('GET', `ajax/findBook.php?query=${encodeURIComponent(query)}`, true);

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
</script>

<?php
include_once 'includes/footer.php';
?>