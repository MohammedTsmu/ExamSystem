<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_id = $_POST['group_id'];
    $exam_id = $_POST['exam_id'];

    $sql = "INSERT INTO group_exams (group_id, exam_id) VALUES ('$group_id', '$exam_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Exam added to group successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch available groups
$groups_sql = "SELECT id, group_name FROM groups";
$groups_result = $conn->query($groups_sql);

// Fetch available exams
$exams_sql = "SELECT id, exam_name FROM exams";
$exams_result = $conn->query($exams_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exam to Group</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Add Exam to Group</h1>
        <form method="post" class="form">
            <label for="group_id">Select Group:</label>
            <select id="group_id" name="group_id" required>
                <?php while ($group = $groups_result->fetch_assoc()): ?>
                    <option value="<?php echo $group['id']; ?>"><?php echo $group['group_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="exam_id">Select Exam:</label>
            <select id="exam_id" name="exam_id" required>
                <?php while ($exam = $exams_result->fetch_assoc()): ?>
                    <option value="<?php echo $exam['id']; ?>"><?php echo $exam['exam_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" class="btn">Add Exam</button>
        </form>
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>