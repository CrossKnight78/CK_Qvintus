
<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seriesId = $_POST['series_id'];
    $seriesData = [
        'serie_name' => $_POST['series_name']
    ];

    $book->updateSeries($seriesId, $seriesData);
    header('Location: edit-series.php?id=' . $seriesId . '&success=1');
    exit;
}
?>