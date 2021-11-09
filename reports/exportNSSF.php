<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require_once('roots.php');
require ($root_path . 'include/inc_environment_global.php');
require_once 'Spreadsheet/Excel/Writer.php';
// Lets define some custom colors codes
define('CUSTOM_DARK_BLUE', 20);
define('CUSTOM_BLUE', 21);
define('CUSTOM_LIGHT_BLUE', 22);
define('CUSTOM_YELLOW', 23);
define('CUSTOM_GREEN', 24);

$workbook=new Spreadsheet_Excel_Writer();

$worksheet=$workbook->addWorksheet('NSSF Returns');

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
$worksheet->setColumn(1, 1, 12); // Name, set the width to 12
$worksheet->setColumn(1, 1, 15); // Email, set the width to 15
$worksheet->setColumn(3, 3, 30); // Email, set the width to 15

$worksheet->write(1, 3, 'NSSF Returns', $formatHeader);

// Create the header for the data starting @ row 4
$indexCol = 0;
$indexRow = 4;
$worksheet->write($indexRow, $indexCol++, 'PAYROLL NUMBER', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'SURNAME', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'OTHER NAMES', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'ID NO', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'KRA PIN', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'NSSF No', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'GROSS PAY', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'VOLUNTARY', $formatReportHeader);
// $worksheet->write($indexRow, $indexCol++, 'Amount', $formatReportHeader);

$indexRow++;   // Advance to the next row
$indexCol = 0; // Start @ column 0

    $payMonth = $_REQUEST['payMonth'];
    //$pstBranch=$_REQUEST[branch];
    
   $sql = "SELECT p.`Pid`,e.`Surname` ,concat(e.`LastName`,' ',e.`FirstName`) as OtherNames,p.`pay_type`, p.`amount` AS gross,
   '' AS Amount,e.ID_No,e.`Pin_NO`,e.NSSF_No FROM proll_payments p INNER JOIN proll_empregister e
           ON p.Pid=e.PID WHERE pay_type ='BASIC PAY' AND payMonth='$payMonth'";

//    if($pmonth<>''){
//        $sql.=" AND payMonth='$pmonth'";
//    }
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
    while($row=$result->FetchRow()){
        $worksheet->write(
            $indexRow,
            $indexCol++,
            $row['Pid'],
            $formatData);
         $worksheet->write(
            $indexRow,
            $indexCol++,
            $row['Surname'],
            $formatData);
        $worksheet->write(
            $indexRow,
            $indexCol++,
            $row['OtherNames'],
            $formatData);
        $worksheet->write(
            $indexRow,
            $indexCol++,
            $row['ID_No'],
            $formatData);
        $worksheet->write(
            $indexRow,
            $indexCol++,
            '',
            $formatData);
         $worksheet->write(
            $indexRow,
            $indexCol++,
            $row['NSSF_No'],
            $formatData);
         $worksheet->write(
            $indexRow,
            $indexCol++,
            $row['gross'],
            $formatData);
         $worksheet->write(
            $indexRow,
            $indexCol++,
            '',
            $formatData);

         // Advance to the next row
        $indexCol=0;
        $indexRow++;
        
    }
    
    // Sends HTTP headers for the Excel file.
$workbook->send('NSSF Returns'.date('His').'.xls');
    
// Calls finalization methods.
// This method should always be the last one to be called on every workbook
$workbook->close();
?>
