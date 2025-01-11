<?php
// Database connection
$host = 'localhost';
$dbname = 'hr';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Initialize variables for date filter
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

// Prepare SQL query with date filter
$query = 'SELECT * FROM records';
$params = [];

if ($start_date) {
    $query .= ' AND RecordTime >= :start_date';
    $params[':start_date'] = $start_date;
}

if ($end_date) {
    $query .= ' AND RecordTime <= :end_date';
    $params[':end_date'] = $end_date;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
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

<h1>Data Report</h1>

<form method="post">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
    
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
    
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>time</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['StudentUID']); ?></td>
                <td><?php echo htmlspecialchars($row['RecordStatus']); ?></td>
                <td><?php echo htmlspecialchars($row['RecordDate']); ?></td>
                <td><?php echo htmlspecialchars($row['RecordTime']); ?></td>
                <!-- Add more columns as needed -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<button class="print-button" onclick="window.print()">Print Report</button>

</body>
</html>