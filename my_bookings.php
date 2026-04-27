<?php
include 'connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bookings for this user
$sql = "SELECT b.booking_date, b.status AS booking_status, 
               p.package_name, p.price, pay.payment_status, pay.payment_method
        FROM bookings b
        JOIN packages p ON b.package_id = p.id
        LEFT JOIN payments pay ON b.id = pay.booking_id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <link rel="stylesheet" href="css/my_bookings.css">
</head>
<body>
    <div class="container">
        <h1>My Bookings</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Price</th>
                        <th>Booking Date</th>
                        <th>Booking Status</th>
                        <th>Payment Status</th>
                        <th>Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['package_name']) ?></td>
                            <td><?= number_format($row['price'], 2) ?></td>
                            <td><?= $row['booking_date'] ?></td>
                            <td><?= ucfirst($row['booking_status']) ?></td>
                            <td><?= $row['payment_status'] ?? 'Pending' ?></td>
                            <td><?= $row['payment_method'] ?? '-' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no bookings yet.</p>
            <a href="packages.php" class="book-more">Book a Package</a>
        <?php endif; ?>
    </div>
</body>
</html>
