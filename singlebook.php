<?php
include_once 'includes/header.php';

$bookClass = new Book($pdo);

if (isset($_GET['id'])) {
    $bookId = intval($_GET['id']);
    $book = $bookClass->getBookById($bookId);

    // Assuming $book contains the current book details
    $currentBookId = $book['book_id'];
    $bookCreatorId = $book['created_by_fk'];

    // Fetch books by the same author
    $authorBooks = $bookClass->getBooksByAuthor($book['authors'], $currentBookId);

    // Fetch books in the same genre
    $genreBooks = $bookClass->getBooksByGenre($book['genres'], $currentBookId);

    // Check if user is logged in
    if (isset($_SESSION['user_role']) && isset($_SESSION['user_id'])) {
        $userRole = $_SESSION['user_role'];
        $userId = $_SESSION['user_id'];
    } else {
        // Default values for non-logged-in users
        $userRole = 0;
        $userId = 0;
    }
}
?>

<div class="container my-5">
    <?php if (!empty($book)): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($book['img_url']); ?>" class="card-img-top" alt="<?= htmlspecialchars($book['book_title']); ?>" style="width: 300px; height: 300px;">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($book['book_title']); ?></h5>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-3" id="bookTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="false">Info</button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($book['book_desc']); ?></p>
                    </div>
                    <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <p class="card-text"><strong>Language:</strong> <?= htmlspecialchars($book['book_language']); ?></p>
                        <p class="card-text"><strong>Release Date:</strong> <?= htmlspecialchars($book['book_release_date']); ?></p>
                        <p class="card-text"><strong>Pages:</strong> <?= htmlspecialchars($book['book_pages']); ?></p>
                        <p class="card-text"><strong>Price:</strong> $<?= htmlspecialchars($book['books_price']); ?></p>
                        <p class="card-text"><strong>Genres:</strong> <?= htmlspecialchars($book['genres']); ?></p>
                        <p class="card-text"><strong>Authors:</strong> <?= htmlspecialchars($book['authors']); ?></p>
                        <p class="card-text"><strong>Illustrators:</strong> <?= htmlspecialchars($book['illustrators']); ?></p>
                        <p class="card-text"><strong>Publisher:</strong> <?= htmlspecialchars($book['publisher_name']); ?></p>
                        <p class="card-text"><strong>Category:</strong> <?= htmlspecialchars($book['category_name']); ?></p>
                        <p class="card-text"><strong>Age Recommendation:</strong> <?= htmlspecialchars($book['age_range']); ?></p>
                        <p class="card-text"><strong>Series:</strong> <?= htmlspecialchars($book['serie_name']); ?></p>
                    </div>
                </div>

                <?php if ($userId == $bookCreatorId || $userRole >= 50): ?>
                    <a href="editbook.php?id=<?= $bookId ?>" class="btn btn-warning p-2 my-2">Edit Book</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Carousel for Books by the Same Author -->
        <div class="mt-5">
            <h5>Books by the Same Author</h5>
            <div id="authorCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    if (!empty($authorBooks)) {
                        // Divide books into groups of 3 for carousel items
                        $chunks = array_chunk($authorBooks, 3); 
                        $isActive = true;
                        
                        foreach ($chunks as $chunk) {
                            echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                            $isActive = false; // Only the first item should be active
                            echo '<div class="row g-3">';
                            foreach ($chunk as $book) {
                                echo '<div class="col-md-4">';
                                echo '<div class="card">';
                                echo '<img src="' . htmlspecialchars($book['img_url']) . '" class="card-img-top" alt="' . htmlspecialchars($book['book_title']) . '" style="width: 150px; height: 150px;">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($book['book_title']) . '</h5>';
                                echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id']) . '" class="btn btn-primary">View Details</a>';
                                echo '</div></div></div>';
                            }
                            echo '</div></div>';
                        }
                    } else {
                        echo '<p class="text-center">No other books by this author.</p>';
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#authorCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#authorCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"></span>
                </button>
            </div>
        </div>

        <!-- Carousel for Books in the Same Genre -->
        <div class="mt-5">
            <h5>Books in the Same Genre</h5>
            <div id="genreCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    if (!empty($genreBooks)) {
                        // Divide books into groups of 3 for carousel items
                        $chunks = array_chunk($genreBooks, 3); 
                        $isActive = true;
                        
                        foreach ($chunks as $chunk) {
                            echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                            $isActive = false; // Only the first item should be active
                            echo '<div class="row g-3">';
                            foreach ($chunk as $book) {
                                echo '<div class="col-md-4">';
                                echo '<div class="card">';
                                echo '<img src="' . htmlspecialchars($book['img_url']) . '" class="card-img-top" alt="' . htmlspecialchars($book['book_title']) . '" style="width: 150px; height: 150px;">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($book['book_title']) . '</h5>';
                                echo '<a href="singlebook.php?id=' . htmlspecialchars($book['book_id']) . '" class="btn btn-primary">View Details</a>';
                                echo '</div></div></div>';
                            }
                            echo '</div></div>';
                        }
                    } else {
                        echo '<p class="text-center">No other books in this genre.</p>';
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#genreCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#genreCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden"></span>
                </button>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-danger">Book not found or an error occurred.</div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>