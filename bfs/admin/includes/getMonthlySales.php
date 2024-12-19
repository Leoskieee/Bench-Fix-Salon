<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('dbconnection.php');

// Query to fetch the total sales per month (sum of Service_Total_Price)
$query = "
    SELECT MONTH(AptDate) as month, SUM(Service_Total_Price) as total_sales
    FROM tblbook
    WHERE YEAR(AptDate) = YEAR(CURDATE()) AND deleted_at IS NULL
    GROUP BY month";
          
$result = $con->query($query);

$salesData = array();
while ($row = $result->fetch_assoc()) {
    $salesData[] = $row;
}

// Return JSON response
echo json_encode($salesData);

$con->close();
