<?php
include_once 'functions.php';

class Admin {

    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;

    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    public function checkUserRegisterInput(string $uuser, string $umail, string $upass, string $upassrepeat, int $uid = null) {
        // START Check if user-entered username or email exists in the database
        if (isset($_POST['register-submit'])) {
            $this->errorState = 0;
            $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uuser OR u_email = :email');
            $stmt_checkUsername->bindParam(':uuser', $uuser, PDO::PARAM_STR);
            $stmt_checkUsername->bindParam(':email', $umail, PDO::PARAM_STR);
            $stmt_checkUsername->execute();
    
            // Check if query returns any result
            if ($stmt_checkUsername->rowCount() > 0) {
                array_push($this->errorMessages, "Username or email address is already taken!");
                $this->errorState = 1;
            }
        } else {
            // Only check for email if user ID is not provided or the email has changed
            if ($uid !== null) {
                $stmt_checkUserEmail = $this->pdo->prepare('SELECT * FROM table_users WHERE u_email = :email AND u_id != :uid');
                $stmt_checkUserEmail->bindParam(':email', $umail, PDO::PARAM_STR);
                $stmt_checkUserEmail->bindParam(':uid', $uid, PDO::PARAM_INT);
                $stmt_checkUserEmail->execute();
            } else {
                $stmt_checkUserEmail = $this->pdo->prepare('SELECT * FROM table_users WHERE u_email = :email');
                $stmt_checkUserEmail->bindParam(':email', $umail, PDO::PARAM_STR);
                $stmt_checkUserEmail->execute();
            }
    
            // Check if query returns any result
            if ($stmt_checkUserEmail->rowCount() > 0) {
                array_push($this->errorMessages, "Email address is already taken!");
                $this->errorState = 1;
            }
        }
        // END Check if user-entered username or email exists in the database
    
        // START Conditionally check passwords if they are provided
        if (isset($_POST['register-submit']) || (!empty($upass) || !empty($upassrepeat))) {
            // Check if passwords match
            if ($upass !== $upassrepeat) {
                array_push($this->errorMessages, "Passwords do not match!");
                $this->errorState = 1;
            } else {
                // Check if password length is at least 8 characters
                if (strlen($upass) < 8) {
                    array_push($this->errorMessages, "Password is too short!");
                    $this->errorState = 1;
                }
            }
        }
        // END Conditionally check passwords if they are provided
    
        // START Check if user-entered email is a proper email address
        if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorMessages, "Email address is not in the correct format!");
            $this->errorState = 1;
        }
        // END Check if user-entered email is a proper email address
    
        if ($this->errorState == 1) {
            return $this->errorMessages;
        } else {
            return 1;    
        }
    }

    public function register(string $uuser, string $umail, string $upass, string $fname, string $lname) {
        // Hash password and clean inputs
        $hashedPassword = password_hash($upass, PASSWORD_DEFAULT);
        $uname = $this->cleanInput($uuser);
        $fname = $this->cleanInput($fname);
        $lname = $this->cleanInput($lname);

        if(password_verify($upass, $hashedPassword)) {
            $stmt_insertNewUser = $this->pdo->prepare('INSERT INTO table_users (u_name, u_pass, u_email, u_role_fk, u_status, u_fname, u_lname) 
            VALUES 
            (:user, :upass, :umail, 1, 1, :fname, :lname)');
            $stmt_insertNewUser->bindParam(':user', $uuser, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':upass', $hashedPassword, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':umail', $umail, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':lname', $lname, PDO::PARAM_STR);
        }
        
        if($stmt_insertNewUser->execute()) {
            return 1;
        } else {
            array_push($this->errorMessages, "Failed to register the user! Contact support!");
            return $this->errorMessages;
        }
    }

    public function editUserInfo(string $umail, string $upassold, string $upassnew, int $uid, int $role, string $ufname, string $ulname, int $status) {
        // Clean and validate first name
        $cleanedFname = $this->cleanInput($ufname);
        if (empty($cleanedFname) || !preg_match("/^[a-zA-Z\s]+$/", $cleanedFname)) {
            array_push($this->errorMessages, "First name cannot be empty and must contain only letters!");
            return $this->errorMessages;
        }
    
        // Clean and validate last name
        $cleanedLname = $this->cleanInput($ulname);
        if (empty($cleanedLname) || !preg_match("/^[a-zA-Z\s]+$/", $cleanedLname)) {
            array_push($this->errorMessages, "Last name cannot be empty and must contain only letters!");
            return $this->errorMessages;
        }
    
        // Get password and current email of the user
        $stmt_getUserDetails = $this->pdo->prepare('SELECT u_password, u_email FROM table_users WHERE u_id = :uid');
        $stmt_getUserDetails->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt_getUserDetails->execute();
        $userDetails = $stmt_getUserDetails->fetch();
        
        // If user edits their own data (legacy)
        if (isset($_POST['edit-user-submit'])) {
            // Check if entered password is correct
            if (!password_verify($upassold, $userDetails['u_password'])) {
                array_push($this->errorMessages, "Password is not valid!");
                return $this->errorMessages;    
            }
        }
    
        // Update fields
        $hashedPassword = password_hash($upassnew, PASSWORD_DEFAULT);
        
        // Update password if new password field isn't empty
        if (!empty($upassnew)) {
            $updatePassword = "u_password = :upassnew, ";
        } else {
            $updatePassword = "";
        }
        // Only set u_email if it has changed
        $updateEmail = $umail !== $userDetails['u_email'] ? ", u_email = :umail" : "";
    
        // Update in the database 
        $stmt_editUserInfo = $this->pdo->prepare("
            UPDATE table_users
            SET $updatePassword u_role_fk = :role, u_status = :status, u_fname = :ufname, u_lname = :ulname 
            $updateEmail
            WHERE u_id = :uid
        ");
        
        // Bind parameters
        if (!empty($upassnew)) {
            $stmt_editUserInfo->bindParam(':upassnew', $hashedPassword, PDO::PARAM_STR);
        }

        if ($updateEmail) {
            $stmt_editUserInfo->bindParam(':umail', $umail, PDO::PARAM_STR);
        }
        
        $stmt_editUserInfo->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt_editUserInfo->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt_editUserInfo->bindParam(':ufname', $cleanedFname, PDO::PARAM_STR); // Use cleaned name
        $stmt_editUserInfo->bindParam(':ulname', $cleanedLname, PDO::PARAM_STR); // Use cleaned name
        $stmt_editUserInfo->bindParam(':uid', $uid, PDO::PARAM_INT);
        
        // Execute the statement
        if ($stmt_editUserInfo->execute() && $uid == $_SESSION['user_id']) {
            $_SESSION['user_email'] = $umail; // Update session email if changed
        }

        if ($this->errorState == 1) {
            return $this->errorMessages;
        } else {
            return 1;    
        }
    }

    public function searchUsers(string $input, int $includeInactive) {
        $input = $this->cleanInput($input);

        // Replace all whitespace characters with % wildcards
        $input = preg_replace('/\s+/', '%', $input);

        $inputJoker = "%".$input."%";

        // Start building the query
        $searchQuery = 'SELECT * FROM table_users WHERE (u_id LIKE :uid OR u_name LIKE :uname OR u_email LIKE :email OR u_fname LIKE :fname OR u_lname LIKE :lname OR CONCAT(u_fname, u_lname) LIKE :fullname)';

         // Conditionally add status filter
        if (!$includeInactive) {
            $searchQuery .= ' AND u_status = 1';
        }

        // Add ORDER BY clause to sort by u_fname, then u_lname
        $searchQuery .= ' ORDER BY u_fname ASC, u_lname ASC';

        $stmt_searchUsers = $this->pdo->prepare($searchQuery);
        $stmt_searchUsers->bindParam(':uid', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':uname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':email', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':fname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':lname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':fullname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->execute();
        $usersList = $stmt_searchUsers->fetchAll(PDO::FETCH_ASSOC);
        
        return $usersList;
    }

    public function populateUserField(array $usersArray) {
        foreach ($usersArray as $user) {
            echo "
            <tr " . ($user['u_status'] === 0 ? "class='table-danger'" : "") . " onclick=\"window.location.href='admin-account.php?uid=" . htmlspecialchars($user['u_id'], ENT_QUOTES, 'UTF-8') . "';\" style=\"cursor: pointer;\">
                <td>" . htmlspecialchars($user['u_fname'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($user['u_lname'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($user['u_name'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($user['u_email'], ENT_QUOTES, 'UTF-8') . "</td>
                <td>" . htmlspecialchars($user['u_id'], ENT_QUOTES, 'UTF-8') . "</td>
            </tr>";
        }
    }

    public function getUserInfo(int $uid) {
        $stmt_selectUserData = $this->pdo->prepare('SELECT * FROM table_users WHERE u_id = :uid');
        $stmt_selectUserData->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt_selectUserData->execute();
        $userInfo = $stmt_selectUserData->fetch(PDO::FETCH_ASSOC);
        return $userInfo;
    }

    public function deleteUser(int $uid) {
        $stmt_deleteUser = $this->pdo->prepare('DELETE FROM table_users WHERE u_id = :uid');
        $stmt_deleteUser->bindParam(':uid', $uid, PDO::PARAM_INT);

        if($stmt_deleteUser->execute()) {
            return "User has been deleted";
        } else {
            return "Something went wrong... Please try again.";
        }
    }

}
?>