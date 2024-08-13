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
        echo "<p class='success-msg'>Student account updated successfully!</p>";
    } else {
        echo "<p class='error-msg'>Error: " . $conn->error . "</p>";
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
    <div class="container">
        <h1>Edit Student</h1>
        <form method="post" class="form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $student['username']; ?>" required>

            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Update Account</button>
        </form>
        <a href="view_students.php" class="btn btn-back">Back to Students List</a>
    </div>
</body>

</html>