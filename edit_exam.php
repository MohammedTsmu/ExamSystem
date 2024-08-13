<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$exam_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];

    $sql = "UPDATE exams SET 
            exam_name='$exam_name', 
            exam_date='$exam_date' 
            WHERE id=$exam_id";

    if ($conn->query($sql) === TRUE) {
        echo "Exam updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM exams WHERE id=$exam_id";
$result = $conn->query($sql);
$exam = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Edit Exam</h1>
    <form method="post">
        <label for="exam_name">Exam Name:</label>
        <input type="text" id="exam_name" name="exam_name" value="<?php echo $exam['exam_name']; ?>" required>
        <label for="exam_date">Exam Date:</label>
        <input type="date" id="exam_date" name="exam_date" value="<?php echo $exam['exam_date']; ?>" required>
        <button type="Here is the final updated code for the **edit_exam.php** file:

```php
<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$exam_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];

    $sql = "UPDATE exams SET 
            exam_name='$exam_name', 
            exam_date='$exam_date' 
            WHERE id=$exam_id";

    if ($conn->query($sql) === TRUE) {
        echo "Exam updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM exams WHERE id=$exam_id";
$result = $conn->query($sql);
$exam = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang=" en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Exam</title>
                <link rel="stylesheet" href="style.css">
            </head>

            <body>
                <div class="container">
                    <h1>Edit Exam</h1>
                    <form method="post" class="form">
                        <label for="exam_name">Exam Name:</label>
                        <input type="text" id="exam_name" name="exam_name" value="<?php echo $exam['exam_name']; ?>" required>
                        <label for="exam_date">Exam Date:</label>
                        <input type="date" id="exam_date" name="exam_date" value="<?php echo $exam['exam_date']; ?>" required>
                        <button type="submit" class="btn">Update Exam</button>
                    </form>
                    <a href="view_exams.php" class="btn btn-back">Back to Exams</a>
                </div>
            </body>

</html>