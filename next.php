<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['userType'] != 'doctor') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Symptoms & Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"], textarea, input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background: #007bff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
            text-align: center;
            cursor: pointer;
        }
        .button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Enter Patient Symptoms & Upload Reports</h1>
        <form action="process.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="symptoms">Symptoms:</label>
                <textarea id="symptoms" name="symptoms" required></textarea>
            </div>
            <div class="form-group">
                <label for="report">Upload Report:</label>
                <input type="file" id="report" name="report" accept=".doc,.docx,.pdf,.png,.jpg,.jpeg" required>
            </div>
            <button type="submit" class="button"><i class="fas fa-upload icon"></i>Submit</button>
        </form>
    </div>
</body>
</html>
