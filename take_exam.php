<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

if (isset($_POST['exam_id'])) {
    $exam_id = $_POST['exam_id'];
    $_SESSION['exam_id'] = $exam_id;
} else {
    $exam_id = $_SESSION['exam_id'];
}

$sql = "SELECT * FROM questions WHERE exam_id = $exam_id";
$questions = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_answers'])) {
    $score = 0;
    $student_id = $_SESSION['user_id'];
    $exam_date = date('Y-m-d H:i:s');

    // حفظ نتيجة الامتحان
    $result_sql = "INSERT INTO results (student_id, exam_id, score, exam_date) 
                   VALUES ('$student_id', '$exam_id', 0, '$exam_date')";
    $conn->query($result_sql);
    $result_id = $conn->insert_id;

    foreach ($questions as $question) {
        $selected_option = $_POST['question_' . $question['id']] ?? null;

        if ($selected_option !== null) {
            // حفظ إجابة الطالب
            $answer_sql = "INSERT INTO answers (result_id, student_id, exam_id, question_id, selected_option) 
                           VALUES ('$result_id', '$student_id', '$exam_id', '" . $question['id'] . "', '$selected_option')";
            $conn->query($answer_sql);

            if ($selected_option == $question['correct_option']) {
                $score++;
            }
        } else {
            echo "No answer provided for question ID: " . $question['id'];
        }
    }

    // تحديث النتيجة بعد حساب الدرجة
    $update_result_sql = "UPDATE results SET score = $score WHERE id = $result_id";
    $conn->query($update_result_sql);

    echo "You scored: $score/" . $questions->num_rows;
    echo "<br><a href='exam_details.php'>Review Old Exams</a>"; // رابط لمراجعة الامتحانات السابقة
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Exam</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Take Exam</h1>
    <form method="post">
        <?php foreach ($questions as $question) : ?>
            <p><?php echo $question['question_text']; ?></p>
            <input type="radio" name="question_<?php echo $question['id']; ?>" value="A" required> <?php echo $question['option_a']; ?><br>
            <input type="radio" name="question_<?php echo $question['id']; ?>" value="B" required> <?php echo $question['option_b']; ?><br>
            <input type="radio" name="question_<?php echo $question['id']; ?>" value="C" required> <?php echo $question['option_c']; ?><br>
            <input type="radio" name="question_<?php echo $question['id']; ?>" value="D" required> <?php echo $question['option_d']; ?><br>
        <?php endforeach; ?>
        <button type="submit" name="submit_answers">Submit Answers</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>

</html>