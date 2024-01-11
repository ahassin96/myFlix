<?php
session_start();
require 'vendor/autoload.php';
require_once 'connect.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    
    $conn = new DbConnect();
    $pdo = $conn->connect();

    
    $stmt = $pdo->prepare("INSERT INTO watch_history (user_id, video_id, profile) VALUES (:userId, :videoId, :userProfile)");

    $userId = $_GET['userId'];
    $videoId = $_GET['videoId'];
    $userProfile = $_GET['userProfile'];

    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':videoId', $videoId);
    $stmt->bindParam(':userProfile', $userProfile);

    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error logging watch: ' . $e->getMessage()]);
}

?>
