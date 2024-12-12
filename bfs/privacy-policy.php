<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Win Salon | Privacy Policy</title>

    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body id="home">
<?php include_once('includes/header.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script> <script src="assets/js/bootstrap.min.js"></script>
<script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>
<section class="w3l-inner-banner-main">
        <div class="about-inner about ">
            <div class="container">   
                <div class="main-titles-head text-center">
                <h3 class="header-name ">
					Privacy Policy
                </h3>
            </div>
</div>
   </div>
   <div class="breadcrumbs-sub">
   <div class="container">   
    <ul class="breadcrumbs-custom-path">
        <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
        <li class="active ">Privacy Policy</li>
    </ul>
</div>
</div>
        </div>
    </section>
<section class="w3l-content-with-photo-4"  id="about">
    <div class="content-with-photo4-block ">
        <div class="container">
            <div class="cwp4-text col-xl-12">
                <div class="posivtion-grid">
                    <h3>Your Privacy is Important to Us</h3>
                    <p>At Win Salon, we are committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and disclose your personal information when you use our website and services.</p>

                    <h4>Information We Collect</h4>
                    <p>We may collect the following types of personal information:</p>
                    <ul>
                        <li>**Personal Information:** Name, email address, phone number, and other contact information.</li>
                        <li>**Payment Information:** Credit card or debit card information.</li>
                        <li>**Booking Information:** Appointment dates and times, services booked, and any special requests.</li>
                    </ul>

                    <h4>How We Use Your Information</h4>
                    <p>We use your personal information to:</p>
                    <ul>
                        <li>Process your bookings and appointments.</li>
                        <li>Provide you with our services.</li>
                        <li>Communicate with you about your appointments and other relevant information.</li>
                        <li>Improve our services and website.</li>
                        <li>Comply with legal obligations.</li>
                    </ul>

                    <h4>Sharing Your Information</h4>
                    <p>We may share your personal information with third-party service providers who assist us in providing our services, such as payment processors and marketing platforms. We will only share the necessary information to fulfill their specific functions.</p>

                    <h4>Data Security</h4>
                    <p>We implement appropriate security measures to protect your personal information from unauthorized access, use, or disclosure. However, please be aware that no method of transmission over the Internet or electronic storage is 100% secure.</p>

                    <h4>Your Rights</h4>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access your personal information.</li>
                        <li>Correct any inaccuracies in your personal information.</li>
                        <li>Request the deletion of your personal information.</li>
                        <li>Object to the processing of your personal information.</li>
                        <li>Restrict the processing of your personal information.</li>
                        <li>Data portability.</li>
                    </ul>

                    <h4>Changes to This Privacy Policy</h4>
                    <p>We may update this Privacy Policy from time to time. We will notify you of any significant changes by posting a notice on our website or by contacting you directly.</p>

                    <h4>Contact Us</h4>
                    <p>If you have any questions or concerns about this Privacy Policy, please contact us at [contact email address] or [contact phone number].</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php');?>
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-long-arrow-up"></span>
</button>
<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function () {
		scrollFunction()
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
</script>
</body>

</html>