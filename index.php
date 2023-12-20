<?php  session_start();
require_once "connect.php";
$conn = new DbConnect();
$conn = $conn->connect();
if(!isset($_SESSION["username"])){
    header("Location:login.php");
} 

?>


<!DOCTYPE html>

<html>
<head>
	<title> hello this is new change </title>
</head>
<body>
		<h1> Welcome <?php echo $_SESSION["username"];?></h1>
            <a href = "logout.php">Exit</a>
            <a href = "createuser.php">Create Account</a>
		
</body>
</html>