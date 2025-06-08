<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['userType'] !== 'patient') {
    header('Location: index.html'); // Redirect to login page if not logged in or wrong user type
    exit;
}

// Handle form submission and doctor assignment logic here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Symptoms</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Patient Symptoms</h1>
    </header>
    <main>
        <form action="assign_doctor.php" method="POST">
            <div class="form-group">
                <label for="symptoms">Describe your symptoms:</label>
                <textarea id="symptoms" name="symptoms" rows="5" required></textarea>
            </div>
            <button class="button" type="submit">Submit</button>
        </form>
    </main>
</body>
</html>
