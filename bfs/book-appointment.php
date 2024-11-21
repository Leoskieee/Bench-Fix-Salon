<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('includes/check_availability.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

        //get Email
        $query = mysqli_query($con, "SELECT email FROM tbluser WHERE id = $uid");
        $result = mysqli_fetch_assoc($query);
        $Uemail = $result['email'];;

         // Initialize total price variable
        $totalPrice = $_POST['Service_Total_Price'];

         // Loop through the selected services and add their prices
        if (!empty($_POST['service']) && is_array($_POST['service'])) {
            foreach ($_POST['service'] as $selectedService) {
                switch ($selectedService) {
                    case 'Hair Botox - 1500':
                        $totalPrice += 1500;
                        break;
                    case 'Haircut - 80':
                        $totalPrice += 80;
                        break;
                    case 'Cellophane - 300':
                        $totalPrice += 300;
                        break;
                    case 'Hair Spa - 300':
                        $totalPrice += 300;
                        break;
                    case 'Rebond - 1000':
                        $totalPrice += 1000;
                        break;
                    case 'Foot Spa - 300':
                        $totalPrice += 300;
                        break;
                    case 'Manicure - 70':
                        $totalPrice += 70;
                        break;
                    case 'Blow-Dry - 120':
                        $totalPrice += 120;
                        break;
                    case 'Hair Extensions - 600':
                        $totalPrice += 600;
                        break;
                    case 'Scalp Treatment - 150':
                        $totalPrice += 150;
                        break;
                    case 'Straightening - 300':
                        $totalPrice += 300;
                        break;
                    case 'Perm - 250':
                        $totalPrice += 250;
                        break;
                }
            }

        }


        // Check how many appointments exist for the selected date
        $countQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblbook WHERE AptDate = '$adate'");
        $countResult = mysqli_fetch_array($countQuery);
        $totalAppointments = $countResult['total'];

        if ($totalAppointments < 10) {
            // Insert the appointment if less than 10
            $query = mysqli_query($con, "INSERT INTO tblbook(UserID, AptNumber, AptDate, AptTime, Service, Message, Service_Total_Price) 
                VALUES ('$uid', '$aptnumber', '$adate', '$atime', '$service', '$msg', '$totalPrice')");

            if ($query) {
                $ret = mysqli_query($con, "SELECT AptNumber FROM tblbook WHERE tblbook.UserID='$uid' ORDER BY ID DESC LIMIT 1;");
                $result = mysqli_fetch_array($ret);
                $_SESSION['aptno'] = $result['AptNumber'];

                require __DIR__ . "/../vendor/autoload.php";

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
    
    <script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
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
                            <!-- <input type="time" class="form-control appointment_time" placeholder="Time" name="atime" id='atime' required="true"> -->
                             <select class="form-control appointment_time" name="atime" id="atime" required="true">
                                <option value="">Select Time</option>
                            </select>
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Select Service</label>
                            <div class="service-group" id="services">
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="1500" value="Hair Botox - 1500">
                                    <div class="service-and-price">
                                        <span class="service-name">Hair Botox</span>
                                        <span class="service-price">₱1500</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="80" value="Haircut - 80">
                                    <div class="service-and-price">
                                        <span class="service-name">Haircut</span>
                                        <span class="service-price">₱80</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="300" value="Cellophane - 300">
                                    <div class="service-and-price">
                                        <span class="service-name">Cellophane</span>
                                        <span class="service-price">₱300</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="300" value="Hair Spa - 300">
                                    <div class="service-and-price">
                                        <span class="service-name">Hair Spa</span>
                                        <span class="service-price">₱300</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="1000" value="Rebond - 1000">
                                    <div class="service-and-price">
                                        <span class="service-name">Rebond</span>
                                        <span class="service-price">₱1000</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="300" value="Foot Spa - 300">
                                    <div class="service-and-price">
                                        <span class="service-name">Foot Spa</span>
                                        <span class="service-price">₱300</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="70" value="Manicure - 70">
                                    <div class="service-and-price">
                                        <span class="service-name">Manicure</span>
                                        <span class="service-price">₱70</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="120" value="Blow-Dry - 120">
                                    <div class="service-and-price">
                                        <span class="service-name">Blow-Dry</span>
                                        <span class="service-price">₱120</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="600" value="Hair Extensions - 600">
                                    <div class="service-and-price">
                                        <span class="service-name">Hair Extensions</span>
                                        <span class="service-price">₱600</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="150" value="Scalp Treatment - 150">
                                    <div class="service-and-price">
                                        <span class="service-name">Scalp Treatment</span>
                                        <span class="service-price">₱150</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="300" value="Straightening - 300">
                                    <div class="service-and-price">
                                        <span class="service-name">Straightening</span>
                                        <span class="service-price">₱300</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="checkbox" class="service-checkbox" name="service[]" data-price="250" value="Perm - 250">
                                    <div class="service-and-price">
                                        <span class="service-name">Perm</span>
                                        <span class="service-price">₱250</span>
                                    </div>
                                </label>
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


$(document).ready(function() {
    // Initialize Flatpickr for the appointment date input
    flatpickr("#adate", {
        minDate: "today", // Prevent selecting past dates
        dateFormat: "Y-m-d", // Format in the format compatible with your backend (e.g., YYYY-MM-DD)
        enable: [
            function(date) {
                // return true if date is a weekday, false if it's a weekend
                return (date.getDay() !== 0 && date.getDay() !== 6);
            }
        ],
        onChange: function(selectedDates, dateStr, instance) {
            var selectedDate = dateStr;
            // AJAX request to check availability for selected date
            $.ajax({
                url: 'check_availability.php',
                type: 'GET',
                data: { date: selectedDate },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.fully_booked) {
                        $('#availabilityMessage').text("Sorry, we're fully booked on this date. Please choose another day.").show();
                    } else {
                        $('#availabilityMessage').hide();
                    }
                },
                error: function() {
                    $('#availabilityMessage').text("An error occurred while checking availability. Please try again later.").show();
                }
            });
        }
    });
    
    // Populate time slots in the dropdown
    const timeSelect = document.getElementById("atime");
    
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

    // Generate time options
    for (let hour = startHour; hour <= endHour; hour++) {
        if (hour === excludedHour) continue; // Skip 12 PM (lunch time)

        const option = document.createElement("option");
        option.value = `${hour}:00`;
        option.textContent = formatTime(hour);
        timeSelect.appendChild(option);
    }

    $('.navbar-toggler').click(function () {
        $('body').toggleClass('noscroll');
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

// // Assuming you calculate the total price dynamically
// let totalPrice = 0; // Example total price value

// // Get the elements
// let totalPriceElement = document.getElementById('totalPrice');
// let totalPriceInput = document.getElementById('totalPriceInput');

// // Update the displayed total price
// totalPriceElement.textContent = `₱${totalPrice}`;

// // Store the total price in the input field (hidden)
// totalPriceInput.value = `₱${totalPrice}`;

$(document).ready(function() {
    // Update the total price when a checkbox is clicked
    $('input[name="service[]"]').change(function() {
        let totalPrice = 0;

        $('input[name="service[]"]:checked').each(function() {
            totalPrice += parseInt($(this).data('price'));
        });

        $('#totalPrice').text('₱' + totalPrice);
        $('#totalPriceInput').val(totalPrice); // Update the hidden input
    });
});



</script>
<!-- /move top -->
</body>
</html>
