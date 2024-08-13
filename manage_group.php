<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$group_id = $_GET['group_id'];

// الحصول على معلومات المجموعة
$sql = "SELECT group_name FROM groups WHERE id = $group_id";
$group_result = $conn->query($sql);
$group = $group_result->fetch_assoc();

// الحصول على جميع الطلاب غير المنتمين إلى المجموعة
$sql = "SELECT * FROM users WHERE role = 'student' AND id NOT IN (SELECT student_id FROM group_students WHERE group_id = $group_id)";
$students = $conn->query($sql);

// الحصول على جميع الطلاب المنتمين إلى المجموعة
$sql = "SELECT users.* FROM users JOIN group_students ON users.id = group_students.student_id WHERE group_students.group_id = $group_id";
$group_students = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Group - <?php echo $group['group_name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Manage Group: <?php echo $group['group_name']; ?></h1>

        <h2>Add Students to Group</h2>
        <form method="post" action="add_student_to_group.php">
            <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
            <select name="student_id" required>
                <?php while ($row = $students->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn">Add Student</button>
        </form>

        <h2>Students in Group</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $group_students->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <a href="remove_student_from_group.php?group_id=<?php echo $group_id; ?>&student_id=<?php echo $row['id']; ?>" class="btn btn-danger">Remove</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="view_groups.php" class="btn btn-back">Back to Groups</a>
    </div>
</body>

</html>