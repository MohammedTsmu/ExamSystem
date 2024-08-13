<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// تأكد من وجود مجلد backup وإنشائه إذا لم يكن موجودًا
if (!is_dir('backup')) {
    mkdir('backup', 0777, true);
}

$backup_file = 'backup/exam_system_backup.sql';
$command = "C:/xampp/mysql/bin/mysqldump --user=root --password= --host=localhost exam_system > $backup_file";

exec($command, $output, $return_var);

if ($return_var === 0) {
    echo "Backup created successfully!";
} else {
    echo "Error creating backup.";
}
