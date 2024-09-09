<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SCHOOL-DB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$rollNo = $_POST['rollNo'];
$fullName = $_POST['fullName'];
$class = $_POST['class'];
$birthDate = $_POST['birthDate'];
$address = $_POST['address'];
$enrollmentDate = $_POST['enrollmentDate'];

// Check if the roll number exists
$stmt = $conn->prepare("SELECT * FROM STUDENT-TABLE WHERE Roll-No = ?");
$stmt->bind_param("s", $rollNo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing student
    $stmt = $conn->prepare("UPDATE STUDENT-TABLE SET Full-Name = ?, Class = ?, Birth-Date = ?, Address = ?, Enrollment-Date = ? WHERE Roll-No = ?");
    $stmt->bind_param("ssssss", $fullName, $class, $birthDate, $address, $enrollmentDate, $rollNo);
    $stmt->execute();
    echo "Student updated successfully";
} else {
    // Insert new student
    $stmt = $conn->prepare("INSERT INTO STUDENT-TABLE (Roll-No, Full-Name, Class, Birth-Date, Address, Enrollment-Date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $rollNo, $fullName, $class, $birthDate, $address, $enrollmentDate);
    $stmt->execute();
    echo "Student saved successfully";
}

// Close connections
$stmt->close();
$conn->close();
?>
