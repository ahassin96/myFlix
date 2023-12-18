<!DOCTYPE html>

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
		<?php 
    // SQL query
		try{
    $sql = "SELECT * FROM UserAccounts";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Execute the query
    $stmt->execute();

    // Check if there are any rows in the result
    if ($stmt->rowCount() > 0) {
        // Fetch and display data
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Display each column value
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