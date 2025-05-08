<?php
include 'db.php';
session_start();

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm_payment'])) {
        // Capture UPI transaction reference ID from the form
        $transaction_id = $_POST['transaction_id'];

        if (!empty($transaction_id)) {
            // Save transaction ID to the database (you can create a field `transaction_id` in your `orders` table)
            $conn->query("UPDATE orders SET transaction_id='$transaction_id', status='Pending Verification' WHERE id='$order_id'");
            echo "<h2>Thank you! Your payment is being verified. Your Transaction ID is: $transaction_id</h2>";
            exit();
        } else {
            $error_message = "Please enter a valid UPI Transaction ID.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function enablePaymentButton() {
            // Enable the payment button after the checkbox is clicked (payment is "done")
            document.getElementById('confirm_button').disabled = false;
        }
    </script>
</head>
<body  style=background-color:#00ffaa;>
    <h2>Payment for Order #<?php echo $order_id; ?></h2>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <h3>Pay Using UPI (GPay, Paytm, etc.)</h3>
    <p>Scan the QR code below with your preferred payment app to complete the payment.</p>
    <img src="QR_image.jpg.jpeg" alt="UPI QR Code" style="width: 200px; height: 200px;">

    <p>After completing the payment, tick the box below to confirm:</p>

    <label>
        <input type="checkbox" onclick="enablePaymentButton()"> I have completed the payment
    </label>

    <form method="post">
        <label for="transaction_id">UPI Transaction Reference ID</label>
        <input type="text" name="transaction_id" id="transaction_id" required>

        <button type="submit" id="confirm_button" name="confirm_payment" disabled>Confirm Payment</button>
    </form>
</body>
</html>
