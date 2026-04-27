<?php
include 'connection.php';
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : 0;

if ($package_id <= 0) {
    die("Invalid Package!");
}

// Step 1: Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (user_id, package_id, status) VALUES (?, ?, 'pending')");
$stmt->bind_param("ii", $user_id, $package_id);

if ($stmt->execute()) {
    $booking_id = $stmt->insert_id;

    // Fetch package details for payment
    $package_sql = $conn->prepare("SELECT price, package_name FROM packages WHERE id = ?");
    $package_sql->bind_param("i", $package_id);
    $package_sql->execute();
    $package_result = $package_sql->get_result();
    $package = $package_result->fetch_assoc();

    // Redirect to payment page
    header("Location: payment.php?booking_id=$booking_id&amount=" . $package['price']);
    exit();
} else {
    echo "Error in booking!";
}
?>
