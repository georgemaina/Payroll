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


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'PID');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Names' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'JobTitle' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'EmpBranch' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'PayMonth' );

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', 'HealthCentre' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', 'AphiaPlus' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', 'WasichanaWote' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', 'Global Fund' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', 'Icop' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', 'YouthProgram' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', 'Nilinde' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', 'Amref' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', 'PoolAccount' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', 'TotalContributions' );

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', 'Basic Pay' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', 'House Allowance' );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', 'Medical' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2', 'Transport' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2', 'Gratuity' );

//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', 'Risk Allowance' );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', 'Non-Practice Allowance' );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', 'Leave Allowance' );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', 'Gratuity' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', 'GrossPay' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U2','NSSF' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2', 'NHIF' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W2', 'PAYE' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X2', 'Advances' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y2', 'Loans' );

//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X2', 'Welfare' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z2', 'Sacco' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA2', 'Helb' );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', 'Food' );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U2', 'Advance' );
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2', 'Bereavement' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB2', 'Other Deductions' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC2', 'Total Deducations' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD2', 'Total Pay' );
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE2', 'Net Pay' );

$payMonth =$_REQUEST[payMonth];
$payBranch=$_REQUEST[empBranch];

$sql = "SELECT l.Pid,EmpNames,l.JobTitle,l.EmpBranch,l.PayMonth,`001` AS BasicPay,`005` AS HouseAllowance,`110` AS Gratuity,
              `107` AS Transport,`044` AS CallAllowance,`100` AS Locum,`012` AS RiskAllowance
            ,`055` AS NonPractice,`073` AS leaveAllowance,`114` AS GrossPay,`016` AS NSSF,`013` AS PAYE,
            `019` AS NHIF,(`111`+`142`+`148`) AS Welfare,`136` AS Food,`121`  AS Medical
            ,`051` AS Advance,`027` AS StaffLoan,`075` AS Bereavement,(`143`+`141`+`067`) AS Sacco ,`124` AS Helb,
              `115` AS TotalDeductions,`132` AS TotalPay,`113` AS NetPay
        FROM proll_listings_Main l LEFT JOIN `proll_empregister` r ON l.`PID`=r.`PID` WHERE payMonth='$payMonth'";

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

            $TotalContributions=$row['HealthCentre']+$row['AphiaPlus']+$row['WasichanaWote']+$row['GlobalFund']+$row['Icop']+$row['YouthProgram']+$row['Nilinde']+$row['Amref']+$row['PoolAccount'];

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$i",$row['HealthCentre']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$i",$row['AphiaPlus']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i",$row['WasichanaWote']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I$i",$row['GlobalFund']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J$i",$row['Icop']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$i",$row['YouthProgram']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L$i",$row['Nilinde']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M$i",$row['Amref']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N$i",$row['PoolAccount']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("O$i",$TotalContributions );


            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P$i",$row['BasicPay']);          //Basic Pay
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Q$i",$row['HouseAllowance']);
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i",$row['Medical']);     //Responsbility Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R$i",$row['Transport']);              // Transport
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("S$i",$row['Gratuity']);    // Leave Allowance


//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I$i",$row['Locum']);   // SP/RES Allowance
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J$i",$row['RiskAllowance']);     //Risk Allowance
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$i",$row['NonPractice']);     // Call Allowance
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$i",$row['leaveAllowance']);    // Leave Allowance
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M$i",$row['Gratuity']);    // Leave Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("T$i",$row['GrossPay']);    // Leave Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U$i",$row['NSSF']);    // Leave Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("V$i",$row['NHIF']);    // Leave Allowance
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("W$i",$row['PAYE']);          // Gross pay
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("X$i",$row['Advance']);              // Welfare
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Y$i",$row['Staffloan']);              // Welfare
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("W$i",$row['Welfare']);              // Welfare
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Z$i",$row['Sacco']);              // Welfare
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AA$i",$row['Helb']);              // Welfare
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("U$i",$row['Advance']);              // NSSF
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("V$i",$row['Bereavement']);              // NHIF
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AB$i",$row['PoolFund']);              // NHIF
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AC$i",$row['TotalDeductions']);              // PAYE
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AD$i",$row['TotalPay']);           // Waumini savings
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("AE$i",$row['NetPay']);           // Waumini savings

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
