<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require_once('roots.php');
require ($root_path . 'include/inc_environment_global.php');
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Africa/Nairobi');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once '../../ExcelClasses/PHPExcel.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new Payroll NHIF Returns" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("George Maina")
    ->setLastModifiedBy("George Maina")
    ->setTitle("NHIF Returns")
    ->setSubject("NHIF Returns")
    ->setDescription("NHIF Returns contains NHIF Deductions for all Employees")
    ->setKeywords("NHIF Returns php")
    ->setCategory("Payroll");

$payMonth =$_REQUEST[payMonth];
$payBranch=$_REQUEST[empBranch];
$period=$_REQUEST[period];

$objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "NHIF RETURNS FOR THE PERIOD OF $period MONTH OF $payMonth");


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'PID');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Names' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'ID No' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'NHIF No' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'Amount' );

$sql = "SELECT p.`Pid`, p.`emp_names`,p.`pay_type`, p.`amount`,e.ID_no,e.nhif_no FROM proll_payments p 
inner join proll_empregister e
on p.Pid=e.PID where pay_type ='N.H.I.F' AND payMonth='$payMonth' AND period='$period'";

//echo $sql;

$result=$db->Execute($sql);
$i=3;
while($row=$result->FetchRow()){
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i",$row['Pid']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i",$row['emp_names']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i",$row['ID_no']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i",TRIM($row['nhif_no']));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$i", intval($row['amount']));

    $i=$i+1;
}

$objPHPExcel->getActiveSheet()->setTitle('NHIF RETURNS');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save(str_replace('php','xlsx',$root_path."/docs/NHIFreturns.xlsx"));

echo "Created file : ".str_replace('php','xlsx',$root_path."docs/NHIFreturns.xlsx" ),EOL;

$objReader=PHPExcel_IOFactory::load($root_path."docs/NHIFreturns.xlsx");

?>
