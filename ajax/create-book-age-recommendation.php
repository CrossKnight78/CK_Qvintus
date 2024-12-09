<?php
include_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ageRecommendationName = $_POST['ageRecommendationName'];

    try {
        $stmt = $pdo->prepare("INSERT INTO table_age (age_range) VALUES (:age_range)");
        $stmt->bindParam(':age_range', $ageRecommendationName);
        $stmt->execute();
        $ageRecommendationId = $pdo->lastInsertId();

        echo json_encode(['status' => 'success', 'age_recommendation_id' => $ageRecommendationId]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
