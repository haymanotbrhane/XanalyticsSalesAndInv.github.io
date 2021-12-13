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
$ids = find_productionPlan_by_id($_GET["id"]);
if (!$ids) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("productionPlan.php");
}

$id = $ids["id"];
$u_id = $_SESSION["admin_id"];

$query = "UPDATE production_plan set request_status = 1,requested_by = {$u_id} WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Production material requested.";

    redirect_to("productionPlan.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Production material requesting failed.";
    redirect_to("productionPlan.php");
}

?>

</body>
</html>
