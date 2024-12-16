<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/dbconnection.php');

$admin_password = '123'; 
if (!isset($_SESSION['admin_verified'])) {
    $_SESSION['admin_verified'] = false;
}

if (isset($_POST['verify_password'])) {
    $entered_password = $_POST['admin_password'];
    if ($entered_password === $admin_password) {
        $_SESSION['admin_verified'] = true;
    } else {
        echo "<script>alert('Incorrect password!');</script>";
    }
}

if (!$_SESSION['admin_verified']) {
    // Show password form
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Admin Verification</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="cbp-spmenu-push">
        <div class="main-content">
            <div id="page-wrapper">
                <div class="main-page">
                    <h3 class="title1">Admin Verification</h3>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="admin_password">Enter Admin Password:</label>
                            <input type="password" name="admin_password" id="admin_password" class="form-control" required>
                        </div>
                        <button type="submit" name="verify_password" class="btn btn-primary">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Session expiration: unset the admin verification session after 15 minutes of inactivity
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 900) {
    unset($_SESSION['admin_verified']);  // Clear admin verification after 15 minutes
    session_unset();
    session_destroy();
}

$_SESSION['last_activity'] = time();  // Update last activity time

// Check session for admin login
if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['reset_action'])) {
        $action = $_POST['reset_action'];
        switch ($action) {
            case 'tblbook':
                $query = "DELETE FROM tblbook WHERE BookingDate < CURDATE() - INTERVAL 30 DAY";
                mysqli_query($con, $query);
                $message = 'Old bookings deleted.';
                break;
            case 'tblcontact':
                $query = "DELETE FROM tblcontact";
                mysqli_query($con, $query);
                $message = 'All contact submissions deleted.';
                break;
            case 'tblfeedback':
                $query = "DELETE FROM tblfeedback WHERE created_at < CURDATE() - INTERVAL 30 DAY";
                mysqli_query($con, $query);
                $message = 'Old feedback deleted.';
                break;
            case 'tbluser':
                $query = "DELETE FROM tbluser WHERE LastLogin < CURDATE() - INTERVAL 365 DAY";
                mysqli_query($con, $query);
                $message = 'Inactive user accounts deleted.';
                break;
            default:
                $message = 'No action performed.';
        }
        echo "<script>alert('$message');</script>";
    }
  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Win Salon | Reset Data</title>

<style>
	.table-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}

.table {
    width: 100%;
    min-width: 600px; /* Ensures table won't collapse too much */
    border-collapse: collapse;
}

@media (max-width: 768px) {
    .table {
        min-width: unset; /* Remove minimum width on smaller screens */
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
				<div class="tables">
					<h3 class="title1">Reset Tables</h3>
					<div class="panel panel-default">
                    <div class="panel-heading">Manage Table Reset Actions</div>
                    <div class="panel-body">
                        <form method="POST" action="">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Table Name</th>
                                        <th>Recommended Action</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Admin</td>
                                        <td>No deletion (update only)</td>
                                        <td><a href="admin-profile.php">Update Admin Profile</a></td>
                                    </tr>
                                    <tr>
                                        <td>Appointments</td>
                                        <td>Delete old bookings older than 30 days, keeping future and recent bookings</td>
                                        <td><button type="submit" name="reset_action" value="tblbook" class="btn btn-warning">Reset</button></td>
                                    </tr>
                                    <tr>
                                        <td>Inquiries</td>
                                        <td>Full deletion</td>
                                        <td><button type="submit" name="reset_action" value="tblcontact" class="btn btn-danger">Reset</button></td>
                                    </tr>
                                    <tr>
                                        <td>Feedback</td>
                                        <td>Retain recent feedback; delete older than a year (365 days)</td>
                                        <td><button type="submit" name="reset_action" value="tblfeedback" class="btn btn-warning">Reset</button></td>
                                    </tr>
                                    <tr>
                                        <td>Sales</td>
                                        <td>No deletion (archive instead)</td>
                                        <td><a href="invoices.php">Manage Sales</a></td>
                                    </tr>
                                    <tr>
                                        <td>Products</td>
                                        <td>Retain product data; allow updates</td>
                                        <td><a href="manage-products.php">Manage Products</a></td>
                                    </tr>
                                    <tr>
                                        <td>Services</td>
                                        <td>Retain service data; allow updates</td>
                                        <td><a href="manage-services.php">Manage Services</a></td>
                                    </tr>
                                    <tr>
                                        <td>Customers</td>
                                        <td>Remove inactive user accounts</td>
                                        <td><button type="submit" name="reset_action" value="tbluser" class="btn btn-warning">Reset</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
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
<?php } ?>
