<!doctype html>
<html class="fixed">

<head>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: mel
 * Date: 4/22/2016
 * Time: 7:03 AM
 */
?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
$product = find_order_product_by_id($_GET["id"]);
if (!$product) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("orderProduct.php");
}

$id = $product["id"];

$query = "DELETE FROM order_product WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Order Product deleted.";

} else {
    // Failure
    $_SESSION["art_error"] = "Order Product deletion failed.";
}

redirect_to("orderProduct.php");

?>

</body>
</html>
