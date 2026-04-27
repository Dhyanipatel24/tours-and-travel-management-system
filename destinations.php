<?php
include 'connection.php';
session_start();


$user_logged_in = isset($_SESSION['user_id']);
$username = $user_logged_in ? $_SESSION['name'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations</title>
    <link rel="stylesheet" href="destinations.css">
</head>
<body>
    
    <nav class="navbar">
        <div class="logo">TravelX</div>
        <ul class="nav-links">
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="packages.php">Packages</a></li>

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
        <h1>Destinations</h1>
        <div class="cards">
            <?php
            $result = $conn->query("SELECT * FROM destinations");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';

                    
                    echo '<a href="packages.php?destination_id=' . $row['id'] . '" class="btn">View Packages</a>';

                    echo '</div>';
                }
            } else {
                echo "<p>No destinations available.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
