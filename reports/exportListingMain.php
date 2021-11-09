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
echo date('H:i:s') , " Create new Payroll Listings" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("George Maina")
    ->setLastModifiedBy("George Maina")
    ->setTitle("Payroll Listing")
    ->setSubject("Payroll Listing")
    ->setDescription("Payroll Listings contains Earnings and Deductions and Totals for all Employees")
    ->setKeywords("Payroll Listings php")
    ->setCategory("Payroll");
//HealthCentre,AphiaPlus,GlobalFund,WasichanaWote,Icop,YouthProgram,Nilinde,Amref,PoolAccount,PoolFund

$objPHPExcel->getActiveSheet(0)->mergeCells('A1:F1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Payroll Listings Main');


//for($i='A';$i!=='AZ'; $i++){
        echo $i;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A2", "PID");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B2", "Names" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C2", "JobTitle" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D2", "EmpBranch" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E2", "PayMonth" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F2", "Basic Pay" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G2", "GrossPay" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H2", "PAYE" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I2", "NHIF" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J2","NSSF" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K2", "Total Deducations" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L2", "Total Pay" );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M2", "Net Pay" );

$payMonth =$_REQUEST['payMonth'];
$payBranch=$_REQUEST['empBranch'];
$period=$_REQUEST['period'];
//$period='2020';

$sql = "SELECT l.Pid,EmpNames,l.JobTitle,l.EmpBranch,l.PayMonth,`001` AS BasicPay,`114` AS GrossPay,`016` AS NSSF,`013` AS PAYE
                ,`019` AS NHIF,`115` AS TotalDeductions,`132` AS TotalPay,`113` AS NetPay
        FROM proll_listings_Main l LEFT JOIN `proll_empregister` r ON l.`PID`=r.`PID` WHERE payMonth='$payMonth' AND `period`='$period'";

if ($payBranch<>'' and $payBranch <> 'null') {
    $sql.=" AND l.EmpBranch='$payBranch'";
}
//echo $sql;
    $result=$db->Execute($sql);
$i=3;
    while($row=$result->FetchRow()){

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i",$row['Pid']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i",$row['EmpNames']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i",$row['JobTitle']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i",TRIM($row['EmpBranch']));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$i",$row['PayMonth']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$i",$row['BasicPay']);          //Basic Pay
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$i",$row['GrossPay']);   // Leave Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i",$row['PAYE']);       // Gross pay
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I$i",$row['NHIF']);    // Leave Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J$i",$row['NSSF']);    // Leave Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$i",$row['TotalDeductions']);              // PAYE
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L$i",$row['TotalPay']);           // Waumini savings
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M$i",$row['NetPay']);           // Waumini savings


        $i=$i+1;
    }

$objPHPExcel->getActiveSheet()->setTitle('Payroll Listings');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save(str_replace('php','xlsx',$root_path."/docs/PayrollListings.xlsx"));

echo "Created file : ".str_replace('php','xlsx',$root_path."docs/PayrollPayrollListings.xlsx" ),EOL;

$objReader=PHPExcel_IOFactory::load($root_path."docs/PayrollListings.xlsx");

?>
