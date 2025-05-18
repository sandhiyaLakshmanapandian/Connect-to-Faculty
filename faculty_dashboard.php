<?php
session_start();
include 'db_connect.php';

// Fetch faculty details
$faculty_id = $_SESSION['faculty_id'];
$sql = "SELECT * FROM faculty WHERE fid='$faculty_id'";
$result = $conn->query($sql);
$faculty = $result->fetch_assoc();

// Fetch schedule
$schedule_sql = "SELECT * FROM faculty_schedule WHERE faculty_id='$faculty_id'";
$schedule_result = $conn->query($schedule_sql);

// Prepare schedule array
$schedule = [];
while ($row = $schedule_result->fetch_assoc()) {
    $schedule[$row['day']][$row['hour']] = $row['room'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            color: #6a11cb;
        }
        .nav {
            display: flex;
            justify-content: space-around;
            background: #2575fc;
            padding: 10px;
            border-radius: 10px;
        }
        .nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .profile, .schedule, .status, .message {
            margin-top: 20px;
        }
        .edit-icon {
            float: right;
            cursor: pointer;
            color: #2575fc;
            font-size: 20px;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .schedule-table th, .schedule-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            background: #6a11cb;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Faculty Dashboard</h2>
        <div class="nav">
            <a href="#profile">Profile</a>
            <a href="#schedule">Schedule</a>
            <a href="#status">Status</a>
            <a href="#message">Message</a>
            <a href="logout.php">Logout</a>
        </div>

        <!-- Profile Section -->
        <div id="profile" class="profile">
            <h3>Profile <span class="edit-icon" onclick="window.location.href='update_profile.php'">✏️</span></h3>
            <img src="uploads/<?php echo $faculty['photo']; ?>" width="100" height="100" style="border-radius:50%;">
            <p><b>Name:</b> <?php echo $faculty['name']; ?></p>
            <p><b>Email:</b> <?php echo $faculty['email']; ?></p>
        </div>

        <!-- Schedule Section -->
        <div id="schedule" class="schedule">
            <h3>Schedule <span class="edit-icon" onclick="window.location.href='update_schedule.php'">✏️</span></h3>
            <table class="schedule-table">
                <tr>
                    <th>Hour</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                </tr>
                <?php for ($hour = 1; $hour <= 7; $hour++) { ?>
                    <tr>
                        <td><?php echo "Hour $hour"; ?></td>
                        <?php 
                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        foreach ($days as $day) {
                            $room_value = isset($schedule[$day][$hour]) ? $schedule[$day][$hour] : '-';
                            echo "<td>$room_value</td>";
                        }
                        ?>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Status Section -->
        <div id="status" class="status">
            <h3>Status <span class="edit-icon" onclick="window.location.href='update_status.php'">✏️</span></h3>
            <p><b>Current Status:</b> <?php echo $faculty['status']; ?></p>
        </div>

        <!-- Message Section -->
        <div id="message" class="message">
            <h3>Important Message <span class="edit-icon" onclick="window.location.href='update_message.php'">✏️</span></h3>
            <p><?php echo $faculty['message']; ?></p>
        </div>

        <!-- Logout -->
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
