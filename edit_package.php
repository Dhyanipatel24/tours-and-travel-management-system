<?php
include 'connection.php';
include 'frame.php'; 

if (!isset($_GET['id'])) {
    echo "Invalid request!";
    exit;
}

$id = $_GET['id'];


$sql = "SELECT * FROM packages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$package = $result->fetch_assoc();

if (!$package) {
    echo "Package not found!";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination_id = $_POST['destination_id'];
    $package_name   = $_POST['package_name'];
    $price          = $_POST['price'];
    $duration       = $_POST['duration'];
    $details        = $_POST['details'];

    $update_sql = "UPDATE packages 
                   SET destination_id = ?, package_name = ?, price = ?, duration = ?, details = ? 
                   WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("isdssi", $destination_id, $package_name, $price, $duration, $details, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Package updated successfully!'); window.location='manage_packages.php';</script>";
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Package</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="edit_packages.css">
</head>
<body>
<div class="content">
    <h2>Edit Package</h2>
    <form method="POST" class="add-form">
        <label>Destination:</label>
        <select name="destination_id" required>
            <option value="">-- Select Destination --</option>
            <?php
            $destinations = $conn->query("SELECT * FROM destinations");
            while ($row = $destinations->fetch_assoc()) {
                $selected = ($row['id'] == $package['destination_id']) ? "selected" : "";
                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
            }
            ?>
        </select><br>

        <label>Package Name:</label>
        <input type="text" name="package_name" value="<?= htmlspecialchars($package['package_name']) ?>" required><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($package['price']) ?>" required><br>

        <label>Duration:</label>
        <input type="text" name="duration" value="<?= htmlspecialchars($package['duration']) ?>"><br>

        <label>Details:</label>
        <textarea name="details"><?= htmlspecialchars($package['details']) ?></textarea><br>

        <button type="submit">Update Package</button>
        <a href="manage_packages.php" class="btn-back">Cancel</a>
    </form>
</div>
</body>
</html>
