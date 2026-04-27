<?php 
include("connection.php");

$userQuery = "SELECT COUNT(*) as total_users FROM users";
$userResult = $conn->query($userQuery);
$userRow = $userResult->fetch_assoc();
$totalUsers = $userRow['total_users'];


$bookingQuery = "SELECT COUNT(*) as total_bookings FROM bookings";
$bookingResult = $conn->query($bookingQuery);
$bookingRow = $bookingResult->fetch_assoc();
$totalBookings = $bookingRow['total_bookings'];


$packageQuery = "SELECT COUNT(*) as total_packages FROM packages";
$packageResult = $conn->query($packageQuery);
$packageRow = $packageResult->fetch_assoc();
$totalPackages = $packageRow['total_packages'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Tour & Travel Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <?php include 'frame.php'; ?>

    <div class="main-content">
        <header>
            <h1>Welcome, Admin</h1>
            <p>Tour & Travel Management System</p>
        </header>

        <section class="dashboard">
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="card">
                <h3>Total Bookings</h3>
                <p><?php echo $totalBookings; ?></p>
            </div>
            <div class="card">
                <h3>Available Packages</h3>
                <p><?php echo $totalPackages; ?></p>
            </div>
            
        </section>
    </div>
</body>
</html>
