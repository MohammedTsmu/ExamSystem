<?php
include('db.php');

$sql = "SELECT s.session_id, u.username, s.start_time, s.end_time, s.status,
        TIMESTAMPDIFF(SECOND, s.start_time, IFNULL(s.end_time, NOW())) AS duration_in_seconds
        FROM sessions s
        JOIN users u ON s.user_id = u.id
        ORDER BY s.start_time DESC";

$result = $conn->query($sql);

$sessions = [];
while ($row = $result->fetch_assoc()) {
    $sessions[] = $row;
}

echo json_encode($sessions);
$conn->close();
