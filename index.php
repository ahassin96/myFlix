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

		$sql = "SELECT * FROM UserAccounts";
			$stmt = $pdo->prepare($sql);

			// Execute the query
			try {
			    $stmt->execute();
			    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			    // Display the results
			    if (!empty($result)) {
			        echo "<ul>";
			        foreach ($result as $row) {
			            echo "<li>";
			            foreach ($row as $key => $value) {
			                echo "$key: $value, ";
			            }
			            echo "</li>";
			        }
			        echo "</ul>";
			    } else {
			        echo "No records found";
			    }
			} catch (PDOException $e) {
			    die("Query failed: " . $e->getMessage());
			}
			?>


		 ?>

</body>
</html>