<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
} else{


// Pagination setup
$limit = 10; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit; // Offset calculation

// Get total number of feedbacks
$count_query = "SELECT COUNT(*) AS total FROM tblfeedback";
$result = mysqli_query($con, $count_query);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

// Calculate total pages
$total_pages = ceil($total_records / $limit);

$query = "SELECT tbluser.FirstName, tbluser.LastName, tblfeedback.rating, tblfeedback.comment, tblfeedback.created_at 
          FROM tblfeedback 
          JOIN tbluser ON tbluser.ID = tblfeedback.user_id
          LIMIT $limit OFFSET $offset";

$feedback_ret = mysqli_query($con, $query);

// Check if any rows are returned
if (mysqli_num_rows($feedback_ret) > 0) {
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Win Salon | Feedbacks</title>

<style>
  /* Table styling */
  table {
    width: 100%;
    border-collapse: collapse;
  }

  table th, table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  table th {
    background-color: #f1f1f1;
  }
</style>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href="css/animate.css" rel="stylesheet" type='text/css' media='all'>
<script src="js/wow.min.js"></script>
    <script>
         new WOW().init();
    </script>
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
</head> 
<body class="cbp-spmenu-push">
    <div class="main-content">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>
        <div id="page-wrapper">
            <div class="main-page">
                <h3 class="title1">Client Feedbacks</h3>

                <table class="table table-bordered">
                    <thead>
                        <tr> 
                            <th>Name</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                        </tr> 
                    </thead> 
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($feedback_ret)) {
                        ?>
                        <tr>
                            <td><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                            <td><?php echo $row['comment']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <nav>
                    <ul class="pagination">
                        <?php if ($page > 1) { ?>
                            <li><a href="feedbacks.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li class="<?php if ($i == $page) echo 'active'; ?>">
                                <a href="feedbacks.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($page < $total_pages) { ?>
                            <li><a href="feedbacks.php?page=<?php echo $page + 1; ?>">Next</a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
        <?php include_once('includes/footer.php');?>
    </div>
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
            showLeftPush = document.getElementById( 'showLeftPush' ),
            body = document.body;
            
        showLeftPush.onclick = function() {
            classie.toggle( this, 'active' );
            classie.toggle( body, 'cbp-spmenu-push-toright' );
            classie.toggle( menuLeft, 'cbp-spmenu-open' );
            disableOther( 'showLeftPush' );
        };
            
        function disableOther( button ) {
            if( button !== 'showLeftPush' ) {
                classie.toggle( showLeftPush, 'disabled' );
            }
        }
    </script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/bootstrap.js"> </script>
</body>
</html>
<?php
} else {
  echo "No feedbacks found.";
}
}
?>