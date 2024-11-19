<?php
include_once 'functions.php';

class User {

    private $username;
    private $role;
    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;


    function __construct($pdo) {
        $this->role = 4;
        $this->username = "RandomGuest123";
        $this->pdo = $pdo;
    }

    public function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function checkUserRegisterInput(string $uuser, string $umail, string $upass, string $upassrepeat, int $uid = null) {
        // START Check if user-entered username or email exists in the database
        if (isset($_POST['register-submit'])) {
            $this->errorState = 0;
            $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_user = :uuser OR u_email = :email');
            $stmt_checkUsername->bindParam(':uuser', $uuser, PDO::PARAM_STR);
            $stmt_checkUsername->bindParam(':email', $umail, PDO::PARAM_STR);
            $stmt_checkUsername->execute();
    
            // Check if query returns any result
            if ($stmt_checkUsername->rowCount() > 0) {
                array_push($this->errorMessages, "Användarnamn eller e-postadress är upptagen!");
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
                array_push($this->errorMessages, "E-postadressen är upptagen!");
                $this->errorState = 1;
            }
        }
        // END Check if user-entered username or email exists in the database
        
        // START Conditionally check passwords if they are provided
        if (isset($_POST['register-submit']) || (!empty($upass) || !empty($upassrepeat))) {
            // Check if passwords match
            if ($upass !== $upassrepeat) {
                array_push($this->errorMessages, "Angivna lösenorden matchar inte!");
                $this->errorState = 1;
            } else {
                // Check if password length is at least 8 characters
                if (strlen($upass) < 8) {
                    array_push($this->errorMessages, "Angivna lösenordet är för kort!");
                    $this->errorState = 1;
                }
            }
        }
        // END Conditionally check passwords if they are provided
    
        // START Check if user-entered email is a proper email address
        if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorMessages, "E-postadressen är inte i rätt format!");
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
            $stmt_insertNewUser = $this->pdo->prepare('INSERT INTO table_users (u_user, u_pass, u_email, u_role_fk, u_status, u_fname, u_lname) 
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
            array_push($this->errorMessages, "Lyckades inte registrera användaren! Kontakta support!");
            return $this->errorMessages;
        }

    }

    public function login(string $unamemail, string $upass) {
        
        $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_user = :uname OR u_email = :email');
        $stmt_checkUsername->bindParam(':uname', $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->bindParam(':email', $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->execute();

        // Check if query returns a result
        if($stmt_checkUsername->rowCount() === 0) {
            array_push($this->errorMessages, "Användarnamnet eller e-postadressen finns inte! ");
            return $this->errorMessages;
            
        }
        // Save user data to an array
        $userData = $stmt_checkUsername->fetch();

        // Check if password is correct
        if(password_verify($upass, $userData['u_pass'])) {

            // Check if user account is deactivated
            if ($userData['u_status'] === 0) {
                array_push($this->errorMessages, "Detta konto har inaktiverats! Kontakta administratören och be om hjälp ");
                return $this->errorMessages;
            }

            $_SESSION['user_id'] = $userData['u_id'];
            $_SESSION['user_name'] = $userData['u_name'];
            $_SESSION['user_email'] = $userData['u_email'];
            $_SESSION['user_role'] = $userData['u_role_fk'];

            header("Location: books.php");
            exit();
        } else {
            array_push($this->errorMessages, "Lösenordet är fel! ");
            return $this->errorMessages;
        }
    }

    public function checkLoginStatus() {
        if(isset($_SESSION['user_id'])) {
            return TRUE;
        } else {
            header("Location: index.php");  
            exit();
        }
    }



    public function checkUserRole(int $requiredValue) {
        
        $stmt_checkUserRole = $this->pdo->prepare(
            'SELECT r_level FROM table_roles WHERE r_id = :rid');
        $stmt_checkUserRole->bindParam(':rid', $_SESSION['user_role'], PDO::PARAM_INT);
        $stmt_checkUserRole->execute();

        $userRoleData = $stmt_checkUserRole->fetch();

        if ($userRoleData['r_level'] >= $requiredValue) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    public function deleteUser(int $uid) {
        $stmt_deleteUser = $this->pdo->prepare('DELETE FROM table_users WHERE u_id = :uid');
        $stmt_deleteUser->bindParam(':uid', $uid, PDO::PARAM_INT);

        if($stmt_deleteUser->execute()) {
            return "Användaren har raderats";
        } else {
            return "Något gick snett ... Försök igen.";
        }
    }
}

?>