<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// SQL query to fetch session details
$sql = "SELECT s.session_id, u.username, s.start_time, s.end_time, s.status 
        FROM sessions s 
        JOIN users u ON s.user_id = u.id 
        ORDER BY s.start_time DESC";

$sessions = $conn->query($sql);

if (!$sessions) {
    die("Error fetching sessions: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sessions</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>عرض الجلسات</h1>
        <?php if ($sessions->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>معرف الجلسة</th>
                        <th>اسم المستخدم</th>
                        <th>وقت البدء</th>
                        <th>وقت الانتهاء</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($session = $sessions->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $session['session_id']; ?></td>
                            <td><?php echo $session['username']; ?></td>
                            <td><?php echo $session['start_time']; ?></td>
                            <td><?php echo $session['end_time']; ?></td>
                            <td><?php echo $session['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>لا توجد جلسات لعرضها.</p>
        <?php endif; ?>
        <a href="dashboard.php" class="btn btn-back">العودة إلى لوحة التحكم</a>
    </div>
</body>

</html>