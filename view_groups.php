<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM groups";
$groups = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Groups</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Manage Groups</h1>
        <table>
            <tr>
                <th>Group Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $groups->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['group_name']; ?></td>
                    <td>
                        <a href="manage_group.php?group_id=<?php echo $row['id']; ?>" class="btn">Manage Students</a>
                        <a href="delete_group.php?group_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>