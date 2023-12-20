<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "connect.php";
    $conn = new DbConnect();
    $pdo = $conn->connect();

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $dob = $_POST["dob"];
    $country = $_POST["country"];

    $sql = "INSERT INTO UserAccounts (Username, Password, email, FirstName, LastName, DateOfBirth, Country) VALUES (:Username, :Password, :email, :FirstName, :LastName, :DateOfBirth, :Country)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':Username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':Password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':FirstName', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':LastName', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':DateOfBirth', $dob, PDO::PARAM_STR);
    $stmt->bindParam(':Country', $country, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "User successfully added.";
    } else {
        echo "Error adding user: " . $stmt->errorInfo()[2];
    }
} else {
    echo "Invalid request method.";
}
?>
