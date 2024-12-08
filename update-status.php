<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statusId = $_POST['status_id'];
    $statusData = [
        's_name' => $_POST['status_name']
    ];

    $book->updateStatus($statusId, $statusData);
    header('Location: edit-status.php?id=' . $statusId . '&success=1');
    exit;
} else {
    echo "<div class='container'>
            <div class='alert alert-danger text-center' role='alert'>
                Inte giltig förfrågan.
            </div>
        </div>";
}
?>