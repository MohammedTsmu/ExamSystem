<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET username='$username', password='$password' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Student account updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM users WHERE id=$id AND role='student'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Student</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $student['username']; ?>" required>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Update Account</button>
    </form>
    <a href="view_students.php">Back to Students List</a>
</body>
</html>
