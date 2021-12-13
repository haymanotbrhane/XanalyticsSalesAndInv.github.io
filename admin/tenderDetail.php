<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$coo = $_POST['tender'];
$tenders = find_all_tender_by_id($coo);

$data = "<table class=\"table table-responsive-md mb-0\" id=\"datatable-tabletools1\">";

$data .= "<tbody>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Title</td>";
$data .= "<td style=\"font-weight: normal\">" . $tenders['Title'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Company</td>";
$data .= "<td style=\"font-weight: normal\">" . find_all_company_by_id($tenders['CompanyID'])['CompanyName'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Tender Category</td>";
$data .= "<td style=\"font-weight: normal\">" . find_all_tenderCategory_by_id($tenders['TenderCategoryID'])['TenderCategory'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Description</td>";
$data .= "<td style=\"font-weight: normal\">" . $tenders['Description'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= " <td style=\"font-weight: bolder\">Tender Requirement</td>";
$data .= " <td style=\"font-weight: normal\">" . $tenders['TenderRequirement'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= " <td style=\"font-weight: bolder\">Tender Contact Address</td>";
$data .= "<td style=\"font-weight: normal\">" . $tenders['TenderContactAddress'] . "</td>";
$data .= "</tr>";
$data .= "<tr>";
$data .= "<td style=\"font-weight: bolder\">Opening DateTime</td>";
$data .= "<td style=\"font-weight: normal\">" . date_format($tenders["OpeningDateTime"], "d/m/Y G:i") . " </td >";
$data .= "</tr > ";
$data .= "<tr > ";
$data .= "<td style = \"font-weight: bolder\">Closing DateTime</td>";
$data .= "<td style=\"font-weight: normal\">" . date_format($tenders["ClosingDateTime"], "d/m/Y G:i") . " </td >";
$data .= "</tr > ";
$data .= "</tbody > ";
$data .= "</table > ";

echo $data;

?>

