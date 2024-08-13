<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id=$id AND role='student'";

if ($conn->query($sql) === TRUE) {
    echo "Student account deleted successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
header("Location: view_students.php");
exit();
?>
