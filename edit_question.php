<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$question_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_text = $_POST['question_text'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    $sql = "UPDATE questions SET 
            question_text='$question_text', 
            option_a='$option_a', 
            option_b='$option_b', 
            option_c='$option_c', 
            option_d='$option_d', 
            correct_option='$correct_option' 
            WHERE id=$question_id";

    if ($conn->query($sql) === TRUE) {
        echo "Question updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM questions WHERE id=$question_id";
$result = $conn->query($sql);
$question = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Edit Question</h1>
    <form method="post">
        <label for="question_text">Question:</label>
        <input type="text" id="question_text" name="question_text" value="<?php echo $question['question_text']; ?>" required>
        <label for="option_a">Option A:</label>
        <input type="text" id="option_a" name="option_a" value="<?php echo $question['option_a']; ?>" required>
        <label for="option_b">Option B:</label>
        <input type="text" id="option_b" name="option_b" value="<?php echo $question['option_b']; ?>" required>
        <label for="option_c">Option C:</label>
        <input type="text" id="option_c" name="option_c" value="<?php echo $question['option_c']; ?>" required>
        <label for="option_d">Option D:</label>
        <input type="text" id="option_d" name="option_d" value="<?php echo $question['option_d']; ?>" required>
        <label for="correct_option">Correct Option (A, B, C, or D):</label>
        <input type="text" id="correct_option" name="correct_option" value="<?php echo $question['correct_option']; ?>" required>
        <button type="submit">Update Question</button>
    </form>
    <a href="view_exams.php">Back to Exams</a>
</body>

</html>