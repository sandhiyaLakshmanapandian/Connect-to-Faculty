<?php
session_start();
include 'db_connect.php';

$faculty_id = $_SESSION['faculty_id'];

// Fetch faculty details
$sql = "SELECT * FROM faculty WHERE fid='$faculty_id'";
$result = $conn->query($sql);
$faculty = $result->fetch_assoc();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // Handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } else {
        $photo = $faculty['photo'];
    }

    $update_sql = "UPDATE faculty SET name='$name', email='$email', photo='$photo' WHERE fid='$faculty_id'";
    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='faculty_dashboard.php';</script>";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #6a11cb;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 2px solid #6a11cb;
        }
        button {
            background: #2575fc;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #1b5fcf;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <img src="uploads/<?php echo $faculty['photo']; ?>" width="100" height="100" style="border-radius:50%;">
            <input type="file" name="photo">
            <input type="text" name="name" value="<?php echo $faculty['name']; ?>" required>
            <input type="email" name="email" value="<?php echo $faculty['email']; ?>" required>
            <button type="submit">Update Profile</button>
        </form>
        <a href="faculty_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
