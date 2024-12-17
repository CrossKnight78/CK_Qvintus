<?php
include_once 'includes/header.php';

if (isset($_POST['user-login'])) {
    $errorMessages = $user->login($_POST['uname'], $_POST['upass']);
}
?>

<div class="container mt-5">
    <?php
    if (isset($_GET['newuser'])) {
        echo "<div class='alert alert-success text-center' role='alert'>
            You have successfully signed up. Please login using the form below.
        </div>";
    }

    if (isset($errorMessages)) {
        echo "<div class='alert alert-danger text-center' role='alert'>";
        foreach ($errorMessages as $message) {
            echo $message;
        }
        echo "</div>";
    }
    ?>

    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <h1 class="text-center my-5">Login</h1>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label" for="uname">Username or Email</label>
                    <input class="form-control" type="text" name="uname" id="uname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="upass">Password</label>
                    <input class="form-control" type="password" name="upass" id="upass" required>
                </div>
                <div class="d-grid">
                    <input class="btn btn-primary py-2" type="submit" name="user-login" value="Login">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>