<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';
include_once 'includes/class.admin.php';

$book = new Book($pdo);
$admin = new Admin($pdo);

// Check if the user is logged in and has the admin role
if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: book-management.php");
        exit();
    }
}

// Check if 'type' and 'id' parameters are set
if (!isset($_GET['type']) || !isset($_GET['id'])) {
    echo "<div class='container'>
            <div class='alert alert-danger text-center' role='alert'>
                Invalid request. Missing parameters.
            </div>
            <div class='text-center'>
                <a href='book-management.php' class='btn btn-primary'>Go to Book Management</a>
            </div>
          </div>";
    exit();
}

$type = $_GET['type'];
$id = $_GET['id'];

if (isset($_POST['delete-submit'])) {
    switch ($type) {
        case 'book':
            $deleteFeedback = $book->deleteBook($id);
            break;
        case 'author':
            $deleteFeedback = $book->deleteAuthor($id);
            break;
        case 'illustrator':
            $deleteFeedback = $book->deleteIllustrator($id);
            break;
        case 'genre':
            $deleteFeedback = $book->deleteGenre($id);
            break;
        case 'series':
            $deleteFeedback = $book->deleteSeries($id);
            break;
        case 'age':
            $deleteFeedback = $book->deleteAgeRecommendation($id);
            break;
        case 'category':
            $deleteFeedback = $book->deleteCategory($id);
            break;
        case 'publisher':
            $deleteFeedback = $book->deletePublisher($id);
            break;
        case 'status':
            $deleteFeedback = $book->deleteStatus($id);
            break;
        case 'user':
            $deleteFeedback = $admin->deleteUser($id);
            break;
        default:
            $deleteFeedback = "Invalid delete type.";
    }
}
?>

<div class="container justify-content-center text-center mt-5 mb-5">
<?php
if (!isset($deleteFeedback)) {
    echo "<h2 class='mb-5'>Are you sure you want to delete this item?</h2>";

    echo "
    <div class='row flex-column justify-content-center'>
        <div class='col-12 col-md-6 col-lg-4 mb-3 mx-auto'>
            <a class='btn btn-warning w-100' href='book-management.php'>No, take me back!</a>
        </div>
        <div class='col-12 col-md-6 col-lg-4 mx-auto'>
            <form action='' method='post'>
                <input type='submit' name='delete-submit' value='Delete' class='btn btn-danger w-100'>
            </form>
        </div>
    </div>";
} else {
    echo "<h2 class='mb-5'>{$deleteFeedback}</h2>"; 

    echo " 
    <div class='row flex-column justify-content-center'>
        <div class='col-12 col-md-6 col-lg-4 mb-3 mx-auto'>
            <a class='btn btn-secondary w-100' href='book-management.php'>Return to Book Management</a>
        </div>
    </div>";
}
?>
</div>

<?php
include_once 'includes/footer.php';
?>