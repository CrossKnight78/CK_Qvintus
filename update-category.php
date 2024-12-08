
<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['category_id'];
    $categoryData = [
        'category_name' => $_POST['category_name']
    ];

    $book->updateCategory($categoryId, $categoryData);
    header('Location: edit-category.php?id=' . $categoryId . '&success=1');
    exit;
}
?>