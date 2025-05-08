<?php
include 'db.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit(); // Make sure to exit after redirecting
        } else {
            // Handle SQL error here
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        // Check if the error is due to duplicate email
        if ($e->getCode() == 1062) { // MySQL error code for duplicate entry
            $error_message = "This email is already registered. Please use another email or log in.";
        } else {
            $error_message = "Something went wrong: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body  style=background-color:#00ffaa;>
    <h1   style="text-align:center;color:red;">Register</h1>
    <form method="post">
        <input type="text" name="username" required placeholder="Username">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit"  style=color:orange;>Register</button>
        <p  style="color:orange;text-decoration:underline;text-align:center;font-weight:bold;font-size:30px;">Already have an account?</p>
        <button onclick="window.location.href='login.php';"  style=color:orange;>Login</button>
    </form>

    <?php
    // Display error message if exists
    if (!empty($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
</body>
</html>
