<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('dbconnection.php');

// Get the search query
$query = isset($_POST['query']) ? $_POST['query'] : '';

if ($query) {
    // SQL query to fetch services matching the search term
    $sql = "SELECT * FROM tblservices 
            WHERE LOWER(ServiceName) LIKE LOWER(?) 
            OR LOWER(ServiceDescription) LIKE LOWER(?)";
    $stmt = $con->prepare($sql);
    $searchTerm = "%" . strtolower($query) . "%"; // Ensure the query is lowercase
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6 propClone" style="margin: 0; margin-block: 2rem;">
                <img src="admin/images/services/<?php echo $row['Image']; ?>" 
                     alt="<?php echo $row['ServiceName']; ?>" 
                     height="300" width="400" 
                     class="img-responsive about-me" 
                     style="object-fit: cover;">
                <div class="about-grids">
                    <hr>
                    <h5 class="para"><?php echo $row['ServiceName']; ?></h5>
                    <p class="para"><?php echo $row['ServiceDescription']; ?></p>
                    <p class="para" style="color: hotpink;">Cost of Service: ₱<?php echo $row['Cost']; ?></p>
                </div>
            </div>
            <?php
        }
    } 
    // else {
    //     echo '<p style="margin-block-start: 1rem">No matching services found.</p>';
    // }
}

// Get the search query
$query = isset($_POST['query']) ? $_POST['query'] : '';

if ($query) {
    // SQL query to fetch products matching the search term
    $sql = "SELECT * FROM tblproducts 
            WHERE LOWER(product_name) LIKE LOWER(?) 
            OR LOWER(product_desc) LIKE LOWER(?)";
    $stmt = $con->prepare($sql);
    $searchTerm = "%" . strtolower($query) . "%"; // Ensure the query is lowercase
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6 propClone" style="margin: 0; margin-block: 2rem;">
                <img src="admin/images/products/<?php echo $row['product_image']; ?>" 
                     alt="<?php echo $row['product_name']; ?>" 
                     height="300" width="400" 
                     class="img-responsive about-me" 
                     style="object-fit: cover;">
                <div class="about-grids">
                    <hr>
                    <h5 class="para"><?php echo $row['product_name']; ?></h5>
                    <p class="para"><?php echo $row['product_desc']; ?></p>
                    <p class="para" style="color: hotpink;">Price: ₱<?php echo $row['product_price']; ?></p>
                </div>
            </div>
            <?php
        }
    } 
    // else {
    //     echo '<p style="margin-block-start: 1rem">No matching products found.</p>';
    // }
}
?>
