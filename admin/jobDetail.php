<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$coo = $_POST['job'];
$jobs = find_all_jobVacancy_by_id($coo);
$req = find_jobRequirements_by_job($coo);

$data = "<header class=\"card-header\">";
$data .= "<h2 class=\"card-title\">" . $jobs['Position'] . ', ' . find_all_company_by_id($jobs['CompanyID'])['CompanyName'] . "</h2>";
$data .= "</header>";
$data .= "<div class=\"card-body\">";
$data .= "<table class=\"table table-responsive-md mb-0\" id=\"datatable-tabletools1\">";
$data .= "<tbody>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Position</td>";
$data .= "<td style=\"font-weight: normal\">" . $jobs['Position'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Company</td>";
$data .= "<td style=\"font-weight: normal\">" . find_all_company_by_id($jobs['CompanyID'])['CompanyName'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Salary</td>";
$data .= "<td style=\"font-weight: normal\">" . $jobs['Salary'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Working Location</td>";
$data .= "<td style=\"font-weight: normal\">" . $jobs['Location'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= " <td style=\"font-weight: bolder\">Employment Type</td>";
$data .= " <td style=\"font-weight: normal\">" . find_all_employmentType_by_id($jobs['EmploymentTypeID'])['EmploymentType'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= " <td style=\"font-weight: bolder\">Job Description</td>";
$data .= "<td style=\"font-weight: normal\">" . $jobs['JobDescription'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Job Extra Requirement</td>";
$data .= "<td style=\"font-weight: normal\">" . $jobs['JobRequirmentExtra'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= " <td style=\"font-weight: bolder\">How To Apply</td>";
$data .= "<td style=\"font-weight: normal\">" . $jobs['HowToApply'] . "</td>";
$data .= " </tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Start Date</td>";
$data .= "<td style=\"font-weight: normal\">" . date_format($jobs["StartDate"], "d-m-Y") . " </td >";
$data .= "</tr > ";
$data .= "<tr > ";
$data .= "<td style = \"font-weight: bolder\">End Date</td>";
$data .= "<td style=\"font-weight: normal\">" . date_format($jobs["EndDate"], "d-m-Y") . " </td >";
$data .= "</tr > ";
$data .= "<tr > ";
$data .= "<td style = \"font-weight: bolder\">Job Requirements</td>";
$data .= "<td style=\"font-weight: normal\">";
$k = 0;
while ($row = sqlsrv_fetch_array($req, SQLSRV_FETCH_ASSOC)) {
    $job = find_all_jobVacancy_by_id($row["JobVacancyID"]);
    $edu = find_all_educationLevel_by_id($row["EducationLevelID"]);
    $exp = find_all_jobExperience_by_id($row["JobExperienceID"]);
    $maxexp = find_all_jobExperience_by_id($row["JobMaxExperienceID"]);
    $cat = find_all_jobCategory_by_id($row["JobCategoryID"]);
    $exprang = ($row["JobMaxExperienceID"] == null)?" and Greater Than ".$exp["start"]:' - '.$maxexp["start"];
    $exprang = ($exp["start"] == $maxexp["start"])? '':$exprang;

    $data .= "<span style='font-weight: bold'>".++$k."). Education Level : </span>".$edu["EducationLevel"]."<br>";
    $data .= "<span style='font-weight: bold;margin-left: 18px;'> Job Experience : </span>".$exp["start"] .$exprang . " Year Experience<br>";
    $data .= "<span style='font-weight: bold;margin-left: 18px;'>Job Category : </span>".$cat["JobCategory"]."<br>";
}
$data .= " </td ></tr > ";
$data .= "</tbody > ";
$data .= "</table > ";
$data .= "</div>";

echo $data;

?>

