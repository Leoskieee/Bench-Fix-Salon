<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
} else {

if (isset($_GET['restoreid'])) {
    $sid = $_GET['restoreid'];
    $restore_query = mysqli_query($con, "UPDATE tblbook SET deleted_at = NULL WHERE ID = '$sid'");
    if ($restore_query) {
        echo "<script>alert('Appointment Restored');</script>";
    } else {
        echo "<script>alert('Error restoring appointment');</script>";
    }
    echo "<script>window.location.href='archived-appointments.php'</script>";
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <title>BFS || Archived Appointments</title>
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
        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>
        
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">Archived Appointments</h3>
                    <div class="table-responsive bs-example widget-shadow">
                        <h4>Archived Appointments:</h4>
                        <table class="table table-bordered"> 
                            <thead> 
                                <tr> 
                                    <th>#</th> 
                                    <th>Appointment Number</th> 
                                    <th>Name</th>
                                    <th>Mobile Number</th> 
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Status</th>
                                    <th>Action</th> 
                                </tr> 
                            </thead> 
                            <tbody>
                            <?php
                            $ret = mysqli_query($con, "SELECT tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, tblbook.ID as bid, tblbook.AptNumber, tblbook.AptDate, tblbook.AptTime, tblbook.Message, tblbook.BookingDate, tblbook.Status 
                                                       FROM tblbook 
                                                       JOIN tbluser ON tbluser.ID = tblbook.UserID 
                                                       WHERE tblbook.deleted_at IS NOT NULL 
                                                       AND tblbook.deleted_at >= NOW() - INTERVAL 30 DAY
                                                       ORDER BY tblbook.BookingDate DESC, tblbook.ID DESC");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($ret)) {
                            ?>
                            <tr> 
                                <th scope="row"><?php echo $cnt; ?></th> 
                                <td><?php echo $row['AptNumber']; ?></td> 
                                <td><?php echo $row['FirstName'] . " " . $row['LastName']; ?></td>
                                <td><?php echo $row['MobileNumber']; ?></td>
                                <td><?php echo $row['AptDate']; ?></td> 
                                <td><?php echo date("g:i A", strtotime($row['AptTime'])); ?></td>
                                <td><?php echo $row['Status'] ? $row['Status'] : "Not Updated Yet"; ?></td> 
                                <td>
                                    <a href="view-appointment.php?viewid=<?php echo $row['bid']; ?>" class="btn btn-primary">View</a>
                                    <a href="archived-appointments.php?restoreid=<?php echo $row['bid']; ?>" class="btn btn-success" onClick="return confirm('Are you sure you want to restore this appointment?')">Restore</a>
                                </td> 
                            </tr>
                            <?php 
                            $cnt++;
                            } ?>
                            </tbody> 
                        </table> 
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php'); ?>
    </div>

   
</body>
</html>
<?php } ?>
