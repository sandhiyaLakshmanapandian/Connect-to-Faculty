<?php
session_start();
include 'db_connect.php';

// Ensure faculty is logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];

// Fetch current schedule
$schedule_sql = "SELECT * FROM faculty_schedule WHERE faculty_id='$faculty_id'";
$schedule_result = $conn->query($schedule_sql);

$schedule_data = [];
while ($row = $schedule_result->fetch_assoc()) {
    $schedule_data[$row['day']][$row['hour']] = $row['room'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Clear old schedule before inserting new data
    $conn->query("DELETE FROM faculty_schedule WHERE faculty_id='$faculty_id'");
    
    foreach ($_POST['schedule'] as $day => $hours) {
        foreach ($hours as $hour => $room) {
            if (!empty($room)) {
                $stmt = $conn->prepare("INSERT INTO faculty_schedule (faculty_id, day, hour, room) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssis", $faculty_id, $day, $hour, $room);
                $stmt->execute();
            }
        }
    }
    echo "<script>alert('Schedule updated successfully!'); window.location.href='faculty_dashboard.php';</script>";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #2575fc;
            color: white;
        }
        input[type='text'] {
            width: 90%;
            padding: 5px;
            border: 1px solid #6a11cb;
            border-radius: 5px;
        }
        button {
            background-color: #2575fc;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            margin-top: 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Schedule</h2>
        <form method="POST">
            <table>
                <tr>
                    <th>Day</th>
                    <th>Hour 1</th>
                    <th>Hour 2</th>
                    <th>Hour 3</th>
                    <th>Hour 4</th>
                    <th>Hour 5</th>
                    <th>Hour 6</th>
                    <th>Hour 7</th>
                </tr>
                <?php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                for ($h = 1; $h <= 6; $h++) {
                    echo "<tr>";
                    echo "<td>{$days[$h - 1]}</td>";
                    for ($hour = 1; $hour <= 7; $hour++) {
                        $room_value = isset($schedule_data[$days[$h - 1]][$hour]) ? $schedule_data[$days[$h - 1]][$hour] : "";
                        echo "<td><input type='text' name='schedule[" . $days[$h - 1] . "][$hour]' value='$room_value'></td>";

                    }
                    echo "</tr>";
                }
                ?>
            </table>
            <button type="submit">Update Schedule</button>
        </form>
    </div>
</body>
</html>
