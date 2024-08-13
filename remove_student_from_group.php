<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$group_id = $_GET['group_id'];
$student_id = $_GET['student_id'];

$sql = "DELETE FROM group_students WHERE group_id = $group_id AND student_id = $student_id";

if ($conn->query($sql) === TRUE) {
    header("Location: manage_group.php?group_id=$group_id");
} else {
    echo "Error removing student: " . $conn->error;
}

$conn->close();
