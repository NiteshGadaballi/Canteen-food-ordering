<?php
include 'db.php';
session_start();

$products = $conn->query("SELECT * FROM products");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
    $conn->query($sql);

    header("Location: cart.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Food Ordering</title>
</head>
<body style=background-color:#00ffaa;>
    <h2>Products</h2>
    <div>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <div>
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p>₹<?php echo $row['price']; ?></p> <!-- Changed to Indian Rupees -->
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>
