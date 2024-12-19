<?php
// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('dbconnection.php');

// Get the date from the GET request
$date = $_GET['date'];

// Query to count the appointments for the given date
$countQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE AptDate = '$date'");
$countResult = mysqli_fetch_array($countQuery);
$totalAppointments = $countResult['total'];

// Return the total number of appointments as the response
echo $totalAppointments;