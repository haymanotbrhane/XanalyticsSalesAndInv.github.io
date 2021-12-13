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
$customer = find_price_by_id($_GET["id"]);
if (!$customer) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("price.php");
}

$id = $customer["id"];

$query = "DELETE FROM price WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Price deleted.";

    redirect_to("price.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Price deletion failed.";
    redirect_to("price.php");
}

?>

