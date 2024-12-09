
<?php
include_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName'];

    try {
        $stmt = $pdo->prepare("INSERT INTO table_category (category_name) VALUES (:category_name)");
        $stmt->bindParam(':category_name', $categoryName);
        $stmt->execute();
        $categoryId = $pdo->lastInsertId();

        echo json_encode(['status' => 'success', 'category_id' => $categoryId]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>