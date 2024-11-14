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

$menuLinks = array(
    array(
        "title" => "Startsida",
        "url" => "home.php"
	),
	array(
        "title" => "Skapa projekt",
        "url" => "newproject.php"
	),
	array(
        "title" => "Kunder",
        "url" => "customers.php"
	),
	array(
        "title" => "Bilar",
        "url" => "cars.php"
	),
    array(
        "title" => "Startsida",
        "url" => "home.php"
	),
	array(
        "title" => "Kunder",
        "url" => "customers.php"
	),
	array(
        "title" => "Bilar",
        "url" => "cars.php"
	)
);
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
</head>


<body>
<header class="container-fluid bg-dark mb-5 px-0">
	<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-dark px-2 ps-lg-4" data-bs-theme="dark">
	<div class="container-fluid px-2 px-sm-4">
		<a class="navbar-brand" href="home.php">Qvintus</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
		<ul class="navbar-nav">
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
			<li class="nav-item">
			<a class="nav-link" href="home.php">Home</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="books.php">Books</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="exclusive.php">exclusive</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="register.php">Sign Up</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="?logout=1">Log Out</a>
			</li>-->
		</ul>
		</div>
	</div>
	</nav>

</header>