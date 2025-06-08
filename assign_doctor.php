<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['userType'] !== 'patient') {
    header('Location: index.html'); // Redirect to login page if not logged in or wrong user type
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$symptoms = $_POST['symptoms'];

// Logic to assign doctor based on symptoms
// For simplicity, we'll just select the first available doctor
$sql = "SELECT * FROM doctors LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $doctorData = $result->fetch_assoc();
    // Assign doctor to patient in the database if needed
    // ...

    echo "Doctor assigned: " . htmlspecialchars($doctorData['name']);
} else {
    echo "No doctors available at the moment";
}

$conn->close();
?>
