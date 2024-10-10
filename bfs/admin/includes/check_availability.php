<?php
// include('includes/dbconnection.php');

if (isset($_GET['date'])) {
    $adate = $_GET['date'];

    // Check how many appointments exist for the selected date
    $countQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE AptDate = '$adate'");
    $countResult = mysqli_fetch_array($countQuery);
    $totalAppointments = $countResult['total'];

    // Return a JSON response
    echo json_encode(['fully_booked' => $totalAppointments >= 10]);
}