<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{ 

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Win Salon | Report</title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body >
	<div class="main-content">
		<!--left-fixed -navigation-->
		 <!-- <?php // include_once('includes/sidebar.php');?> -->
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		 <!-- <?php // include_once('includes/header.php');?> -->
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper" style="padding: 4rem 2rem !important; display: flex; width: 100%; justify-content: center;">
			<div class="main-page" style="width: 90rem">
				<div class="tables">
          <form method="get" class="filter-form table-responsive bs-example widget-shadow">
            <h3 class="title1">Generate Report</h3>
            <div class="form-list" style="width: 100%; display: flex; align-items: flex-start; gap: 2rem; margin-bottom: 2rem;">
              
               <div class="group" style="display: flex; flex-direction: column;">
                 <div class="form-group">
                   <label for="start_date">From:</label>
                      <input type="date" name="start_date" id="start_date" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label for="end_date">To:</label>
                      <input type="date" name="end_date" id="end_date" class="form-control" required>
                  </div>
              </div>

              <div class="form-group">
                  <label for="status">Status:</label><br>
                  <div class="status-lists" style="display: flex; gap: 0.5rem; flex-wrap: wrap">
                    <div class="input-container" style="display: flex; gap: 0.4rem; align-items: center">

                      <input type="checkbox" name="status[]" value="Pending" style="flex: 1 0 1 50%"> Pending
                    </div>
                    <div class="input-container" style="display: flex; gap: 0.4rem; align-items: center">

                      <input type="checkbox" name="status[]" value="Confirmed" style="flex: 1 0 1 50%"> Confirmed
                    </div>
                    <div class="input-container" style="display: flex; gap: 0.4rem; align-items: center">

                      <input type="checkbox" name="status[]" value="Rejected" style="flex: 1 0 1 50%"> Rejected
                    </div>
                  </div>
              </div>
              
              <div class="form-group">
                  <label for="services">Services:</label><br>
                  <div class="services-checkbox-group form-group" style="display: flex; gap: 0.5rem; flex-wrap: wrap">
                    <?php
                      // Fetch services from tblservices table
                      $services_query = "SELECT ServiceName FROM tblservices";
                      $services_result = mysqli_query($con, $services_query);
                      while ($service = mysqli_fetch_assoc($services_result)) {
                        echo '<input type="checkbox" name="services[]" value="'. $service['ServiceName'] .'" style="flex: 1 0 1 33%">'. $service['ServiceName'] . '<br>';
                      }
                      ?>
                  </div>
              </div>

              <button type="submit" name="filter" class="btn btn-primary">Filter</button>
            </div>
          </form>

          <div class="table-responsive bs-example widget-shadow">
            <h3>Filter Results</h3>
            <table style="width: 100%; border-collapse: collapse; margin-block: 1rem;">
              <tr>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Date Range</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Status</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Services</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Last Week Sales</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Yesterday Sales</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Today Sales</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Total Sales</th>
                <th style="text-align: left; padding: 8px; border: 1px solid #ccc;">Action</th>
              </tr>
              <tr>
                <td style="padding: 8px; border: 1px solid #ccc;">
                  <?php echo isset($_GET['start_date']) && isset($_GET['end_date']) ? $_GET['start_date'] . ' to ' . $_GET['end_date'] : 'Not Selected'; ?>
                </td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                  <?php 
                  echo isset($_GET['status']) && !empty($_GET['status']) 
                      ? implode(', ', $_GET['status']) 
                      : 'Not Selected'; 
                  ?>
                </td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                  <?php 
                  echo isset($_GET['services']) && !empty($_GET['services']) 
                      ? implode(', ', $_GET['services']) 
                      : 'Not Selected'; 
                  ?>
                </td>
                <?php
                  // Last Sevendays Sale
                    $lastSevenDaysSale = 0;
                    $query8 = mysqli_query($con, "
                        SELECT SUM(tblservices.Cost) as total
                        FROM tblinvoice
                        JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
                        WHERE DATE(tblinvoice.PostingDate) >= CURDATE() - INTERVAL 7 DAY;
                    ");
                    $row8 = mysqli_fetch_assoc($query8);
                    $lastSevenDaysSale = $row8['total'] ?? 0;
                    
                    $yesterdaysale = 0;
                    $query7 = mysqli_query($con, "
                        SELECT SUM(tblservices.Cost) as total
                        FROM tblinvoice
                        JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
                        WHERE DATE(tblinvoice.PostingDate) = CURDATE() - INTERVAL 1 DAY;
                    ");
                    $row7 = mysqli_fetch_assoc($query7);
                    $yesterdaysale = $row7['total'] ?? 0;

                    $todaysale = 0;
                    $query6 = mysqli_query($con, "
                        SELECT SUM(tblservices.Cost) as total
                        FROM tblinvoice
                        JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
                        WHERE DATE(tblinvoice.PostingDate) = CURDATE();
                        ");
                        $row6 = mysqli_fetch_assoc($query6);
                    $todaysale = $row6['total'] ?? 0;

                    $totalrevenue = 0;
                    $query9 = mysqli_query($con, "
                        SELECT SUM(tblservices.Cost) as total
                        FROM tblinvoice
                        JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId;
                    ");
                    $row9 = mysqli_fetch_assoc($query9);
                    $totalrevenue = $row9['total'] ?? 0;

                ?>
                <td style="padding: 8px; border: 1px solid #ccc;">₱<?php echo number_format($lastSevenDaysSale); ?></td>
                <td style="padding: 8px; border: 1px solid #ccc;">₱<?php echo number_format($yesterdaysale); ?></td>
                <td style="padding: 8px; border: 1px solid #ccc;">₱<?php echo number_format($todaysale); ?></td>
                <td style="padding: 8px; border: 1px solid #ccc;">₱<?php echo number_format($totalrevenue); ?></td>
                <td style="padding: 8px; border: 1px solid #ccc;">
                  <button class="btn btn-success" onclick="window.print();">Print PDF</button>
                </td>
              </tr>
            </table>
            
            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Client Name</th>
                      <th>Client Email</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Service</th>
                      <th>Total Price</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                      // Build the WHERE clause dynamically based on filters
                      $conditions = [];
                      if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                        $start_date = $_GET['start_date'];
                        $end_date = $_GET['end_date'];
                          $conditions[] = "AptDate BETWEEN '$start_date' AND '$end_date'";
                      }
                      if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status_filter = $_GET['status'];
    $status_conditions = [];
    
    // Loop through status filter array
    foreach ($status_filter as $status) {
        if ($status === 'Pending') {
            $status_conditions[] = "Status IS NULL";  // Check for NULL for pending
        } else {
            $status_conditions[] = "Status = '$status'";  // Check for other statuses
        }
    }
    
    if (!empty($status_conditions)) {
        $conditions[] = "(" . implode(" OR ", $status_conditions) . ")";
    }
}
                      if (isset($_GET['services[]']) && !empty($_GET['services[]'])) {
                          $services_filter = implode("','", $_GET['services']);
                          $conditions[] = "Service IN ('$services_filter')";
                      }

                      // Fetch filtered data from tblbook, tbluser, and tblservices
                      $where_clause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : "";
                      $query = "SELECT b.ID, CONCAT(u.FirstName, ' ', u.LastName) AS ClientName, u.Email, b.AptDate, b.AptTime, b.Service, b.Service_Total_Price, b.Status 
                                FROM tblbook b
                                LEFT JOIN tbluser u ON b.UserID = u.ID
                                $where_clause";
                      $result = mysqli_query($con, $query);
                      $counter = 1;
                      if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          ?>
                  <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo $row['ClientName']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['AptDate']; ?></td>
                    <td><?php echo date("g:i A", strtotime($row['AptTime'])); ?></td>
                    <td><?php echo $row['Service']; ?></td>
                    <td>₱<?php echo $row['Service_Total_Price']; ?></td>
                    <td><?php echo !empty($row['Status']) ? $row['Status'] : 'Pending'; ?></td>
                  </tr>
                  <?php
                          }
                        } else {
                          echo "<tr><td colspan='7'>No records found</td></tr>";
                        }
                        ?>
              </tbody>
            </table>
          </div>
				</div>
			</div>
		</div>

		<!--footer-->
		 <?php include_once('includes/footer.php');?>
        <!--//footer-->
	</div>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
</body>
</html>
<?php }  ?>