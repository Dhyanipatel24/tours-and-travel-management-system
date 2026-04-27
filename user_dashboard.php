<?php
session_start();
include("connection.php"); 


$name = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT name FROM users WHERE id='$user_id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
    } else {
       
        session_unset();
        session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/user_dashboardd.css">
</head>
<body>
    
    <nav class="navbar">
        <div class="logo">TravelX</div>
        <ul class="nav-links">
            <li><a href="destinations.php">Destinations</a></li>
            <li><a href="packages.php">Packages</a></li>
            
            <?php if ($name): ?>
                
                <li><a href="my_bookings.php">My Bookings</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="user_logout.php" class="logout-btn">Logout</a></li>
            <?php else: ?>

                <li><a href="login_user.php" class="login-btn">Login</a></li>
                <li><a href="register.php" class="register-btn">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

   
    <header class="hero">
        <div class="hero-content">
            <?php if ($name): ?>
                <h1>Welcome, <?php echo htmlspecialchars($name); ?> </h1>
                <p>Your adventure starts here. Explore amazing destinations & packages.</p>
                <a href="packages.php" class="btn">Book Now</a>
            <?php else: ?>
                <h1>Welcome to TravelX</h1>
                <p>Your adventure starts here. Explore amazing destinations & packages.</p>
                <a href="login_user.php" class="btn">Login to Book</a>
            <?php endif; ?>
        </div>
    </header>

    
    <section class="cards">
        <div class="card">
            <h2>Destinations</h2>
            <p>Explore beautiful places around the world.</p>
            <a href="destinations.php" class="btn">Explore</a>
        </div>
        <div class="card">
            <h2>Packages</h2>
            <p>Find the best travel deals tailored for you.</p>
            <?php if ($name): ?>
                <a href="packages.php?package_id=1" class="btn">Explore</a>
            <?php else: ?>
                <a href="packages.php" class="btn">Explore</a>
            <?php endif; ?>
        </div>

        <?php if ($name): ?>
            <div class="card">
                <h2>My Bookings</h2>
                <p>Check your booked trips and manage them.</p>
                <a href="my_bookings.php" class="btn">My Trips</a>
            </div>
            <div class="card">
                <h2>Profile</h2>
                <p>Update your account details and preferences.</p>
                <a href="profile.php" class="btn">View Profile</a>
            </div>
        <?php else: ?>
            <div class="card">
                <h2>Start Your Journey</h2>
                <p>Create an account to book your dream trips.</p>
                <a href="register.php" class="btn">Register</a>
                <a href="login.php" class="btn">Login</a>
            </div>
        <?php endif; ?>
    </section>
</body>
</html>
