<?php
include("connection.php");
session_start();

$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $location    = $_POST['location'];
    $price       = $_POST['price'];


    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_types)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            echo "<script>alert('Invalid image type. Only JPG, PNG, GIF allowed.');</script>";
        }
    }

    $sql = "INSERT INTO destinations (name, description, location, price, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssds", $name, $description, $location, $price, $image_name);

    if ($stmt->execute()) {
        $success_msg = "Destination added successfully!";
        
    } else {
        echo "<script>alert('Error adding destination');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Destination | Tour & Travel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="add_destination.css">
</head>
<body>
    <?php include 'frame.php'; ?>

    <div class="main-content">
        <header class="header-with-btn">
            <h1>Add Destination</h1>
            <a href="manage_destination.php" class="manage-btn">Manage Destination</a>
        </header>

        <?php if($success_msg) { ?>
            <div class="success-msg"><?php echo $success_msg; ?></div>
        <?php } ?>

        <form action="add_destination.php" method="post" enctype="multipart/form-data" class="add-destination-form">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <label>Location:</label>
            <input type="text" name="location" required>

            <label>Price (₹):</label>
            <input type="number" name="price" step="0.01" required>

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Add Destination</button>
        </form>
    </div>
</body>
</html>
