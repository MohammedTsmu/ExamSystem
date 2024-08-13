<?php
include('db.php');

$sql = "SELECT s.session_id, u.username, s.start_time, s.end_time, s.status 
        FROM sessions s 
        JOIN users u ON s.user_id = u.id 
        ORDER BY s.start_time DESC";
$sessions = $conn->query($sql);

$sessions_data = array();
while ($row = $sessions->fetch_assoc()) {
    $sessions_data[] = $row;
}

echo json_encode($sessions_data);
$conn->close();
