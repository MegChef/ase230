<?php
// Database connection
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
echo "Connected successfully<br><br>";

// ============================================================================
// CREATE - Insert new student records
// ============================================================================
echo "<h2>CREATE - Adding New Students</h2>";

$name1 = "Alice Johnson";
$age1 = 22;
$major1 = "Computer Science";

$sql = "INSERT INTO students (name, age, major) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $name1, $age1, $major1);

if ($stmt->execute()) {
    echo "Student '$name1' added successfully<br>";
} else {
    echo "Error: " . $stmt->error . "<br>";
}

$name2 = "Bob Smith";
$age2 = 21;
$major2 = "Mathematics";

$stmt->bind_param("sis", $name2, $age2, $major2);

if ($stmt->execute()) {
    echo "Student '$name2' added successfully<br>";
} else {
    echo "Error: " . $stmt->error . "<br>";
}

$stmt->close();
echo "<br>";

// ============================================================================
// READ - Display all student records
// ============================================================================
echo "<h2>READ - All Students</h2>";

$sql = "SELECT id, name, age, major FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Found " . $result->num_rows . " students:<br>";
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Age: " . $row["age"]. " - Major: " . $row["major"]. "<br>";
    }
} else {
    echo "No students found<br>";
}
echo "<br>";

// ============================================================================
// READ - Get specific student by ID
// ============================================================================
echo "<h2>READ - Specific Student (ID = 1)</h2>";

$student_id = 1;
$sql = "SELECT id, name, age, major FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Found student: " . $row["name"] . " (Age: " . $row["age"] . ", Major: " . $row["major"] . ")<br>";
} else {
    echo "No student found with ID $student_id<br>";
}

$stmt->close();
echo "<br>";

// ============================================================================
// UPDATE - Modify existing student record
// ============================================================================
echo "<h2>UPDATE - Updating Student</h2>";

$update_id = 1;
$new_name = "Alice Johnson Updated";
$new_age = 23;
$new_major = "Computer Engineering";

$sql = "UPDATE students SET name = ?, age = ?, major = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisi", $new_name, $new_age, $new_major, $update_id);

if ($stmt->execute()) {
    echo "Student with ID $update_id updated successfully<br>";
} else {
    echo "Error updating student: " . $stmt->error . "<br>";
}

$stmt->close();

// Show updated record
echo "Updated student info:<br>";
$sql = "SELECT id, name, age, major FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $update_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Age: " . $row["age"]. " - Major: " . $row["major"]. "<br>";
}

$stmt->close();
echo "<br>";

// ============================================================================
// DELETE - Remove a student record
// ============================================================================
echo "<h2>DELETE - Removing Student</h2>";

$delete_id = 2;
$sql = "DELETE FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $delete_id);

if ($stmt->execute()) {
    echo "Student with ID $delete_id deleted successfully<br>";
} else {
    echo "Error deleting student: " . $stmt->error . "<br>";
}

$stmt->close();
echo "<br>";

// ============================================================================
// READ - Show final results
// ============================================================================
echo "<h2>Final Results - All Remaining Students</h2>";

$sql = "SELECT id, name, age, major FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Remaining students:<br>";
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["name"]. " - Age: " . $row["age"]. " - Major: " . $row["major"]. "<br>";
    }
} else {
    echo "No students found<br>";
}

// Close connection
$conn->close();
?>
