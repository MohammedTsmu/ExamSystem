<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الجلسات</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function formatDuration(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);

            return `<span>${hours.toString().padStart(2, '0')}</span> س <span>${minutes.toString().padStart(2, '0')}</span> د`;
        }

        function fetchSessions() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_sessions_status.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    var sessions = JSON.parse(this.responseText);
                    var output = '';

                    sessions.forEach(function(session) {
                        const duration = formatDuration(session.duration_in_seconds);
                        output += `
                            <tr>
                                <td>${session.session_id}</td>
                                <td>${session.username}</td>
                                <td>${session.start_time}</td>
                                <td>${session.end_time ? session.end_time : 'N/A'}</td>
                                <td>${session.status}</td>
                                <td>${duration}</td>
                            </tr>
                        `;
                    });

                    document.getElementById('sessionsTable').innerHTML = output;
                }
            };
            xhr.send();
        }

        setInterval(fetchSessions, 1000); // تحديث كل ثانية
    </script>
</head>

<body onload="fetchSessions()">
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
                    <th>الوقت المستغرق</th> <!-- العمود الجديد -->
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