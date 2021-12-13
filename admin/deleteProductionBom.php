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
$bom = find_productionBom_by_id($_GET["id"]);
if (!$bom) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("bom.php");
}

$id = $bom["id"];

$query = "DELETE FROM production_bom WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Bill of material deleted.";

    redirect_to("bom.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Bill of material deletion failed.";
    redirect_to("bom.php");
}

?>

</body>
</html>
