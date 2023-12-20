
<?php  
session_start();
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
		<p> this is the body</p>
		<p> this is the new text added for apache test</p>		
		<p> second test </p>
		<?php 
    
		try{
    $sql = "SELECT * FROM UserAccounts";

    
    $stmt = $conn->prepare($sql);

    
    $stmt->execute();

    
    if ($stmt->rowCount() > 0) {
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            foreach ($row as $key => $value) {
                echo $key . ": " . $value . "<br>";
            }
            echo "<hr>";
        }
    } else {
        echo "No records found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
</body>
</html>