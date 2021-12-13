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
$line = find_productionLine_by_id($_GET["id"]);
if (!$line) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("productionLine.php");
}

$id = $line["id"];

$query = "DELETE FROM production_line WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Production line deleted.";

    redirect_to("productionLine.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Production line deletion failed.";
    redirect_to("productionLine.php");
}

?>

</body>
</html>
