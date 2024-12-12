<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['bpmsuid']) || empty($_SESSION['bpmsuid'])) {
        echo "<script>alert('Please log in to provide feedback.');</script>";
        echo "<script>window.location.href='login.php';</script>";
        exit();
    }

    $user_id = $_SESSION['bpmsuid'];
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    // Validate input
    if ($rating < 1 || $rating > 5) {
        echo "<script>alert('Please provide a valid rating between 1 and 5 stars.');</script>";
    } else {
        // Insert feedback into database
        $query = "INSERT INTO tblfeedback (user_id, rating, comment) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('iis', $user_id, $rating, $comment);

        if ($stmt->execute()) {
            echo "<script>alert('Thank you for your feedback!');</script>";
        } else {
            echo "<script>alert('Failed to submit feedback. Please try again.');</script>";
        }

        $stmt->close();
    }
}
  ?>
<!doctype html>
<html lang="en">
  <head>
    

    <title>Products| Products Page </title>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

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
    <div class="about-inner services ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">
                
            </h3>
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">Feedback</li>
</ul>
</div>
</div>
    </div>
</section>

<div class="container mt-5 mb-5">
        <h2>Provide Your Feedback</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5):</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="">Select Rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment (Optional):</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your comment here..."></textarea>
            </div>
            <button type="submit" class="btn" style="background: #39104b; color: #fff">Submit Feedback</button>
        </form>
    </div>

<?php include_once('includes/footer.php');?>
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