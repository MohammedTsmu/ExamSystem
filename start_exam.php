<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
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
    <title>Select Exam</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Select Exam</h1>
        <form method="post" action="take_exam.php" class="form">
            <label for="exam_id">Choose an exam:</label>
            <select id="exam_id" name="exam_id" required>
                <?php while ($row = $exams->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['exam_name']; ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn">Start Exam</button>
        </form>
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>