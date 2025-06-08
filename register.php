<?php
require 'db.php';

// Ensure all expected POST variables are set
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
    // Check if all required fields are filled
    if (!$userType || !$name || !$contact || !$country_code || !$gender || !$email || !$password) {
        throw new Exception("Please fill in all required fields.");
    }

    // Begin transaction
    $pdo->beginTransaction();

    if ($userType === 'patient') {
        $stmt = $pdo->prepare("INSERT INTO patients (name, contact, country_code, gender, email, password, age) VALUES (:name, :contact, :country_code, :gender, :email, :password, :age)");
        $stmt->execute(['name' => $name, 'contact' => $contact, 'country_code' => $country_code, 'gender' => $gender, 'email' => $email, 'password' => $password, 'age' => $age]);
        $pdo->commit();
        header("Location: patient_dashboard.php");
        exit;
    } elseif ($userType === 'doctor') {
        $stmt = $pdo->prepare("INSERT INTO doctors (name, contact, country_code, gender, email, password, specialization, degree, experience, availability) VALUES (:name, :contact, :country_code, :gender, :email, :password, :specialization, :degree, :experience, :availability)");
        $stmt->execute(['name' => $name, 'contact' => $contact, 'country_code' => $country_code, 'gender' => $gender, 'email' => $email, 'password' => $password, 'specialization' => $specialization, 'degree' => $degree, 'experience' => $experience, 'availability' => $availability]);
        $pdo->commit();
        header("Location: doctor_dashboard.php");
        exit;
    } else {
        throw new Exception("Invalid user type.");
    }
} catch (PDOException $e) {
    // Rollback the transaction on PDO exception
    $pdo->rollBack();
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
