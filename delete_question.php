<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$question_id = $_GET['id'];

$sql = "DELETE FROM questions WHERE id=$question_id";

if ($conn->query($sql) === TRUE) {
    echo "Question deleted successfully!";
} else {
    echo "Error: " . $conn->error;
}

header("Location: view_exams.php");
$conn->close();
