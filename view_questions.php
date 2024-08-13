<?php
session_start();
include('db.php');

// Check if exam_id is set in either GET or session
if (isset($_GET['exam_id'])) {
    $exam_id = $_GET['exam_id'];
    $_SESSION['exam_id'] = $exam_id; // Store it in session for later use
} elseif (isset($_SESSION['exam_id'])) {
    $exam_id = $_SESSION['exam_id'];
} else {
    // Redirect to manage exams page if exam_id is not set
    header('Location: view_exams.php');
    exit();
}

// Fetch questions for the selected exam
$sql = "SELECT * FROM questions WHERE exam_id = $exam_id";
$questions = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Questions</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>View Questions for Exam ID: <?php echo $exam_id; ?></h1>
        <table>
            <tr>
                <th>Question ID</th>
                <th>Question Text</th>
                <th>Option A</th>
                <th>Option B</th>
                <th>Option C</th>
                <th>Option D</th>
                <th>Correct Option</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $questions->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['question_text']; ?></td>
                    <td><?php echo $row['option_a']; ?></td>
                    <td><?php echo $row['option_b']; ?></td>
                    <td><?php echo $row['option_c']; ?></td>
                    <td><?php echo $row['option_d']; ?></td>
                    <td><?php echo $row['correct_option']; ?></td>
                    <td>
                        <a href="edit_question.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="delete_question.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="view_exams.php" class="btn btn-back">Back to Exams</a>
    </div>
</body>

</html>