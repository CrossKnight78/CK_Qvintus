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
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    public function login(string $unamemail, string $upass) {
        // Sanitize inputs
        $unamemail = $this->cleanInput($unamemail);
        $upass = $this->cleanInput($upass);
        
        // Query to check if the username or email exists in the database
        $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uname OR u_email = :email');
        $stmt_checkUsername->bindParam(':uname', $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->bindParam(':email', $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->execute();
    
        // Check if query returns a result
        if ($stmt_checkUsername->rowCount() === 0) {
            array_push($this->errorMessages, "Username or email address does not exist!");
            return $this->errorMessages;
        }
    
        // Save user data to an array
        $userData = $stmt_checkUsername->fetch();
    
        // Check if the provided password matches the hashed password in the database
        if (password_verify($upass, $userData['u_pass'])) {
            // Check if the account is active
            if ((int)$userData['u_status'] === 0) {
                array_push($this->errorMessages, "This account has been deactivated! Contact the administrator for help.");
                return $this->errorMessages;
            }
    
            // Set session variables
            $_SESSION['user_id'] = $userData['u_id'];
            $_SESSION['user_name'] = $userData['u_name'];
            $_SESSION['user_email'] = $userData['u_email'];
            $_SESSION['user_role'] = $userData['u_role_fk']; // Ensure this is set correctly
    
            // Regenerate session ID for security
            session_regenerate_id(true);
    
            // Redirect to the desired page
            header("Location: books.php");
            exit();
        } else {
            array_push($this->errorMessages, "Password is incorrect!");
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
}
?>