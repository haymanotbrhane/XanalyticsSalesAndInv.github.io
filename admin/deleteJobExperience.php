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
$jobexp = find_all_jobExperience_by_id($_GET["id"]);
if (!$jobexp) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("jobExperience.php");
}

$id = $jobexp["JobExperienceID"];
//$query = "DELETE FROM dbo.Users WHERE UserID = '{$id}' LIMIT 1";

$query = "DELETE FROM [dbo].[JobExperience] WHERE [JobExperienceID] = '{$id}'";
$result = sqlsrv_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Job Experience deleted.";

    redirect_to("jobExperience.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Job Experience deletion failed.";
    redirect_to("jobExperience.php");
}

?>

</body>
</html>
