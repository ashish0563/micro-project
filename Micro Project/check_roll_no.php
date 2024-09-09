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

// Get Roll No from request
$rollNo = $_POST['rollNo'];

// Prepare and execute query
$stmt = $conn->prepare("SELECT * FROM STUDENT-TABLE WHERE Roll-No = ?");
$stmt->bind_param("s", $rollNo);
$stmt->execute();
$result = $stmt->get_result();

$response = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = [
        'exists' => true,
        'fullName' => $row['Full-Name'],
        'class' => $row['Class'],
        'birthDate' => $row['Birth-Date'],
        'address' => $row['Address'],
        'enrollmentDate' => $row['Enrollment-Date']
    ];
} else {
    $response = ['exists' => false];
}

// Return JSON response
echo json_encode($response);

// Close connections
$stmt->close();
$conn->close();
?>
