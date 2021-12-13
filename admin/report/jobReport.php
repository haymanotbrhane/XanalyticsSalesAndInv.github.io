<?php require_once("../../includes/db_connection.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php require_once("../../includes/validation_functions.php"); ?>
<?php

$user = find_all_jobsVacancy();
date_default_timezone_set('Asia/Kolkata');

require_once 'PHPExcel/Classes/PHPExcel.php';

$filename = 'jobReport'; //your file name
$objPHPExcel = new PHPExcel();
/*********************Add column headings START**********************/
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Company')
    ->setCellValue('B1', 'Position')
    ->setCellValue('C1', 'Location')
    ->setCellValue('D1', 'End Date')
    ->setCellValue('E1', 'Active Match');
/*********************Add column headings END**********************/

// You can add this block in loop to put all ur entries.Remember to change cell index i.e "A2,A3,A4" dynamically
/*********************Add data entries START**********************/
$k = 2;
while ($row = sqlsrv_fetch_array($user, SQLSRV_FETCH_ASSOC)) {
    $comp = find_all_company_by_id($row["CompanyID"]);
    $req = find_all_req_by_job($row["JobVacancyID"]);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$k, $comp["CompanyName"])
        ->setCellValue('B'.$k, $row["Position"])
        ->setCellValue('C'.$k, $row["Location"])
        ->setCellValue('D'.$k, date_format($row["EndDate"], "d/m/Y"))
        ->setCellValue('E'.$k, isset($row['ActiveMatch']) ? $row['ActiveMatch'] : '0');
    $k++;
}
/*********************Add data entries END**********************/

/*********************Autoresize column width depending upon contents START**********************/
foreach (range('A', 'E') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
/*********************Autoresize column width depending upon contents END***********************/

$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true); //Make heading font bold

/*********************Add color to heading START**********************/
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:E1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('99ff99');
/*********************Add color to heading END***********************/

$objPHPExcel->getActiveSheet()->setTitle('jobReport'); //give title to sheet
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;Filename=$filename.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>