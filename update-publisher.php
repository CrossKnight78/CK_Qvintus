
<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $publisherId = $_POST['publisher_id'];
    $publisherData = [
        'publisher_name' => $_POST['publisher_name']
    ];

    $book->updatePublisher($publisherId, $publisherData);
    header('Location: edit-publisher.php?id=' . $publisherId . '&success=1');
    exit;
}
?>