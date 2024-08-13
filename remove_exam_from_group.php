<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_id = $_POST['group_id'];
    $exam_id = $_POST['exam_id'];

    $sql = "DELETE FROM group_exams WHERE group_id = '$group_id' AND exam_id = '$exam_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Exam removed from group successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch groups with linked exams
$groups_sql = "SELECT DISTINCT g.id, g.group_name 
               FROM groups g 
               JOIN group_exams ge ON g.id = ge.group_id";
$groups_result = $conn->query($groups_sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Exam from Group</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Remove Exam from Group</h1>

        <?php if ($groups_result->num_rows > 0): ?>
            <?php while ($group = $groups_result->fetch_assoc()): ?>
                <div class="group-block">
                    <h2><?php echo $group['group_name']; ?></h2>
                    <?php
                    $group_id = $group['id'];
                    $exams_sql = "SELECT e.id, e.exam_name 
                                  FROM exams e 
                                  JOIN group_exams ge ON e.id = ge.exam_id 
                                  WHERE ge.group_id = '$group_id'";
                    $exams_result = $conn->query($exams_sql);
                    ?>

                    <?php if ($exams_result->num_rows > 0): ?>
                        <ul>
                            <?php while ($exam = $exams_result->fetch_assoc()): ?>
                                <li>
                                    <form method="post" action="">
                                        <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
                                        <input type="hidden" name="exam_id" value="<?php echo $exam['id']; ?>">
                                        <?php echo $exam['exam_name']; ?>
                                        <button type="submit" class="btn btn-remove">Remove</button>
                                    </form>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>No exams linked to this group.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No groups have exams linked to them.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>

<?php
$conn->close();
?>