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
$attribute_value = find_attribute_value_by_id($_GET["id"]);
if (!$attribute_value) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("attributeValue.php");
}

$id = $attribute_value["id"];

$query = "DELETE FROM attribute_value WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Attribute Value deleted.";

} else {
    // Failure
    $_SESSION["art_error"] = "Attribute Value deletion failed.";
}

redirect_to("attributeValue.php");

?>
