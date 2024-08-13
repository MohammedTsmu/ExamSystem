session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
header('Location: login.php');
exit();
}

$student_id = $_GET['student_id'];
$exam_id = $_GET['exam_id'];

// جلب تفاصيل النتيجة
$sql = "SELECT r.*, u.username, e.exam_name
FROM results r
JOIN users u ON r.student_id = u.id
JOIN exams e ON r.exam_id = e.id
WHERE r.student_id = $student_id AND r.exam_id = $exam_id";
$result = $conn->query($sql);
$details = $result->fetch_assoc();

// جلب تفاصيل الإجابات
$sql = "SELECT q.question_text, q.correct_option, a.selected_option
FROM answers a
JOIN questions q ON a.question_id = q.id
WHERE a.result_id = " . $details['id'];
$answers = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير النتائج التفصيلية</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>تقارير النتائج التفصيلية</h1>
        <h2>الطالب: <?php echo $details['username']; ?></h2>
        <h2>الامتحان: <?php echo $details['exam_name']; ?></h2>
        <h2>الدرجة: <?php echo $details['score']; ?></h2>
        <h2>إجابات صحيحة: <?php echo $details['total_correct']; ?></h2>
        <h2>إجابات خاطئة: <?php echo $details['total_incorrect']; ?></h2>
        <table>
            <thead>
                <tr>
                    <th>السؤال</th>
                    <th>الإجابة الصحيحة</th>
                    <th>إجابتك</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($answer = $answers->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $answer['question_text']; ?></td>
                        <td><?php echo $answer['correct_option']; ?></td>
                        <td style="color: <?php echo $answer['selected_option'] == $answer['correct_option'] ? 'green' : 'red'; ?>;">
                            <?php echo $answer['selected_option']; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="view_results.php" class="btn btn-back">العودة إلى النتائج</a>
    </div>
</body>

</html>