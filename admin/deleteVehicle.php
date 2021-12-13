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
$vehicle = find_vehicle_by_id($_GET["id"]);
if (!$vehicle) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("vehicle.php");
}

$id = $vehicle["id"];
//$query = "DELETE FROM dbo.Users WHERE UserID = '{$id}' LIMIT 1";

$query = "DELETE FROM vehicle WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Vehicle deleted.";

    redirect_to("vehicle.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Vehicle deletion failed.";
    redirect_to("vehicle.php");
}

?>
