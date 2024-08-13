<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_id = $_POST['group_id'];

    // Delete the group and cascade to linked exams and students
    $sql = "DELETE FROM groups WHERE id = '$group_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Group deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all groups
$groups_sql = "SELECT * FROM groups";
$groups_result = $conn->query($groups_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Group</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Delete Group</h1>
        <?php if ($groups_result->num_rows > 0): ?>
            <ul>
                <?php while ($group = $groups_result->fetch_assoc()): ?>
                    <li>
                        <form method="post" action="">
                            <input type="hidden" name="group_id" value="<?php echo $group['id']; ?>">
                            <?php echo $group['group_name']; ?>
                            <button type="submit" class="btn btn-remove">Delete Group</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No groups found.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>

<?php
$conn->close();
?>