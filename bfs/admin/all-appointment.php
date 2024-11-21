<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{

// if($_GET['delid']){
// $sid=$_GET['delid'];
// mysqli_query($con,"delete from tblbook where ID ='$sid'");
// echo "<script>alert('Data Deleted');</script>";
// echo "<script>window.location.href='all-appointment.php'</script>";
//           }
if ($_GET['delid']) {
    $sid = $_GET['delid'];
    mysqli_query($con, "UPDATE tblbook SET deleted_at = NOW() WHERE ID = '$sid'");
    echo "<script>alert('Appointment Archived');</script>";
    echo "<script>window.location.href='all-appointment.php'</script>";
}
// // Pagination setup
//     $limit = 10; // Limit of records per page
//     $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
//     $offset = ($page - 1) * $limit; // Offset calculation

//     // Get total records
//     $result = mysqli_query($con, "SELECT COUNT(*) AS total FROM tblbook WHERE deleted_at IS NULL OR deleted_at < NOW() - INTERVAL 30 DAY");
//     $row = mysqli_fetch_assoc($result);
//     $total_records = $row['total'];
//     $total_pages = ceil($total_records / $limit); // Calculate total pages


// Pagination setup
    $limit = 10; // Records per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
    $offset = ($page - 1) * $limit; // Offset calculation

    // Get filter values from URL or form submission
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $time_of_day = isset($_GET['time_of_day']) ? $_GET['time_of_day'] : '';
    $appointment_type = isset($_GET['appointment_type']) ? $_GET['appointment_type'] : '';

    $filters = [];
    
    // Filter based on appointment type
    if ($appointment_type == 'today') {
        $filters[] = "DATE(tblbook.AptDate) = CURDATE()";
    } elseif ($appointment_type == 'weekly') {
        $filters[] = "YEARWEEK(tblbook.AptDate, 1) = YEARWEEK(CURDATE(), 1)";
    } elseif ($appointment_type == 'monthly') {
        $filters[] = "MONTH(tblbook.AptDate) = MONTH(CURDATE()) AND YEAR(tblbook.AptDate) = YEAR(CURDATE())";
    } elseif ($appointment_type == 'next_week') {
        // Filter for next week (7 days after today)
        $filters[] = "tblbook.AptDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
    } elseif ($appointment_type == 'next_month') {
        // Filter for next month (next 30 days)
        $filters[] = "tblbook.AptDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)";
    }

    // Additional filters
    if ($status) {
        $filters[] = "tblbook.Status = '$status'";
    }
    if ($time_of_day) {
        if ($time_of_day == 'day') {
            $filters[] = "HOUR(tblbook.AptTime) BETWEEN 6 AND 18";  // Day time is from 6 AM to 6 PM
        } elseif ($time_of_day == 'night') {
            $filters[] = "HOUR(tblbook.AptTime) BETWEEN 18 AND 23";  // Night time is from 6 PM to 11:59 PM
        }
    }

    // Combine filters
    $filter_sql = count($filters) > 0 ? 'WHERE ' . implode(' AND ', $filters) : '';

    // Get total records with applied filters
    $count_query = "SELECT COUNT(*) AS total FROM tblbook
                    JOIN tbluser ON tbluser.ID = tblbook.UserID
                    $filter_sql AND (tblbook.deleted_at IS NULL OR tblbook.deleted_at < NOW() - INTERVAL 30 DAY)";
    $result = mysqli_query($con, $count_query);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $total_pages = ceil($total_records / $limit);

    // Fetch filtered appointments
    $query = "SELECT tbluser.FirstName, tbluser.LastName, tbluser.MobileNumber, tblbook.ID AS bid, tblbook.AptNumber, 
              tblbook.AptDate, tblbook.AptTime, tblbook.Status
              FROM tblbook
              JOIN tbluser ON tbluser.ID = tblbook.UserID
              $filter_sql AND (tblbook.deleted_at IS NULL OR tblbook.deleted_at < NOW() - INTERVAL 30 DAY)
              ORDER BY tblbook.BookingDate DESC LIMIT $limit OFFSET $offset";

    $ret = mysqli_query($con, $query);
    $cnt = $offset + 1;
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BFS || All Appointment</title>

<style>
    /* Styling the form container */
    .filter-form {
        display: flex;
        justify-content: flex-start;
        gap: 20px;
        background-color: #f4f4f4;
        border-radius: 8px;
       	width: 100%;
        margin: 0 auto;

    }

    /* Styling each select element */
    .filter-select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: max-content;
        max-width: 180px;
        background-color: white;
    }

    /* Styling the button */
    .filter-button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .filter-button:hover {
        background-color: #45a049;
    }

    /* Optional: Clear link style if needed */
    .filter-clear {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
    }

    .filter-clear:hover {
        text-decoration: underline;
    }
