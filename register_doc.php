<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userType = $_POST['userType'] ?? null;
    $name = $_POST['name'] ?? null;
    $contact = $_POST['contact'] ?? null;
    $country_code = $_POST['country-code'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);
    $age = $_POST['age'] ?? null;
    $specialization = $_POST['specialization'] ?? null;
    $degree = $_POST['degree'] ?? null;
    $experience = $_POST['experience'] ?? null;
    $availability = $_POST['availability'] ?? null;

    try {
        if ($userType == 'patient') {
            $stmt = $pdo->prepare("INSERT INTO patients (name, contact, country_code, gender, email, password, age) VALUES (:name, :contact, :country_code, :gender, :email, :password, :age)");
            $stmt->execute(['name' => $name, 'contact' => $contact, 'country_code' => $country_code, 'gender' => $gender, 'email' => $email, 'password' => $password, 'age' => $age]);
            header("Location: patient_dashboard.php");
        } elseif ($userType == 'doctor') {
            $availabilityJson = json_encode($availability);
            $stmt = $pdo->prepare("INSERT INTO doctors (name, contact, country_code, gender, email, password, specialization, degree, experience, availability) VALUES (:name, :contact, :country_code, :gender, :email, :password, :specialization, :degree, :experience, :availability)");
            $stmt->execute(['name' => $name, 'contact' => $contact, 'country_code' => $country_code, 'gender' => $gender, 'email' => $email, 'password' => $password, 'specialization' => $specialization, 'degree' => $degree, 'experience' => $experience, 'availability' => $availabilityJson]);
            header("Location: doctor_dashboard.php");
        } else {
            echo "Invalid user type.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
