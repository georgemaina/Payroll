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

$worksheet=$workbook->addWorksheet('Payroll Postings');

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

$worksheet->write(1, 3, 'Payroll Postings', $formatHeader);

// Create the header for the data starting @ row 4
$indexCol = 0;
$indexRow = 4;
$worksheet->write($indexRow,$indexCol++, 'PID', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Names', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Category', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Pay Type', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Amount', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Pay Date', $formatReportHeader);
$worksheet->write($indexRow,$indexCol++, 'Pay Month', $formatReportHeader);


$indexRow++;   // Advance to the next row
$indexCol = 0; // Start @ column 0
//
$payMonth =$_REQUEST[payMonth];
$CatID=$_REQUEST['CatID'];
$empBranch=$_REQUEST['empBranch'];
$PaymentType=$_REQUEST['PaymentType'];
//
$sql = "SELECT p.`ID`,p.`Pid`,p.`emp_names` as EmpNames,p.`catID`,p.`pay_type`,p.`amount`,p.`payDate`,p.`payMonth` FROM `proll_payments` p
        LEFT JOIN proll_paytypes k ON p.pay_type=k.PayType
         left join proll_empregister r on p.pid=r.pid
         where p.paymonth='$payMonth'";

if ($CatID <> '') {
    $sql = $sql . " and p.CatID = '$CatID'";
}

if ($PaymentType <> '') {
    $sql = $sql . " and p.pay_type = '$PaymentType'";
}

if ($empBranch <> '') {
    $sql = $sql . " and r.empBranch = '$empBranch'";
}


$sql = $sql . " ORDER BY p.Pid,P.ID ASC";
//echo $sql;

$result = $db->Execute($sql);
$numRows = $result->RecordCount();

     //echo $sql;

    $result=$db->Execute($sql);
    while($row=$result->FetchRow()){
        $worksheet->write($indexRow,$indexCol++,$row['Pid']);
        $worksheet->write($indexRow,$indexCol++,TRIM($row['EmpNames']));
        $worksheet->write($indexRow,$indexCol++,$row['catID']);          //Basic Pay
        $worksheet->write($indexRow,$indexCol++,$row['pay_type']);
        $worksheet->write($indexRow,$indexCol++,$row['amount'],$formatData);
        $worksheet->write($indexRow,$indexCol++,$row['PayDate']);
        $worksheet->write($indexRow,$indexCol++,$row['PayMonth']);

         // Advance to the next row
        $indexCol=0;
        $indexRow++;
    }
    
    // Sends HTTP headers for the Excel file.
$workbook->send('Payroll Postings'.date('Hms').'.xls');
    
// Calls finalization methods.
// This method should always be the last one to be called on every workbook
$workbook->close();
?>
