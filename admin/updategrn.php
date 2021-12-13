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
$grn = find_goods_receive_by_id($_GET["id"]);
if (!$grn) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("grn.php");
}

if ($grn["status"] == 1) {
    $_SESSION["art_error"] = "This GRN is already approved.";
    redirect_to("grn.php");
}

$id = $grn["id"];

$query = "UPDATE grn set status = 1 WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "GRN is approved.";

    redirect_to("grn.php");
} else {
    // Failure
    $_SESSION["art_error"] = "GRN is not approved.";
    redirect_to("grn.php");
}

?>
