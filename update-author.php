<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authorId = $_POST['author_id'];
    $authorData = [
        'author_name' => $_POST['author_name']
    ];

    $book->updateAuthor($authorId, $authorData);
    header('Location: book-management.php');
}
?>