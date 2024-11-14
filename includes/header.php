<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/class.user.php';
require_once 'includes/class.admin.php';
require_once 'includes/class.book.php';
require_once 'includes/class.utility.php';
require_once 'includes/config.php';
$user = new User($pdo);


if(isset($_GET['logout'])) {
	$user->logout();
}

$adminMenuLinks = array(
    array(
        "title" => "Administratör",
        "url" => "admin.php"
	),
);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Qvintus</title>
	<link rel="stylesheet" href="css/style.css">
	<!--<script defer src="js/script.js"></script>-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link rel="icon" href="assets/favicon.ico" type="image/ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>


<body>
<div class="wrapper d-flex flex-column min-vh-100">
<header class="container-fluid bg-dark mb-5 px-0">
	<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-dark px-2 ps-lg-4" data-bs-theme="dark">
	<div class="container-fluid px-2 px-sm-4">
		<a class="navbar-brand" href="index.php">Qvintus</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item">
			<a class="nav-link" href="index.php">Home</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="books.php">Books</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="exclusive.php">Exclusive</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="contact.php">Contact</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="company.php">Company</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="login.php">Worker Login</a>
			</li>
			<?php
			if(isset($_SESSION['user_id'])) {
				if ($user->checkUserRole(200)) {
					foreach ($adminMenuLinks as $menuItem) {
						echo "<li class='nav-item'>
						<a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
						</li>";
					}
				}
				echo "
				<li class='nav-item'>
					<a class='nav-link' href='?logout=1.php'>Logga ut</a>
				</li>";
			}
			?>
		</ul>
		</div>
	</div>
	</nav>

</header>