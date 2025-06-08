<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$appointment_confirmation = "";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $doctor_id = $_GET['id'];
    $sql = "SELECT * FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();

    // Decode the JSON availability data into an associative array
    $availability = json_decode($doctor['availability'], true);

    $stmt->close();
} else {
    echo "No doctor ID provided.";
}

// Handle appointment booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_appointment'])) {
    if (isset($_POST['selected_timing']) && isset($_POST['patient_name']) && isset($_POST['patient_age']) && isset($_POST['patient_gender']) && isset($_POST['patient_symptoms'])) {
        $selected_timing = $_POST['selected_timing'];
        $patient_name = $_POST['patient_name'];
        $patient_age = $_POST['patient_age'];
        $patient_gender = $_POST['patient_gender'];
        $patient_symptoms = $_POST['patient_symptoms'];

        // Prepare appointment data to store in appointments column
        $appointment_data = array(
            'patient_name' => $patient_name,
            'age' => $patient_age,
            'gender' => $patient_gender,
            'timing' => $selected_timing,
            'symptoms' => $patient_symptoms
        );

        // Encode appointment data as JSON
        $appointment_json = json_encode($appointment_data);

        // Retrieve current appointments array from database
        $current_appointments = json_decode($doctor['appointments'], true);

        // Append new appointment data
        $current_appointments[] = $appointment_data;

        // Encode updated appointments array as JSON
        $current_appointments_json = json_encode($current_appointments);

        // Update the doctors table with the new appointments data
        $update_sql = "UPDATE doctors SET appointments = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $current_appointments_json, $doctor_id);
        
        if ($stmt->execute()) {
            $appointment_confirmation = "Appointment confirmed for " . htmlspecialchars($selected_timing) . ".";
        } else {
            $appointment_confirmation = "Failed to book appointment. Please try again.";
        }

        $stmt->close();
    } else {
        $appointment_confirmation = "Please fill out all fields before confirming the appointment.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrQkTyMbcj8H6FE0f7KNM2Yz7roV05JJMEjYmg+Gj42f1T5fzxOexdEU1RAf0U0F3oYfWx4fgkJZ4DdKcQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            border-radius: 15px;
            overflow: hidden;
            width: 90%;
            max-width: 700px;
            text-align: center;
            padding: 30px;
            transition: transform 0.3s ease-in-out;
        }

        .container:hover {
            transform: translateY(-5px);
        }

        h1 {
            margin: 0;
            padding: 20px 0;
            font-size: 2.5rem;
            font-weight: 600;
            color: #007bff;
        }

        .doctor-details {
            text-align: left;
        }

        .doctor-details p {
            margin: 10px 0;
            font-size: 1.1rem;
        }

        .availability-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .availability-table th, .availability-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 1rem;
        }

        .availability-table th {
            background-color: #f2f2f2;
        }

        .appointment-section {
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .confirmation {
            margin-top: 20px;
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-md"></i> Doctor Details</h1>
        <div class="doctor-details">
            <?php if (isset($doctor)) { ?>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($doctor['name']); ?></p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($doctor['contact']); ?></p>
                <p><strong>Country Code:</strong> <?php echo htmlspecialchars($doctor['country_code']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($doctor['gender']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p>
                <p><strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                <p><strong>Degree:</strong> <?php echo htmlspecialchars($doctor['degree']); ?></p>
                <p><strong>Experience:</strong> <?php echo htmlspecialchars($doctor['experience']); ?> years</p>
                <h3>Availability:</h3>
                <?php if (!empty($availability)) { ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $doctor_id; ?>">
                        <table class="availability-table">
                            <tr>
                                <th>Day</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Select Timing</th>
                            </tr>
                            <?php foreach ($availability as $day => $times) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($day); ?></td>
                                    <td><?php echo !empty($times['from']) ? htmlspecialchars($times['from']) : '-'; ?></td>
                                    <td><?php echo !empty($times['to']) ? htmlspecialchars($times['to']) : '-'; ?></td>
                                    <td><input type="radio" name="selected_timing" value="<?php echo htmlspecialchars($day . ': ' . $times['from'] . ' - ' . $times['to']); ?>"></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4">
                                    <div class="form-group">
                                        <label for="patient_name">Patient Name:</label>
                                        <input type="text" id="patient_name" name="patient_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="patient_age">Age:</label>
                                        <input type="number" id="patient_age" name="patient_age" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="patient_gender">Gender:</label>
                                        <select id="patient_gender" name="patient_gender" required>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="patient_symptoms">Symptoms:</label>
                                        <textarea id="patient_symptoms" name="patient_symptoms" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn" name="book_appointment">Book Appointment</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php if (!empty($appointment_confirmation)) { ?>
                        <div class="confirmation"><?php echo $appointment_confirmation; ?></div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No availability data found.</p>
                <?php } ?>
            <?php } else { ?>
                <p>No doctor details found.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
