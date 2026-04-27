<?php
include 'connection.php';
include 'frame.php'; 


if (isset($_GET['action'], $_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']);
    $action = $_GET['action'];

    if ($action == 'confirm') {
        $conn->query("UPDATE bookings SET status='confirmed' WHERE id=$booking_id");
    } elseif ($action == 'cancel') {
        $conn->query("UPDATE bookings SET status='cancelled' WHERE id=$booking_id");
    }
}


$sql = "SELECT b.id AS booking_id, b.booking_date, b.status AS booking_status, 
               u.name AS user_name, u.email, p.package_name, p.price, pay.payment_status, pay.payment_method
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN packages p ON b.package_id = p.id
        LEFT JOIN payments pay ON b.id = pay.booking_id
        ORDER BY b.booking_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/admin_bookings.css">
</head>
<body>
<div class="content">
    
    <div class="header-with-btn">
        <h1>View Bookings</h1>
        <a href="add_package.php" class="manage-btn">Add Package</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Package</th>
                    <th>Price</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['package_name']) ?></td>
                        <td><?= number_format($row['price'], 2) ?></td>
                        <td><?= $row['booking_date'] ?></td>
                        <td><?= ucfirst($row['booking_status']) ?></td>
                        <td><?= $row['payment_status'] ?? 'Pending' ?></td>
                        <td><?= $row['payment_method'] ?? '-' ?></td>
                        <td>
                            <?php if($row['booking_status'] == 'pending'): ?>
                                <a href="?action=confirm&booking_id=<?= $row['booking_id'] ?>" class="confirm-btn">Confirm</a>
                                <a href="?action=cancel&booking_id=<?= $row['booking_id'] ?>" class="cancel-btn">Cancel</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
</div>

</body>
</html>
