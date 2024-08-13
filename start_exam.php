<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['user_id'];

// تحقق من وجود مجموعة مرتبطة بالطالب
$sql = "SELECT group_id FROM group_students WHERE student_id = $student_id";
$group_result = $conn->query($sql);

if ($group_result->num_rows > 0) {
    $group_row = $group_result->fetch_assoc();
    $group_id = $group_row['group_id'];

    // جلب الامتحانات المرتبطة بالمجموعة
    $sql = "SELECT exams.* FROM exams 
            JOIN group_exams ON exams.id = group_exams.exam_id 
            WHERE group_exams.group_id = $group_id";
    $exams = $conn->query($sql);

    if ($exams->num_rows > 0) {
        // إنشاء أو تحديث الجلسة فقط إذا كان هناك امتحانات
        $sql = "INSERT INTO sessions (user_id, start_time, status) 
                VALUES ($student_id, NOW(), 'active')
                ON DUPLICATE KEY UPDATE start_time = NOW(), status = 'active'";
        $conn->query($sql);

        // عرض صفحة الامتحانات
?>
        <!DOCTYPE html>
        <html lang="ar">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>اختيار الامتحان</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <div class="container">
                <h1>اختيار الامتحان</h1>
                <form method="post" action="take_exam.php">
                    <label for="exam_id">اختر امتحان:</label>
                    <select id="exam_id" name="exam_id" required>
                        <?php while ($exam = $exams->fetch_assoc()) : ?>
                            <option value="<?php echo $exam['id']; ?>"><?php echo $exam['exam_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                    <button type="submit" class="btn">بدء الامتحان</button>
                </form>
                <a href="dashboard.php" class="btn btn-back">العودة إلى لوحة التحكم</a>
            </div>
        </body>

        </html>
<?php
    } else {
        // إنهاء الجلسة إذا لم يكن هناك امتحانات متاحة
        $session_end_sql = "UPDATE sessions SET end_time = NOW(), status = 'ended' 
                            WHERE user_id = '$student_id' AND status = 'active'";
        $conn->query($session_end_sql);

        echo "<div class='container'>";
        echo "<p>لا توجد امتحانات متاحة حاليًا لمجموعتك.</p>";
        echo "<a href='dashboard.php' class='btn btn-back'>العودة إلى لوحة التحكم</a>";
        echo "</div>";
    }
} else {
    // إنهاء الجلسة إذا لم يكن الطالب مرتبطًا بأي مجموعة
    $session_end_sql = "UPDATE sessions SET end_time = NOW(), status = 'ended' 
                        WHERE user_id = '$student_id' AND status = 'active'";
    $conn->query($session_end_sql);

    echo "<div class='container'>";
    echo "<p>أنت غير مرتبط بأي مجموعة.</p>";
    echo "<a href='dashboard.php' class='btn btn-back'>العودة إلى لوحة التحكم</a>";
    echo "</div>";
}

$conn->close();
?>