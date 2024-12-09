<?php
include_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statusName = $_POST['statusName'];

    try {
        $stmt = $pdo->prepare("INSERT INTO table_status (s_name) VALUES (:s_name)");
        $stmt->bindParam(':s_name', $statusName);
        $stmt->execute();
        $statusId = $pdo->lastInsertId();

        echo json_encode(['status' => 'success', 'status_id' => $statusId]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
