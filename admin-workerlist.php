<?php
include_once 'includes/header.php';
include_once 'includes/class.admin.php';

$admin = new Admin($pdo);

// Check if the user is logged in
if (!$user->checkLoginStatus()) {
    header("Location: login.php");
    exit();
}

// Check if the user has the admin role
if (!$user->checkUserRole(200)) {
    header("Location: home.php");
    exit();
}

if (isset($_POST['search-users-submit']) && !empty($_POST['search'])) {
    $usersArray = $admin->searchUsers($_POST['search'], isset($_POST['include-inactive']) ? 1 : 0);
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-6">
            <h1 class="my-4 text-center">Administrator</h1>

            <a class="btn btn-primary mb-3 w-35" href="createuser.php">Create New User</a>

            <div class="card rounded-4 text-start shadow-sm p-4 mb-4">
                <div class="mb-3">
                    <label for="search" class="form-label">Search Users (ID, name, username, or email)</label>
                    <input class="form-control mb-2" type="text" name="search" id="search" onkeyup="searchUsers(this.value)">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="include-inactive" name="include-inactive" onchange="searchUsers(document.getElementById('search').value)">
                        <label class="form-check-label" for="include-inactive">
                            Include Inactive Users
                        </label>
                    </div>
                </div>

                <p class="mt-3 mb-2 fst-italic">Click on any user to edit their details.</p>
                <div class="table-responsive">
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>Name</th>
                                <th scope='col'>Username</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>User ID</th>
                            </tr>
                        </thead>
                        <tbody id="user-field">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Code to run when the DOM is ready
        searchUsers();
    });

    function searchUsers(str) {
        if (str === undefined || str === null || str.length === 0) {
            str = " ";
        }

        // Get the checkbox status
        var includeInactive = document.getElementById("include-inactive").checked ? 1 : 0;
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("user-field").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "ajax/search_users.php?q=" + encodeURIComponent(str) + "&includeInactive=" + includeInactive, true);
        xmlhttp.send();
    }
</script>

<?php
include_once 'includes/footer.php';
?>