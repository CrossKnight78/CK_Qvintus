<?php
include_once 'includes/header.php';
include_once 'includes/class.admin.php';

$admin = new Admin($pdo);

// Check if the user is logged in and has admin role
if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: index.php");
        exit();
    }
}

// Get user information and roles
$userInfoArray = $admin->getUserInfo($_GET['uid']);
$roleArray = $pdo->query("SELECT * FROM table_roles")->fetchAll();

// Handle form submission for editing user information
if (isset($_POST['admin-edit-user-submit'])) {
    $uStatus = isset($_POST['is-disabled']) ? 0 : 1;
    $feedback = $admin->checkUserRegisterInput(
        $admin->cleanInput($_POST['uname']), 
        $admin->cleanInput($_POST['umail']), 
        $admin->cleanInput($_POST['upassnew']), 
        $admin->cleanInput($_POST['upassrepeat']), 
        $admin->cleanInput($_GET['uid']) // Pass the user ID here
    );

    if ($feedback === 1) {
        $editFeedback = $admin->editUserInfo(
            $admin->cleanInput($_POST['umail']), 
            $admin->cleanInput($_POST['upassold']), 
            $admin->cleanInput($_POST['upassnew']), 
            $admin->cleanInput($_GET['uid']), 
            $admin->cleanInput($_POST['urole']), 
            $admin->cleanInput($_POST['ufname']), 
            $admin->cleanInput($_POST['ulname']), 
            $admin->cleanInput($uStatus)
        );
        if ($editFeedback === 1) {
            echo "<div class='container'>
                    <div class='alert alert-success text-center' role='alert'>
                        User information has been updated
                    </div>
                </div>";
        } else {
            foreach ($editFeedback as $message) {
                echo "<div class='container'>
                        <div class='alert alert-danger text-center' role='alert'>
                            {$message}
                        </div>
                    </div>";
            }
        }
    } else {
        foreach ($feedback as $message) {
            echo "<div class='container'>
                    <div class='alert alert-danger text-center' role='alert'>
                        {$message}
                    </div>
                </div>";
        }
    }
}

?>

<div class="container min-vh-100">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <h1 class="mb-3 text-center">Edit User</h1>

            <form action="" method="post" class="border p-4 rounded shadow-sm">

                <div class="mb-3">
                    <label for="ufname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="ufname" id="ufname" value="<?php echo htmlspecialchars($userInfoArray['u_fname'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            
                <div class="mb-3">
                    <label for="ulname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="ulname" id="ulname" value="<?php echo htmlspecialchars($userInfoArray['u_lname'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>    

                <div class="mb-3">
                    <label for="uname" class="form-label">Username</label>
                    <input type="text" class="form-control" name="uname" id="uname" value="<?php echo htmlspecialchars($userInfoArray['u_name'], ENT_QUOTES, 'UTF-8'); ?>" readonly required>
                </div>

                <div class="mb-3">
                    <label for="umail" class="form-label">Email</label>
                    <input type="email" class="form-control" name="umail" id="umail" value="<?php echo htmlspecialchars($userInfoArray['u_email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <input type="hidden" name="upassold" id="upassold" value="asdfs123" readonly required>

                <div class="mb-2">
                    <label for="upassnew" class="form-label">New Password</label>
                    <input type="password" class="form-control" name="upassnew" id="upassnew">
                </div>

                <div class="mb-2">
                    <label for="upassrepeat" class="form-label">Repeat New Password</label>
                    <input type="password" class="form-control" name="upassrepeat" id="upassrepeat">
                </div>

                <div class="mb-2">
                    <label for="role" class="form-label">User Role</label>
                    <select class="form-select" name="urole" id="role">
                        <?php
                            foreach ($roleArray as $role) {
                                $selected = $role['r_id'] === $userInfoArray['u_role_fk'] ? "selected" : "";
                                echo "<option {$selected} value='{$role['r_id']}'>{$role['r_name']}</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="is-disabled" name="is-disabled" value="1" <?php if($userInfoArray['u_status'] === 0){echo "checked";} ?>>
                    <label class="form-check-label" for="is-disabled">Disable Account</label>
                </div>

                <div class="d-grid">
                    <input type="submit" class="btn btn-primary mt-2 me-auto" name="admin-edit-user-submit" value="Update">
                </div>
                
            </form>

            <div class="text-center mt-3">
                <a class="btn btn-danger my-3 p-2" href="confirm-delete.php?type=user&id=<?php echo htmlspecialchars($_GET['uid'], ENT_QUOTES, 'UTF-8'); ?>">Delete this user</a>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>