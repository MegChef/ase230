<?php

require_once 'Student.php'; // or include_once 'Student.php';

$s1 = new Student(1, 'Alice Johnson', 'alice@university.edu');
echo json_encode($s1->toArray(), JSON_PRETTY_PRINT);

?>