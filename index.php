<?php
session_start();
require_once "connect.php";
$conn = new DbConnect();
$pdo = $conn->connect();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
$userId = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT * FROM UserProfiles WHERE UserId = :UserId");
$stmt->bindParam(':UserId', $userId, PDO::PARAM_INT);
$stmt->execute();
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Your Profiles</title>
    <link rel="stylesheet" href="css/mystyle.css">
</head>

<body>
    <h1>Welcome <?php echo $_SESSION["username"]; ?></h1>
    <a href="logout.php">Logout</a>

    <?php foreach ($genres as $genre): ?>
        <?php
            
            $videos = $database->videos->find(['genre' => $genre]);
        ?>
        <div class="video-container" id="<?php echo $genre; ?>-container">
            <h2><?php echo ucfirst($genre); ?></h2>

            <?php foreach ($videos as $video): ?>
                <div class="video">
                    <video controls>
                        <source src="<?php echo $video['url']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p><?php echo $video['title']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</body>

</html>