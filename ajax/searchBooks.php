<?php
include_once '../includes/config.php';
include_once '../includes/class.book.php';

header('Content-Type: application/json');

// Initialize the variables
$query = isset($_GET['q']) ? trim($_GET['q']) : '';  // Set query from GET parameter or default to empty string
$results = [];  // Initialize results as an empty array

if ($query !== '') {
    // Perform the search if query is not empty
    try {
        $book = new Book($pdo);
        $results = $book->searchBooks($query);  // Call searchBooks to fetch the results

        // If no results, return a specific message
        if (empty($results)) {
            echo json_encode(["message" => "No results found"]);
        } else {
            echo json_encode($results);  // Return the actual results
        }
    } catch (PDOException $e) {
        // Handle error and log it
        error_log("Error: " . $e->getMessage());

        // Return error message as JSON
        echo json_encode(["error" => "An error occurred while processing your request."]);
    }
} else {
    // Return an error if the query is empty
    echo json_encode(["error" => "No search query provided"]);
}
?>
