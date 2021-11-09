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
echo date('H:i:s') , " Create new PAYE Returns" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("George Maina")
    ->setLastModifiedBy("George Maina")
    ->setTitle("PAYE Returns")
    ->setSubject("PAYE Returns")
    ->setDescription("PAYE Returns contains TAX Returns for all Employees")
    ->setKeywords("PAYE Returns php")
    ->setCategory("Payroll");

$payMonth =$_REQUEST['payMonth'];
$payBranch=$_REQUEST['empBranch'];
$period=$_REQUEST['period'];

$objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "PAYE RETURNS FOR THE PERIOD $period AND MONTH OF $payMonth");



$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'PIN NO');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Names' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'Nationality' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'STATUS' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'GROSS' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2', 'BENEFIT' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W2', '' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X2', 'NSSF' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y2', '' );

$sql = "SELECT e.`Pin_NO`,p.`emp_names`,e.`Nationality`,e.`empStatus`,IF(p.`pay_type`='BASIC PAY',Amount,'') AS gross,
'1','2','3','4','5','6','7','8','9','10','11','12','benefit','13','14','15','16','17',IF(p.`pay_type`='N.S.S.F',amount,'') AS NSSF,'18'
,e.ID_no,e.pin_no FROM proll_payments p INNER JOIN proll_empregister e
ON p.Pid=e.PID WHERE payMonth='$payMonth' AND `period`='$period' having gross>0";

//echo $sql;
function getNssfRates(){
    global $db;
    $sql="Select value from proll_rates where ID=32";
    $result=$db->Execute($sql);
    $row=$result->FetchRow();

    return $row[0];
}
$result=$db->Execute($sql);
$i=3;
while($row=$result->FetchRow()){

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i",$row['Pin_NO']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i",$row['emp_names']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i",'Resident');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i",'Primary Employee');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$i",$row['gross']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("O$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Q$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R$i",'Benefit not given');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("T$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("V$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("W$i",'0');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("X$i",$row['NSSF']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Y$i",'0');
    


//    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i",$row['WasichanaWote']);

    $i=$i+1;
}

$objPHPExcel->getActiveSheet()->setTitle('PAYE Returns');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save(str_replace('php','xlsx',$root_path."/docs/PAYEReturns.xlsx"));

echo "Created file : ".str_replace('php','xlsx',$root_path."/docs/PAYEReturns.xlsx" ),EOL;

$objReader=PHPExcel_IOFactory::load($root_path."/docs/PAYEReturns.xlsx");

?>
