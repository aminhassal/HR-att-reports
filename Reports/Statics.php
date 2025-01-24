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

// Fetch monthly attendance totals
$query_monthly = "SELECT 
    COUNT(CASE WHEN RecordStatus = 'Check In' THEN 1 END) AS PresentCount,
    SUM(RecordStatus IS NULL) AS AbsentCount
FROM reportview
WHERE Date BETWEEN :first_day AND :last_day";

$stmt_monthly = $pdo->prepare($query_monthly);
$stmt_monthly->execute([':first_day' => $first_day, ':last_day' => $last_day]);
$monthly_totals = $stmt_monthly->fetch(PDO::FETCH_ASSOC);

$present_count = $monthly_totals['PresentCount'] ?? 0;
$absent_count = $monthly_totals['AbsentCount'] ?? 0;
$total_count = $present_count + $absent_count;

// Fetch daily attendance data
$query_daily = "SELECT 
    Date,
    COUNT(CASE WHEN RecordStatus = 'Check In' THEN 1 END) AS PresentCount,
    SUM(RecordStatus IS NULL) AS AbsentCount
FROM reportview
WHERE Date BETWEEN :first_day AND :last_day
GROUP BY Date
ORDER BY Date";

$stmt_daily = $pdo->prepare($query_daily);
$stmt_daily->execute([':first_day' => $first_day, ':last_day' => $last_day]);
$attendance_by_date = $stmt_daily->fetchAll(PDO::FETCH_ASSOC);

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
        .chart-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        canvas {
            max-width: 100%; /* اجعل الحجم متكيفًا مع العرض */
            max-height: 390px; /* ارتفاع أقل للرسم */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">إحصائيات الحضور</h1>

    <!-- Month Selection Form -->
    <form method="POST" class="mb-4 text-center">
        <div class="form-group">
            <label for="month">اختر الشهر:</label>
            <input type="month" id="month" name="month" value="<?php echo $selected_month; ?>" class="form-control w-50 mx-auto" required>
        </div>
        <button type="submit" class="btn btn-primary">عرض الإحصائيات</button>
    </form>

    <!-- Line Chart: Daily Attendance -->
    <div class="chart-container">
        <h3 class="text-center">الحضور حسب اليوم</h3>
        <canvas id="attendanceByDateChart"></canvas>
    </div>

    <!-- Doughnut Chart: Monthly Attendance -->
    <div class="chart-container">
        <h3 class="text-center">إحصائيات الشهر</h3>
        <canvas id="monthlyAttendanceChart"></canvas>
    </div>
</div>

<script>
    // Line Chart: Attendance by Date
    const ctxDate = document.getElementById('attendanceByDateChart').getContext('2d');
    new Chart(ctxDate, {
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
            maintainAspectRatio: false,
            scales: {
    y: {
        beginAtZero: true,
        title: {
            display: true,
            text: 'عدد الطلاب'
        },
        ticks: {
            stepSize: 1, // تحديد الخطوة بين كل رقمين
            callback: function(value) {
                if (Number.isInteger(value)) {
                    return value; // عرض الأعداد الصحيحة فقط
                }
            }
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

    // Doughnut Chart: Monthly Attendance
    const ctxMonthly = document.getElementById('monthlyAttendanceChart').getContext('2d');
    new Chart(ctxMonthly, {
        type: 'doughnut',
        data: {
            labels: ['حاضر', 'غائب'],
            datasets: [{
                data: [<?php echo $present_count; ?>, <?php echo $absent_count; ?>],
                backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = <?php echo $total_count; ?>;
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${label}: ${value} (${percentage}%)`;
                        }
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
