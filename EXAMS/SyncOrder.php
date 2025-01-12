<?php
include("zklib/zklib.php");
include("DAL/Test.php");

$zk = new ZKLib("192.168.1.201", 4370);
$tst = new DAL();
$tstInfo = new DAL_INF();
$ret = $zk->connect();

try {
    $users = $zk->getUser();
    sleep(1);
    
    $allUserData = [];

    foreach ($users as $uid => $userdata) :
        if ($userdata[2] == LEVEL_ADMIN) {
            $role = 'ADMIN';
        } elseif ($userdata[2] == LEVEL_USER) {
            $role = 'USER';
        } else {
            $role = 'Unknown';
        }

        $allUserData[] = [
            'id' => $userdata[0],
            'name' => $userdata[1],
            'role' => $role,
            'other_info' => $userdata[3],
        ];
    endforeach;

    $tstdeleteInfo = new DAL();
    $tstdeleteInfo->deleteinfos();

    foreach ($allUserData as $userData) {
        $tstInfo->sqlInsertoinfo($userData['id'], $userData['id'], $userData['name'], $userData['other_info']);
    }

} catch (Exception $e) {
    header("HTTP/1.0 404 Not Found");
    header('HTTP', true, 500); // 500 internal server error                
}
?>
//----------------------------------
<?php
$attendance = $zk->getAttendance();
sleep(1);

foreach ($attendance as $idx => $attendancedata) {
    if ($attendancedata[2] == 14) {
        $status = 'Check Out';
    } else {
        $status = 'Check In';
    }

    // You can use $idx and $status here for further processing.
    // For example:
    echo "Index: $idx, Status: $status\n";
}
?>

<?php
   $tst->sqlInserto(
        $attendancedata[1],
        $status,
        date('Y-m-d', strtotime($attendancedata[3])),
        date("H:i:s", strtotime($attendancedata[3]))
    );
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit()
?>