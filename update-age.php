
<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ageId = $_POST['age_id'];
    $ageData = [
        'age_range' => $_POST['age_range']
    ];

    $book->updateAgeRecommendation($ageId, $ageData);
    header('Location: edit-age.php?id=' . $ageId . '&success=1');
    exit;
}
?>