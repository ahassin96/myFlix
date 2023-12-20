<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
</head>
<body>

    <h2>Add New User</h2>

    <form action="adduser.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

         <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br>

         <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br>

         <label for="dob">Date Of Birth:</label>
        <input type="text" id="dob" name="dob" required><br>

         <label for="country">Country:</label>
        <input type="text" id="country" name="country" required><br>

 

        <input type="submit" value="Add User">
    </form>

</body>
</html>