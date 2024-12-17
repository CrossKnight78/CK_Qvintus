<?php
include_once '../includes/config.php';
include_once '../includes/class.admin.php';
$admin = new Admin($pdo);

if (isset($_GET["q"])) {
    $search = $_GET["q"];
} else {
    $search = " ";
}

// Retrieve checkbox status
$includeInactive = isset($_GET['includeInactive']) && $_GET['includeInactive'] == '1';

$usersArray = $admin->searchUsers($search, $includeInactive);

$admin->populateUserField($usersArray);
?>