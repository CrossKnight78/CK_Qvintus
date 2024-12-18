<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $categoryId = $_POST['category_id'];
    $categoryData = [
        'category_name' => $_POST['category_name']
    ];

    if ($book->updateCategory($categoryId, $categoryData)) {
        $message = "Category updated successfully!";
        $alertType = "success";
    } else {
        $message = "Failed to update category.";
        $alertType = "danger";
    }
} else {
    // Display form
    $categoryId = $_GET['id'];
    $category = $book->getCategoryById($categoryId);

    if (!$category) {
        echo '<div class="alert alert-danger">Category not found.</div>';
        include_once 'includes/footer.php';
        exit;
    }
}
?>

<div class="container mt-5 mb-5">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-<?= $alertType ?> text-center" role="alert">
            <?= $message ?>
        </div>
        <div class="text-center">
            <a href="book-management.php" class="btn btn-primary">Back to Book Management</a>
        </div>
    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h2 class="text-center mb-4">Edit Category</h2>
                <form method="post" action="">
                    <input type="hidden" name="category_id" value="<?= htmlspecialchars($category['category_id']) ?>">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?= htmlspecialchars($category['category_name']) ?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include_once 'includes/footer.php';
?>