<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['faculty_id'])) {
    echo "Invalid faculty ID.";
    exit;
}

$faculty_id = $_GET['faculty_id'];

// Fetch faculty details
$sql = "SELECT * FROM faculty WHERE fid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
$faculty = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$faculty) {
    echo "Faculty not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        h2 {
            color: #6a11cb;
        }
        p {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="uploads/<?php echo $faculty['photo'] ?: 'default.jpg'; ?>" alt="Faculty Photo">
        <h2><?php echo $faculty['name']; ?></h2>
        <p><b>Email:</b> <?php echo $faculty['email']; ?></p>
        <p><b>Status:</b> <?php echo $faculty['status']; ?></p>
        <p><b>Message:</b> <?php echo $faculty['message'] ?: 'No message available'; ?></p>
    </div>
</body>
</html>
