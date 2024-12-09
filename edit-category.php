<?php
include_once 'includes/header.php';
include_once 'includes/class.book.php';

$book = new Book($pdo);

$categoryId = $_GET['id'];
$category = $book->getCategoryById($categoryId);
?>

<div class="container mt-5">
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
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>