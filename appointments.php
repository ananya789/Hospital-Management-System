<?php
session_start();
require 'db.php'; // Ensure 'db.php' includes database connection and necessary queries

// Redirect to login page if user is not logged in or not a doctor
if (!isset($_SESSION['user']) || $_SESSION['userType']!= 'doctor') {
    header("Location: login.html");
    exit();
}

// Retrieve doctor information from session
$doctor = $_SESSION['user'];

// Retrieve appointments data from doctor table
$appointments = json_decode($doctor['appointments'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .appointments-container {
            background-color: #e9f7f5; /* New background color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-top: 0;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        p {
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="appointments-container">
        <h1>Appointments</h1>
        <?php if (!empty($appointments)) {?>
            <table>
                <tr>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Timing</th>
                    <th>Symptoms</th>
                </tr>
                <?php foreach ($appointments as $appointment) {?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['patient_name']);?></td>
                        <td><?php echo htmlspecialchars($appointment['age']);?></td>
                        <td><?php echo htmlspecialchars($appointment['gender']);?></td>
                        <td><?php echo htmlspecialchars($appointment['timing']);?></td>
                        <td><?php echo htmlspecialchars($appointment['symptoms']);?></td>
                    </tr>
                <?php }?>
            </table>
        <?php } else {?>
            <p>No appointments found.</p>
        <?php }?>
    </div>
</body>
</html>
