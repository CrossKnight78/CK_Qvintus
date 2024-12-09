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

    if ($book->updateStatus($statusId, $statusData)) {
        $message = "Status updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update status.";
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