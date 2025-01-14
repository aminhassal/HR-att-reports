<?php
require 'config.php';
// Database connection
$host = $mysqlhost;
$dbname = $mysqldb;
$username = $mysqlusername;
$password = $mysqlpassword;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Could not connect to the database: ' . $e->getMessage());
}

// Fetch attendance statistics for the last month
$last_month = date('Y-m-d', strtotime('-30 days'));

// Attendance by date (unique students)
$query_date = "SELECT DATE(RecordDate) as Date, 
                      COUNT(DISTINCT CASE WHEN RecordStatus IS NOT NULL THEN Uid END) as PresentCount,
                      COUNT(DISTINCT CASE WHEN RecordStatus IS NULL THEN Uid END) as AbsentCount
               FROM reportview
               WHERE RecordDate >= :last_month
               GROUP BY DATE(RecordDate)";
$stmt_date = $pdo->prepare($query_date);
$stmt_date->execute([':last_month' => $last_month]);
$attendance_by_date = $stmt_date->fetchAll(PDO::FETCH_ASSOC);

// Attendance by subject
$query_subject = "SELECT SubjectName, 
                          COUNT(DISTINCT CASE WHEN RecordStatus IS NOT NULL THEN Uid END) as PresentCount,
                          COUNT(DISTINCT CASE WHEN RecordStatus IS NULL THEN Uid END) as AbsentCount
                   FROM reportview
                   WHERE RecordDate >= :last_month
                   AND SubjectName IS NOT NULL
                   GROUP BY SubjectName";
$stmt_subject = $pdo->prepare($query_subject);
$stmt_subject->execute([':last_month' => $last_month]);
$attendance_by_subject = $stmt_subject->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for charts
$dates = [];
$present_counts_by_date = [];
$absent_counts_by_date = [];
foreach ($attendance_by_date as $row) {
    $dates[] = $row['Date'];
    $present_counts_by_date[] = $row['PresentCount'];
    $absent_counts_by_date[] = $row['AbsentCount'];
}

$subjects = [];
$present_counts_by_subject = [];
$absent_counts_by_subject = [];
foreach ($attendance_by_subject as $row) {
    if (isset($row['SubjectName'])) {
        $subjects[] = $row['SubjectName'];
        $present_counts_by_subject[] = $row['PresentCount'];
        $absent_counts_by_subject[] = $row['AbsentCount'];
    }
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
    <title>Attendance Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1>إحصائيات الحضور</h1>

    <h3>الحضور حسب اليوم</h3>
    <canvas id="attendanceByDateChart"></canvas>

    <h3 class="mt-5">الحضور حسب المادة</h3>
    <canvas id="attendanceBySubjectChart"></canvas>
</div>

<script>
    // Chart for attendance by date
    const ctxDate = document.getElementById('attendanceByDateChart').getContext('2d');
    const attendanceByDateChart = new Chart(ctxDate, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [
                {
                    label: 'عدد الطلاب الحاضرين',
                    data: <?php echo json_encode($present_counts_by_date); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                },
                {
                    label: 'عدد الطلاب الغائبين',
                    data: <?php echo json_encode($absent_counts_by_date); ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart for attendance by subject
    const ctxSubject = document.getElementById('attendanceBySubjectChart').getContext('2d');
    const attendanceBySubjectChart = new Chart(ctxSubject, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($subjects); ?>,
            datasets: [
                {
                    label: 'عدد الطلاب الحاضرين',
                    data: <?php echo json_encode($present_counts_by_subject); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'عدد الطلاب الغائبين',
                    data: <?php echo json_encode($absent_counts_by_subject); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</body>
</html>