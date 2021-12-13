<?php require_once("../../includes/db_connection.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php require_once("../../includes/validation_functions.php"); ?>
<?php

$tender = $tender = find_all_tenders();
date_default_timezone_set('Asia/Kolkata');

require_once 'PHPExcel/Classes/PHPExcel.php';

$filename = 'tenderReport'; //your file name
$objPHPExcel = new PHPExcel();
/*********************Add column headings START**********************/
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Tender Title')
    ->setCellValue('B1', 'Tender Category')
    ->setCellValue('C1', 'Company Name')
    ->setCellValue('D1', 'Opening Date')
    ->setCellValue('E1', 'Closing Date')
    ->setCellValue('F1', 'Active Match');
/*********************Add column headings END**********************/

// You can add this block in loop to put all ur entries.Remember to change cell index i.e "A2,A3,A4" dynamically
/*********************Add data entries START**********************/
$k = 2;
while ($row = sqlsrv_fetch_array($tender, SQLSRV_FETCH_ASSOC)) {
    $cat = find_all_tenderCategory_by_id($row["TenderCategoryID"]);
    $com = find_all_company_by_id($row["CompanyID"]);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$k, $row["Title"])
        ->setCellValue('B'.$k, $cat["TenderCategory"])
        ->setCellValue('C'.$k, $com["CompanyName"])
        ->setCellValue('D'.$k, date_format($row["OpeningDateTime"], "d/m/Y G:i"))
        ->setCellValue('E'.$k, date_format($row["ClosingDateTime"], "d/m/Y G:i"))
        ->setCellValue('F'.$k, isset($row['ActiveMatch']) ? $row['ActiveMatch'] : '0');
    $k++;
}
/*********************Add data entries END**********************/

/*********************Autoresize column width depending upon contents START**********************/
foreach (range('A', 'F') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}
/*********************Autoresize column width depending upon contents END***********************/

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true); //Make heading font bold

/*********************Add color to heading START**********************/
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:F1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('99ff99');
/*********************Add color to heading END***********************/

$objPHPExcel->getActiveSheet()->setTitle('tenderReport'); //give title to sheet
$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;Filename=$filename.xls");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>