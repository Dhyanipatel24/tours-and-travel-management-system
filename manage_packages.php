<?php
include 'connection.php';
include 'frame.php'; 

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // 1️⃣ DELETE PAYMENTS RELATED TO THIS PACKAGE
    $conn->query("
        DELETE payments FROM payments
        INNER JOIN bookings ON payments.booking_id = bookings.id
        WHERE bookings.package_id = $id
    ");

    // 2️⃣ DELETE BOOKINGS RELATED TO THIS PACKAGE
    $conn->query("DELETE FROM bookings WHERE package_id = $id");

    // 3️⃣ DELETE THE PACKAGE
    $conn->query("DELETE FROM packages WHERE id = $id");

    echo "<script>alert('Package deleted successfully!'); window.location='manage_packages.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Packages</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/manage_package.css">
</head>
<body>
<div class="content">
    <div class="top-bar">
        <h2>Manage Packages</h2>
        <div class="button-group">
            <a href="add_package.php" class="btn">Add Package</a>
        </div>
    </div>

    <table>
        <tr>
            <th>Destination</th>
            <th>Package Name</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Details</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT p.id, d.name AS destination, p.package_name, p.price, p.duration, p.details 
                FROM packages p 
                JOIN destinations d ON p.destination_id = d.id";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['destination']}</td>
                    <td>{$row['package_name']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['duration']}</td>
                    <td>{$row['details']}</td>
                    <td>
                        <a href='edit_package.php?id={$row['id']}' class='edit-btn'>Edit</a>
                        <a href='manage_packages.php?delete={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this package?');\">Delete</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
