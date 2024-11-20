<?php
include_once 'includes/header.php';

$bookClass = new Book($pdo);

if (isset($_GET['id'])) {
    $bookId = intval($_GET['id']);
    $book = $bookClass->selectSingleBook($bookId);
}



?>

<div class="container my-5">
    <?php if (!empty($book)): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($book['img_url']); ?>" class="card-img-top" alt="<?= htmlspecialchars($book['book_title']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($book['book_title']); ?></h5>
                <p class="card-text"><strong>Description:</strong> <?= htmlspecialchars($book['book_desc']); ?></p>
                <p class="card-text"><strong>Language:</strong> <?= htmlspecialchars($book['book_language']); ?></p>
                <p class="card-text"><strong>Release Date:</strong> <?= htmlspecialchars($book['book_release_date']); ?></p>
                <p class="card-text"><strong>Pages:</strong> <?= htmlspecialchars($book['book_pages']); ?></p>
                <p class="card-text"><strong>Price:</strong> $<?= htmlspecialchars($book['books_price']); ?></p>
                <p class="card-text"><strong>Genres:</strong> <?= htmlspecialchars(implode(', ', $book['genres'])); ?></p>
                <p class="card-text"><strong>Authors:</strong> <?= htmlspecialchars(implode(', ', $book['authors'])); ?></p>
                <p class="card-text"><strong>Illustrators:</strong> <?= htmlspecialchars(implode(', ', $book['illustrators'])); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Book not found or an error occurred.</div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>