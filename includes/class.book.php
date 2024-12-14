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
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
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
            error_log($e->getMessage());
            return [];
        }
    }

    public function displayAllBooks() {
        $books = $this->selectAllBooks();
        if ($this->errorState === 1) {
            echo '<div class="alert alert-danger">Error retrieving books:</div>';
            foreach ($this->errorMessages as $error) {
                echo '<p>' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</p>';
            }
            return;
        }
        if (empty($books)) {
            echo '<p class="text-center">No books available to display.</p>';
            return;
        }
        echo '<div class="row">';
        foreach ($books as $book) {
            echo '<div class="col-md-4 mb-4 d-flex justify-content-center">';
            echo '<div class="card text-center" style="width: 16rem; padding: 10px;">';
            echo '<img src="' . htmlspecialchars($book['img_url'], ENT_QUOTES, 'UTF-8') . '" class="card-img-top thumbnail-img mx-auto d-block" alt="' . htmlspecialchars($book['book_title'], ENT_QUOTES, 'UTF-8') . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($book['book_title'], ENT_QUOTES, 'UTF-8') . '</h5>';
            echo '<p class="card-text"><strong>Price:</strong> $' . htmlspecialchars($book['books_price'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id'], ENT_QUOTES, 'UTF-8') . '" class="btn btn-primary">View Details</a>';
            echo '</div></div></div>';
        }
        echo '</div>';
    }

    public function searchBooks(STRING $query) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_books WHERE book_title LIKE :query");
        $searchQuery = '%' . $this->cleanInput($query) . '%';
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
            error_log($e->getMessage());
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
            error_log($e->getMessage());
            return [];
        }
    }

    public function getBooksByAuthor(STRING $authors, INT $currentBookId) {
        $authorList = explode(', ', $this->cleanInput($authors)); // Split authors string into an array
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

    public function getBooksByGenre(STRING $genres, INT $currentBookId) {
        $genreList = explode(', ', $this->cleanInput($genres)); // Split genres string into an array
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
                ':book_release_date' => $this->cleanInput($bookData['book_release_date']),
                ':book_pages' => $this->cleanInput($bookData['book_pages']),
                ':books_price' => $this->cleanInput($bookData['books_price']),
                ':book_series_fk' => $this->cleanInput($bookData['book_series_fk']),
                ':age_recommendation_fk' => $this->cleanInput($bookData['age_recommendation_fk']),
                ':category_fk' => $this->cleanInput($bookData['category_fk']),
                ':publisher_fk' => $this->cleanInput($bookData['publisher_fk']),
                ':created_by_fk' => $this->cleanInput($bookData['created_by_fk']),
                ':status_fk' => $this->cleanInput($bookData['status_fk']),
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
                ]);
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
            error_log($e->getMessage());
            return false;
        }
    }

    public function validateBookData($bookData) {
        $requiredFields = [
            'book_title', 'book_desc', 'book_language', 'book_release_date',
            'book_pages', 'books_price', 'book_series_fk', 'age_recommendation_fk',
            'category_fk', 'publisher_fk', 'status_fk', 'img_url'
        ];

        foreach ($requiredFields as $field) {
            if (empty($bookData[$field])) {
                return false;
            }
        }
        return true;
    }

    public function selectAllAuthors() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM table_authors ORDER BY author_name");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
    
    public function selectAllIllustrators() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM table_illustrators ORDER BY illustrator_name");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
    
    public function selectAllGenres() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM table_genres ORDER BY genre_name");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
    
    public function selectAllPublishers() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM table_publishers ORDER BY publisher_name");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
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
            error_log($e->getMessage());
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
            error_log($e->getMessage());
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
            error_log($e->getMessage());
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
            error_log($e->getMessage());
            return [];
        }
    }
    
    public function createAuthor($authorName) {
        $stmt = $this->pdo->prepare("INSERT INTO table_authors (author_name) VALUES (:author_name)");
        $stmt->bindParam(':author_name', $this->cleanInput($authorName), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function editAuthor($authorId, $authorName) {
        $stmt = $this->pdo->prepare("UPDATE table_authors SET author_name = :author_name WHERE author_id = :author_id");
        $stmt->bindParam(':author_name', $this->cleanInput($authorName), PDO::PARAM_STR);
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function deleteAuthor($authorId) {
        try {
            // Begin a transaction
            $this->pdo->beginTransaction();
    
            // Delete related records from junction tables
            $stmt = $this->pdo->prepare("DELETE FROM books_authors WHERE book_author_id = :author_id");
            $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Delete the author record
            $stmt = $this->pdo->prepare("DELETE FROM table_authors WHERE author_id = :author_id");
            $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Commit the transaction
            $this->pdo->commit();
    
            return "Author deleted successfully.";
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete author.";
        }
    }
    
    public function createGenre($genreName, $genreStatus, $genreImg) {
        $stmt = $this->pdo->prepare("INSERT INTO table_genres (genre_name, genre_status, genre_img) VALUES (:genre_name, :genre_status, :genre_img)");
        $stmt->bindParam(':genre_name', $this->cleanInput($genreName), PDO::PARAM_STR);
        $stmt->bindParam(':genre_status', $genreStatus, PDO::PARAM_INT);
        $stmt->bindParam(':genre_img', $this->cleanInput($genreImg), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function editGenre($genreId, $genreName) {
        $stmt = $this->pdo->prepare("UPDATE table_genres SET genre_name = :genre_name WHERE genre_id = :genre_id");
        $stmt->bindParam(':genre_name', $this->cleanInput($genreName), PDO::PARAM_STR);
        $stmt->bindParam(':genre_id', $genreId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function deleteGenre($genreId) {
        try {
            // Begin a transaction
            $this->pdo->beginTransaction();
    
            // Delete related records from junction tables
            $stmt = $this->pdo->prepare("DELETE FROM books_genres WHERE book_genre_id = :genre_id");
            $stmt->bindParam(':genre_id', $genreId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Delete the genre record
            $stmt = $this->pdo->prepare("DELETE FROM table_genres WHERE genre_id = :genre_id");
            $stmt->bindParam(':genre_id', $genreId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Commit the transaction
            $this->pdo->commit();
    
            return "Genre deleted successfully.";
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete genre.";
        }
    }
    
    public function createIllustrator($illustratorName) {
        $stmt = $this->pdo->prepare("INSERT INTO table_illustrators (illustrator_name) VALUES (:illustrator_name)");
        $stmt->bindParam(':illustrator_name', $this->cleanInput($illustratorName), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function editIllustrator($illustratorId, $illustratorName) {
        $stmt = $this->pdo->prepare("UPDATE table_illustrators SET illustrator_name = :illustrator_name WHERE illustrator_id = :illustrator_id");
        $stmt->bindParam(':illustrator_name', $this->cleanInput($illustratorName), PDO::PARAM_STR);
        $stmt->bindParam(':illustrator_id', $illustratorId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function deleteIllustrator($illustratorId) {
        try {
            // Begin a transaction
            $this->pdo->beginTransaction();
    
            // Delete related records from junction tables
            $stmt = $this->pdo->prepare("DELETE FROM books_illustrators WHERE book_illustrator_id = :illustrator_id");
            $stmt->bindParam(':illustrator_id', $illustratorId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Delete the illustrator record
            $stmt = $this->pdo->prepare("DELETE FROM table_illustrators WHERE illustrator_id = :illustrator_id");
            $stmt->bindParam(':illustrator_id', $illustratorId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Commit the transaction
            $this->pdo->commit();
    
            return "Illustrator deleted successfully.";
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete illustrator.";
        }
    }
    
    public function deleteBook($bookId) {
        try {
            // Begin a transaction
            $this->pdo->beginTransaction();
    
            // Delete related records from junction tables
            $stmt = $this->pdo->prepare("DELETE FROM books_authors WHERE books_id = :book_id");
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->execute();
    
            $stmt = $this->pdo->prepare("DELETE FROM books_illustrators WHERE books_id = :book_id");
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->execute();
    
            $stmt = $this->pdo->prepare("DELETE FROM books_genres WHERE books_id = :book_id");
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Delete the book record
            $stmt = $this->pdo->prepare("DELETE FROM table_books WHERE book_id = :book_id");
            $stmt->bindParam(':book_id', $bookId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Commit the transaction
            $this->pdo->commit();
    
            return "Book deleted successfully.";
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete book.";
        }
    }
    
    public function updateBook($bookId, $bookData) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE table_books SET
                    book_title = :book_title,
                    book_desc = :book_desc,
                    book_language = :book_language,
                    book_release_date = :book_release_date,
                    book_pages = :book_pages,
                    books_price = :books_price,
                    book_series_fk = :book_series_fk,
                    age_recommendation_fk = :age_recommendation_fk,
                    category_fk = :category_fk,
                    publisher_fk = :publisher_fk,
                    status_fk = :status_fk,
                    img_url = :img_url
                WHERE book_id = :book_id
            ");
    
            $stmt->execute([
                ':book_title' => $this->cleanInput($bookData['book_title']),
                ':book_desc' => $this->cleanInput($bookData['book_desc']),
                ':book_language' => $this->cleanInput($bookData['book_language']),
                ':book_release_date' => $this->cleanInput($bookData['book_release_date']),
                ':book_pages' => $this->cleanInput($bookData['book_pages']),
                ':books_price' => $this->cleanInput($bookData['books_price']),
                ':book_series_fk' => $this->cleanInput($bookData['book_series_fk']),
                ':age_recommendation_fk' => $this->cleanInput($bookData['age_recommendation_fk']),
                ':category_fk' => $this->cleanInput($bookData['category_fk']),
                ':publisher_fk' => $this->cleanInput($bookData['publisher_fk']),
                ':status_fk' => $this->cleanInput($bookData['status_fk']),
                ':img_url' => $this->cleanInput($bookData['img_url']),
                ':book_id' => $bookId
            ]);
    
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function getAuthorById($authorId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_authors WHERE author_id = :author_id");
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAuthor($authorId, $authorData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_authors SET author_name = :author_name WHERE author_id = :author_id");
            $stmt->execute([
                ':author_name' => $this->cleanInput($authorData['author_name']),
                ':author_id' => $authorId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function getIllustratorById($illustratorId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_illustrators WHERE illustrator_id = :illustrator_id");
        $stmt->bindParam(':illustrator_id', $illustratorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateIllustrator($illustratorId, $illustratorData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_illustrators SET illustrator_name = :illustrator_name WHERE illustrator_id = :illustrator_id");
            $stmt->execute([
                ':illustrator_name' => $this->cleanInput($illustratorData['illustrator_name']),
                ':illustrator_id' => $illustratorId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function getGenreById($genreId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_genres WHERE genre_id = :genre_id");
        $stmt->bindParam(':genre_id', $genreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateGenre($genreId, $genreData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_genres SET genre_name = :genre_name, genre_img = :genre_img, genre_status = :genre_status WHERE genre_id = :genre_id");
            $stmt->execute([
                ':genre_name' => $this->cleanInput($genreData['genre_name']),
                ':genre_img' => $this->cleanInput($genreData['genre_img'] ?? null),
                ':genre_status' => $genreData['genre_status'],
                ':genre_id' => $genreId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function createSeries($seriesName) {
        $stmt = $this->pdo->prepare("INSERT INTO table_series (serie_name) VALUES (:serie_name)");
        $stmt->bindParam(':serie_name', $this->cleanInput($seriesName), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function createAgeRecommendation($ageRange) {
        $stmt = $this->pdo->prepare("INSERT INTO table_age (age_range) VALUES (:age_range)");
        $stmt->bindParam(':age_range', $this->cleanInput($ageRange), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function createCategory($categoryName) {
        $stmt = $this->pdo->prepare("INSERT INTO table_category (category_name) VALUES (:category_name)");
        $stmt->bindParam(':category_name', $this->cleanInput($categoryName), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function createPublisher($publisherName) {
        $stmt = $this->pdo->prepare("INSERT INTO table_publishers (publisher_name) VALUES (:publisher_name)");
        $stmt->bindParam(':publisher_name', $this->cleanInput($publisherName), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function createStatus($statusName) {
        $stmt = $this->pdo->prepare("INSERT INTO table_status (s_name) VALUES (:s_name)");
        $stmt->bindParam(':s_name', $this->cleanInput($statusName), PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function deleteSeries($seriesId) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM table_series WHERE serie_id = :series_id");
            $stmt->bindParam(':series_id', $seriesId, PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
            return "Series deleted successfully.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete series.";
        }
    }
    
    public function deleteAgeRecommendation($ageId) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM table_age WHERE age_id = :age_id");
            $stmt->bindParam(':age_id', $ageId, PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
            return "Age recommendation deleted successfully.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete age recommendation.";
        }
    }
    
    public function deleteCategory($categoryId) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM table_category WHERE category_id = :category_id");
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
            return "Category deleted successfully.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete category.";
        }
    }
    
    public function deletePublisher($publisherId) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM table_publishers WHERE publisher_id = :publisher_id");
            $stmt->bindParam(':publisher_id', $publisherId, PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
            return "Publisher deleted successfully.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete publisher.";
        }
    }
    
    public function deleteStatus($statusId) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("DELETE FROM table_status WHERE s_id = :status_id");
            $stmt->bindParam(':status_id', $statusId, PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
            return "Status deleted successfully.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log($e->getMessage());
            return "Failed to delete status.";
        }
    }
    
    public function updateSeries($seriesId, $seriesData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_series SET serie_name = :serie_name WHERE serie_id = :serie_id");
            $stmt->execute([
                ':serie_name' => $this->cleanInput($seriesData['serie_name']),
                ':serie_id' => $seriesId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function updateAgeRecommendation($ageId, $ageData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_age SET age_range = :age_range WHERE age_id = :age_id");
            $stmt->execute([
                ':age_range' => $this->cleanInput($ageData['age_range']),
                ':age_id' => $ageId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function updateCategory($categoryId, $categoryData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_category SET category_name = :category_name WHERE category_id = :category_id");
            $stmt->execute([
                ':category_name' => $this->cleanInput($categoryData['category_name']),
                ':category_id' => $categoryId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function updatePublisher($publisherId, $publisherData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_publishers SET publisher_name = :publisher_name WHERE publisher_id = :publisher_id");
            $stmt->execute([
                ':publisher_name' => $this->cleanInput($publisherData['publisher_name']),
                ':publisher_id' => $publisherId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function updateStatus($statusId, $statusData) {
        try {
            $stmt = $this->pdo->prepare("UPDATE table_status SET s_name = :s_name WHERE s_id = :status_id");
            $stmt->execute([
                ':s_name' => $this->cleanInput($statusData['s_name']),
                ':status_id' => $statusId
            ]);
            return true;
        } catch (PDOException $e) {
            $this->errorState = 1;
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function getSeriesById($seriesId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_series WHERE serie_id = :serie_id");
        $stmt->bindParam(':serie_id', $seriesId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAgeById($ageId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_age WHERE age_id = :age_id");
        $stmt->bindParam(':age_id', $ageId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getCategoryById($categoryId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_category WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getPublisherById($publisherId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_publishers WHERE publisher_id = :publisher_id");
        $stmt->bindParam(':publisher_id', $publisherId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getStatusById($statusId) {
        $stmt = $this->pdo->prepare("SELECT * FROM table_status WHERE s_id = :status_id");
        $stmt->bindParam(':status_id', $statusId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
