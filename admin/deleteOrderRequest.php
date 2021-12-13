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
$request = find_order_request_by_id($_GET["id"]);
if (!$request) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("orderRequest.php");
}

if ($request["status"] == 1) {
    $_SESSION["art_error"] = "This request is already loaded.";
    redirect_to("orderRequest.php");
}

$id = $request["id"];
//$query = "DELETE FROM dbo.Users WHERE UserID = '{$id}' LIMIT 1";

$query = "DELETE FROM order_requst WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Order Request deleted.";

    redirect_to("orderRequest.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Order Request deletion failed.";
    redirect_to("orderRequest.php");
}

?>
