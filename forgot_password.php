<?php
session_start();
include 'db_connect.php';
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php'; 

    $email = $_POST['email'];
    $token = bin2hex(random_bytes(32)); // Generates a secure token

    // Check if the email exists in the database
    $checkEmail = $conn->prepare("SELECT * FROM faculty WHERE email=?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        // Update the reset token in the database
        $updateToken = $conn->prepare("UPDATE faculty SET reset_token=? WHERE email=?");
        $updateToken->bind_param("ss", $token, $email);
        
        if ($updateToken->execute()) {
            echo "<script>alert('Password reset link has been sent. Token: $token'); window.location.href='reset_password.php?token=$token';</script>";
        } else {
            echo "<script>alert('Error updating reset token.');</script>";
        }
    } else {
        echo "<script>alert('Email not found!');</script>";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
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
            color: #ff416c;
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
            border: 2px solid #ff416c;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            background-color: #ff4b2b;
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
            background-color: #e63c1e;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
        a {
            color: #ff4b2b;
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
        <h2>Forgot Password</h2>
        <form action="" method="POST">
            <label>Email</label>
            <input type="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
