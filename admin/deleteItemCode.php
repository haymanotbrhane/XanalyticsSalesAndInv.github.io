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
$item = find_item_code_by_id($_GET["id"]);
if (!$item) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("itemCode.php");
}

$id = $item["id"];
unlink($item["image"]);

$query = "DELETE FROM item_code WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Item code deleted.";

    redirect_to("itemCode.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Item code deletion failed.";
    redirect_to("itemCode.php");
}

?>

