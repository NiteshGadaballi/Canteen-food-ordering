<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_payment'])) {
    $order_id = $_POST['order_id'];

    // Update order status to 'Paid'
    $conn->query("UPDATE orders SET status='Paid' WHERE id='$order_id'");

    echo "<h2>Thank you! Your payment has been received. Order ID: $order_id</h2>";
} else {
    header("Location: index.php");
}
?>