</style>

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
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		 <?php include_once('includes/sidebar.php');?>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		 <?php include_once('includes/header.php');?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<h3 class="title1">All Appointment</h3>
					
					<form method="get" action="" class="filter-form">
						<select name="status" class="filter-select">
								<option value="">Status</option>
								<option value="Confirmed">Confirmed</option>
								<option value="Pending">Pending</option>
								<option value="Cancelled">Cancelled</option>
						</select>
						
						<select name="time_of_day" class="filter-select">
								<option value="">Time of Day</option>
								<option value="day">Day Time</option>
								<option value="night">Night Time</option>
						</select>

						 <select name="appointment_type" class="filter-select">
									<option value="">Appointment Type</option>
									<option value="today">Today's Appointment</option>
									<option value="weekly">Weekly Appointment</option>
									<option value="monthly">Monthly Appointment</option>
									<option value="next_week">Next Week Appointment</option>
									<option value="next_month">Next Month Appointment</option>
							</select>

						<button type="submit" class="filter-button">Filter</button>
				</form>

				
					<div class="table-responsive bs-example widget-shadow">
						<table class="table table-bordered"> 
							<thead> 
								<tr> 
									<th>#</th> 
									<!-- <th> Appointment Number</th>  -->
									<!-- <th>Name</th> -->
									<!-- <th>Mobile Number</th>  -->
									<th>Date</th>
									<th>Time<th>
									<th>Status</th>
									<th>Action</th> 
								</tr> 
							</thead> 
							<tbody>
    <?php
    // Fetch filtered appointments
    $query = "SELECT tbluser.FirstName, tbluser.LastName, tbluser.MobileNumber, tblbook.ID AS bid, tblbook.AptNumber, 
              tblbook.AptDate, tblbook.AptTime, tblbook.Status
              FROM tblbook
              JOIN tbluser ON tbluser.ID = tblbook.UserID
              $filter_sql AND (tblbook.deleted_at IS NULL OR tblbook.deleted_at < NOW() - INTERVAL 30 DAY)
              ORDER BY tblbook.BookingDate DESC LIMIT $limit OFFSET $offset";

    $ret = mysqli_query($con, $query);
    $cnt = $offset + 1;

    // Check if any rows are returned
    if (mysqli_num_rows($ret) > 0) {
        // Output results if there are appointments
        while ($row = mysqli_fetch_array($ret)) {
    ?>
            <tr> 
                <td scope="row"><?php echo $cnt; ?></td> 
                <!-- <td><?php echo $row['AptNumber']; ?></td>  -->
                <!-- <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td> -->
                <!-- <td><?php echo $row['MobileNumber']; ?></td> -->
                <td><?php echo $row['AptDate']; ?></td> 
                <td><?php echo date("g:i A", strtotime($row['AptTime'])); ?></td>
                <td class="font-w600">
                    <?php if ($row['Status'] == "") {
                        echo "Pending"; 
                    } else { 
                        echo $row['Status']; 
                    }?>
                </td>
                <td>
                    <a href="view-appointment.php?viewid=<?php echo $row['bid']; ?>" class="btn btn-primary">View</a>
                    <a href="all-appointment.php?delid=<?php echo $row['bid']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                </td> 
            </tr>   
    <?php 
            $cnt++;
        }
    } else {
        // Display message when no appointments are found
        echo "<tr><td colspan='8' style='text-align:center;'>No appointments found for the selected filters.</td></tr>";
    }
    ?>
</tbody>

					</table> 
					</div>
					<!-- Pagination -->
                <nav>
                    <ul class="pagination">
                        <?php if ($page > 1) { ?>
                            <li><a href="all-appointment.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li class="<?php if ($i == $page) echo 'active'; ?>">
                                <a href="all-appointment.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($page < $total_pages) { ?>
                            <li><a href="all-appointment.php?page=<?php echo $page + 1; ?>">Next</a></li>
                        <?php } ?>
                    </ul>
                </nav>
				</div>
			</div>
		</div>
		<!--footer-->
		 <?php include_once('includes/footer.php');?>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
</body>
</html>
<?php }  ?>