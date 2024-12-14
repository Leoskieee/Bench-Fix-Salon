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
if($_GET['delid']){
$sid=$_GET['delid'];
mysqli_query($con,"delete from tblinvoice where BillingId ='$sid'");
echo "<script>alert('Data Deleted');</script>";
echo "<script>window.location.href='invoices.php'</script>";
          }


  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Win Salon | Invoices</title>

<style>
	html, body {
		overflow-x: auto !important;
		overflow-y: visible !important;
		overflow: visible !important;
	}
	/* Default styles for buttons in the table */
td a.btn {
    display: inline-block;
    margin: 0.5rem; /* Add some spacing between buttons */
}

/* Responsive styling for mobile view */
@media (max-width: 768px) {
    td.btn-container {
        display: flex;
        flex-direction: column; /* Stack buttons vertically */
        /* gap: 0.5rem; Add spacing between stacked buttons */
        align-items: center; /* Center align buttons */
    }
}

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

    /* Default styles for the filter form */
    .filter-form {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        justify-content: flex-start;
    }

    .filter-select {
        width: calc(33.33% - 1rem); /* Default width for three-column layout */
        min-width: 330px;
    }

    .filter-button {
        width: auto;
        padding: 0.5rem 1rem;
        min-width: 100px;
    }

    /* Adjust layout for smaller screens */
    @media (max-width: 768px) {
        .filter-select {
            width: 48%; /* Two-column layout */
        }

        .filter-button {
            width: 100%; /* Full-width button */
        }
    }

    /* Adjust layout for very small screens */
    @media (max-width: 480px) {
        .filter-select {
            width: 100%; /* Single-column layout */
        }

        .filter-form {
            gap: 0.5rem;
        }
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
				<a href="dashboard_content.php" class="btn btn-primary" style="margin-bottom: 2rem;" target="_blank">Print Total Sales Report</a>
				<div class="tables">
					<h3 class="title1">Invoice List</h3>
					<!-- naglagay ako ng test query for filter form so if need niyo idelete just query this sa may tblinvoice sql
								DELETE FROM tblinvoice
								WHERE Userid IN (13, 14, 15, 16, 17, 19, 23, 25, 26, 27)
								AND ServiceId IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10); 
					-->
					<form method="get" action="" class="filter-form">
						<select name="sales" class="filter-select">
							<option value="">Sales</option>
							<option value="Today">Today Sales</option>
							<option value="Yesterday">Yesterday Sales</option>
							<option value="SevenDays">Last 7 Days Sales</option>
							<option value="Total">Total Sales</option>
						</select>
						<button type="submit" class="filter-button">Filter</button>
					</form>

					<div class="table-responsive bs-example widget-shadow">
						<?php
						$condition = "";
						$filter = isset($_GET['sales']) ? $_GET['sales'] : "";
						$filterTitle = "Total Sales";
						
						if ($filter == "Today") {
							$condition = "WHERE DATE(tblinvoice.PostingDate) = CURDATE()";
							$filterTitle = "Today Sales";
						} elseif ($filter == "Yesterday") {
							$condition = "WHERE DATE(tblinvoice.PostingDate) = CURDATE() - INTERVAL 1 DAY";
							$filterTitle = "Yesterday Sales";
						} elseif ($filter == "SevenDays") {
							$condition = "WHERE DATE(tblinvoice.PostingDate) >= CURDATE() - INTERVAL 7 DAY";
							$filterTitle = "Last 7 Days Sales";
						} elseif ($filter == "Total") {
							// No additional condition for total sales
							$condition = "";
							$filterTitle = "Total Sales";
						}

						// Query to join tblinvoice and tblservice and calculate the total cost of services
						$query = "
							SELECT DISTINCT tbluser.FirstName, tbluser.LastName, tblinvoice.BillingId, 
								DATE(tblinvoice.PostingDate) AS invoicedate, 
								tblservices.Cost
							FROM tbluser 
							JOIN tblinvoice ON tbluser.ID = tblinvoice.Userid 
							JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
							$condition
							ORDER BY tblinvoice.ID DESC";

						$result = mysqli_query($con, $query);
						$cnt = 1;
						$totalSales = 0;

						while ($row = mysqli_fetch_array($result)) {
							$totalSales += $row['Cost']; // Accumulate the cost of services
						}
						?>

						<!-- Dynamic Title Display -->
						<h4><?php echo $filterTitle . " - " . number_format($totalSales, 2); ?></h4>

						<table class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Invoice Id</th>
									<th>Invoice Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// Reset query and fetch data again for table display
								$result = mysqli_query($con, $query);
								$cnt = 1;
								while ($row = mysqli_fetch_array($result)) {
								?>
									<tr>
										<th scope="row"><?php echo $cnt; ?></th>
										<td><?php echo $row['BillingId']; ?></td>
										<td><?php echo $row['invoicedate']; ?></td>
										<td class="btn-container">
											<a href="view-invoice.php?invoiceid=<?php echo $row['BillingId']; ?>" class="btn btn-primary">View</a>
											<a href="invoices.php?delid=<?php echo $row['BillingId']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
										</td>
									</tr>
								<?php
									$cnt++;
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><strong>Total Sales</strong></td>
									<td colspan="2"><strong><?php echo number_format($totalSales, 2); ?></strong></td>
								</tr>
							</tfoot>
						</table>
					</div>
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