<?php
include 'connection.php';
include 'frame.php'; // sidebar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination_id = $_POST['destination_id'];
    $package_name   = $_POST['package_name'];
    $price          = $_POST['price'];
    $duration       = $_POST['duration'];
    $details        = $_POST['details'];

    $sql = "INSERT INTO packages (destination_id, package_name, price, duration, details) 
            VALUES ('$destination_id', '$package_name', '$price', '$duration', '$details')";
    if ($conn->query($sql)) {
        echo "<script>alert('Package added successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Package</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="add_package.css">
</head>
<body>
<div class="content">

    
    <div class="header-with-btn">
        <h1>Add Package</h1>
        <a href="manage_packages.php" class="manage-btn">Manage Packages</a>
    </div>

    
    <form method="POST" class="add-form">
        <label>Destination:</label>
        <select name="destination_id" required>
            <option value="">-- Select Destination --</option>
            <?php
            $result = $conn->query("SELECT * FROM destinations");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>

        <label>Package Name:</label>
        <input type="text" name="package_name" required>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required>

        <label>Duration:</label>
        <input type="text" name="duration">

        <label>Details:</label>
        <textarea name="details"></textarea>

        <button type="submit">Add Package</button>
    </form>
</div>
</body>
</html>
