<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsuid']==0)) {
  header('location:logout.php');
} else {
  
  // Set the number of results per page
  $limit = 5;
  
  // Get the current page from the URL or set it to 1 if not available
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  
  // Calculate the offset for the query
  $offset = ($page - 1) * $limit;
  
  ?>
<!doctype html>
<html lang="en">
  <head>
    <title>Win Salon | Booking History</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

<!-- Your existing scripts -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- breadcrumbs and other sections -->

<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">
            <div>
                <div class="table-content table-responsive cart-table-content m-t-30">
                    <h4 style="padding-bottom: 20px;text-align: center;color: blue;">Appointment History</h4>
                        <table border="2" class="table">
                            <thead class="gray-bg">
                                <tr>
                                    <th>#</th>
                                    <th>Appointment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $userid = $_SESSION['bpmsuid'];
                                // Update query to include LIMIT and OFFSET
                                // $query = mysqli_query($con, "SELECT tbluser.ID as uid, tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, tblbook.ID as bid, tblbook.AptNumber, tblbook.AptDate, tblbook.AptTime, tblbook.Message, tblbook.BookingDate, tblbook.Status 
                                //                             FROM tblbook 
                                //                             JOIN tbluser ON tbluser.ID = tblbook.UserID 
                                //                             WHERE tbluser.ID = '$userid' 
                                //                             ORDER BY tblbook.BookingDate DESC
                                //                             LIMIT $limit OFFSET $offset");

                                // Update query to include LIMIT, OFFSET, and exclude deleted bookings
                                $query = mysqli_query($con, "
                                    SELECT tbluser.ID as uid, tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, 
                                        tblbook.ID as bid, tblbook.AptNumber, tblbook.AptDate, tblbook.AptTime, 
                                        tblbook.Message, tblbook.BookingDate, tblbook.Status 
                                    FROM tblbook 
                                    JOIN tbluser ON tbluser.ID = tblbook.UserID 
                                    WHERE tbluser.ID = '$userid' AND tblbook.deleted_at IS NULL 
                                    ORDER BY tblbook.BookingDate DESC 
                                    LIMIT $limit OFFSET $offset
                                ");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td><p><?php echo $row['AptDate']; ?></p></td>
                                        <td><a href="appointment-detail.php?aptnumber=<?php echo $row['AptNumber'];?>" class="btn btn-primary">View</a></td>
                                    </tr>
                                <?php 
                                    $cnt++;
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?php 
// Pagination Logic
// Count the total number of records for the user
// $total_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM tblbook WHERE UserID = '$userid'");
// Count the total number of records for the user excluding deleted bookings
$total_query = mysqli_query($con, "
    SELECT COUNT(*) AS total 
    FROM tblbook 
    WHERE UserID = '$userid' AND deleted_at IS NULL
");
$total_result = mysqli_fetch_assoc($total_query);
$total_records = $total_result['total'];
$total_pages = ceil($total_records / $limit); // Calculate total pages

// Display pagination links
echo '<div class="pagination" style="text-align: center;">';
for ($i = 1; $i <= $total_pages; $i++) {
    echo '<a href="?page=' . $i . '" class="btn btn-secondary" style="margin: 0 5px;">' . $i . '</a>';
}
echo '</div>';
?>
            </div>
        </div>
    </div>
</section>


<?php include_once('includes/footer.php');?>

<!-- move top button and scripts -->
<button onclick="topFunction()" id="movetop" title="Go to top">
    <span class="fa fa-long-arrow-up"></span>
</button>

<script>
    window.onscroll = function () { scrollFunction() };
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("movetop").style.display = "block";
        } else {
            document.getElementById("movetop").style.display = "none";
        }
    }
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
</body>
</html>
<?php } ?>
