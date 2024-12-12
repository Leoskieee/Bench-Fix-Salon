<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Win Salon | Terms and Conditions</title>

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
					Terms and Conditions
                </h3>
            </div>
</div>
   </div>
   <div class="breadcrumbs-sub">
   <div class="container">   
    <ul class="breadcrumbs-custom-path">
        <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
        <li class="active ">Terms and Conditions</li>
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
                    <h3>Please read these Terms and Conditions carefully before using our website.</h3>
                    <p>By accessing or using this website, you agree to be bound by these Terms and Conditions and all applicable laws and regulations. If you do not agree to all of these terms, you are prohibited from using this site.</p>

                    <h4>Intellectual Property</h4>
                    <p>The content of this website, including but not limited to the text, graphics, logos, images, and software, is the property of Win Salon or its licensors and is protected by copyright and other intellectual property laws. You may not reproduce, modify, distribute, or commercially exploit any of the content without the express written permission of Win Salon.</p>

                    <h4>Use of the Website</h4>
                    <p>You may use this website for your personal, non-commercial use only. You may not use this website for any illegal or unauthorized purpose, including but not limited to:</p>
                    <ul>
                        <li>Violating any local, state, national, or international law or regulation.</li>
                        <li>Infringing upon the intellectual property rights of others.</li>
                        <li>Transmitting any harmful or malicious content, such as viruses or malware.</li>
                        <li>Interfering with or disrupting the website or its servers.</li>
                        <li>Collecting or storing personal data about other users without their consent.</li>
                    </ul>

                    <h4>Disclaimer</h4>
                    <p>The information on this website is provided "as is" without warranty of any kind, express or implied, including but not limited to the warranties of merchantability, fitness for a particular purpose, or non-infringement. Win Salon does not warrant that the website will be error-free, uninterrupted, or secure, or that any defects will be corrected.</p>

                    <h4>Limitation of Liability</h4>
                    <p>In no event shall Win Salon, its affiliates, or their respective officers, directors, employees, or agents be liable for any direct, indirect, incidental, special, consequential, or punitive damages arising out of or in connection with your use of the website or its content.</p>

                    <h4>Indemnification</h4>
                    <p>You agree to indemnify and hold harmless Win Salon, its affiliates, and their respective officers, directors, employees, and agents from and against any and all claims, liabilities, damages, losses, costs, and expenses, including reasonable attorney's fees, arising out of or in connection with your use of the website or your violation of these Terms and Conditions.</p>

                    <h4>Governing Law</h4>
                    <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of the State of [State], without regard to its conflict of law provisions.</p>

                    <h4>Changes to Terms and Conditions</h4>
                    <p>Win Salon reserves the right to modify or amend these Terms and Conditions at any time without prior notice. Your continued use of the website after any such modifications or amendments will constitute your acceptance of the revised Terms and Conditions.</p>

                    <h4>Contact Us</h4>
                    <p>If you have any questions or concerns about these Terms and Conditions, please contact us at [contact email address] or [contact phone number].</p>
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