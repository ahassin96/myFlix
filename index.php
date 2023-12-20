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
</head>

<body>
    <h1>Welcome <?php echo $_SESSION["username"]; ?></h1>
    <a href="logout.php">Logout</a>

    <?php if (empty($profiles)): ?>
        <p>No profiles found for this user.</p>
    <?php else: ?>
        <h2>Your Profiles:</h2>
        <ul>
            <?php foreach ($profiles as $profile): ?>
                <li>
                    <strong>Profile Name:</strong> <?php echo $profile['ProfileName']; ?><br>
                    
                    <a href="profile.php?ProfileId=<?php echo $profile['ProfileId']; ?>">View Profile</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>