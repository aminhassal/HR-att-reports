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

// Fetch attendance statistics for the selected month
$selected_month = isset($_POST['month']) ? $_POST['month'] : date('Y-m');
$first_day = date('Y-m-01', strtotime($selected_month));
$last_day = date('Y-m-t', strtotime($selected_month));

// Attendance by date (unique students)
$query_date = "SELECT 
        Date,
        COUNT(CASE WHEN RecordStatus = 'Check In' THEN 1 END) AS PresentCount,
        SUM(RecordStatus IS NULL ) AS AbsentCount
    FROM reportview
    WHERE Date BETWEEN :first_day AND :last_day
    GROUP BY Date
    ORDER BY Date;
";

$stmt_date = $pdo->prepare($query_date);
$stmt_date->execute([':first_day' => $first_day, ':last_day' => $last_day]);
$attendance_by_date = $stmt_date->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for charts
$dates = [];
$present_counts_by_date = [];
$absent_counts_by_date = [];
foreach ($attendance_by_date as $row) {
    $dates[] = $row['Date'];
    $present_counts_by_date[] = $row['PresentCount'];
    $absent_counts_by_date[] = $row['AbsentCount'];
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
    <style>
        body {
            background-color: #f8f9fa;
        }
        h1, h3 {
            color: #333;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>إحصائيات الحضور</h1>

    <!-- Month Selection Form -->
    <form method="POST" class="mb-4">
        <div class="form-group">
            <label for="month">اختر الشهر:</label>
            <input type="month" id="month" name="month" value="<?php echo $selected_month; ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">عرض الإحصائيات</button>
    </form>

    <h3>الحضور حسب اليوم</h3>
    <canvas id="attendanceByDateChart"></canvas>
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
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    fill: true
                },
                {
                    label: 'عدد الطلاب الغائبين',
                    data: <?php echo json_encode($absent_counts_by_date); ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'عدد الطلاب'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'التاريخ'
                    }
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