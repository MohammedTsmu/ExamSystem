<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM users WHERE role = 'student'";
$students = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Student Accounts</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $students->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn-action">Edit</a>
                        <a href="delete_student.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" class="btn-action btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="dashboard.php" class="btn btn-back">Back to Dashboard</a>
    </div>
</body>

</html>