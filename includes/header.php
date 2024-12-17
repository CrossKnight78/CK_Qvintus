<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/class.user.php';
require_once 'includes/class.admin.php';
require_once 'includes/class.book.php';
$user = new User($pdo);

if(isset($_GET['logout'])) {
    $user->logout();
}

$adminMenuLinks = array(
    array(
        "title" => "Admin",
        "url" => "admin.php"
    ),
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Qvintus</title>
    <link rel="stylesheet" href="css/style.css">
    <!--<script defer src="js/script.js"></script>-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.ico" type="image/ico">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<div class="wrapper d-flex flex-column min-vh-100">
<header class="container-fluid mb-5 px-0 fixed-top" style="background-color: saddlebrown;">
    <nav class="navbar navbar-expand-lg navbar-dark px-2 ps-lg-4" data-bs-theme="dark">
    <div class="container-fluid px-2 px-sm-4">
        <a class="navbar-brand" href="index.php">Qvintus</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="books.php">Books</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="exclusive.php">Exclusive</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li>
            <a class="nav-link" href="review.php">Leave a Review</a> 
            </li>
            <li class="nav-item">
            <a class="nav-link" href="company.php">Company</a>
            </li>
            <?php
            // Only show "Worker Login" if the user is not logged in
            if (!isset($_SESSION['user_id'])) {
                echo '<li class="nav-item">
                        <a class="nav-link" href="login.php">Worker Login</a>
                    </li>';
            }

            // Check if user is logged in
            if (isset($_SESSION['user_id'])) {
                // Check if user has the admin role
                if ($user->checkUserRole(200)) {
                    foreach ($adminMenuLinks as $menuItem) {
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
                        </li>";
                    }
                } else {
                    // Check if user has role level 1 (worker) or 50 (store manager)
                    if ($user->checkUserRole(1) || $user->checkUserRole(50)) {
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='book-management.php'>Book Management</a>
                        </li>";
                    }
                }

                echo "
                <li class='nav-item'>
                    <a class='nav-link' href='?logout=1.php'>Logga ut</a>
                </li>";
            }
            ?>
        </ul>
        </div>
    </div>
    </nav>
</header>
