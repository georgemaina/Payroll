<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require_once('roots.php');
require ($root_path . 'include/inc_environment_global.php');
require_once 'spreadsheet/Excel/Writer.php';
// Lets define some custom colors codes
define('CUSTOM_DARK_BLUE', 20);
define('CUSTOM_BLUE', 21);
define('CUSTOM_LIGHT_BLUE', 22);
define('CUSTOM_YELLOW', 23);
define('CUSTOM_GREEN', 24);

$workbook=new Spreadsheet_Excel_Writer();

    $payMonth = $_REQUEST[payMonth];
    $pstBranch=$_REQUEST[empBranch];

$worksheet=$workbook->addWorksheet('Payroll Listings');

$workbook->setCustomColor(CUSTOM_DARK_BLUE, 31, 73, 125);
$workbook->setCustomColor(CUSTOM_BLUE, 0, 112, 192);
$workbook->setCustomColor(CUSTOM_LIGHT_BLUE, 184, 204, 228);
$workbook->setCustomColor(CUSTOM_YELLOW, 255, 192, 0);
$workbook->setCustomColor(CUSTOM_GREEN, 0, 176, 80);

//$worksheet->hideScreenGridlines();

//custom styles
$formatHeader=&$workbook->addFormat();
$formatHeader=&$workbook->addFormat(
        array('Size'=>16,
              'VAlign'=>'vcenter',
              'HAlign'=>'center',
              'Bold'=>1,
              'Color'=>'white',
              'FgColor'=>CUSTOM_DARK_BLUE));

$formatReportHeader =
    &$workbook->addFormat(
        array('Size'     => 9,
              'VAlign'   => 'bottom',
              'HAlign'   => 'center',
              'Bold'     => 1,
              'FgColor'  => CUSTOM_LIGHT_BLUE,
              'TextWrap' => true));

$formatData =
    &$workbook->addFormat(
        array(
            'Size'   => 8,
            'HAlign' => 'left',
            'VAlign' => 'vcenter'));

$worksheet->setRow(0, 15, $formatHeader);
$worksheet->setRow(1, 46, $formatHeader);
$worksheet->setRow(2, 11, $formatHeader);

$worksheet->setColumn(0, 0, 7); // User Id, shrink it to 7
$worksheet->setColumn(1, 1, 25); // Name, set the width to 12
$worksheet->setColumn(1, 1, 15); // Email, set the width to 15
$worksheet->setColumn(3, 3, 7); // Email, set the width to 15

$worksheet->write(1, 3, 'Payroll Listings '.$pstBranch, $formatHeader);

// Create the header for the data starting @ row 4
$indexCol = 0;
$indexRow = 4;
$worksheet->write($indexRow, $indexCol++, 'PID', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Names', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Job Title', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Branch', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Month', $formatReportHeader);

$worksheet->write($indexRow, $indexCol++, 'HealthCentre', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'AphiaPlus', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'WasichanaWote', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Global Fund', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Icop', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'YouthProgram', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Nilinde', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Amref', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'PoolAccount', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'TotalContributions', $formatReportHeader);


$worksheet->write($indexRow, $indexCol++, 'Basic pay', $formatReportHeader);
//$worksheet->write($indexRow, $indexCol++, 'SpecialRisk Allowance', $formatReportHeader);
//$worksheet->write($indexRow, $indexCol++, 'Risk Allowance', $formatReportHeader);
//$worksheet->write($indexRow, $indexCol++, 'Responsibility Allowance', $formatReportHeader);
//$worksheet->write($indexRow, $indexCol++, 'Leave Allowance', $formatReportHeader);
//$worksheet->write($indexRow, $indexCol++, 'Field Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'House Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Transport', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Gratuity', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Gross Pay', $formatReportHeader);

$worksheet->write($indexRow, $indexCol++, 'NSSF', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'NHIF', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'PAYE', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Loans', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Advances', $formatReportHeader);

//$worksheet->write($indexRow, $indexCol++, 'Insurance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Sacco', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Helb', $formatReportHeader);

//$worksheet->write($indexRow, $indexCol++, 'GratuityB', $formatReportHeader);
//$worksheet->write($indexRow, $indexCol++, 'Medical', $formatReportHeader);
//$worksheet->write($indexRow, $indexCol++, 'Welfare', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Other Deductions', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Total Deductions', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Total Pay', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Net Pay', $formatReportHeader);

$indexRow++;   // Advance to the next row
$indexCol = 0; // Start @ column 0


   $sql = "SELECT Pid,EmpNames,JobTitle,EmpBranch,PayMonth,`001` AS BasicPay,`112` as SpecialRisk,`012` AS RiskAllowance,
                `108` AS ResponsibilityAllowance,`073` AS LeaveAllowance,`109` as FieldAllowance,`005` AS HouseAllowance,
                `110` as Gratuity,`121` AS Medical,`114` AS GrossSalary,`013` AS PAYE,`016` AS NSSF,`019` AS NHIF,`133` AS Loans,`051` AS Advance,
                `091` as Insurance,`124` AS Helb,`067` AS Waumini,`110` as GratuityB,`121` as MedicalB,`111` as Welfare,`115` as Deductions,`113` as NetPay
                FROM proll_listings WHERE payMonth='$payMonth'";

    if($pstBranch<>''){
        $sql.=" AND EmpBranch='$pstBranch'";
    }
    //echo $sql;
    
    $result=$db->Execute($sql);
    while($row=$result->FetchRow()){
         $worksheet->write($indexRow,$indexCol++,$row['Pid'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['EmpNames'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['JobTitle'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['EmpBranch'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['PayMonth'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['SpecialRisk'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['RiskAllowance'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['ResponsibilityAllowance'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['LeaveAllowance'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['FieldAllowance'], $formatData);
         $worksheet->write($indexRow,$indexCol++,$row['HouseAllowance'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Gratuity'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Medical'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['GrossSalary'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['PAYE'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['PAYE'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['NHIF'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Loans'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Advance'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Insurance'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Helb'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Waumini'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['GratuityB'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['MedicalB'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Welfare'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['Deductions'],$formatData);
         $worksheet->write($indexRow,$indexCol++,$row['NetPay'],$formatData);

         // Advance to the next row
        $indexCol=0;
        $indexRow++;
        
    }
    
    // Sends HTTP headers for the Excel file.
$workbook->send('Payroll Listing'.date('Hms').'.xls');
    
// Calls finalization methods.
// This method should always be the last one to be called on every workbook
$workbook->close();
?>
