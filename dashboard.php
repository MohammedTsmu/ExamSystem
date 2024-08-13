<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

echo "Welcome, " . $_SESSION['username'] . "!";

if ($_SESSION['role'] == 'student') {
    echo "<a href='start_exam.php'>Start Exam</a>";
} elseif ($_SESSION['role'] == 'admin') {
    echo "<a href='add_exam.php'>Add New Exam</a>";
    echo "<a href='add_question.php'>Add New Question</a>";
    echo "<a href='add_student.php'>Add New Student</a>";
    echo "<a href='view_students.php'>View Students</a>";  // إضافة هذا الرابط لعرض الطلاب
    echo "<a href='view_results.php'>View Results</a>";  // إضافة هذا الرابط لعرض النتائج
}

?>

<a href="logout.php">Logout</a>