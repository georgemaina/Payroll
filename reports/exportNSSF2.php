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
echo date('H:i:s') , " Create new NSSF Returns" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("George Maina")
    ->setLastModifiedBy("George Maina")
    ->setTitle("NSSF Returns")
    ->setSubject("NSSF Returns")
    ->setDescription("NSSF Returns contains NSSF Returns for all Employees")
    ->setKeywords("NSSF Returns php")
    ->setCategory("Payroll");

$objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'NSSF Returns');


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'PID');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Names' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'ID No' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'NSSF No' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'Self' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', 'Company' );

$payMonth =$_REQUEST[payMonth];
$payBranch=$_REQUEST[empBranch];

$sql = "SELECT p.`Pid`, p.`emp_names`,p.`pay_type`, p.`amount` AS Self,'' AS Company,'' AS Amount,e.ID_No,e.NSSF_No,p.payMonth FROM proll_payments p INNER JOIN proll_empregister e
        ON p.Pid=e.PID WHERE pay_type ='N.S.S.F' AND payMonth='$payMonth' and p.period='$period'";

//echo $sql;

function getNssfRates(){
    global $db;
    $sql="Select value from proll_rates where ID=32";
    $result=$db->Execute($sql);
    $row=$result->FetchRow();

    return $row[0];
}
$result=$db->Execute($sql);
$nssfCompany=getNssfRates();
$i=3;
while($row=$result->FetchRow()){

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i",$row['Pid']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i",$row['emp_names']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i",$row['ID_No']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i",$row['NSSF_No']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$i",$row['Self']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$i",$nssfCompany);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$i", intval($row['Self']+$nssfCompany));
//    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i",$row['WasichanaWote']);

    $i=$i+1;
}

$objPHPExcel->getActiveSheet()->setTitle('NSSF Returns');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save(str_replace('php','xlsx',$root_path."/docs/NSSFReturns.xlsx"));

echo "Created file : ".str_replace('php','xlsx',$root_path."docs/NSSFReturns.xlsx" ),EOL;

$objReader=PHPExcel_IOFactory::load($root_path."docs/NSSFReturns.xlsx");

?>
