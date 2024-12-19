<?php 
session_start();
error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/dbconnection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (strlen($_SESSION['bpmsuid']) == 0) {
    header('location:logout.php');
} else {
    $availabilityMessage = ""; // Initialize availability message

    // Query to get dates that have exceeded the appointment limit (3 appointments per day)
    $exceededDatesQuery = mysqli_query($con, "SELECT AptDate FROM tblbook GROUP BY AptDate HAVING COUNT(*) >= 3");
    $exceededDates = [];
    while ($row = mysqli_fetch_assoc($exceededDatesQuery)) {
        $exceededDates[] = $row['AptDate']; // Store the dates in an array
    }

    $exceededDatesJson = json_encode($exceededDates); // Convert the array to JSON
    function convertTo24HourFormat($time) {
        $time = trim($time); // Remove any extra spaces
        $time = date("H:i:s", strtotime($time)); // Convert 12-hour to 24-hour format
        return $time;
    }

    if (isset($_POST['submit'])) {
        $uid = $_SESSION['bpmsuid'];
        $adate = $_POST['adate'];
        $atime = $_POST['atime'];
        $service = $_POST['service'];
        $msg = $_POST['message'];
        $aptnumber = mt_rand(100000000, 999999999);
        
        // Convert time to 24-hour format
        $atime = convertTo24HourFormat($atime);

        //get Email
        $query = mysqli_query($con, "SELECT email FROM tbluser WHERE id = $uid");
        $result = mysqli_fetch_assoc($query);
        $Uemail = $result['email'];

        $totalPrice = (int) $_POST['Service_Total_Price']; // Get the total price from the form

        $countQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE AptDate = '$adate'");
        $countResult = mysqli_fetch_array($countQuery);
        $totalAppointments = $countResult['total'];

        if ($totalAppointments < 3) {
            $hourlyQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE AptDate = '$adate' AND AptTime = '$atime'");
            $hourlyResult = mysqli_fetch_array($hourlyQuery);
            $totalHourlyAppointments = $hourlyResult['total'];

            if ($totalHourlyAppointments < 1) {
                // Insert the appointment if both daily and hourly limits are not exceeded
                $query = mysqli_query($con, "INSERT INTO tblbook(UserID, AptNumber, AptDate, AptTime, Service, Message, Service_Total_Price) 
                    VALUES ('$uid', '$aptnumber', '$adate', '$atime', '$service', '$msg', '$totalPrice')");

                if ($query) {
                    $ret = mysqli_query($con, "SELECT AptNumber FROM tblbook WHERE tblbook.UserID='$uid' ORDER BY ID DESC LIMIT 1;");
                    $result = mysqli_fetch_array($ret);
                    $_SESSION['aptno'] = $result['AptNumber'];

                // require __DIR__ . "/vendor/autoload.php";
                require __DIR__ . "../../vendor/autoload.php";

                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPAuth = true;
                        $mail->Username = "leonardr009@gmail.com";
                        $mail->Password = "llgp swji majk hqwh";
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                        $mail->Port = 587;

                        $mail->setFrom($Uemail);
                        $mail->addAddress("leonardr009@gmail.com", "ADMIN");

                        $mail->isHTML(true);
                        $mail->Subject = "Win Salon Appointment Request";
                        $aptnumber = $_SESSION['aptno'] = $result['AptNumber'];
                        $mail->Body = "Win Salon website has recieved new appointment request : $aptnumber : go to website to see details";

                        $mail->send();
                        echo "<script>window.location.href='thank-you.php'</script>";
                    } catch (Exception $e) {
                        $availabilityMessage = "Mailer Error: " . $mail->ErrorInfo;
                    }

                } else {
                    $availabilityMessage = "Something went wrong. Please try again.";
                }
            } else {
                $availabilityMessage = "JP Sorry, this time slot is already booked. Please choose another time.";
            }
        } else {
            $availabilityMessage = "JP Sorry, we're fully booked for today. Please try another day.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Win Salon | Appointment Page</title>
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .service-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .service-group label {
            /* width: 50%; */
            flex: 1 1 20%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            width: initial !important;
            height: initial !important;
            padding: 1rem !important;
            border: 1px solid #999;
            border-radius: 0.3rem;
            margin-bottom: 0 !important;
        }

        .service-group input {
            appearance: auto;
            width: 1rem !important;
            height: 1rem !important;
            padding: 0 !important;
        }

        .service-group .service-and-price {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
    </style>
</head>
<body id="home">
    <?php include_once('includes/header.php');?>

    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script> <!-- //bootstrap working -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                             <select class="form-control appointment_time" name="atime" id="atime" required="true">
                                <option value="">Select Time</option>
                            </select>
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Select Service</label>
                            <div class="service-group" id="services">
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM tblservices");
                                
                                while ($row = mysqli_fetch_array($query)) {
                                    $serviceName = $row['ServiceName'];
                                    $servicePrice = $row['Cost'];
                                    echo '<label>';
                                    echo '<input type="checkbox" class="service-checkbox" data-price="' . $servicePrice . '" name="service[]" value="' . $serviceName . ' - ' . $servicePrice . '">';
                                    echo '<div class="service-and-price">';
                                    echo '<span class="service-name">' . $serviceName . '</span>';
                                    echo '<span class="service-price">₱' . $servicePrice . '</span>';
                                    echo '<span class="service-duration">(';
                                            $timeInMinutes = $row['Time'];

                                            if ($timeInMinutes < 60) {
                                                echo $timeInMinutes . " mins";  // For times less than 60 minutes
                                            } else {
                                                $hours = floor($timeInMinutes / 60); // Calculate hours
                                                $minutes = $timeInMinutes % 60; // Calculate remaining minutes
                                                echo $hours . " hr";  // Print hours
                                                if ($minutes > 0) {
                                                    echo " " . $minutes . " mins"; // Append minutes if any
                                                }
                                            }
                                    echo ') </ span> </div>';
                                    echo '</label>';
                                }
                                ?>
                            </div>                       

                            <div class="total-price">
                                <span>Total Price:</span>
                                <span id="totalPrice">₱0</span>
                                <!-- The input where you want to store the total price -->
                                <input type="hidden" id="totalPriceInput" value="₱0" name="Service_Total_Price">
                            </div>
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

$(document).ready(function() {
    let exceededDates = <?php echo $exceededDatesJson; ?>;

    // Convert PHP dates (which are in string format) to JavaScript Date objects in the correct format
    let disabledDates = exceededDates.map(function(date) {
        return date; // Ensure the date is in 'YYYY-MM-DD' format
    });
    
    // Initialize Flatpickr for the appointment date input
    flatpickr("#adate", {
        minDate: "today", // Prevent selecting past dates
        dateFormat: "Y-m-d", // Format in the format compatible with your backend (e.g., YYYY-MM-DD)
        disable: [
            function(date) {
                // Disable weekends (Saturday: 6, Sunday: 0)
                return (date.getDay() === 0 || date.getDay() === 6); // Disable Sundays and Saturdays
            },
            ...exceededDates // Add the dates with exceeded appointments
        ],
        onChange: function(selectedDates, dateStr, instance) {
            // AJAX call to check appointment count for selected date
            $.ajax({
                url: 'includes/check_appointments.php', // Create a PHP file to handle the check
                method: 'GET',
                data: { date: dateStr },
                success: function(response) {
                    // Parse the response to get the total number of appointments
                    var totalAppointments = parseInt(response);

                    // Disable the date if the limit (3 appointments) is exceeded
                    if (totalAppointments >= 3) {
                        alert('Sorry, we are fully booked for this day.');
                        instance.clear(); // Clear the date field if the date is disabled
                    }
                },
                error: function() {
                    console.error('Error checking the number of appointments.');
                }
            });
        },
    });

    $('#adate').change(function() {
    var selectedDate = $(this).val();
    var timeSelect = $("#atime");

    // Clear existing options in time dropdown
    timeSelect.empty();
    timeSelect.append('<option value="">Select Time</option>');

    // Define start, end, and excluded hour (12 PM for lunch)
    const startHour = 9;
    const endHour = 21;
    const excludedHour = 12;
    
    // Function to format time in AM/PM format
    function formatTime(hour) {
        const period = hour >= 12 ? "PM" : "AM";
        const formattedHour = (hour % 12) || 12; // Convert 0 to 12 for 12-hour format
        return `${formattedHour} ${period}`;
    }

    // Get the current time to disable past slots
    var currentTime = new Date();
    var currentHour = currentTime.getHours();
    var currentMinutes = currentTime.getMinutes();

    // Generate time options
    for (let hour = startHour; hour <= endHour; hour++) {
        if (hour === excludedHour) continue; // Skip 12 PM (lunch time)

        const optionValue = `${hour}:00`;
        const optionText = formatTime(hour);

        // Disable past time slots
        if (hour < currentHour || (hour === currentHour && currentMinutes > 0)) {
            timeSelect.append(`<option value="${optionValue}" disabled>${optionText} (Unavailable)</option>`);
            continue;
        }

        // Check if this time is available
        $.get('includes/check_time_availability.php', { checkTimeAvailability: true, adate: selectedDate, atime: optionValue }, function(response) {
            const data = JSON.parse(response);
            if (data.available) {
                timeSelect.append(`<option value="${optionValue}">${optionText}</option>`);
            } else {
                // Disable the option if not available
                timeSelect.append(`<option value="${optionValue}" disabled>${optionText} (Unavailable)</option>`);
            }
        });
    }
});
    
});

$(document).ready(function() {
    // Store the services and total price
    var selectedServices = [];
    var totalPrice = 0;

    // Update the total price and selected services when a checkbox is clicked
    $('.service-checkbox').change(function() {
        var serviceName = $(this).val();
        var servicePrice = parseFloat($(this).data('price'));

        // If the checkbox is checked, add the service and price
        if ($(this).is(':checked')) {
            selectedServices.push(serviceName);
            totalPrice += servicePrice;
        } else {
            // If the checkbox is unchecked, remove the service and subtract the price
            var index = selectedServices.indexOf(serviceName);
            if (index > -1) {
                selectedServices.splice(index, 1);
                totalPrice -= servicePrice;
            }
        }

        // Update the total price and the selected services
        $('#totalPrice').text('₱' + totalPrice.toFixed(2));
    });

    // Submit the form and pass the selected services and total price
    $('form').submit(function() {
        // Add the selected services to the form
        $('<input>').attr({
            type: 'hidden',
            name: 'service',
            value: selectedServices.join(', ')  // Join the services with commas
        }).appendTo(this);

        // Add the total price to the form
        $('<input>').attr({
            type: 'hidden',
            name: 'Service_Total_Price',
            value: totalPrice.toFixed(2)
        }).appendTo(this);
    });
});

</script>
<!-- /move top -->
</body>
</html>
