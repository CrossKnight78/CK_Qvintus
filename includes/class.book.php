<?php

class Book {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getBookById($bookId) {
        // SQL query to fetch book details by book_id
        $stmt = $this->pdo->prepare("SELECT * FROM table_books WHERE book_id = :book_id");
        $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT); // Bind as an integer
        $stmt->execute();
        
        // Fetch the single book detail
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function selectAllBooks() {
        try {
            $stmt_selectAllBooks = $this->pdo->prepare('SELECT * FROM table_books');
            $stmt_selectAllBooks->execute();
            return $stmt_selectAllBooks->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorState = 1;
            $this->errorMessages[] = $e->getMessage();
            return [];
        }
    }

    public function displayAllBooks() {
        $books = $this->selectAllBooks();
        if ($this->errorState === 1) {
            echo '<div class="alert alert-danger">Error retrieving books:</div>';
            foreach ($this->errorMessages as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            return;
        }
        if (empty($books)) {
            echo '<p class="text-center">No books available to display.</p>';
            return;
        }
        echo '<div class="row">';
        foreach ($books as $book) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<img src="' . htmlspecialchars($book['img_url']) . '" class="card-img-top" alt="' . htmlspecialchars($book['book_title']) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($book['book_title']) . '</h5>';
            echo '<p class="card-text"><strong>Price:</strong> $' . htmlspecialchars($book['books_price']) . '</p>';
            echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id']) . '" class="btn btn-primary">View Details</a>';
            echo '</div></div></div>';
        }
        echo '</div>';
    }

    public function selectSingleBook($id) {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM table_books WHERE book_id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorState = 1;
            $this->errorMessages[] = $e->getMessage();
            return null;
        }
    }

    public function searchBooks($query) {
        // SQL query to search books by book_title with wildcards for partial matching
        $stmt = $this->pdo->prepare("SELECT * FROM table_books WHERE book_title LIKE :query");
        
        // Adding wildcards to the query for partial matching
        $searchQuery = '%' . $query . '%';
        
        // Bind the query parameter as a string (PDO::PARAM_STR) for LIKE comparison
        $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all results as associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPopularGenres() {
        $stmt = $this->pdo->prepare("SELECT genre_name, genre_img FROM table_genres WHERE genre_status = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPopularBooks() {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM table_books WHERE status_fk = 5');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->errorState = 1;
            $this->errorMessages[] = $e->getMessage();
            return [];
        }
    }

}



?>
