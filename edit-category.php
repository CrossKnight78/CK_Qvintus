<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$book = new Book($pdo);

$categoryId = $_GET['id'];
$category = $book->getCategoryById($categoryId);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="text-center mb-4">Edit Category</h2>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success" role="alert">
                    Category updated successfully!
                </div>
            <?php endif; ?>
            <form method="post" action="update-category.php">
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
</div>

<?php
include_once 'includes/footer.php';
?>