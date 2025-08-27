<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "studentdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

// Insert record
$name = "Student2";
$age = 20;
$major = "Computer Science";

$sql = "INSERT INTO students (name, age, major) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $name, $age, $major);

if ($stmt->execute()) {
    echo "New student added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();

// Close connection
$conn->close();
?>