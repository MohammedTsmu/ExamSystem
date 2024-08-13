<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM exams";
$exams = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Exams</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Exams List</h1>
    <table>
        <tr>
            <th>Exam Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $exams->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['exam_name']; ?></td>
                <td>
                    <a href="edit_exam.php?id=<?php echo $row['id']; ?>">Edit Exam</a>
                    <a href="delete_exam.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete Exam</a>
                    <a href="view_questions.php?exam_id=<?php echo $row['id']; ?>">View Questions</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>

</html>