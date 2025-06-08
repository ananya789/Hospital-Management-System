<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['userType'] != 'doctor') {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $symptoms = $_POST['symptoms'];
    $report = $_FILES['report'];

    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($report['name']);

    if (move_uploaded_file($report['tmp_name'], $uploadFile)) {
        // Save the symptoms and report file path to the database
        $stmt = $pdo->prepare("INSERT INTO patient_reports (doctor_id, symptoms, report_path) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['user']['id'], $symptoms, $uploadFile]);

        echo "Report uploaded successfully.";
    } else {
        echo "Failed to upload report.";
    }
} else {
    header("Location: next.php");
    exit();
}
?>
