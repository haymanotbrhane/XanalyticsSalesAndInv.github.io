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
$job = find_all_jobVacancy_by_id($_GET["id"]);
if (!$job) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("Jobs.php");
}

$id = $job["JobVacancyID"];
//$query = "DELETE FROM dbo.Users WHERE UserID = '{$id}' LIMIT 1";

$query = "DELETE FROM [dbo].[JobVacancy] WHERE [JobVacancyID] = '{$id}'";
$result = sqlsrv_query($connection, $query);

if ($result) {
    // Success

    $_SESSION["art_message"] = "Job Vacancy deleted.";

    redirect_to("jobs.php");
} else {
    // Failure
    $_SESSION["art_error"] = "Job Vacancy deletion failed.";
    redirect_to("jobs.php");
}

?>

</body>
</html>
