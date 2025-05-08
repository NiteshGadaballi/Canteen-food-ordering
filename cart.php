<?php
include 'db.php';
session_start();

$user_id = $_SESSION['user_id'];

// Get the items in the cart for the logged-in user
$cart_items = $conn->query("SELECT cart.id as cart_id, products.id as product_id, products.name, products.price, cart.quantity 
                            FROM cart 
                            JOIN products ON cart.product_id = products.id 
                            WHERE cart.user_id='$user_id'");

// Check if remove button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_item'])) {
    $cart_id = $_POST['cart_id'];

    // Remove the product from the cart
    $conn->query("DELETE FROM cart WHERE id='$cart_id' AND user_id='$user_id'");

    header("Location: cart.php");  // Refresh the cart page after removal
    exit();
}

// Check if place order button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    $total_amount = $_POST['total_amount'];

    // Insert into orders table
    $sql = "INSERT INTO orders (user_id, total_amount) VALUES ('$user_id', '$total_amount')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;  // Get the last inserted order ID

        // Loop through cart items and insert into order_details
        while ($item = $cart_items->fetch_assoc()) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            // Check if product_id is valid
            if (empty($product_id)) {
                echo "Error: Product ID is missing!";
                exit();
            }

            // Insert into order_details table
            $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                    VALUES ('$order_id', '$product_id', '$quantity', '$price')";
            if (!$conn->query($sql)) {
                echo "Error inserting order details: " . $conn->error;
                exit();
            }
        }

        // Clear the cart after order is placed
        $conn->query("DELETE FROM cart WHERE user_id='$user_id'");

        // Redirect to payment page
        header("Location: payment.php?order_id=$order_id");
        exit();
    } else {
        echo "Error inserting order: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
</head>
<body style=background-color:#00ffaa;>
    <h1 style="text-align:center;">Your Cart</h1>
    <form method="post">
        <table border="10px" style="width:100%; height:100%;">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php $total_amount = 0; ?>
            <?php while ($row = $cart_items->fetch_assoc()) { ?>
                <tr style="text-align:center;font-weight:bold;text-decoration:underline;">
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>₹<?php echo $row['price']; ?></td>
                    <td>₹<?php echo $row['price'] * $row['quantity']; ?></td>
                    <td>
                        <!-- Remove button -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                            <button type="submit" name="remove_item" style="background-color:red;color:white;">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php $total_amount += $row['price'] * $row['quantity']; ?>
            <?php } ?>
        </table>
        <p style="text-align:center;font-weight:bold;font-size:30px;">Total Amount: ₹<?php echo $total_amount; ?></p>
        <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
        <div style="display:flex;justify-content:center;font-size:50px;">
        <button type="submit" name="place_order"  style="background-color:#fab072;color:white;">Place Order</button><br></div>
    </form>
</body>
</html>
