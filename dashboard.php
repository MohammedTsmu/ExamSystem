<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- إضافة رابط ملف CSS -->
</head>

<body>

    <div class='container'>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <?php if ($_SESSION['role'] == 'student') : ?>
            <a href='start_exam.php' class='btn'>Start Exam</a>
        <?php elseif ($_SESSION['role'] == 'admin') : ?>
            <a href='add_exam.php' class='btn'>Add New Exam</a>
            <a href='add_question.php' class='btn'>Add New Question</a>
            <a href='add_student.php' class='btn'>Add New Student</a>
            <a href='view_students.php' class='btn'>View Students</a>
            <a href='view_results.php' class='btn'>View Results</a>
        <?php endif; ?>

        <a href='logout.php' class='btn btn-logout'>Logout</a>
    </div>

</body>

</html>