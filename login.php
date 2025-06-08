<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['userType'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userType = $_POST['userType']; // added closing parenthesis

        try {
            if ($userType == 'patient') {
                $stmt = $pdo->prepare("SELECT * FROM patients WHERE email = :email");
            } else {
                $stmt = $pdo->prepare("SELECT * FROM doctors WHERE email = :email");
            }

            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['userType'] = $userType;
                if ($userType == 'patient') {
                    header("Location: patient_dashboard.php");
                    exit();
                } else {
                    header("Location: doctor_dashboard.php");
                    exit();
                }
            } else {
                echo "Invalid email or password.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Please fill in all required fields.";
    }
} else {
    echo "Invalid request method.";
}
?>