<?php
include 'connection.php';
session_start();


$user_logged_in = isset($_SESSION['user_id']);
$username = $user_logged_in ? $_SESSION['name'] : null;


$destination_id = isset($_GET['destination_id']) ? intval($_GET['destination_id']) : 0;

if ($destination_id > 0) {
    $stmt = $conn->prepare("SELECT packages.*, destinations.name AS destination_name 
                            FROM packages 
                            JOIN destinations ON packages.destination_id = destinations.id
                            WHERE destination_id = ?");
    $stmt->bind_param("i", $destination_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT packages.*, destinations.name AS destination_name 
                            FROM packages 
                            JOIN destinations ON packages.destination_id = destinations.id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages</title>
    <link rel="stylesheet" href="css/packages.css">
</head>
<body>
    
    <nav class="navbar">
        <div class="logo">TravelX</div>
        <ul class="nav-links">
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="destinations.php">Destinations</a></li>

            <?php if ($user_logged_in): ?>
                <li><a href="my_bookings.php">My Bookings</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            <?php else: ?>
                <li><a href="login_user.php" class="login-btn">Login</a></li>
                <li><a href="register.php" class="register-btn">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="content">
        <h1>Travel Packages </h1>
        <div class="cards">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<h2>' . htmlspecialchars($row['package_name']) . '</h2>';
                    echo '<p><strong>Destination:</strong> ' . htmlspecialchars($row['destination_name']) . '</p>';
                    echo '<p><strong>Price:</strong> ' . htmlspecialchars($row['price']) . '</p>';
                    echo '<p><strong>Duration:</strong> ' . htmlspecialchars($row['duration']) . '</p>';
                    echo '<p>' . htmlspecialchars($row['details']) . '</p>';

                    
                    if ($user_logged_in) {
                        echo '<a href="book_package.php?package_id=' . $row['id'] . '" class="btn">Book Now</a>';
                    } else {
                        echo '<a href="login_user.php" class="btn">Login to Book</a>';
                    }

                    echo '</div>';
                }
            } else {
                echo "<p>No packages available.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
