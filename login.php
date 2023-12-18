<?php 
require_once "connect.php";
$conn = new DbConnect();
$conn = $conn->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'db_connection.php';

    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    
    if (empty($inputUsername) || empty($inputPassword)) {
        die('Please enter both username and password.');
    }

    try {
       
        $stmt = $conn->prepare('SELECT * FROM UserAccounts WHERE username = :username');

       
        $stmt->bindParam(':username', $inputUsername);

       
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       
        if ($user && password_verify($inputPassword, $user['password'])) {
           
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            
            header('Location: index.php');
            exit;
        } else {
            
            die('Invalid username or password.');
        }
    } catch (PDOException $e) {
        die('Database error: ' . $e->getMessage());
    }
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>
    
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <br>

        <input type="submit" value="Login">
    </form>

</body>
</html>