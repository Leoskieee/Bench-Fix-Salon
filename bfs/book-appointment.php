<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('includes/check_availability.php');
if (strlen($_SESSION['bpmsuid']) == 0) {
    header('location:logout.php');
} else {
    $availabilityMessage = ""; // Initialize availability message

    if (isset($_POST['submit'])) {
        $uid = $_SESSION['bpmsuid'];
        $adate = $_POST['adate'];
        $atime = $_POST['atime'];
        $service = $_POST['service'];
        $msg = $_POST['message'];
        $aptnumber = mt_rand(100000000, 999999999);

        // Check how many appointments exist for the selected date
        $countQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE AptDate = '$adate'");
        $countResult = mysqli_fetch_array($countQuery);
        $totalAppointments = $countResult['total'];

        if ($totalAppointments < 10) {
            // Insert the appointment if less than 10
            $query = mysqli_query($con, "INSERT INTO tblbook(UserID, AptNumber, AptDate, AptTime, Service, Message) 
                VALUES ('$uid', '$aptnumber', '$adate', '$atime', '$service', '$msg')");

            if ($query) {
                $ret = mysqli_query($con, "SELECT AptNumber FROM tblbook WHERE tblbook.UserID='$uid' ORDER BY ID DESC LIMIT 1;");
                $result = mysqli_fetch_array($ret);
                $_SESSION['aptno'] = $result['AptNumber'];
                echo "<script>window.location.href='thank-you.php'</script>";  
            } else {
                $availabilityMessage = "Something Went Wrong. Please try again.";
            }
        } else {
            $availabilityMessage = "Sorry, we're fully booked right now. Please try another day.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Bench Fix Salon | Appointment Page</title>
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body id="home">
<?php include_once('includes/header.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
<script src="assets/js/bootstrap.min.js"></script> <!-- //bootstrap working -->
<script>
$(function () {
    $('.navbar-toggler').click(function () {
        $('body').toggleClass('noscroll');
    });
});
</script>

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact">
        <div class="container">   
            <div class="main-titles-head text-center">
                <h3 class="header-name "></h3>
                <p class="tiltle-para "></p>
            </div>
        </div>
    </div>
    <div class="breadcrumbs-sub">
        <div class="container">   
            <ul class="breadcrumbs-custom-path">
                <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a></li>
                <li class="active ">Book Appointment</li>
            </ul>
        </div>
    </div>
</section>
<!-- breadcrumbs //-->

<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec">
        <div class="container">
            <div class="d-grid contact-view">
                <div class="map-content-9 mt-lg-0 mt-4">
                    <?php if (!empty($availabilityMessage)) : ?>
                        <div id="availabilityMessage" style="color: red; font-weight: bold;">
                            <?php echo $availabilityMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <div style="padding-top: 30px;">
                            <label>Appointment Date</label>
                            <input type="date" class="form-control appointment_date" placeholder="Date" name="adate" id='adate' required="true">
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Appointment Time</label>
                            <input type="time" class="form-control appointment_time" placeholder="Time" name="atime" id='atime' required="true">
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Select Service</label>
                            <select class="form-control" name="service" required="true">
                                <option value="">Choose a service</option>
                                <option value="Haircut">Haircut</option>
                                <option value="Hair Color">Hair Color</option>
                                <option value="Hair Treatment">Hair Treatment</option>
                                <option value="Manicure">Manicure</option>
                                <option value="Pedicure">Pedicure</option>
                                <option value="Facial">Facial</option>
                            </select>
                        </div>
                        <div style="padding-top: 30px;">
                            <textarea class="form-control" id="message" name="message" placeholder="Message" required=""></textarea>
                        </div>
                        <button type="submit" class="btn btn-contact" name="submit">Make an Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php');?>
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
    <span class="fa fa-long-arrow-up"></span>
</button>
<script>
$(document).ready(function() {
    $('#adate').change(function() {
        var selectedDate = $(this).val();

        // Make an AJAX request to check availability
        $.ajax({
            url: 'check_availability.php',
            type: 'GET',
            data: { date: selectedDate },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.fully_booked) {
                    // Show the availability message
                    $('#availabilityMessage').text("Sorry, we're fully booked on this date. Please choose another day.").show();
                } else {
                    // Hide the message if not fully booked
                    $('#availabilityMessage').hide();
                }
            },
            error: function() {
                $('#availabilityMessage').text("An error occurred while checking availability. Please try again later.").show();
            }
        });
    });
});

// Scroll to top functionality
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("movetop").style.display = "block";
    } else {
        document.getElementById("movetop").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

$(function(){
    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10) month = '0' + month.toString();
    if(day < 10) day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#adate').attr('min', maxDate);
});
</script>
<!-- /move top -->
</body>
</html>
