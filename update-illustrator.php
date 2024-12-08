<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $illustratorId = $_POST['illustrator_id'];
    $illustratorData = [
        'illustrator_name' => $_POST['illustrator_name']
    ];

    $book->updateIllustrator($illustratorId, $illustratorData);
    header('Location: book-management.php');
}
?>