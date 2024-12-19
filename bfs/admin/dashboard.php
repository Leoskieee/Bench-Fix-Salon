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
// Query to get the total revenue from confirmed appointments
$query = "SELECT SUM(Service_Total_Price) AS total_revenue FROM tblbook WHERE Status = 'confirmed'";
$result = mysqli_query($con, $query);

// Fetch the result
$row = mysqli_fetch_assoc($result);

// Get the total revenue or set it to 0 if no confirmed appointments are found
$total_revenue = $row['total_revenue'] ? number_format($row['total_revenue'], 2) : '0.00';
?>
<!DOCTYPE HTML>
<html>
<head>
<title>BFS | Admin Dashboard</title>
<link rel="stylesheet" href="css/dashboard.css">

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
<!-- <link rel="stylesheet" href="css/clndr.css" type="text/css" /> -->
<!-- <script src="js/underscore-min.js" type="text/javascript"></script> -->
<!-- <script src= "js/moment-2.2.1.js" type="text/javascript"></script> -->
<!-- <script src="js/clndr.js" type="text/javascript"></script> -->
<!-- <script src="js/site.js" type="text/javascript"></script> -->
<!--End Calender-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php include_once('includes/sidebar.php');?>
		<?php include_once('includes/header.php');?>

		<!-- main content start-->
		<div id="page-wrapper" class="row calender widget-shadow">
			<div class="main-page">
				
				<div class="header-group">
					<h1>Win Salon Dashboard</h1>
					<div class="reports-container">
						<a href="report.php" class="btn btn-primary" target="_blank">Raw Reports</a>
						<a href="periods-report.php" class="btn" style="background: #505576; color: white;" target="_blank">General Report</a>
					</div>
				</div>

				<div class="top-container">
					<div class="revenue-container">
						<h1 class="header">Total Revenue</h1>
						<p class="revenue-amount">₱<?php echo $total_revenue; ?></p>
					</div>

					<div class="appointments-container">
						<a href="all-appointment.php" class="apt all">
							<p class="header"><span class="icon"></span> All Appointments</p>
							<?php 
								$query2 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook");
								$row2 = mysqli_fetch_assoc($query2);
								$totalappointment = $row2['total'];
							?>
							<p class="number">
								<?php echo $totalappointment;?>
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.5 22H20.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 3.5L19 17.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 13.77V3.5H15.27" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</p>
						</a>
						<a href="all-appointment.php?status=Confirmed" class="apt accepted">
							<p class="header"><span class="icon"></span> Accepted Appointments</p>
							<?php 
								$query3 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE Status='Confirmed'");
								$row3 = mysqli_fetch_assoc($query3);
								$totalaccapt = $row3['total'];
							?>
							<p class="number">
								<?php echo $totalaccapt;?>
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.5 22H20.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 3.5L19 17.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 13.77V3.5H15.27" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

							</p>
						</a>
						<a href="all-appointment.php?status=Rejected" class="apt rejected">
							<p class="header"><span class="icon"></span> Rejected Appointments</p>
							<?php 
								$query4 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE Status='Rejected'");
								$row4 = mysqli_fetch_assoc($query4);
								$totalrejapt = $row4['total'];
							?>
							<p class="number">
								<?php echo $totalrejapt;?>
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.5 22H20.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 3.5L19 17.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 13.77V3.5H15.27" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

							</p>
						</a>
						<a href="manage-services.php" class="apt services">
							<p class="header"><span class="icon"></span> Services</p>
							<?php 
								$query5 = mysqli_query($con, "SELECT COUNT(*) as total FROM tblservices");
								$row5 = mysqli_fetch_assoc($query5);
								$totalser = $row5['total'];
							?>
							<p class="number">
								<?php echo $totalser;?>
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.5 22H20.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 3.5L19 17.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 13.77V3.5H15.27" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

							</p>
						</a>

						<a href="customer-list.php" class="apt services">
							<p class="header"><span class="icon"></span> Customers</p>
							<?php 
								$query1 = mysqli_query($con, "SELECT COUNT(*) as total FROM tbluser");
								$row1 = mysqli_fetch_assoc($query1);
								$totalcust = $row1['total'];
							?>
							<p class="number">
								<?php echo $totalcust;?>
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.5 22H20.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 3.5L19 17.5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M5 13.77V3.5H15.27" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>

							</p>
						</a>
					</div>
				</div>
				
				<div class="dashboard-cards-container">
					<a href="invoices.php?sales=Today" class="card today">
						<p class="header"><span class="icon"></span> Today Sales</p>
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
						<p class="number">₱<?php echo number_format($todaysale); ?></p>
					</a>
					<a href="invoices.php?sales=Yesterday" class="card yesterday">
						<p class="header"><span class="icon"></span> Yesterday Sales</p>
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
						<p class="number">₱<?php echo number_format($yesterdaysale); ?></p>
					</a>
					<a href="invoices.php?sales=SevenDays" class="card weekly">
						<p class="header"><span class="icon"></span> Weekly Sales</p>
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
						<p class="number">₱<?php echo number_format($lastSevenDaysSale); ?></p>
					</a>
					<!-- <a href="" class="card monthly-sales">
						<p class="header"><span class="icon"></span> Monthly Sales</p>
						<p class="number">₱25986</p>
					</a> -->
				</div>

				<div class="charts-container table-responsive bs-example widget-shadow">
					<div>
						<!-- <h2>Monthly Appointments</h2> -->
						<canvas id="barChart"></canvas>
					</div>
					<div>
						<!-- <h2>Appointment Status</h2> -->
						<canvas id="pieChart"></canvas>
					</div>
				</div>
					
			</div>

		</div>
	</div>
	<!--footer-->
	<?php include_once('includes/footer.php');?>
  <!--//footer-->
	
	<script>
		// Canvas contexts
		const pieCtx = document.getElementById('pieChart').getContext('2d');
		const barCtx = document.getElementById('barChart').getContext('2d');

		// Pie chart gradient
		const pieGradient = pieCtx.createLinearGradient(0, 0, 0, 400);
		pieGradient.addColorStop(0, 'hsla(0, 85%, 70%, 0.9)');
		pieGradient.addColorStop(1, 'hsla(216, 50%, 53%, 0.9)');

		// Fetch appointment status data
		fetch('includes/getAppointmentStatus.php')
			.then(response => response.json())
			.then(statusData => {
				const pieGraphData = {
					labels: ['Confirmed', 'Pending', 'Rejected'],
					datasets: [{
						label: 'Appointment Status',
						data: [statusData.confirmed, statusData.pending, statusData.rejected],
						backgroundColor: ['#4f52ba', '#3c415f', '#f652a0'],
						borderColor: 'transparent',
						borderWidth: 1,
					}]
				};

				const pieConfig = {
					type: 'doughnut',
					data: pieGraphData,
					options: {
						responsive: true,
						plugins: {
							legend: {
								position: 'top',
								labels: { font: { family: 'DM Sans, sans-serif' } },
							},
						},
						 cutout: '75%' 
					}
				};

				new Chart(pieCtx, pieConfig);
			})
			.catch(error => console.error('Error fetching appointment status data:', error));

		// Fetch monthly appointments data
		fetch('includes/getMonthlySales.php')
    .then(response => response.json())
    .then(data => {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const salesPerMonth = new Array(12).fill(0);

        // Populate the salesPerMonth array with sales data
        data.forEach(item => {
            salesPerMonth[item.month - 1] = item.total_sales;
        });

        // Prepare the bar graph data
        const barGraphData = {
            labels: months,
            datasets: [{
                label: 'Monthly Sales',
                data: salesPerMonth,
                backgroundColor: [
                    '#4c5270', '#1D72F2', '#4f52ba', '#1D72F2', '#f652a0', '#4c5270', '#1D72F2',
                    '#4f52ba', '#1D72F2', '#f652a0', '#4f52ba', '#4c5270'
                ],
                borderColor: 'transparent',
                borderRadius: 20,
            }]
        };

        // Configuring the bar graph (line chart in your case)
        const barConfig = {
            type: 'bar',
            data: barGraphData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        ticks: {
                            font: { family: 'DM Sans, sans-serif' }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 30000, 
                        ticks: {
                            stepSize: 1000, 
                            font: { family: 'DM Sans, sans-serif' }
                        }
                    }
                }
            }
        };

        // Create and render the chart
        new Chart(barCtx, barConfig);
    })
    .catch(error => console.error('Error fetching monthly sales data:', error));


		</script>


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