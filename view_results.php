<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$sql = "SELECT users.username, exams.exam_name, results.score, results.exam_date
        FROM results
        JOIN users ON results.student_id = users.id
        JOIN exams ON results.exam_id = exams.id
        ORDER BY results.exam_date DESC, users.username, exams.exam_name"; // ترتيب النتائج حسب التاريخ ثم اسم الطالب

$results = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Student Results</h1>
    <table>
        <tr>
            <th>Student</th>
            <th>Exam</th>
            <th>Score</th>
            <th>Date and Time</th>
        </tr>
        <?php while ($row = $results->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['exam_name']; ?></td>
                <td><?php echo $row['score']; ?></td>
                <td><?php echo $row['exam_date']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>

</html>