<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($checkUser) > 0) {
        echo "<script>alert('Username or Email already exists!');</script>";
    } else {
        $query = "INSERT INTO users (name, email, username, password) VALUES ('$name', '$email', '$username', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful! Please login.'); window.location='login_user.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <h2>User Registration</h2>
      <form method="POST" action="register.php">
        <div class="input-group">
          <input type="text" name="name" placeholder="Full Name" required>
        </div>
        <div class="input-group">
          <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
          <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Register</button>
        <p class="redirect">Already have an account? <a href="login_user.php">Login here</a></p>
      </form>
    </div>
  </div>
</body>
</html>
