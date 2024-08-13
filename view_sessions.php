<?php
session_start();
include('db.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sessions</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function fetchSessions() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_sessions_status.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    var sessions = JSON.parse(this.responseText);
                    var output = '';

                    sessions.forEach(function(session) {
                        output += `
                            <tr>
                                <td>${session.session_id}</td>
                                <td>${session.username}</td>
                                <td>${session.start_time}</td>
                                <td>${session.end_time ? session.end_time : 'N/A'}</td>
                                <td>${session.status}</td>
                            </tr>
                        `;
                    });

                    document.getElementById('sessionsTable').innerHTML = output;
                }
            };
            xhr.send();
        }

        setInterval(fetchSessions, 5000); // تحديث كل 5 ثوانٍ
    </script>
</head>

<body>
    <div class="container">
        <h1>عرض الجلسات</h1>
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
            <tbody id="sessionsTable">
                <!-- سيتم تحديث الجلسات هنا بواسطة JavaScript -->
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-back">العودة إلى لوحة التحكم</a>
    </div>
</body>

</html>