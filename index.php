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
    <h1 style="text-align:left;font-size:100px;padding-left:100px;text-decoration:underline;">Products</h1>
    <div>
        <?php while ($row = $products->fetch_assoc()) { ?>
            <div>
                <link href="style.css" rel="stylesheets" type="text/css">
                <h3 style="text-align:center;font-size:30px;text-decoration:underline;"><?php echo $row['name']; ?></h3>
                <p style="text-align:right;font-size:30px;text-decoration:underline;"><?php echo $row['description']; ?></p>
                <div style="display: flex;justify-content:center;"> 
                <img src="<?php echo $row['image']; ?>" alt="Product Image" width="500px" height="400px"
                style="border-radius:80px;align:center;"/></div>

                <p style="text-align:center;font-weight:bold;font-size:30px;">₹<?php echo $row['price']; ?></p> <!-- Changed to Indian Rupees -->
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>" style=font-size:30px;>
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>
