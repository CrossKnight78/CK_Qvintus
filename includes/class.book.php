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
}
}


?>
