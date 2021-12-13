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
$measurement = find_measurement_by_id($_GET["id"]);
if (!$measurement) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("measurement.php");
}

$id = $measurement["id"];

$query = "DELETE FROM measurment WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Measurement deleted.";

} else {
    // Failure
    $_SESSION["art_error"] = "Measurement deletion failed.";
}

redirect_to("measurement.php");
?>

</body>
</html>
