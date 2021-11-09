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

$worksheet=$workbook->addWorksheet('PAYE Returns');

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

$worksheet->write(1, 3, 'PAYE Returns', $formatHeader);

// Create the header for the data starting @ row 4
$indexCol = 0;
$indexRow = 4;
$worksheet->write($indexRow, $indexCol++, 'Pin No', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Names', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Nationality', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'Status', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'gross', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '1', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '2', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '3', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '4', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '5', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '6', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '7', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '8', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '9', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '10', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '12', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'benefit', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '13', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '14', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '15', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '16', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '17', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, 'NSSF', $formatReportHeader);
$worksheet->write($indexRow, $indexCol++, '18', $formatReportHeader);



$indexRow++;   // Advance to the next row
$indexCol = 0; // Start @ column 0

    $payMonth = $_REQUEST['payMonth'];
    //$pstBranch=$_REQUEST[branch];
    
   $sql = "SELECT e.`Pin_NO`,p.`emp_names`,e.`Nationality`,e.`empStatus`,IF(p.`pay_type`='BASIC PAY',Amount,'') AS gross,
   '1','2','3','4','5','6','7','8','9','10','11','12','benefit','13','14','15','16','17',IF(p.`pay_type`='N.S.S.F',amount,'') AS NSSF,'18'
   ,e.ID_no,e.pin_no FROM proll_payments p INNER JOIN proll_empregister e
   ON p.Pid=e.PID WHERE payMonth='$payMonth'";

//    if($pmonth<>''){
//        $sql.=" AND payMonth='$pmonth'";
//    }
//    echo $sql;
    
    $result=$db->Execute($sql);
    while($row=$result->FetchRow()){
        $worksheet->write($indexRow,$indexCol++,$row['Pid'],$formatData);
        $worksheet->write($indexRow,$indexCol++,$row['emp_names'],$formatData);
        $worksheet->write($indexRow,$indexCol++,$row['Nationality'], $formatData);
        $worksheet->write( $indexRow,$indexCol++,$row['empStatus'],$formatData);
        $worksheet->write($indexRow,$indexCol++,$row['gross'],$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'Benefit not given',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);
        $worksheet->write($indexRow,$indexCol++,$row['NSSF'],$formatData);
        $worksheet->write($indexRow,$indexCol++,'0',$formatData);

         // Advance to the next row
        $indexCol=0;
        $indexRow++;
        
    }
    
    // Sends HTTP headers for the Excel file.
$workbook->send('PAYE Returns'.date('His').'.xlsm');
    
// Calls finalization methods.
// This method should always be the last one to be called on every workbook
$workbook->close();
?>
