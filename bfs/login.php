<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);

if(isset($_POST['login']))
  {
    $emailcon=$_POST['emailcont'];
    $password=md5($_POST['password']);

    $query=mysqli_query($con,"select ID from tbladmin where  UserName='$emailcon' && Password='$password' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
      $_SESSION['bpmsaid']=$ret['ID'];
     header('location:admin/dashboard.php');
    }
    else{
        $query=mysqli_query($con,"select ID from tbluser where  (Email='$emailcon' || MobileNumber='$emailcon') && Password='$password' ");
        $ret=mysqli_fetch_array($query);
        if($ret>0){
            $_SESSION['bpmsuid']=$ret['ID'];
            header('location:index.php');
        }
        else{
        echo "<script>alert('Invalid Details.');</script>";
        }
    }

    
    } 
?>
<!doctype html>
<html lang="en">
  <head>
 

    <title>Bench Fix Salon | Login</title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
      .user-form {
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: row-reverse;
      }
      .user-form > * {
        width: 100%;
      }

      .w3l-inner-banner-main {
        background-repeat: repeat;
        background: url("./assets/images/b8.jpg") no-repeat bottom center;
        background-size: cover !important;
      }

      .w3l-inner-banner-main .about-inner:before, .w3l-inner-banner-main .contact {
        background: none !important;
      }

      /* form */
      .w3l-contact-info-main .container {
        padding-inline: 6rem;
      }

      .w3l-contact-info-main .container .nav-link {
        padding-inline: 0;
        padding-block: 1rem;
      }
    </style>
  </head>
  <body id="home" class="user-form">
<?php // include_once('includes/header.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
<!--bootstrap working-->
<script src="assets/js/bootstrap.min.js"></script>
<!-- //bootstrap working-->
<!-- disable body scroll which navbar is in active -->
<script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>
<!-- disable body scroll which navbar is in active -->

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">
                
 
            </h3>
        </div>
</div>
</div>
<!-- <div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">
        Login</li>
</ul>
</div>
</div> -->
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact" style="align-self: center;">
    <div class="contact-sec	">
        <div class="container">

            <div class="d-grid contact-view">
                
                <div class="map-content-9 mt-lg-0 mt-4">
                  <h3 style="color: #6f42c1; font-weight: 900; margin-bottom: 2rem !important">Login your account</h3>
                    <form method="post">
                        <div>
                            <input type="text" class="form-control" name="emailcont" required="true" placeholder="Registered Email or Contact Number" required="true">
                           
                        </div>
                        <div style="padding-top: 30px;">
                          <input type="password" class="form-control" name="password" placeholder="Password" required="true">
                        
                        </div>
                        
                        <div class="twice-two fl-c" style="margin-bottom: 0;">
                            <a class="nav-link" href="signup.php">Don't have an account yet? Signup</a>
                            <a class="link--gray" style="color: blue; justify-self: flex-end;" href="forgot-password.php">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-contact" name="login">Login</button>
                    </form>
                </div>
    </div>
   
    </div></div>
</section>
<!-- <?php include_once('includes/footer.php');?> -->
<!-- move top -->
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
<!-- /move top -->
</body>

</html>