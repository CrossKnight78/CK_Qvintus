<?php

class Book {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function selectAllBooks() {
        try {
            // Use the PDO object stored in $this->pdo to prepare the query
            $stmt_selectAllBooks = $this->pdo->prepare('SELECT * FROM table_books');
            $stmt_selectAllBooks->execute();
            
            // Fetch all rows as an associative array
            $books = $stmt_selectAllBooks->fetchAll(PDO::FETCH_ASSOC);
            
            return $books;
        } catch (PDOException $e) {
            // Handle errors and log them
            $this->errorState = 1;
            $this->errorMessages[] = $e->getMessage();
            return [];
        }
    }

    public function displayAllBooks() {
        // Fetch books
        $books = $this->selectAllBooks();
    
        // Check for errors
        if ($this->errorState === 1) {
            echo '<p>Error retrieving books:</p>';
            foreach ($this->errorMessages as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            return;
        }
    
        // If no books found
        if (empty($books)) {
            echo '<p>No books available to display.</p>';
            return;
        }
    
        // Display books as cards
        echo '<div class="book-cards-container" style="display: flex; flex-wrap: wrap; gap: 20px;">';
    
        foreach ($books as $book) {
            echo '<div class="book-card" style="border: 1px solid #ccc; border-radius: 8px; padding: 16px; width: 300px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">';
            echo '<img src="' . htmlspecialchars($book['img_url']) . '" alt="' . htmlspecialchars($book['book_title']) . '" style="width: 100%; height: auto; border-radius: 4px;">';
            echo '<h3 style="margin: 10px 0; font-size: 1.25em;">' . htmlspecialchars($book['book_title']) . '</h3>';
            echo '<p><strong>Description:</strong> ' . htmlspecialchars($book['book_desc']) . '</p>';
            echo '<p><strong>Language:</strong> ' . htmlspecialchars($book['book_language']) . '</p>';
            echo '<p><strong>Release Date:</strong> ' . htmlspecialchars($book['book_release_date']) . '</p>';
            echo '<p><strong>Pages:</strong> ' . htmlspecialchars($book['book_pages']) . '</p>';
            echo '<p><strong>Price:</strong> $' . htmlspecialchars($book['books_price']) . '</p>';
            echo '<a href="book_details.php?id=' . htmlspecialchars($book['book_id']) . '" style="text-decoration: none; color: white; background-color: #007BFF; padding: 10px 15px; border-radius: 5px; display: inline-block; text-align: center;">View Details</a>';
            echo '</div>';
        }
    
        echo '</div>';
    }
}



?>
