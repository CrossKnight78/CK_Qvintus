
<?php
include_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $publisherName = $_POST['publisherName'];

    try {
        $stmt = $pdo->prepare("INSERT INTO table_publishers (publisher_name) VALUES (:publisher_name)");
        $stmt->bindParam(':publisher_name', $publisherName);
        $stmt->execute();
        $publisherId = $pdo->lastInsertId();

        echo json_encode(['status' => 'success', 'publisher_id' => $publisherId]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>