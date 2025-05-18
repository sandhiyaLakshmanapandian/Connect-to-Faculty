<?php
session_start();
include 'db_connect.php';

if (!isset($_GET['faculty_id'])) {
    echo "<script>alert('Invalid access!'); window.location.href = 'student_dashboard.php';</script>";
    exit();
}

$faculty_id = $_GET['faculty_id'];

// Fetch faculty details
$faculty_sql = "SELECT * FROM faculty WHERE fid = ?";
$stmt = $conn->prepare($faculty_sql);
$stmt->bind_param("s", $faculty_id);
$stmt->execute();
$faculty_result = $stmt->get_result();
$faculty = $faculty_result->fetch_assoc();

// Fetch faculty schedule
$schedule_sql = "SELECT * FROM faculty_schedule WHERE faculty_id = ? ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), hour";
$stmt = $conn->prepare($schedule_sql);
$stmt->bind_param("s", $faculty_id);
$stmt->execute();
$schedule_result = $stmt->get_result();

// Initialize schedule array
$schedule = [];
while ($row = $schedule_result->fetch_assoc()) {
    $schedule[$row['day']][$row['hour']] = $row['room'];
}
$conn->close();

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday',];
$hours = range(1,7);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Schedule</title>
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
            text-align: center;
        }
        h2 {
            color: #6a11cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #2575fc;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo $faculty['name']; ?>'s Schedule</h2>
        <table>
            <tr>
                <th>Hour</th>
                <?php foreach ($days as $day) { echo "<th>$day</th>"; } ?>
            </tr>
            <?php foreach ($hours as $hour) { ?>
                <tr>
                    <td><?php echo "Hour $hour"; ?></td>
                    <?php foreach ($days as $day) { ?>
                        <td>
                            <?php echo isset($schedule[$day][$hour]) ? $schedule[$day][$hour] : 'N/A'; ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
