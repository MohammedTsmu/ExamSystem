<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_system";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    $conn->select_db($dbname);

    // إنشاء جدول المستخدمين إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20) NOT NULL
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating table: " . $conn->error);
    }

    // إنشاء جدول الامتحانات إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS exams (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        exam_name VARCHAR(100) NOT NULL,
        exam_date DATE NOT NULL
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating exams table: " . $conn->error);
    }

    // إنشاء جدول الأسئلة إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS questions (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        exam_id INT(11) NOT NULL,
        question_text TEXT NOT NULL,
        option_a VARCHAR(255) NOT NULL,
        option_b VARCHAR(255) NOT NULL,
        option_c VARCHAR(255) NOT NULL,
        option_d VARCHAR(255) NOT NULL,
        correct_option CHAR(1) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating questions table: " . $conn->error);
    }

    // إنشاء جدول النتائج إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS results (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        student_id INT(11) NOT NULL,
        exam_id INT(11) NOT NULL,
        score INT(11) NOT NULL,
        exam_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (student_id) REFERENCES users(id),
        FOREIGN KEY (exam_id) REFERENCES exams(id)
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating results table: " . $conn->error);
    }

    // إنشاء جدول الإجابات إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS answers (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        result_id INT(11) NOT NULL,
        student_id INT(11) NOT NULL,
        exam_id INT(11) NOT NULL,
        question_id INT(11) NOT NULL,
        selected_option CHAR(1) NOT NULL,
        FOREIGN KEY (result_id) REFERENCES results(id),
        FOREIGN KEY (student_id) REFERENCES users(id),
        FOREIGN KEY (exam_id) REFERENCES exams(id),
        FOREIGN KEY (question_id) REFERENCES questions(id)
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating answers table: " . $conn->error);
    }

    // إنشاء جدول المجموعات إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS groups (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        group_name VARCHAR(100) NOT NULL
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating groups table: " . $conn->error);
    }

    // إنشاء جدول الطلاب في المجموعات إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS group_students (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        group_id INT(11) NOT NULL,
        student_id INT(11) NOT NULL,
        FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
        FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating group_students table: " . $conn->error);
    }

    // إنشاء جدول الامتحانات في المجموعات إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS group_exams (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        group_id INT(11) NOT NULL,
        exam_id INT(11) NOT NULL,
        FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
        FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating group_exams table: " . $conn->error);
    }

    // إنشاء جدول الجلسات إذا لم يكن موجودًا
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

    // إنشاء جدول لتحليل النتائج إذا لم يكن موجودًا
    $sql = "CREATE TABLE IF NOT EXISTS result_analysis (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        result_id INT(11) NOT NULL,
        question_id INT(11) NOT NULL,
        is_correct BOOLEAN NOT NULL,
        FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE CASCADE,
        FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Error creating result_analysis table: " . $conn->error);
    }

    // التحقق من وجود مستخدمين وإنشاء حساب مدير افتراضي
    $sql = "SELECT COUNT(*) as count FROM users";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        $username = "admin";
        $password = password_hash("admin123", PASSWORD_DEFAULT); // كلمة مرور مشفرة
        $role = "admin";

        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($conn->query($sql) === TRUE) {
            echo "Admin account created: Username: admin, Password: admin123";
        } else {
            die("Error creating admin account: " . $conn->error);
        }
    }
} else {
    die("Error creating database: " . $conn->error);
}
