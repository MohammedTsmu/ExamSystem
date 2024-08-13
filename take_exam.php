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

$score = null;
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
            echo "<p class='error-msg'>لم يتم تقديم إجابة للسؤال ID: " . $question['id'] . "</p>";
        }
    }

    // تحديث النتيجة
    $update_result_sql = "UPDATE results SET score = $score WHERE id = $result_id";
    $conn->query($update_result_sql);

    // إنهاء الجلسة
    $session_end_sql = "UPDATE sessions SET end_time = NOW(), status = 'ended' WHERE user_id = '$student_id' AND status = 'active'";
    $conn->query($session_end_sql);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اجراء الامتحان</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>اجراء الامتحان</h1>
        <form method="post" class="form">
            <?php foreach ($questions as $question) : ?>
                <div class="question-container">
                    <p class="question-text"><?php echo $question['question_text']; ?></p>
                    <label class="option">
                        <input type="radio" name="question_<?php echo $question['id']; ?>" value="A" required>
                        <?php echo $question['option_a']; ?>
                    </label>
                    <label class="option">
                        <input type="radio" name="question_<?php echo $question['id']; ?>" value="B" required>
                        <?php echo $question['option_b']; ?>
                    </label>
                    <label class="option">
                        <input type="radio" name="question_<?php echo $question['id']; ?>" value="C" required>
                        <?php echo $question['option_c']; ?>
                    </label>
                    <label class="option">
                        <input type="radio" name="question_<?php echo $question['id']; ?>" value="D" required>
                        <?php echo $question['option_d']; ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <button type="submit" name="submit_answers" class="btn">ارسال الاجوبة</button>
        </form>
        <?php if ($score !== null) : ?>
            <div class="result-container">
                <p class='success-msg'>حصلت على: <?php echo $score . "/" . $questions->num_rows; ?></p>
                <a href='exam_details.php' class='btn'>مراجعة الامتحانات السابقة</a>
            </div>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-back">العودة الى لوحة التحكم</a>
    </div>
</body>

</html>