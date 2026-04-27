<?php
include("connection.php");
session_start();

if (!isset($_GET['id'])) {
    header("Location: manage_destination.php");
    exit;
}

$destId = $_GET['id'];

// Fetch destination details
$sql = "SELECT * FROM destinations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $destId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Destination not found'); window.location.href='manage_destination.php';</script>";
    exit;
}

$destination = $result->fetch_assoc();
$success_msg = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $location    = $_POST['location'];
    $price       = $_POST['price'];

    // Handle image upload (optional)
    $image_name = $destination['image']; // keep old by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $new_image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $new_image_name;

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Delete old image if exists
                if (!empty($destination['image']) && file_exists("uploads/" . $destination['image'])) {
                    unlink("uploads/" . $destination['image']);
                }
                $image_name = $new_image_name;
            }
        } else {
            echo "<script>alert('Invalid image type. Only JPG, PNG, GIF allowed.');</script>";
        }
    }

    // Update database
    $update = "UPDATE destinations SET name=?, description=?, location=?, price=?, image=? WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssdsi", $name, $description, $location, $price, $image_name, $destId);

    if ($stmt->execute()) {
        $success_msg = "Destination updated successfully!";
        // Refresh destination details
        $destination = ['name' => $name, 'description' => $description, 'location' => $location, 'price' => $price, 'image' => $image_name];
    } else {
        echo "<script>alert('Error updating destination');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Destination | Tour & Travel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="add_destination.css">
</head>
<body>
    <?php include 'frame.php'; ?>


    <div class="main-content">
        <header class="header-with-btn">
            <h1>Edit Destination</h1>
            <a href="manage_destination.php" class="manage-btn">Manage Destination</a>
        </header>

        <?php if($success_msg) { ?>
            <div class="success-msg"><?php echo $success_msg; ?></div>
        <?php } ?>

        <form action="" method="post" enctype="multipart/form-data" class="add-destination-form">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($destination['name']); ?>" required>

            <label>Description:</label>
            <textarea name="description" rows="4" required><?php echo htmlspecialchars($destination['description']); ?></textarea>

            <label>Location:</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($destination['location']); ?>" required>

            <label>Price (₹):</label>
            <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($destination['price']); ?>" required>

            <label>Current Image:</label><br>
            <?php if (!empty($destination['image'])) { ?>
                <img src="uploads/<?php echo $destination['image']; ?>" width="150" style="margin-bottom:10px; border-radius:5px;">
            <?php } else { ?>
                <p>No image uploaded</p>
            <?php } ?>

            <label>Upload New Image (optional):</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Update Destination</button>
        </form>
    </div>
</body>
</html>
