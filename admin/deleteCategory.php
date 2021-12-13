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
$cat = find_category_by_id($_GET["id"]);
if (!$cat) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("categories.php");
}

$id = $cat["id"];

$query = "DELETE FROM category WHERE id = {$id}";
$result = mysqli_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Category deleted.";

    redirect_to("categories.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Category deletion failed.";
    redirect_to("categories.php");
}

?>

</body>
</html>
