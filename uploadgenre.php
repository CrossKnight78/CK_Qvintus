<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Directory to upload images
    $target_dir = "uploads/";
    // Create the directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Get the genre name from the POST data
    $genreName = isset($_POST['genre_name']) ? $_POST['genre_name'] : 'genre';
    $genreName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $genreName); // Sanitize the genre name

    // Full path of the uploaded file
    $target_file = $target_dir . basename($_FILES["genre_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate the uploaded image
    if (isset($_FILES["genre_img"]["tmp_name"]) && $_FILES["genre_img"]["tmp_name"] !== '') {
        $check = getimagesize($_FILES["genre_img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $_SESSION['upload_error'] = "File is not an image.";
        }
    } else {
        $uploadOk = 0;
        $_SESSION['upload_error'] = "No file was uploaded.";
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $_SESSION['upload_error'] = "File already exists.";
    }

    // Check file size (5MB max)
    if ($_FILES["genre_img"]["size"] > 5000000) {
        $uploadOk = 0;
        $_SESSION['upload_error'] = "File is too large.";
    }

    // Allow certain file formats
    $allowedFormats = ["jpg", "jpeg", "png", "gif", "webp"];
    if (!in_array($imageFileType, $allowedFormats)) {
        $uploadOk = 0;
        $_SESSION['upload_error'] = "Invalid file format.";
    }

    // Check if everything is ok and upload file
    if ($uploadOk == 0) {
        $_SESSION['upload_error'] = "Sorry, your file was not uploaded.";
    } else {
        // Generate a unique filename to avoid collisions
        $uniqueFileName = $target_dir . uniqid($genreName . "_", true) . '.' . $imageFileType;

        if (move_uploaded_file($_FILES["genre_img"]["tmp_name"], $uniqueFileName)) {
            $_SESSION['uploaded_image'] = $uniqueFileName;
        } else {
            $_SESSION['upload_error'] = "Sorry, there was an error uploading your file.";
        }
    }
}
?>