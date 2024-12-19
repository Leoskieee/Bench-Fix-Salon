<?php
// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('dbconnection.php');

if (isset($_GET['checkTimeAvailability'])) {
    $adate = $_GET['adate'];
    $atime = $_GET['atime'];

    $hourlyQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE AptDate = '$adate' AND AptTime = '$atime'");
    $hourlyResult = mysqli_fetch_array($hourlyQuery);
    $totalHourlyAppointments = $hourlyResult['total'];

    if ($totalHourlyAppointments < 1) {
        echo json_encode(['available' => true]);
    } else {
        echo json_encode(['available' => false]);
    }

    exit();
}
