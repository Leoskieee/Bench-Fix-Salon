<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid'] == 0)) {
  header('location:logout.php');
} else { 
    // Get today's date, the start of the current week, and the start of the current month
    $today = date('Y-m-d');
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $startOfMonth = date('Y-m-01');
    
    // Fetch appointments based on date range and status
    // For today
    $todayQuery = "SELECT 
                    CASE 
                        WHEN Status IS NULL THEN 'Pending'
                        ELSE Status
                    END AS Status, 
                    COUNT(*) as count 
                    FROM tblbook 
                    WHERE AptDate = '$today' 
                    GROUP BY Status";
    $todayResult = mysqli_query($con, $todayQuery);
    
    // For this week
    $weeklyQuery = "SELECT 
                    CASE 
                        WHEN Status IS NULL THEN 'Pending'
                        ELSE Status
                    END AS Status, 
                    COUNT(*) as count 
                    FROM tblbook 
                    WHERE AptDate >= '$startOfWeek' AND AptDate <= '$today' 
                    GROUP BY Status";
    $weeklyResult = mysqli_query($con, $weeklyQuery);
    
    // For this month
    $monthlyQuery = "SELECT 
                    CASE 
                        WHEN Status IS NULL THEN 'Pending'
                        ELSE Status
                    END AS Status, 
                    COUNT(*) as count 
                    FROM tblbook 
                    WHERE AptDate >= '$startOfMonth' AND AptDate <= '$today' 
                    GROUP BY Status";
    $monthlyResult = mysqli_query($con, $monthlyQuery);
    
    // Initialize arrays to store counts for each status
    $todayCounts = ['Pending' => 0, 'Confirmed' => 0, 'Rejected' => 0];
    $weeklyCounts = ['Pending' => 0, 'Confirmed' => 0, 'Rejected' => 0];
    $monthlyCounts = ['Pending' => 0, 'Confirmed' => 0, 'Rejected' => 0];
    
    // Process today's results
    while ($row = mysqli_fetch_assoc($todayResult)) {
        $todayCounts[$row['Status']] = $row['count'];
    }
    
    // Process this week's results
    while ($row = mysqli_fetch_assoc($weeklyResult)) {
        $weeklyCounts[$row['Status']] = $row['count'];
    }
    
    // Process this month's results
    while ($row = mysqli_fetch_assoc($monthlyResult)) {
        $monthlyCounts[$row['Status']] = $row['count'];
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Win Salon | General Report</title>

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
<!-- <link rel="stylesheet" href="css/dashboard.css"> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
			<div class="main-page" style="width: 45rem">
        <div class="table-responsive bs-example widget-shadow" style="padding: 2rem">
          <div class="header" style="margin-bottom: 1rem; width: 100%; display: flex; justify-content: space-between">
            <h3>General Report</h3>
            <button class="btn btn-success" onclick="window.print();">Print Report</button>
          </div>
                     
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Time Periods</th>
                <th>Pending</th>
                <th>Confirmed</th>
                <th>Rejected</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Today</td>
                <td><?php echo $todayCounts['Pending']; ?></td>
                <td><?php echo $todayCounts['Confirmed']; ?></td>
                <td><?php echo $todayCounts['Rejected']; ?></td>
              </tr>
              <tr>
                <td>Weekly</td>
                <td><?php echo $weeklyCounts['Pending']; ?></td>
                <td><?php echo $weeklyCounts['Confirmed']; ?></td>
                <td><?php echo $weeklyCounts['Rejected']; ?></td>
              </tr>
              <tr>
                <td>Monthly</td>
                <td><?php echo $monthlyCounts['Pending']; ?></td>
                <td><?php echo $monthlyCounts['Confirmed']; ?></td>
                <td><?php echo $monthlyCounts['Rejected']; ?></td>
              </tr>
            </tbody>
          </table>

          
        </div>
        <div class="charts-container table-responsive bs-example widget-shadow" style="display: flex; flex-direction: row; gap: 2rem; align-items:flex-start; padding: 2rem">
          <div>
            <h2 style="font-size: 1rem;">Monthly Appointments</h2>
            <canvas id="barChart" style="width: 25rem !important;"></canvas>
          </div>
          <div>
            <h2 style="font-size: 1rem;">Appointment Status</h2>
            <canvas id="pieChart" style="width: 13rem !important;"></canvas>
          </div>
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
                        max: 30000,  // Set Y-axis max to 50,000
                        ticks: {
                            stepSize: 1000,  // Adjust step size for better visibility
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
</body>
</html>
<?php } ?>
