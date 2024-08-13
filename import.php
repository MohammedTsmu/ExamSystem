<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$backup_file = 'backup/exam_system_backup.sql';
$command = "C:/xampp/mysql/bin/mysql --user=root --password= --host=localhost exam_system < $backup_file";

// تنفيذ الأمر لاستيراد قاعدة البيانات
exec($command, $output, $return_var);

if ($return_var === 0) {
    echo "Database imported successfully!";
} else {
    echo "Error importing database.";
}
