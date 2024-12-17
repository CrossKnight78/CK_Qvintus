<?php    
include_once 'includes/header.php';
include_once 'includes/class.admin.php';

$admin = new Admin($pdo);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: index.php");
    }
}

if(isset($_POST['register-submit'])) {
    $feedbackMessages = $admin->checkUserRegisterInput(
        $admin->cleanInput($_POST['uname']), 
        $admin->cleanInput($_POST['umail']), 
        $admin->cleanInput($_POST['upass']), 
        $admin->cleanInput($_POST['upassrepeat'])
    );

    if($feedbackMessages === 1) {
        $signUpFeedback = $admin->register(
            $admin->cleanInput($_POST['uname']), 
            $admin->cleanInput($_POST['umail']), 
            $admin->cleanInput($_POST['upass']), 
            $admin->cleanInput($_POST['ufname']), 
            $admin->cleanInput($_POST['ulname'])
        );
        if($signUpFeedback === 1) {
            echo "<div class='container'>
                    <div class='alert alert-success text-center' role='alert'>
                        User has been created.
                    </div>
                    <div class='text-center'>
                        <a href='admin-workerlist.php' class='btn btn-primary'>Go to worker list</a>
                    </div>
                </div>";
        }

    } else {
        echo "<div class='container'>";
        foreach($feedbackMessages as $message) {
            echo "<div class='alert alert-danger text-center' role='alert'>";
            echo    $message;
            echo "</div>";
        }
        echo "<div class='text-center'>
                <a href='admin-workerlist.php' class='btn btn-primary'>Go to worker list</a>
            </div>";
        echo "</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h1 class="text-center mb-4">Create New User</h1>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label" for="uname">Username</label>
                    <input class="form-control" type="text" name="uname" id="uname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="umail">Email</label>
                    <input class="form-control" type="email" name="umail" id="umail" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="upass">Password</label>
                    <input class="form-control" type="password" name="upass" id="upass" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="upassrepeat">Repeat Password</label>
                    <input class="form-control" type="password" name="upassrepeat" id="upassrepeat" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="ufname">First Name</label>
                    <input class="form-control" type="text" name="ufname" id="ufname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="ulname">Last Name</label>
                    <input class="form-control" type="text" name="ulname" id="ulname" required>
                </div>
                <div class="d-grid">
                    <input class="btn btn-primary py-2" type="submit" name="register-submit" value="Create New User">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>