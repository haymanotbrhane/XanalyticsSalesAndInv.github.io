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
$order = find_order_sheet_by_id($_GET["id"]);
if (!$order) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("orderSheet.php");
}

$id = $order["id"];

$query = "DELETE FROM order_sheet WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Order deleted.";

} else {
    // Failure
    $_SESSION["art_error"] = "Order deletion failed.";
}
redirect_to("orderSheet.php");

?>

</body>
</html>
