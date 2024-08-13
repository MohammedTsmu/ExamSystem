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
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class='container'>
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <?php if ($_SESSION['role'] == 'student') : ?>
            <a href='start_exam.php' class='btn'>Start Exam</a>
        <?php elseif ($_SESSION['role'] == 'admin') : ?>
            <a href='add_exam.php' class='btn'>Add New Exam</a>
            <a href='view_exams.php' class='btn'>Manage Exams</a> <!-- Link to manage exams -->
            <a href='add_question.php' class='btn'>Add New Question</a>
            <a href='view_questions.php' class='btn'>Manage Questions</a> <!-- Link to manage questions -->
            <a href='add_student.php' class='btn'>Add New Student</a>
            <a href='view_students.php' class='btn'>View Students</a>
            <a href='add_group.php' class='btn'>Add New Group</a> <!-- Link to add new group -->
            <a href='add_exam_to_group.php' class='btn'>Add Exam To Group</a>
            <a href='remove_exam_from_group.php' class='btn'>Remove Exam From Group</a> <!-- Corrected link to remove exam from group -->
            <a href='view_groups.php' class='btn'>Manage Groups</a> <!-- Link to manage groups -->
            <a href='view_results.php' class='btn'>View Results</a>
            <a href='view_sessions.php' class='btn'>view sessions</a>
            <a href='backup.php' class='btn'>Backup Database</a>
            <a href='import.php' class='btn'>Import Backup</a>
        <?php endif; ?>

        <a href='logout.php' class='btn btn-logout'>Logout</a>
    </div>

</body>

</html>