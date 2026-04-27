<?php
include("connection.php");
session_start();

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);

    
    $sql = "SELECT image FROM destinations WHERE id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (!empty($row['image']) && file_exists("uploads/" . $row['image'])) {
                unlink("uploads/" . $row['image']); // Delete the image file
            }
        }
        $stmt->close();
    }


    $deleteSql = "DELETE FROM destinations WHERE id=?";
    if ($stmt = $conn->prepare($deleteSql)) {
        $stmt->bind_param("i", $deleteId);
        if ($stmt->execute()) {
            $stmt->close();
            echo "<script>alert('Destination deleted successfully (linked packages also removed)'); window.location.href='manage_destination.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error deleting destination'); window.location.href='manage_destination.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to prepare delete statement'); window.location.href='manage_destination.php';</script>";
    }
}


$sql = "SELECT * FROM destinations ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Destinations | Tour & Travel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="css/manage_destination.css">
</head>
<body>
    <?php include 'frame.php'; ?>

    <div class="main-content">
        <header class="header-with-btn">
            <h1>Manage Destinations</h1>
            <a href="add_destination.php" class="manage-btn">Add New Destination</a>
        </header>

        <table class="dest-table">
            <thead>
                <tr>
                
                    <th>Image</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Price (₹)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): 
                while($row = $result->fetch_assoc()): ?>
                <tr>
                    
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" width="80" height="60" style="border-radius:5px;">
                        <?php else: ?>
                            No image
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo number_format($row['price'], 2); ?></td>
                    <td>
                        <a href="edit_destination.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="manage_destination.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this destination?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; 
            else: ?>
                <tr>
                    <td colspan="5">No destinations found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
