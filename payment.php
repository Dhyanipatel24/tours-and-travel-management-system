<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0.00;

if ($booking_id <= 0 || $amount <= 0) {
    die("Invalid Payment Request!");
}

$payment_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_POST['payment_method'];

    if ($method == "card") {
        if (empty($_POST['card_number']) || empty($_POST['expiry']) || empty($_POST['cvv'])) {
            $error_msg = "Please fill all card details!";
        }
    }
    elseif ($method == "upi") {
        if (empty($_POST['upi_id'])) {
            $error_msg = "Please enter UPI ID!";
        }
    }
    elseif ($method == "netbanking") {
        if (empty($_POST['bank_name'])) {
            $error_msg = "Please choose your bank!";
        }
    }

    if (!isset($error_msg)) {
        $stmt = $conn->prepare("INSERT INTO payments (booking_id, amount, payment_status, payment_method) VALUES (?, ?, 'completed', ?)");
        $stmt->bind_param("ids", $booking_id, $amount, $method);

        if ($stmt->execute()) {
            $conn->query("UPDATE bookings SET status='confirmed' WHERE id=$booking_id");
            $payment_success = true;
        } else {
            $error_msg = "Payment failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>

<div class="payment-box">

<?php if ($payment_success): ?>
    <h2>Payment Successful!</h2>
    <p>Your booking is confirmed.</p>
    <a href="my_bookings.php" class="go-bookings">Go to My Bookings</a>

<?php else: ?>

    <h2>Complete Your Payment</h2>
    <p><strong>Booking ID:</strong> <?= $booking_id ?></p>
    <p><strong>Amount:</strong> <?= number_format($amount, 2) ?></p>

    <?php if(isset($error_msg)) echo "<p style='color:red;'>$error_msg</p>"; ?>

    <form method="post">
        <label for="payment_method">Choose Payment Method</label>
        <select name="payment_method" id="payment_method" required onchange="showFields()">
            <option value="">-- Select Method --</option>
            <option value="card">Credit/Debit Card</option>
            <option value="upi">UPI</option>
            <option value="netbanking">Net Banking</option>
        </select>

        <!-- CARD PAYMENT -->
        <div id="card_fields" style="display:none; margin-top:10px;">
            <label>Card Number</label>
            <input type="text" name="card_number" minlength="16" maxlength="16">

            <label>Expiry Date</label>
            <input type="month" name="expiry">

            <label>CVV</label>
            <input type="password" name="cvv" maxlength="3">
        </div>

        <!-- UPI PAYMENT -->
        <div id="upi_fields" style="display:none; margin-top:10px;">
            <label>UPI ID</label>
            <input type="text" name="upi_id" placeholder="example@upi">
        </div>

        <!-- NET BANKING -->
        <div id="netbanking_fields" style="display:none; margin-top:10px;">
            <label>Select Bank</label>
            <select name="bank_name">
                <option value="">-- Choose Bank --</option>
                <option value="SBI">SBI</option>
                <option value="HDFC">HDFC</option>
                <option value="ICICI">ICICI</option>
                <option value="Kotak">Kotak</option>
            </select>
        </div>

        <button type="submit">Pay Now</button>
    </form>

<?php endif; ?>

</div>

<script>
function showFields() {
    let method = document.getElementById('payment_method').value;

    // Hide all sections
    document.getElementById('card_fields').style.display = 'none';
    document.getElementById('upi_fields').style.display = 'none';
    document.getElementById('netbanking_fields').style.display = 'none';

    // Show selected
    if (method === 'card') {
        document.getElementById('card_fields').style.display = 'block';
    }
    else if (method === 'upi') {
        document.getElementById('upi_fields').style.display = 'block';
    }
    else if (method === 'netbanking') {
        document.getElementById('netbanking_fields').style.display = 'block';
    }
}
</script>

</body>
</html>
