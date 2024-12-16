<?php
include_once 'includes/functions.php';    
include_once 'includes/header.php';
?>

<div class="container my-5">
    <h2 class="mb-4">Leave a Review</h2>
    <form>
        <div class="mb-3">
            <label for="reviewTitle" class="form-label">Review Title</label>
            <input type="text" class="form-control" id="reviewTitle" placeholder="Review Title" required>
        </div>
        <div class="mb-3">
            <label for="reviewDesc" class="form-label">Review Description</label>
            <textarea class="form-control" id="reviewDesc" rows="4" placeholder="Review Description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <select class="form-control" id="rating" required>
                <option value="" disabled selected>Select your rating</option>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</div>

<?php
include_once 'includes/footer.php';
?>