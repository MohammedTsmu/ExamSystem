<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_id = $_POST['exam_id'];
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];
    
    $sql = "INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option) 
            VALUES ('$exam_id', '$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New question added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM exams";
$exams = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Question</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add New Question</h1>
    <form method="post">
        <label for="exam_id">Select Exam:</label>
        <select id="exam_id" name="exam_id" required>
            <?php while($row = $exams->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['exam_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <label for="question_text">Question:</label>
        <input type="text" id="question_text" name="question_text" required>
        <label for="option_a">Option A:</label>
        <input type="text" id="option_a" name="option_a" required>
        <label for="option_b">Option B:</label>
        <input type="text" id="option_b" name="option_b" required>
        <label for="option_c">Option C:</label>
        <input type="text" id="option_c" name="option_c" required>
        <label for="option_d">Option D:</label>
        <input type="text" id="option_d" name="option_d" required>
        <label for="correct_option">Correct Option (A, B, C, or D):</label>
        <input type="text" id="correct_option" name="correct_option" required>
        <button type="submit">Add Question</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
