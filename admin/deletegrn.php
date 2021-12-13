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
$response = find_order_response_by_id($_GET["id"]);
if (!$response) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("orderResponse.php");
}

if ($response["status"] == 1) {
    $_SESSION["art_error"] = "This response/ISIV is already loaded.";
    redirect_to("orderResponse.php");
}

$id = $response["id"];

$query = "DELETE FROM isiv WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Order Response deleted.";

    redirect_to("orderResponse.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Order Response deletion failed.";
    redirect_to("orderResponse.php");
}

?>
