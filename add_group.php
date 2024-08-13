<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_name = $_POST['group_name'];

    $sql = "INSERT INTO groups (group_name) VALUES ('$group_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Group added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Group</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Add New Group</h1>
        <form method="post" class="form">
            <label for="group_name">Group Name:</label>
            <input type="text" id="group_name" name="group_name" required>
            <button type="submit" class="btn">Add Group</button>
        </form>
        <a href="view_groups.php" class="btn btn-back">Back to Groups</a>
    </div>
</body>

</html>