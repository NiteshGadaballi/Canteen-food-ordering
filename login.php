<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
        } else {
            echo "Invalid credentials";
        }
    } else {
        echo "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style=background-color:#00ffaa;>
    <h1  style="text-align:center;color:red;">Login</h1>
    <form method="post">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password" >
        <button type="submit" style=color:orange;>Login</button>
        <p   style="color:orange;text-decoration:underline;text-align:center;font-weight:bold;font-size:30px;">Don't have an account?</p>
        <button onclick="window.location.href='register.php';" style=color:orange;>Register</button>
    </form>
</body>
</html>
