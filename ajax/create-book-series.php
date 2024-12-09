
<?php
include_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seriesName = $_POST['seriesName'];

    try {
        $stmt = $pdo->prepare("INSERT INTO table_series (serie_name) VALUES (:serie_name)");
        $stmt->bindParam(':serie_name', $seriesName);
        $stmt->execute();
        $seriesId = $pdo->lastInsertId();

        echo json_encode(['status' => 'success', 'series_id' => $seriesId]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>