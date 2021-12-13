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
$product = find_product_by_id($_GET["id"]);
if (!$product) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("product.php");
}

$id = $product["id"];

$query = "DELETE FROM product WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Product deleted.";

    redirect_to("product.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Product deletion failed.";
    redirect_to("product.php");
}

?>

