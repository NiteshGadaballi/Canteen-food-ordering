<?php
// Start the session to check if the user is logged in
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Food Ordering System</title>
    <link rel="stylesheet" type="text/css" href="style1.css"> <!-- Link to your CSS file -->
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <a href="home.php">Home</a>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</nav>

<!-- Hero Section -->
<section class="hero">
    <h1>Crispy kitchen</h1>
    <p>Order delicious food from the comfort of your college.</p>
    <a href="login.php" class="btn">Start Ordering</a> <!-- Start Ordering button leads to login page -->
</section>

<!-- About Section -->
<section class="about">
    <h2>About Us</h2>
    <p>We offer a wide range of food and beverages to satisfy your cravings. From pizzas to burgers, and refreshing drinks, we have it all.</p>
</section>

<!-- Footer -->
<footer>
    <p>&copy; 2024 College Canteen. All rights reserved.</p>
</footer>

</body>
</html>
