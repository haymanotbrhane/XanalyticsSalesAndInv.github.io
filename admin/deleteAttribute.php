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
$attribute = find_attribute_by_id($_GET["id"]);
if (!$attribute) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("attribute.php");
}

$id = $attribute["id"];

$query = "DELETE FROM product_attribute WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Product Attribute deleted.";

} else {
    // Failure
    $_SESSION["art_error"] = "Product Attribute deletion failed.";
}

redirect_to("attribute.php");
?>

</body>
</html>
