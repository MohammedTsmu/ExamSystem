<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$group_id = $_POST['group_id'];
$student_id = $_POST['student_id'];

$sql = "INSERT INTO group_students (group_id, student_id) VALUES ($group_id, $student_id)";

if ($conn->query($sql) === TRUE) {
    header("Location: manage_group.php?group_id=$group_id");
} else {
    echo "Error adding student: " . $conn->error;
}

$conn->close();
