<?php
if (isset($_POST["submit-book"])) {
    // Directory to upload images
    $target_dir = "uploads/";
    // Create the directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Full path of the uploaded file
    $target_file = $target_dir . basename($_FILES["book-img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate the uploaded image
    if (isset($_FILES["book-img"]["tmp_name"]) && $_FILES["book-img"]["tmp_name"] !== '') {
        $check = getimagesize($_FILES["book-img"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }
    } else {
        echo "No file was uploaded.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size (5MB max)
    if ($_FILES["book-img"]["size"] > 5000000) {
        echo "Sorry, your file is too large. Maximum allowed size is 5MB.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = ["jpg", "jpeg", "png", "gif", "webp"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only " . implode(", ", $allowedFormats) . " files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if everything is ok and upload file
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
    } else {
        // Generate a unique filename to avoid collisions
        $uniqueFileName = $target_dir . uniqid("book_", true) . '.' . $imageFileType;

        if (move_uploaded_file($_FILES["book-img"]["tmp_name"], $uniqueFileName)) {
            echo "The file " . htmlspecialchars(basename($_FILES["book-img"]["name"])) . " has been uploaded as " . htmlspecialchars($uniqueFileName) . ".<br>";
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
?>
