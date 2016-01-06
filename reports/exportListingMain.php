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

$worksheet=$workbook->addWorksheet('Payroll Listings Main');

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
//
$formatReportHeader =
    $workbook->addFormat(
        array('Size'     => 9,
              'VAlign'   => 'bottom',
              'HAlign'   => 'center',
              'Bold'     => 1,
              'FgColor'  => CUSTOM_LIGHT_BLUE,
              'TextWrap' => true));

$formatData =
    $workbook->addFormat(
        array(
            'Size'   => 8,
            'HAlign' => 'left',
            'VAlign' => 'center'));

$worksheet->setRow(0, 15, $formatHeader);
$worksheet->setRow(1, 46, $formatHeader);
$worksheet->setRow(2, 11, $formatHeader);

$worksheet->setColumn(0, 0, 7); // User Id, shrink it to 7
$worksheet->setColumn(1, 1, 12); // Name, set the width to 12
$worksheet->setColumn(1, 1, 15); // Email, set the width to 15
//$worksheet->setColumn(3, 3, 30); // Email, set the width to 15

$worksheet->write(1, 3, 'Payroll Listings Main', $formatHeader);

// Create the header for the data starting @ row 4
$indexCol = 0;
$indexRow = 4;
$worksheet->write($indexRow,$indexCol++, 'PID', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Names', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'JobTitle', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'EmpBranch', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'PayMonth', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Basic Pay', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'House Allowance', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Medical', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Transport', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Risk Allowance', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Non-Practice Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Leave Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Caritas Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'MaryKnoll Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'CHAK Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Sister Allowance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'GrossPay', $formatReportHeader);

$worksheet->write($indexRow, $indexCol++, 'NSSF', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'NHIF', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'PAYE', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Waumini', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Waumini Repayment', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Waumini Insurance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Advance', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Loan', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Welfare', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Welfare Repayment', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Total Deducations', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Total Pay', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Net Pay', $formatReportHeader);


$indexRow++;   // Advance to the next row
$indexCol = 0; // Start @ column 0
//
$payMonth =$_REQUEST[payMonth];
$payBranch=$_REQUEST[empBranch];
//
$sql = "SELECT Pid,EmpNames,JobTitle,EmpBranch,PayMonth,`001` AS BasicPay,`005` AS HouseAllowance,`121` AS Medical,`107` AS Transport,`012` AS RiskAllowance
            ,`055` AS NonPractice,`073` AS leaveAllowance,`144` AS CaritasAllowance,`145` as MaryKnollAllowance,`146` AS CHAKAllowance,
            `147` AS SisterAllowance,`114` AS GrossPay,`016` AS NSSF,`013` AS PAYE,`019` AS NHIF,`067` AS Waumini,`141` as WauminiRepayment,`143` AS WauminiInsurance
            ,`051` AS Advance,`018` AS Loan,(`111`+ `148`) AS Welfare,`142` AS WelfareRepayment,`115` AS TotalDeductions,`132` AS TotalPay,`113` AS NetPay
            FROM proll_listings_Main WHERE payMonth='$payMonth'";

if ($payBranch <> '' and $payBranch<>'null') {
    $sql.=" AND EmpBranch='$payBranch' ";
}

//echo $sql;

    $result=$db->Execute($sql);
    while($row=$result->FetchRow()){
        $worksheet->write($indexRow,$indexCol++,$row['Pid']);
        $worksheet->write($indexRow,$indexCol++,TRIM($row['EmpNames']));
        $worksheet->write($indexRow,$indexCol++,$row['JobTitle']);
        $worksheet->write($indexRow,$indexCol++,$row['EmpBranch']);
        $worksheet->write($indexRow,$indexCol++,$row['PayMonth']);
        $worksheet->write($indexRow,$indexCol++,$row['BasicPay'],$formatData);          //Basic Pay
        $worksheet->write($indexRow,$indexCol++,$row['HouseAllowance'],$formatData);
        $worksheet->write($indexRow,$indexCol++,$row['Medical'],$formatData);     //Responsbility Allowance
        $worksheet->write($indexRow,$indexCol++,$row['Transport'],$formatData);   // SP/RES Allowance
        $worksheet->write($indexRow,$indexCol++,$row['RiskAllowance'],$formatData);     //Risk Allowance
        $worksheet->write($indexRow,$indexCol++,$row['NonPractice'],$formatData);     // Call Allowance
        $worksheet->write($indexRow,$indexCol++,$row['leaveAllowance'],$formatData);    // Leave Allowance
        $worksheet->write($indexRow,$indexCol++,$row['CaritasAllowance'],$formatData);    // Leave Allowance
        $worksheet->write($indexRow,$indexCol++,$row['MaryKnollAllowance'],$formatData);    // Leave Allowance
        $worksheet->write($indexRow,$indexCol++,$row['CHAKAllowance'],$formatData);    // Leave Allowance
        $worksheet->write($indexRow,$indexCol++,$row['SisterAllowance'],$formatData);    // Leave Allowance
        $worksheet->write($indexRow,$indexCol++,$row['GrossPay'],$formatData);          // Gross pay
        $worksheet->write($indexRow,$indexCol++,$row['NSSF'],$formatData);              // NSSF
        $worksheet->write($indexRow,$indexCol++,$row['NHIF'],$formatData);              // NHIF
        $worksheet->write($indexRow,$indexCol++,$row['PAYE'],$formatData);              // PAYE
        $worksheet->write($indexRow,$indexCol++,$row['Waumini'],$formatData);           // Waumini savings
        $worksheet->write($indexRow,$indexCol++,$row['WauminiRepayment'],$formatData);           // Waumini savings
        $worksheet->write($indexRow,$indexCol++,$row['WauminiInsurance'],$formatData);           // Waumini savings
        $worksheet->write($indexRow,$indexCol++,$row['Advance'],$formatData);           // Advance
        $worksheet->write($indexRow,$indexCol++,$row['Loan'],$formatData);          // CoopLoan
        $worksheet->write($indexRow,$indexCol++,$row['Welfare'],$formatData);           // Welfare
        $worksheet->write($indexRow,$indexCol++,$row['WelfareRepayment'],$formatData);           // Welfare
        $worksheet->write($indexRow,$indexCol++,$row['TotalDeductions'],$formatData);   // TotalDeductions
        $worksheet->write($indexRow,$indexCol++,$row['TotalPay'],$formatData);          // Total Pay
        $worksheet->write($indexRow,$indexCol++,$row['NetPay'],$formatData);            // Net pay

         // Advance to the next row
        $indexCol=0;
        $indexRow++;

    }
    
    // Sends HTTP headers for the Excel file.
$workbook->send('Payroll Listing '.$payBranch.' '.date('His').'.xls');
    
// Calls finalization methods.
// This method should always be the last one to be called on every workbook
$workbook->close();
?>
