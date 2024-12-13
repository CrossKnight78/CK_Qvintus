<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}


$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $publisherId = $_POST['publisher_id'];
    $publisherData = [
        'publisher_name' => $_POST['publisher_name']
    ];

    if ($book->updatePublisher($publisherId, $publisherData)) {
        $message = "Publisher updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update publisher.";
        $alertType = "danger";
    }
}
?>

<div class="container mt-5">
    <div class="alert alert-<?= $alertType ?> text-center" role="alert">
        <?= $message ?>
    </div>
    <div class="text-center">
        <a href="book-management.php" class="btn btn-primary">Back to Book Management</a>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>