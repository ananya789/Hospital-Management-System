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

// Decode the JSON availability data into an associative array
$availability = json_decode($doctor['availability'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
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
        .dashboard-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
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
        p {
            color: #666;
            margin: 10px 0;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #0056b3;
        }
        .icon {
            margin-right: 10px;
            color: #007bff;
        }
        .profile-info {
            text-align: left;
            margin-top: 20px;
        }
        .profile-info div {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }
        .availability-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .availability-table th,
        .availability-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .availability-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, Dr. <?php echo htmlspecialchars($doctor['name']);?></h1>
        <div class="profile-info">
            <div><i class="fas fa-envelope icon"></i><p>Email: <?php echo htmlspecialchars($doctor['email']);?></p></div>
            <div><i class="fas fa-phone icon"></i><p>Contact: <?php echo htmlspecialchars($doctor['contact']);?></p></div>
            <div><i class="fas fa-venus-mars icon"></i><p>Gender: <?php echo htmlspecialchars($doctor['gender']);?></p></div>
            <div><i class="fas fa-stethoscope icon"></i><p>Specialization: <?php echo htmlspecialchars($doctor['specialization']);?></p></div>
            <div><i class="fas fa-graduation-cap icon"></i><p>Degree: <?php echo htmlspecialchars($doctor['degree']);?></p></div>
            <div><i class="fas fa-briefcase icon"></i><p>Experience: <?php echo htmlspecialchars($doctor['experience']);?> years</p></div>
            <h3>Availability:</h3>
            <?php if (!empty($availability)) {?>
                <table class="availability-table">
                    <tr>
                        <th>Day</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                    <?php foreach ($availability as $day => $time) {?>
                        <tr>
                            <td><?php echo ucfirst($day);?></td>
                            <td><?php echo!empty($time['from'])? htmlspecialchars($time['from']) : '-';?></td>
                            <td><?php echo!empty($time['to'])? htmlspecialchars($time['to']) : '-';?></td>
                        </tr>
                    <?php }?>
                </table>
            <?php } else {?>
                <p>No availability data found.</p>
            <?php }?>
        </div>
        <a href="logout.php"><i class="fas fa-sign-out-alt icon"></i>Logout</a>
        <a href="appointments.php"><i class="fas fa-calendar-alt icon"></i>Appointments</a>
    </div>
</body>
</html>
