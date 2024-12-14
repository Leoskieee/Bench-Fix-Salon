<?php
// Include TCPDF library (assuming it's installed via Composer or directly included)
require_once('tcpdf/tcpdf.php');

// Fetch data from database
include('includes/dbconnection.php');

// Fetch the data you want in your report
$query1 = mysqli_query($con, "SELECT COUNT(*) as total FROM tbluser");
$row1 = mysqli_fetch_assoc($query1);
$totalcust = $row1['total'];

$query2 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook");
$row2 = mysqli_fetch_assoc($query2);
$totalappointment = $row2['total'];

$totalaccepted = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblbook WHERE Status='Confirmed'"));

$totalrejected = mysqli_num_rows(mysqli_query($con, "select * from tblbook where Status='Rejected'"));

// today sales
$todaysale = 0;
$query6 = mysqli_query($con, "
		SELECT SUM(tblservices.Cost) as total
		FROM tblinvoice
		JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
		WHERE DATE(tblinvoice.PostingDate) = CURDATE();
");
$row6 = mysqli_fetch_assoc($query6);
$todaySales = $row6['total'];

$query7 = mysqli_query($con, "
		SELECT SUM(tblservices.Cost) as total
		FROM tblinvoice
		JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
		WHERE DATE(tblinvoice.PostingDate) = CURDATE() - INTERVAL 1 DAY;
");
$row7 = mysqli_fetch_assoc($query7);
$yesterdaySales = $row7['total'] ?? 0;

$query8 = mysqli_query($con, "
		SELECT SUM(tblservices.Cost) as total
		FROM tblinvoice
		JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
		WHERE DATE(tblinvoice.PostingDate) >= CURDATE() - INTERVAL 7 DAY;
");
$row8 = mysqli_fetch_assoc($query8);
$lastWeekSales = $row8['total'] ?? 0;

$result = mysqli_query($con, "SELECT SUM(tblservices.Cost) AS totalSales
    FROM tblinvoice
    JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId");

$row = mysqli_fetch_assoc($result);
$totalSales = $row['totalSales']; // This will now contain the total sales amount


// Create new PDF document
$pdf = new TCPDF();
$pdf->AddPage();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Dashboard Report');

// Add content in table format
$html = <<<EOD
<style>
  @import url('https://fonts.googleapis.com/css2?family=Anta&family=Host+Grotesk:ital,wght@0,300..800;1,300..800&display=swap');
  
  body {
    font-family: Helvetica, Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 20px;
  }

  h1 {
    text-align: center;
    color: #2c3e50;
  }

  h2 {
    color: #2980b9;
    border-bottom: 2px solid #2980b9;
    padding-bottom: 5px;
  }

  table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
  }

  table th, table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
  }

  table th {
    background-color: #2980b9;
    color: #fff;
  }

  table tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .total {
    margin-top: 20px;
    font-size: 16px;
    font-weight: bold;
    color: green;
  }
</style>
<h1>Dashboard Report</h1>

<h2>Customers</h2>
<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th><strong>Metric</strong></th>
            <th><strong>Value</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Customers</td>
            <td>{$totalcust}</td>
        </tr>
    </tbody>
</table>

<h2>Appointments</h2>
<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th><strong>Metric</strong></th>
            <th><strong>Value</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Appointments</td>
            <td>{$totalappointment}</td>
        </tr>
        <tr>
            <td>Accepted Appointments</td>
            <td>{$totalaccepted}</td>
        </tr>

        <tr>
            <td>Rejected Appointments</td>
            <td>{$totalrejected}</td>
        </tr>
    </tbody>
</table>

<h2>Sales</h2>
<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th><strong>Metric</strong></th>
            <th><strong>Value</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Today Sales</td>
            <td>{$todaySales}</td>
        </tr>

        <tr>
            <td>Yesterday Sales</td>
            <td>{$yesterdaySales}</td>
        </tr>

        <tr>
            <td>Last Week Sales</td>
            <td>{$lastWeekSales}</td>
        </tr>

        <tr>
            <td class="total">TOTAL SALES</td>
            <td style="margin-top: 20px;
    font-size: 16px;
    font-weight: bold;
    color: green;">{$totalSales}</td>
        </tr>
    </tbody>
</table>
EOD;

// Output content in the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF (downloadable or viewable in a new tab)
$pdf->Output('dashboard_report.pdf', 'I'); // 'I' opens in browser, 'D' for download
