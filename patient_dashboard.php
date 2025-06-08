<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['userType'] != 'patient') {
    header("Location: login.html");
    exit();
}

$patient = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap">
    <style>
        /* Global Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            width: 90%;
            max-width: 800px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        h1 {
            font-size: 28px;
            margin: 0;
            font-weight: 600;
        }

        .patient-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .patient-details h2 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .patient-details p {
            margin: 10px 0;
            font-size: 16px;
            font-weight: 400;
            color: #333;
        }

        .patient-details p strong {
            font-weight: 600;
            color: #555;
        }

        .next-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            align-self: center;
        }

        .next-btn:hover {
            background-color: #0056b3;
        }

        footer {
            padding: 20px 0;
            background-color: #f0f2f5;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top: 1px solid #ddd;
        }

        footer a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($patient['name']); ?></h1>
        </header>
        <section class="patient-details">
            <h2>Your Details</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
            <p><strong>Contact:</strong> <?php echo htmlspecialchars($patient['contact']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
            <button class="next-btn" onclick="window.location.href='enter_symptoms.php'">Next</button>
        </section>
        <footer>
            <a href="logout.php">Logout</a>
        </footer>
    </div>
</body>

</html>
