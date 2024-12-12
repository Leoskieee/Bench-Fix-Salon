<?php
if (!isset($_GET["token"])) {
    die("No token provided.");
}

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = include "dbconnection.php";
$sql = "SELECT * FROM tbluser WHERE account_activation_hash = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user != null) {
    $sql = "UPDATE tbluser SET account_activation_hash = NULL WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user["ID"]); // Assuming user_id is an integer
    $stmt->execute();
    
    echo "<script> alert('Your account is verified you can now login.'); window.close(); </script>";
    exit;
    
}else{
// Redirect or display a friendly error message
echo "<script>alert('Invalid or expired token.'); window.close();</script>";
exit;
    
}
