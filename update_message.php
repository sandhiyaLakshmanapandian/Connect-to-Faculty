<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];

// Fetch current message
$sql = "SELECT message FROM faculty WHERE fid=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc();
$current_message = $faculty['message'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_message = $_POST['message'];

    $update_sql = "UPDATE faculty SET message=? WHERE fid=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $new_message, $faculty_id);

    if ($update_stmt->execute()) {
        $_SESSION['success_msg'] = "Message updated successfully!";
        header("Location: faculty_dashboard.php");
        exit();
    } else {
        $_SESSION['error_msg'] = "Error updating message.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            text-align: center;
            padding: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            display: inline-block;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #2575fc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back {
            margin-top: 10px;
            display: block;
            color: #6a11cb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Important Message</h2>
        <form method="post">
            <textarea name="message"><?php echo htmlspecialchars($current_message); ?></textarea><br>
            <button type="submit">Update</button>
        </form>
        <a class="back" href="faculty_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
