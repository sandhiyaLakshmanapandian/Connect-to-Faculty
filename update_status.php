<?php
session_start();
include 'db_connect.php';

$faculty_id = $_SESSION['faculty_id'];

// Fetch current status and message
$sql = "SELECT status, message FROM faculty WHERE fid='$faculty_id'";
$result = $conn->query($sql);
$faculty = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $message = $_POST['message'];

    $update_sql = "UPDATE faculty SET status='$status', message='$message' WHERE fid='$faculty_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Status updated successfully!'); window.location.href='faculty_dashboard.php';</script>";
    } else {
        echo "Error updating status: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #6a11cb;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 2px solid #6a11cb;
            border-radius: 8px;
        }
        button {
            background-color: #2575fc;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        button:hover {
            background-color: #1b5fcf;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Status</h2>
        <form action="" method="POST">
            <label for="status">Select Status:</label>
            <select name="status" required>
                <option value="Available" <?php echo ($faculty['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                <option value="Busy" <?php echo ($faculty['status'] == 'Busy') ? 'selected' : ''; ?>>Busy</option>
                <option value="On Leave" <?php echo ($faculty['status'] == 'On Leave') ? 'selected' : ''; ?>>On Leave</option>
            </select>
            
            <label for="message">Important Message:</label>
            <textarea name="message" rows="3" placeholder="Enter important message (optional)"><?php echo $faculty['message']; ?></textarea>
            
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>