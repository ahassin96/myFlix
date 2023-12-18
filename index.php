<?php session_start();

require_once "connect.php";
$conn = new DbConnect();
$conn = $conn->connect();

?>

<!DOCTYPE html>

<html>
<head>
	<title> hello this is new change </title>
</head>
<body>
		<p> this is the body</p>
		<p> this is the new text added for apache test</p>		
		<p> second test </p>

</body>
</html>