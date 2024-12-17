<?php
include_once 'includes/functions.php';    
include_once 'includes/header.php';
?>

<div class="container my-5">
    <h2 class="mb-4 text-center">Contact Us</h2>
    <form>
        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3 mb-md-0">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
            </div>
            <div class="col-12 col-md-6">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="phone" placeholder="Phone Number" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email Address" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" rows="4" placeholder="Your Message" required></textarea>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
    <div class="d-grid mt-3">
        <a href="review.php" class="btn btn-secondary">Leave a Review</a>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>