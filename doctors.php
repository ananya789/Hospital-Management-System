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

$doctors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['specialization']) && !empty($_POST['specialization'])) {
        $specialization = $_POST['specialization'];
        $sql = "SELECT * FROM doctors WHERE specialization = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $specialization);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }

        $stmt->close();
    } else {
        echo "Specialization is not set or empty.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
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

        .doctor-list {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .doctor-list li {
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .doctor-list li:last-child {
            border-bottom: none;
        }

        .doctor-list li:hover {
            background-color: #f9f9f9;
        }

        .doctor-list li a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            font-size: 1.2rem;
            flex-grow: 1;
        }

        .doctor-list li a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .doctor-list li i {
            margin-right: 15px;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-user-md"></i> Doctors List</h1>
        <ul class="doctor-list">
            <?php
            if (!empty($doctors)) {
                foreach ($doctors as $doctor) {
                    echo "<li><i class='fas fa-stethoscope'></i><a href='doctor_details.php?id=" . $doctor['id'] . "'>" . $doctor['name'] . "</a></li>";
                }
            } else {
                echo "<li>No doctors found for the selected specialization.</li>";
            }
            ?>
        </ul>
    </div>
</body>

</html>
