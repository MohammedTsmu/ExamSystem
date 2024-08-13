<?php
include('db.php');

// تحديث قاعدة البيانات بإضافة جدول الجلسات
$sql = "CREATE TABLE IF NOT EXISTS sessions (
    session_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME DEFAULT NULL,
    status ENUM('active', 'ended', 'suspended') NOT NULL DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating sessions table: " . $conn->error);
}

$conn->close();

echo "Database updated successfully!";
