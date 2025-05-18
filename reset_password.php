<?php
session_start();
include 'db_connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE faculty SET password=?, reset_token=NULL WHERE reset_token=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $token);
        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully! Redirecting to login...'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Invalid token or error!');</script>";
        }
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
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
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 380px;
            text-align: left;
        }
        h2 {
            text-align: center;
            color: #6a11cb;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 2px solid #6a11cb;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            background-color: #2575fc;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        button:hover {
            background-color: #1b5fcf;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
        a {
            color: #2575fc;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="" method="POST">
            <label>New Password</label>
            <input type="password" name="password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
