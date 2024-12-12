<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
error_reporting(0);

if(isset($_POST['submit']))
  {
    $agree = isset($_POST['agree']) ? $_POST['agree'] : false;
    if (!$agree) {
        echo "<script>alert('You must agree to the Terms and Conditions and Privacy Policy to sign up.');</script>";
        exit;
    }

    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $contno=$_POST['mobilenumber'];
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash("sha256", $activation_token);

    $ret=mysqli_query($con, "select Email from tbluser where Email='$email' || MobileNumber='$contno'");
    $result=mysqli_fetch_array($ret);
    if($result>0){

echo "<script>alert('This email or Contact Number already associated with another account!.');</script>";
    }
    else{
    $query=mysqli_query($con, "insert into tbluser(FirstName, LastName, MobileNumber, Email, Password, account_activation_hash) value('$fname', '$lname','$contno', '$email', '$password', '$activation_token_hash')");
    

    if ($query) {
      require __DIR__ . "/vendor/autoload.php";

      $mail = new PHPMailer(true);

      $mail->isSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPAuth = true;
      $mail->Username = "leonardr009@gmail.com";
      $mail->Password = "llgp swji majk hqwh";
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
      $mail->Port = 587;

      $mail->setFrom("leonardr009@gmail.com");
      $mail->addAddress($email);
      $baseUrl = "http://winsaloncapstone.lovestoblog.com/";
      $activationUrl = $baseUrl . "/includes/email_activation.php?token=$activation_token";

      $mail->isHTML(true);
      $mail->Subject = "Win Salon Email Verification";
      $mail->Body = <<<END

      <p>Hello $fname $lname Thank you for signing up! Please click the link below to Verify your account:</p>
      <p><a href="$activationUrl">Verify your account</a></p>

      END;

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        exit;
    }

    echo "<script>alert('You have successfully registered.');</script>";
  }
  else
    {
    
      echo "<script>alert('Something Went Wrong. Please try again.');</script>";
    }
}
}
?>
<!doctype html>
<html lang="en">
  <head>
 

    <title>Win Salon | Signup Page</title>

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
        padding-block-start: 4rem;
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

      .field-group {
        width: 100%;
        display: flex;
        gap: 1rem;
      }

      .field-group > * {
        width: 100%;
      }

      .w3l-contact-info-main .container .nav-link {
        padding-inline: 0;
        padding-block: 1rem;
      }

      /* Default styling for larger screens */
      .field-group {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
      }

      .field-group > div {
        width: 48%; /* You can adjust the width to fit your design */
        padding-top: 30px;
      }

      .field-group input {
        width: 100%;
      }

      /* Media Queries */
      @media (max-width: 1200px) {
        .w3l-contact-info-main .container {
          padding-inline: 3rem;
        }

        .map-content-9 h3 {
          font-size: 1.8rem;
        }

        .field-group > div {
          width: 100%; 
          padding-top: 15px;
        }
      }

      @media (max-width: 768px) {
        .w3l-contact-info-main .container {
          padding-inline: 1.5rem;
        }

        .twice-two.fl-c {
          display: flex;
          flex-direction: column;
          gap: 10px;
          margin-bottom: 20px;
        }

        .map-content-9 h3 {
          font-size: 1.5rem;
          text-align: center;
        }

        .btn.btn-contact {
          width: 100%;
          margin-top: 1rem;
        }

        .field-group > div {
          width: 100%; 
          padding-top: 15px;
        }
      }

      @media (max-width: 576px) {
        .user-form {
          flex-direction: column;
          align-items: center;
          justify-content: flex-start;
          padding-block-start: 0 !important;
        }

        .w3l-contact-info-main .container {
          padding-inline: 1rem;
        }

        .map-content-9 h3 {
          font-size: 1.2rem;
        }

        form input,
        form button {
          font-size: 1rem;
        }

        .btn.btn-contact {
          font-size: 1rem;
        }
      }
    </style>
  
  </head>
  <body id="home" class="user-form">
    <nav style="position: absolute; top: 0">

    <?php include_once('includes/header.php');?>
    </nav>

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
<script type="text/javascript">
function checkpass()
{
if(document.signup.password.value!=document.signup.repeatpassword.value)
{
alert('Password and Repeat Password field does not match');
document.signup.repeatpassword.focus();
return false;
}
return true;
} 
</script>
<!-- disable body scroll which navbar is in active -->

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact">
        <div class="container">   
            <div class="main-titles-head text-center">
              <h3 class="header-name "></h3>
            </div>
        </div>
    </div>
<!-- <div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">
        Signup</li>
</ul>
</div>
</div> -->
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

            <div class="d-grid contact-view">

            <!-- <div class="breadcrumbs-sub">
              <div class="container">   
                <ul class="breadcrumbs-custom-path">
                    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
                    <li class="active ">
                        Signup</li>
                </ul>
              </div>
              </div> -->
                
                <div class="map-content-9 mt-lg-0 mt-4">
                    <h3 style="color: #6f42c1; font-weight: 900;">Register with us!</h3>
                    <form method="post" name="signup" onsubmit="return checkpass();">

                        <div class="field-group">
                          <div style="padding-top: 30px;">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required=""></div>
                           <div style="padding-top: 30px;">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required="">
                        </div>
                        
                        </div>

                        <div class="field-group">
                          <div style="padding-top: 30px;">
                              <label>Mobile Number</label>
                            <input type="text" class="form-control" placeholder="Mobile Number" required="" name="mobilenumber" pattern="[0-9]+" maxlength="10"></div>
                            <div style="padding-top: 30px;">
                              <label>Email address</label>
                              <input type="email" class="form-control" class="form-control" placeholder="Email address" required="" name="email">
                          </div>
                        </div>
                         <div style="padding-top: 30px;">
                            <label>Password</label>
                           <input type="password" class="form-control" name="password" placeholder="Password" required="true">
                       </div>
                       <div style="padding-top: 30px;">
                        <label>Repeat password</label>
                            <input type="password" class="form-control" name="repeatpassword" placeholder="Repeat password" required="true">
                        </div>

                        <a class="nav-link" href="login.php">Already have an account? Login</a>

                        <div style="padding-top: 30px;">
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem">
                                <input type="checkbox" name="agree" id="agree" required style="width: initial !important; height: initial !important; padding: 1rem !important; border: 1px solid #999; border-radius: 0.3rem; margin-bottom: 0 !important; appearance: auto; width: 1rem !important;height: 1rem !important; padding: 0 !important; cursor: pointer;">
                                I agree to the <a href="terms-and-conditions.php" target="_blank">Terms and Conditions</a> and <a href="privacy-policy.php" target="_blank">Privacy Policy</a>.
                            </label>
                        </div>
                      
                        <button type="submit" class="btn btn-contact" name="submit">Signup</button>
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