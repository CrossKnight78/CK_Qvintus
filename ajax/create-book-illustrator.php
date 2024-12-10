<?php
include_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $illustratorName = $_POST['illustratorName'];

    try {
        $stmt = $pdo->prepare("INSERT INTO table_illustrators (illustrator_name) VALUES (:illustrator_name)");
        $stmt->bindParam(':illustrator_name', $illustratorName);
        $stmt->execute();
        $illustratorId = $pdo->lastInsertId();

        echo json_encode(['status' => 'success', 'illustrator_id' => $illustratorId]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>