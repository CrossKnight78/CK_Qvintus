<?php
include_once 'includes/functions.php';    
include_once 'includes/header.php';
$bookClass = new Book($pdo);
?>

<div class="container my-5">
    <h1 class="mb-4 text-center">Books</h1>
    <div>
        <?php $bookClass->displayAllBooks(); ?>
    </div>
</div>


<?php
include_once 'includes/footer.php';
?>
