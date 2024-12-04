<?php
    class Book {

        private $pdo;
        private $errorMessages = [];
        private $errorState = 0;
    
        function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function cleanInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        public function getBookById(INT $bookId) {
            $stmt = $this->pdo->prepare("
                SELECT b.*, 
                       GROUP_CONCAT(DISTINCT g.genre_name SEPARATOR ', ') AS genres,
                       GROUP_CONCAT(DISTINCT a.author_name SEPARATOR ', ') AS authors,
                       GROUP_CONCAT(DISTINCT i.illustrator_name SEPARATOR ', ') AS illustrators,
                       p.publisher_name,
                       c.category_name,
                       ar.age_range,
                       s.serie_name
                FROM table_books b
                LEFT JOIN books_genres bg ON b.book_id = bg.books_id
                LEFT JOIN table_genres g ON bg.book_genre_id = g.genre_id
                LEFT JOIN books_authors ba ON b.book_id = ba.books_id
                LEFT JOIN table_authors a ON ba.book_author_id = a.author_id
                LEFT JOIN books_illustrators bi ON b.book_id = bi.books_id
                LEFT JOIN table_illustrators i ON bi.book_illustrator_id = i.illustrator_id
                LEFT JOIN table_publishers p ON b.publisher_fk = p.publisher_id
                LEFT JOIN table_category c ON b.category_fk = c.category_id
                LEFT JOIN table_age ar ON b.age_recommendation_fk = ar.age_id
                LEFT JOIN table_series s ON b.book_series_fk = s.serie_id
                WHERE b.book_id = :book_id
                GROUP BY b.book_id
            ");
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->execute();
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
    
    
        public function searchBooks(STRING $query) {
            $stmt = $this->pdo->prepare("SELECT * FROM table_books WHERE book_title LIKE :query");
            $searchQuery = '%' . $query . '%';
            $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
            $stmt->execute();
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

        public function getExclusiveBooks(INT $status) {
            try {
                $stmt = $this->pdo->prepare('SELECT * FROM table_books WHERE status_fk = :status');
                $stmt->bindParam(':status', $status, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->errorState = 1;
                $this->errorMessages[] = $e->getMessage();
                return [];
            }
        }

        
// Fetch books by the same author, excluding the current book and limiting the results to 5
public function getBooksByAuthor(STRING $authors, INT $currentBookId) {
    $authorList = explode(', ', $authors); // Split authors string into an array
    $authorPlaceholders = [];
    
    // Create named placeholders for each author
    foreach ($authorList as $index => $author) {
        $authorPlaceholders[] = ":author_$index";
    }
    
    // Prepare SQL query (only select necessary fields and limit the results to 5)
    $stmt = $this->pdo->prepare("
        SELECT b.book_id, b.book_title, b.img_url
        FROM table_books b
        LEFT JOIN books_authors ba ON b.book_id = ba.books_id
        LEFT JOIN table_authors a ON ba.book_author_id = a.author_id
        WHERE a.author_name IN (" . implode(',', $authorPlaceholders) . ")
        AND b.book_id != :currentBookId
        GROUP BY b.book_id
    ");
    
    // Bind each author name to the query using the named placeholders
    foreach ($authorList as $index => $author) {
        $stmt->bindValue(":author_$index", $author, PDO::PARAM_STR);
    }
    
    // Bind the current book ID to the query
    $stmt->bindValue(':currentBookId', $currentBookId, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch books by the same genre, excluding the current book and limiting the results to 5
public function getBooksByGenre(STRING $genres, INT $currentBookId) {
    $genreList = explode(', ', $genres); // Split genres string into an array
    $genrePlaceholders = [];
    
    // Create named placeholders for each genre
    foreach ($genreList as $index => $genre) {
        $genrePlaceholders[] = ":genre_$index";
    }
    
    // Prepare SQL query (only select necessary fields and limit the results to 5)
    $stmt = $this->pdo->prepare("
        SELECT b.book_id, b.book_title, b.img_url
        FROM table_books b
        LEFT JOIN books_genres bg ON b.book_id = bg.books_id
        LEFT JOIN table_genres g ON bg.book_genre_id = g.genre_id
        WHERE g.genre_name IN (" . implode(',', $genrePlaceholders) . ")
        AND b.book_id != :currentBookId
        GROUP BY b.book_id
    ");
    
    // Bind each genre name to the query using the named placeholders
    foreach ($genreList as $index => $genre) {
        $stmt->bindValue(":genre_$index", $genre, PDO::PARAM_STR);
    }

    // Bind the current book ID to the query
    $stmt->bindValue(':currentBookId', $currentBookId, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function fetchCustomerReviews() {
    try {
        $sql = "SELECT * FROM customer_review";
        $stmt = $this->pdo->query($sql);

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Return an empty array if no reviews are found
        }
    } catch (PDOException $e) {
        // Log or handle the error
        error_log("Error fetching customer reviews: " . $e->getMessage());
        return []; // Return an empty array on failure
    }
}

public function createBook($bookData, $authors, $illustrators, $genres) {
    try {
        // Begin a transaction
        $this->pdo->beginTransaction();

        // Insert into the Books table
        $stmt = $this->pdo->prepare("
            INSERT INTO table_books (
                book_title, book_desc, book_language, book_release_date, 
                book_pages, books_price, book_series_fk, age_recommendation_fk, 
                category_fk, publisher_fk, created_by_fk, status_fk, img_url
            ) VALUES (
                :book_title, :book_desc, :book_language, :book_release_date, 
                :book_pages, :books_price, :book_series_fk, :age_recommendation_fk, 
                :category_fk, :publisher_fk, :created_by_fk, :status_fk, :img_url
            )
        ");

        $stmt->execute([
            ':book_title' => $this->cleanInput($bookData['book_title']),
            ':book_desc' => $this->cleanInput($bookData['book_desc']),
            ':book_language' => $this->cleanInput($bookData['book_language']),
            ':book_release_date' => $bookData['book_release_date'],
            ':book_pages' => $bookData['book_pages'],
            ':books_price' => $bookData['books_price'],
            ':book_series_fk' => $bookData['book_series_fk'],
            ':age_recommendation_fk' => $bookData['age_recommendation_fk'],
            ':category_fk' => $bookData['category_fk'],
            ':publisher_fk' => $bookData['publisher_fk'],
            ':created_by_fk' => $bookData['created_by_fk'],
            ':status_fk' => $bookData['status_fk'],
            ':img_url' => $this->cleanInput($bookData['img_url'])
        ]);

        // Get the ID of the inserted book
        $bookId = $this->pdo->lastInsertId();

        // Insert authors into the junction table
        $stmtAuthor = $this->pdo->prepare("
            INSERT INTO books_authors (books_id, book_author_id) VALUES (:book_id, :author_id)
        ");
        foreach ($authors as $authorId) {
            $stmtAuthor->execute([
                ':book_id' => $bookId,
                ':author_id' => $authorId
        }

        // Insert illustrators into the junction table
        $stmtIllustrator = $this->pdo->prepare("
            INSERT INTO books_illustrators (books_id, book_illustrator_id) VALUES (:book_id, :illustrator_id)
        ");
        foreach ($illustrators as $illustratorId) {
            $stmtIllustrator->execute([
                ':book_id' => $bookId,
                ':illustrator_id' => $illustratorId
            ]);
        }

        // Insert genres into the junction table
        $stmtGenre = $this->pdo->prepare("
            INSERT INTO books_genres (books_id, book_genre_id) VALUES (:book_id, :genre_id)
        ");
        foreach ($genres as $genreId) {
            $stmtGenre->execute([
                ':book_id' => $bookId,
                ':genre_id' => $genreId
            ]);
        }

        // Commit the transaction
        $this->pdo->commit();

        return $bookId; // Return the ID of the newly created book

    } catch (PDOException $e) {
        // Rollback the transaction on error
        $this->pdo->rollBack();
        $this->errorState = 1;
        $this->errorMessages[] = $e->getMessage();
        return false;
    }
}


// Select all genres
public function selectAllGenres() {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM table_genres ORDER BY genre_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}

// Select all authors
public function selectAllAuthors() {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM table_authors ORDER BY author_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}

// Select all illustrators
public function selectAllIllustrators() {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM table_illustrators ORDER BY illustrator_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}

public function selectAllPublishers() {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM table_publishers ORDER BY publisher_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}

// Select all categories
public function selectAllCategories() {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM table_category ORDER BY category_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}

// Select all age recommendations
public function selectAllAgeRecommendations() {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM table_age ORDER BY age_range");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}

// Select all series
public function selectAllSeries() {
    try {
        // Correcting the column names to match the database table
        $stmt = $this->pdo->prepare("SELECT * FROM table_series ORDER BY serie_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}


// Select all statuses
public function selectAllStatuses() {
    try {
        $stmt = $this->pdo->prepare("SELECT * FROM table_status ORDER BY s_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $this->errorMessages[] = $e->getMessage();
        return [];
    }
}

}



?>
