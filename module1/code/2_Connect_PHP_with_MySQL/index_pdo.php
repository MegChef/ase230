<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "studentdb";

try {
  // Create PDO connection
  $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // throw exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false, // use real prepared statements
  ];
  $pdo = new PDO($dsn, $username, $password, $options);

  echo "Connected successfully\n";

  // Insert record
  $name = "Student2";
  $age = 20;
  $major = "Computer Science";

  $sql = "INSERT INTO students (name, age, major) VALUES (:name, :age, :major)";
  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    ':name' => $name,
    ':age' => $age,
    ':major' => $major,
  ]);

  echo "New student added successfully";

} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}