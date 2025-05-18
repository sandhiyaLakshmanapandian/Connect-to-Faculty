<?php
session_start();
include 'db_connect.php';

// Fetch all faculty details
$sql = "SELECT * FROM faculty";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #2575fc;
            color: white;
        }
        .view-btn {
            text-decoration: none;
            background: #6a11cb;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Faculty List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <?php if ($row['status'] == 'Available') { ?>
                            <a class="view-btn" href="view_schedule.php?faculty_id=<?php echo $row['fid']; ?>">View Schedule</a>
                            <a class="view-btn" href="view_profile.php?faculty_id=<?php echo $row['fid']; ?>">View Profile</a>
                        <?php } else { ?>
                            <p><b>Message:</b> <?php echo $row['message'] ?: 'No message available'; ?></p>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
