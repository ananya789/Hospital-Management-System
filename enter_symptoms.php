<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Symptoms and Upload Reports</title>
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
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            text-align: center;
            padding: 20px;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            border-radius: 10px 10px 0 0;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        form {
            padding: 20px;
        }

        textarea {
            width: 100%;
            height: 120px;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            resize: none;
        }

        .file-upload {
            margin: 10px 0;
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 20px;
            position: relative;
            cursor: pointer;
            text-align: center;
        }

        .file-upload input[type="file"] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload .file-upload-text {
            font-size: 16px;
            color: #aaa;
        }

        .file-upload .file-list {
            margin-top: 10px;
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .file-upload .file-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .submit-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .progress-bar {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 20px;
            height: 10px;
        }

        .progress-bar .progress {
            width: 0;
            height: 100%;
            background-color: #007bff;
            transition: width 0.3s;
        }

        .chatbot-button {
            margin-top: 20px;
            text-align: center;
        }

        .chatbot-button p {
            font-size: 14px;
            color: #555;
        }

        .chatbot-button button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .chatbot-button button:hover {
            background-color: #0056b3;
        }

        .chatbot-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            display: none;
        }

        .chatbot-container iframe {
            width: 90%;
            max-width: 800px;
            height: 80%;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Enter Symptoms and Upload Reports</h1>
        </header>
        <form action="doctors.php" method="post" enctype="multipart/form-data" id="symptomForm">
            <textarea name="symptoms" placeholder="Enter your symptoms here..."></textarea>
            <div class="file-upload" id="fileUpload">
                <span class="file-upload-text">Drag & drop files here or click to select files</span>
                <input type="file" name="medicalReports[]" multiple id="fileInput">
                <ul class="file-list" id="fileList"></ul>
            </div>
            <label for="doctor-specialization">Select Doctor's Specialization:</label>
            <select id="doctor-specialization" name="specialization">
                <option value="">Select Specialization</option>
                <?php
                // Example of $specializations array
                $specializations = array("Cardiologist", "Dermatologist", "Neurologist", "Orthopedician", "Pediatrician", "Psychiatrist", "Radiologist", "Ophthalmologist", "General Physician", "Gynocologist");

                // Loop through $specializations to create options
                foreach ($specializations as $specialization) {
                    echo "<option value='" . $specialization . "'>" . $specialization . "</option>";
                }
                ?>
            </select>
            <button type="submit" class="submit-btn">Submit</button>
            <div class="progress-bar" id="progressBar">
                <div class="progress" id="progress"></div>
            </div>
        </form>

        <div class="chatbot-button">
            <p>If you are unable to find a doctor's specialization, click below to get assistance:</p>
            <button onclick="openChatbot()">Get Solution</button>
        </div>
    </div>

    <div class="chatbot-container" id="chatbotContainer">
        <button class="back-btn" onclick="closeChatbot()">Back</button>
        <iframe src="https://www.chatbase.co/chatbot-iframe/Zf_v5diIpHGgVeRVPCjaK"></iframe>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');

        fileInput.addEventListener('change', () => {
            fileList.innerHTML = '';
            Array.from(fileInput.files).forEach(file => {
                const li = document.createElement('li');
                li.textContent = file.name;
                fileList.appendChild(li);
            });
        });

        const chatbotContainer = document.getElementById('chatbotContainer');

        function openChatbot() {
            document.querySelector('.container').style.display = 'none';
            chatbotContainer.style.display = 'flex';
        }

        function closeChatbot() {
            chatbotContainer.style.display = 'none';
            document.querySelector('.container').style.display = 'block';
        }
    </script>
</body>

</html>
