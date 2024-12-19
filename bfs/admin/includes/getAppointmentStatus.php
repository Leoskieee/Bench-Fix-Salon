<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('dbconnection.php');

// Query to fetch appointment status counts
$query = "SELECT 
            CASE 
              WHEN Status = 'Confirmed' THEN 'confirmed'
              WHEN Status = 'Rejected' THEN 'rejected'
              WHEN Status IS NULL THEN 'pending' -- Treat NULL as 'pending'
              ELSE 'other'
            END as status,
            COUNT(*) as count
          FROM tblbook
          WHERE deleted_at IS NULL
          GROUP BY status";

$result = $con->query($query);

$statusData = array('confirmed' => 0, 'pending' => 0, 'rejected' => 0);

while ($row = $result->fetch_assoc()) {
    $status = $row['status'];
    $count = (int)$row['count'];
    if (isset($statusData[$status])) {
        $statusData[$status] = $count;
    }
}

// Return JSON response
echo json_encode($statusData);

$con->close();
