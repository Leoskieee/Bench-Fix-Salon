<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } 

require_once('tcpdf/tcpdf.php'); 

// Function to generate PDF
if(isset($_POST['generate_pdf'])) {
    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->AddPage();
    
    // Set title and document metadata
    $pdf->SetTitle('Dashboard Report');
    $pdf->SetAuthor('BFS Admin');
    
    // Set content
    ob_start();
    include('dashboard_content.php'); // Place HTML dashboard content in a separate PHP file (e.g., dashboard_content.php)
    $htmlContent = ob_get_clean();
    
    $pdf->writeHTML($htmlContent, true, false, true, false, '');
    
    // Output the PDF as a download
    $pdf->Output('dashboard_report.pdf', 'D');
    exit;
}
     ?>
<!DOCTYPE HTML>
<html>
<head>
<title>BFS | Admin Dashboard</title>

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
<!-- chart -->
<script src="js/Chart.js"></script>
<!-- //chart -->
<!--Calender-->
<link rel="stylesheet" href="css/clndr.css" type="text/css" />
<script src="js/underscore-min.js" type="text/javascript"></script>
<script src= "js/moment-2.2.1.js" type="text/javascript"></script>
<script src="js/clndr.js" type="text/javascript"></script>
<script src="js/site.js" type="text/javascript"></script>
<!--End Calender-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
<div class="main-content">
		
		 <?php include_once('includes/sidebar.php');?>
		
	<?php include_once('includes/header.php');?>
		<!-- main content start-->
		<div id="page-wrapper" class="row calender widget-shadow">
			<div class="main-page">
				
				<a href="report.php" class="btn btn-primary" target="_blank">Generate Report</a>

				<div class="row calender widget-shadow">
					<div class="row-one">
					<div class="col-md-4 widget">
						<a href="customer-list.php" class="stat-link">
								<?php 
								$query1 = mysqli_query($con, "SELECT COUNT(*) as total FROM tbluser");
								$row1 = mysqli_fetch_assoc($query1);
								$totalcust = $row1['total'];
								?>
							<div class="stats-left ">
								<h5>Total</h5>
								<h4>Customer</h4>
							</div>
							<div class="stats-right">
								<label> <?php echo $totalcust;?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>

					<div class="col-md-4 widget states-mdl">
						<a href="all-appointment.php" class="stat-link">
							<?php 
							$query2 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook");
							$row2 = mysqli_fetch_assoc($query2);
							$totalappointment = $row2['total'];
							?>
							<div class="stats-left">
								<h5>Total</h5>
								<h4>Appointment</h4>
							</div>
							<div class="stats-right">
								<label> <?php echo $totalappointment;?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>

					<div class="col-md-4 widget states-last">
						<a href="all-appointment.php?status=Confirmed" class="stat-link">
							<?php 
								$query3 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE Status='Confirmed'");
								$row3 = mysqli_fetch_assoc($query3);
								$totalaccapt = $row3['total'];
							?>
							<div class="stats-left">
								<h5>Total</h5>
								<h4>Accepted Apt</h4>
							</div>
							<div class="stats-right">
								<label><?php echo $totalaccapt;?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>
				</div>
				</div>

				<div class="row calender widget-shadow">
					<div class="row-one">
					<div class="col-md-4 widget">
						<a href="all-appointment.php?status=Rejected" class="stat-link">
							<?php 
								$query4 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE Status='Rejected'");
								$row4 = mysqli_fetch_assoc($query4);
								$totalrejapt = $row4['total'];
							?>
							<div class="stats-left ">
								<h5>Total</h5>
								<h4>Rejected Apt</h4>
							</div>
							<div class="stats-right">
								<label> <?php echo $totalrejapt;?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>
					<div class="col-md-4 widget states-mdl">
						<a href="manage-services.php" class="stat-link">

							<?php 
								$query5 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblservices");
								$row5 = mysqli_fetch_assoc($query5);
								$totalser = $row5['total'];
							?>
							<div class="stats-left">
								<h5>Total</h5>
								<h4>Services</h4>
							</div>
							<div class="stats-right">
								<label> <?php echo $totalser;?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>

					<div class="col-md-4 widget states-last">
						<a href="invoices.php?sales=Today" class="stat-link">
							<?php
							// todays sale
							$todaysale = 0;
							$query6 = mysqli_query($con, "
									SELECT SUM(tblservices.Cost) as total
									FROM tblinvoice
									JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
									WHERE DATE(tblinvoice.PostingDate) = CURDATE();
							");
							$row6 = mysqli_fetch_assoc($query6);
							$todaysale = $row6['total'] ?? 0;
							?>
							<div class="stats-left">
								<h5>Today</h5>
								<h4>Sales</h4>
							</div>
							<div class="stats-right">
								<label>₱<?php echo number_format($todaysale); ?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>
					<div class="clearfix"> </div>	
				</div>
						
					</div>

				<div class="row calender widget-shadow">
					<div class="row-one">
					<div class="col-md-4 widget">
						<a href="invoices.php?sales=Yesterday" class="stat-link">
							<?php
								// Yesterday's sale
								$yesterdaysale = 0;
								$query7 = mysqli_query($con, "
										SELECT SUM(tblservices.Cost) as total
										FROM tblinvoice
										JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
										WHERE DATE(tblinvoice.PostingDate) = CURDATE() - INTERVAL 1 DAY;
								");
								$row7 = mysqli_fetch_assoc($query7);
								$yesterdaysale = $row7['total'] ?? 0;
							?>
							<div class="stats-left ">
								<h5>Yesterday</h5>
								<h4>Sales</h4>
							</div>
							<div class="stats-right">
								<label>₱<?php echo number_format($yesterdaysale); ?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>

					<div class="col-md-4 widget states-mdl">
						<a href="invoices.php?sales=SevenDays" class="stat-link">
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
 							?>
							<div class="stats-left">
								<h5>Last Sevendays</h5>
								<h4>Sale</h4>
							</div>
							<div class="stats-right">
								<label>₱<?php echo number_format($lastSevenDaysSale); ?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>

					<div class="col-md-4 widget states-last">
						<a href="invoices.php?sales=Total" class="stat-link">
							<?php
								// Total Sale
								$totalrevenue = 0;
								$query9 = mysqli_query($con, "
										SELECT SUM(tblservices.Cost) as total
										FROM tblinvoice
										JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId;
								");
								$row9 = mysqli_fetch_assoc($query9);
								$totalrevenue = $row9['total'] ?? 0;
							?>
							<div class="stats-left">
								<h5>Total</h5>
								<h4>Sales</h4>
							</div>
							<div class="stats-right">
								<label>₱<?php echo number_format($totalrevenue); ?></label>
							</div>
							<div class="clearfix"> </div>	
						</a>
					</div>
					<div class="clearfix"> </div>	
				</div>
						
					</div>
					
				</div>
				<div class="clearfix"> </div>
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