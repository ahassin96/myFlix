<?php
session_start();
require_once "connect.php";
$conn = new DbConnect();
$pdo = $conn->connect();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit(); 
}

$userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

$stmt = $pdo->prepare("SELECT * FROM UserProfiles WHERE UserId = :UserId");
$stmt->bindParam(':UserId', $userId, PDO::PARAM_INT);
$stmt->execute();
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['selectedProfile'])) {
    $_SESSION['userProfile'] = $_GET['selectedProfile'];
    var_dump($_SESSION['userProfile']);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Your profile</title>
    <link rel="stylesheet" href="css/mystyle.css">
</head>

<body>
    <h1>Welcome <?php echo htmlspecialchars($_SESSION["username"]); ?></h1>
    <a href="logout.php">Logout</a>

    <?php if (empty($profiles)): ?>
        <p>No profiles found for this user.</p>
    <?php else: ?>
        <h2>Your Profiles:</h2>
        <ul>
            <?php foreach ($profiles as $profile): ?>
            <li>
                <strong>Profile Name:</strong> <?php echo $profile['ProfileName']; ?><br>
                <?php
                $isChildProfile = $profile['AccountType'] === 'Child';
                $profileType = $isChildProfile ? 'Child' : 'Adult';
                $profileId = $profile['ProfileId'];
                $profilePage = $isChildProfile ? 'childProfile.php' : 'adultProfile.php';
                ?>
                <a href="<?php echo $profilePage; ?>?ProfileId=<?php echo $profileId; ?>&selectedProfile=<?php echo urlencode($profile['ProfileName']); ?>">View <?php echo ucfirst($profileType); ?> Profile</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</body>

</html>
