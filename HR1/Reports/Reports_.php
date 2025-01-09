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

// Initialize variables for filters
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$subject_name = isset($_POST['subject_name']) ? $_POST['subject_name'] : ''; // تغيير هنا

// Prepare SQL query with filters
$query = 'SELECT * FROM `student_records` WHERE 1=1';
$params = [];

// Add conditions if dates are provided
if ($start_date) {
    $query .= " AND STR_TO_DATE(RecordDate, '%Y-%m-%d') >= :start_date";
    $params[':start_date'] = $start_date;
}

if ($end_date) {
    $query .= " AND STR_TO_DATE(RecordDate, '%Y-%m-%d') <= :end_date";
    $params[':end_date'] = $end_date;
}

// Add condition for subject if provided
if ($subject_name) {
    $query .= " AND SubjectName = :subject_name"; // استخدام SubjectName
    $params[':subject_name'] = $subject_name;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subjects = []; // Initialize an array to hold subjects

// Fetch subjects from the database
$query2 = "SELECT SubjectName FROM subjects"; // تعديل هنا لجلب SubjectName فقط
$result = mysqli_query($con, $query2);

while ($row = mysqli_fetch_assoc($result)) {
    $subjects[] = $row;
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
    <title>Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12pt;
                color: #000;
            }

            .print-button {
                display: none;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .print-button {
            margin: 20px 0;
        }
    </style>
</head>

<body>
<h1 align='right'>تقرير الحضور والانصراف</h1>

<form method='post'>
    <div class='card-header' style='display: flex; align-items: center; gap: 10px;'>
        <div class='container mt-4' align='left'>
            <h4>
                <button type="button" class='print-button btn btn-success' onclick='window.print()'>طباعة التقرير</button>
            </h4>
        </div>

        <button type='submit' class='btn btn-success'>فلترة</button>

        <input type='date' id='start_date' name='start_date' value="<?php echo htmlspecialchars($start_date); ?>">
        <label for='start_date'>تاريخ البداية</label>

        <input type='date' id='end_date' name='end_date' value="<?php echo htmlspecialchars($end_date); ?>">
        <label for='end_date'>تاريخ النهاية</label>

        <!-- Subject Filter -->
        <select name='subject_name' id='subject_name'> <!-- تعديل هنا لتتناسب مع المتغير -->
            <option value="">اختر المادة</option>
            <?php foreach ($subjects as $subject): ?>
                <option value="<?php echo htmlspecialchars($subject['SubjectName']); ?>">
                    <?php echo htmlspecialchars($subject['SubjectName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for='subject_name'>اسم المادة</label>
    </div>
</form>

<table>
    <thead>
        <tr>
            <th>الرقم</th>
            <th>إسم الطالب</th>
            <th>حالة البصمة</th>
            <th>تاريخ البصمة</th>
            <th>وقت البصمة</th>
            <th>اسم المادة</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['InRollNumber']); ?></td>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td><?php echo htmlspecialchars($row['RecordStatus']); ?></td>
            <td><?php echo htmlspecialchars($row['RecordDate']); ?></td>
            <td><?php echo htmlspecialchars($row['RecordTime']); ?></td>
            <td><?php echo htmlspecialchars($row['SubjectName']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
</body>

</html>