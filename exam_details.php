<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['user_id'];

// Retrieve all attempts for the student
$sql = "SELECT id as result_id, exam_id, exam_date 
        FROM results 
        WHERE student_id = $student_id 
        ORDER BY exam_date DESC";

$exams = $conn->query($sql);

// Fetch performance statistics
$stats_sql = "SELECT COUNT(*) AS exam_count, AVG(score) AS average_score 
              FROM results 
              WHERE student_id = $student_id";
$stats_result = $conn->query($stats_sql);
$stats = $stats_result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Student Dashboard</h1>

        <div class="stats">
            <h2>Exam Statistics</h2>
            <p>Total Exams Taken: <?php echo $stats['exam_count']; ?></p>
            <p>Average Score: <?php echo round($stats['average_score'], 2); ?></p>
        </div>

        <?php while ($exam = $exams->fetch_assoc()) :
            $result_id = $exam['result_id'];
            $exam_id = $exam['exam_id'];
            $exam_date = $exam['exam_date'];

            // Fetch the questions and answers for the selected attempt using result_id
            $sql = "SELECT q.question_text, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_option, r.selected_option 
                    FROM questions q 
                    JOIN answers r ON q.id = r.question_id 
                    WHERE r.result_id = $result_id";
            $results = $conn->query($sql);
        ?>

            <div class="exam-block">
                <h2>Exam ID: <?php echo $exam_id; ?> - Date: <?php echo $exam_date; ?></h2>
                <table>
                    <tr>
                        <th>Question</th>
                        <th>Option A</th>
                        <th>Option B</th>
                        <th>Option C</th>
                        <th>Option D</th>
                        <th>Your Answer</th>
                        <th>Correct Answer</th>
                    </tr>
                    <?php while ($row = $results->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['question_text']; ?></td>
                            <td><?php echo $row['option_a']; ?></td>
                            <td><?php echo $row['option_b']; ?></td>
                            <td><?php echo $row['option_c']; ?></td>
                            <td><?php echo $row['option_d']; ?></td>
                            <td style="background-color: <?php echo ($row['selected_option'] == $row['correct_option']) ? 'green' : 'red'; ?>;">
                                <?php echo $row['selected_option']; ?>
                            </td>
                            <td><?php echo $row['correct_option']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

        <?php endwhile; ?>

        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>

<?php
$conn->close();
?>