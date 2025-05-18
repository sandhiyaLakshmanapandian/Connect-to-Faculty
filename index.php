<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            color: #6a11cb;
        }
        .profiles {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }
        .profile {
            cursor: pointer;
            text-align: center;
        }
        .profile img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #2575fc;
            transition: transform 0.3s;
        }
        .profile img:hover {
            transform: scale(1.1);
        }
        .profile p {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Your Profile</h2>
        <div class="profiles">
            <div class="profile" onclick="location.href='login.php'">
                <img src="faculty.png" alt="Faculty">
                <p>Faculty</p>
            </div>
            <div class="profile" onclick="location.href='student_dashboard.php'">
                <img src="student.png" alt="Student">
                <p>Student</p>
            </div>
        </div>
    </div>
</body>
</html>
