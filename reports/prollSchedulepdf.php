<?php
    error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require ('roots.php');
require ($root_path . 'include/inc_environment_global.php');

$paymonth = $_POST['scharam1'];
$month1 = date_create($_POST['scharam2']);
$month2 = date_create($_POST['scharam3']);
$dept = $_POST['schParam4'];

$sql = 'SELECT p.`Type` FROM proll_paytypes p';
$result = $db->Execute($sql);
$numRows = $result->RecordCount();

while ($row = $result->FetchRow()) {
    $payData[] = $row[0];
}

$rowsperpage = 10;

$sqlC = 'SELECT  count(distinct `Pid`) FROM proll_payments';
$resultC = $db->Execute($sqlC);
$rows = $resultC->FetchRow();
$numRows = $rows[0];
$maxPage = ceil($numRows / $rowsperpage);
$offset = 0;

$sqlD = 'select ID, CompanyName, Address, Postal, Phone, `Physical Address`, Town, country, email from proll_company ';
$resultD = $db->Execute($sqlD);
$rowD = $resultD->FetchRow();

for ($page = 1; $page <= $maxPage; $page++) {
    printTable($empData, $payData, $offset, $maxPage, $rowsperpage);
}

function printTable($empData, $payData, $offset, $maxPage, $rowsperpage) {
    global $db;
    require ('roots.php');
    require_once 'Zend/Pdf.php';
    $pdf = new Zend_Pdf ();
    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);

    $pageHeight = $page->getHeight();
    $width = $page->getWidth();
    $topPos = $pageHeight - 10;
    $leftPos = 10;
    $config_type = 'main_info_%';

    $sql2 = 'SELECT  distinct `Pid`,emp_names FROM proll_payments limit ' . $offset . ',' . $rowsperpage;
    $result2 = $db->Execute($sql2);
    while ($row2 = $result2->FetchRow()) {
        $empData[1][] = $row2[0];
        $empData[2][] = $row2[1];
    }

    $headingStyle1 = new Zend_Pdf_Style ();
    $headingStyle1->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
    $headingStyle1->setFont($font, 12);
    $page->setStyle($headingStyle1);

     $page->drawText('Names', $leftPos + 10, $topPos - 40);
    foreach ($empData[1] as $pid) {
       $page->drawText($pid, $leftPos+150, $topPos - 40);
       $leftPos=$leftPos+60;
    }
//     $leftPos=10;
//     $topPos = $topPos -40;
    foreach ($payData as $side) { // Creating each row
       $page->drawText($side,  20, $topPos - 60);
        $leftPos=150;
        foreach ($empData[1] as $top) { // Creating each column in each row
            $sql3 = 'SELECT  p.`Pid`, p.`catID`, p.`pay_type`, p.`amount`, p.`payMonth` FROM proll_payments p
       where  p.`pay_type`="' . $side . '" and p.`pid`="' . $top . '"';
            $result3 = $db->Execute($sql3);
            $numRows = $result3->RecordCount();
            $row = $result3->FetchRow();
            $output = $row[3]; // multiple the top value times the side value
            $page->drawText($output, $leftPos, $topPos - 60);
            $leftPos=$leftPos+60;
        }
       
       $topPos=$topPos-30;

    }

        if ($position == $max) {
            array_push($pdf->pages, $page);
            $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_LETTER_LANDSCAPE);
            $resultsStyle = new Zend_Pdf_Style ();
            $resultsStyle->setLineDashingPattern(array(2), 1.6);
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
            $resultsStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0.9));
            $resultsStyle->setFont($font, 9);
            $page->setStyle($resultsStyle);
            $pageHeight = $page->getHeight();
            $topPos = $pageHeight - 20;
            $currpos = 20;
            $leftPos = 36;
            $position = 1;
        } else {
            $leftPos = $leftPos + 240;
            $topPos = $pageHeight - 10;
            $position++;
        }
        
        $topPos = $topPos - 10;
    array_push($pdf->pages, $page);
    header('Content-type: application/pdf');
    echo $pdf->render();
}


?>
