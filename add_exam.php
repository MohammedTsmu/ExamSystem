<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];

    $sql = "INSERT INTO exams (exam_name, exam_date) VALUES ('$exam_name', '$exam_date')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>New exam created successfully!</p>";
    } else {
        echo "<p class='error-msg'>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Exam</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Add New Exam</h1>
        <form method="post" class="form">
            <label for="exam_name">Exam Name:</label>
            <input type="text" id="exam_name" name="exam_name" required>

            <label for="exam_date">Exam Date:</label>
            <input type="date" id="exam_date" name="exam_date" required>

            <button type="submit" class="btn">Create Exam</button>
        </form>
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>