<?php  session_start();
require_once "connect.php";
$conn = new DbConnect();
$conn = $conn->connect();
if(!isset($_SESSION["username"])){
    header("Location:login.php");
} 
$userId = $_SESSION["user_id"];

           

                $stmt = $pdo->prepare("SELECT * FROM UserProfiles WHERE user_id = :user_id");
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>

<html>
<head>
	<title> hello this is new change </title>
</head>
<body>
		<h1> Welcome <?php echo $_SESSION["username"];?></h1>
            <a href = "logout.php">Exit</a>
            <?php if (empty($profiles)): ?>
            <p>No profiles found for this user.</p>
            <?php else: ?>


		
</body>
</html>