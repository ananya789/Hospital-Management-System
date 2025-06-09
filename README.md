# Hospital-Management-System
## Overview
The **Hospital Management System** is a web-based platform designed to enhance hospital operations by providing streamlined access to patient registration, doctor scheduling, appointment booking, and real-time healthcare management. Developed using **HTML, CSS, JavaScript, PHP, Node.js**, and **MySQL**, it supports both **patients** and **doctors** with secure access and dynamic features.
This project was developed as part of a Summer Internship Programme at **NIT Warangal**, under the guidance of **Prof. L. Anjaneyulu**.
## 🎯 Features
### 🔵 User Mode (Patient)
- Easy registration with name, age, gender, contact, email.
- Login with email and password.
- Enter symptoms and upload medical documents.
- Get help from a chatbot to choose specialization.
- View list of available doctors and their schedules.
- Book appointments and receive confirmation messages.
### 🛠 Admin/Doctor Mode
- Doctor registration with full profile: specialization, degree, availability.
- Login with secure credentials.
- View daily appointments with patient details.
- Update availability and manage profile.
- Structured and interactive dashboard for managing schedules.

## 💻 Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP, Node.js
- **Database**: MySQL
- **Chatbot**: JavaScript logic with specialization mapping
- **Real-time Notifications**: Node.js
- **Security**: Encrypted credentials & secured sessions
  
## ⚙️ Setup
### 1️⃣ Database Configuration
#### Create the Database
```sql
CREATE DATABASE hospital_management;
Create Required Tables
sql
Copy
Edit
-- Doctors table
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    gender VARCHAR(10),
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    specialization VARCHAR(100),
    degree VARCHAR(100),
    availability VARCHAR(100),
    password VARCHAR(100)
);

-- Patients table
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    dob DATE,
    gender VARCHAR(10),
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100)
);

-- Appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    symptoms TEXT,
    appointment_time DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);
🚀 Run the Application
Step 1: Clone or Download the Project
git clone https://github.com/<ananya789>/hospital-management-system.git
cd hospital-management-system
Step 2: Setup Database Credentials in config.php
<?php
$host = "localhost";
$dbname = "hospital_management";
$username = "root";
$password = ""; // Replace with your DB password
$conn = new mysqli($host, $username, $password, $dbname);
?>
Step 3: Start a Local Server
Using XAMPP/WAMP: Place the folder in htdocs and run Apache & MySQL.
Access via: http://localhost/hospital-management-system/index.html

**📌 How to Use
👤 Patient Side**
Register via the signup form.
Login to your dashboard.
Enter symptoms and optionally upload files.
Use the chatbot to select specialization.
Choose a doctor and book appointment.

****###Create Required Tables
**-- Doctors table**
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    age INT,
    gender VARCHAR(10),
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    specialization VARCHAR(100),
    degree VARCHAR(100),
    availability VARCHAR(100),
    password VARCHAR(100)
);

-- Patients table
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    dob DATE,
    gender VARCHAR(10),
    phone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100)
);

-- Appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    doctor_id INT,
    symptoms TEXT,
    appointment_time DATETIME,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

Get confirmation message and track bookings.
**###👨‍⚕️ Doctor Side**
Register your details and login.
Access personalized dashboard.
View all scheduled appointments.
Check patient details and symptoms.
Update availability and manage profile.
##How to Use
###👤 Patient Side
Register via the signup form.
Login to your dashboard.
Enter symptoms and optionally upload files.
Use the chatbot to select specialization.
Choose a doctor and book appointment.
Get confirmation message and track bookings.

###👨‍⚕️ Doctor Side
Register your details and login.
Access personalized dashboard.
View all scheduled appointments.
Check patient details and symptoms.
Update availability and manage profile.
