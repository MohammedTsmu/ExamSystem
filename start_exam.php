<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['user_id'];

// Create or update the session record for the student
$sql = "INSERT INTO sessions (user_id, start_time, status) 
        VALUES ($student_id, NOW(), 'active')
        ON DUPLICATE KEY UPDATE start_time = NOW(), status = 'active'";
$conn->query($sql);

// Check if the student is assigned to any group
$sql = "SELECT group_id FROM group_students WHERE student_id = $student_id";
$group_result = $conn->query($sql);

if ($group_result->num_rows > 0) {
    $group_row = $group_result->fetch_assoc();
    $group_id = $group_row['group_id'];

    // Get exams assigned to this group
    $sql = "SELECT exams.* FROM exams 
            JOIN group_exams ON exams.id = group_exams.exam_id 
            WHERE group_exams.group_id = $group_id";
    $exams = $conn->query($sql);

    if ($exams->num_rows > 0) {
        // Exams are available for the student's group
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
                <form method="post" action="take_exam.php">
                    <label for="exam_id">Choose an exam:</label>
                    <select id="exam_id" name="exam_id" required>
                        <?php while ($exam = $exams->fetch_assoc()) : ?>
                            <option value="<?php echo $exam['id']; ?>"><?php echo $exam['exam_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" class="btn">Start Exam</button>
                </form>
                <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
            </div>
        </body>

        </html>
<?php
    } else {
        // No exams available for this group
        echo "<div class='container'>";
        echo "<p>No exams are currently assigned to your group.</p>";
        echo "<a href='dashboard.php' class='btn btn-back'>Back to Dashboard</a>";
        echo "</div>";
    }
} else {
    // No group assigned to this student
    echo "<div class='container'>";
    echo "<p>You are not assigned to any group.</p>";
    echo "<a href='dashboard.php' class='btn btn-back'>Back to Dashboard</a>";
    echo "</div>";
}

$conn->close();
?>