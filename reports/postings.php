<?php

require ('roots.php');
require ($root_path . 'include/inc_environment_global.php');
$pmonth = $_REQUEST[pmonth];
$ptype = $_REQUEST[ptype];

createStatement($db, $pmonth,$ptype);

function getTotals($ptype,$pmonth) {
        global $db;

        $sql = "select sum(b.total) as total from care_proll_payments b  where b.pay_type like '$ptype%' and 
    b.paymonth like '$pmonth%'";
        $request = $db->Execute($sql);
        if ($row = $request->FetchRow()) {
            return $row[0];
        } else {
            return '0';
        }
    }
function createStatement($db, $pmonth,$ptype) {
    require ('roots.php');
    require_once 'Zend/Pdf.php';
    $pdf = new Zend_Pdf ();
    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

    $pageHeight = $page->getHeight();
    $width = $page->getWidth();
    $topPos = $pageHeight - 10;
    $leftPos = 36;
    $config_type = 'main_info_%';
    $sql = "SELECT * FROM care_ke_invoice";
    $global_result = $db->Execute($sql);
    if ($global_result) {
        while ($data_result = $global_result->FetchRow()) {
            $company = $data_result ['CompanyName'];
            $address = $data_result ['Address'];
            $town = $data_result ['Town'];
            $postal = $data_result ['Postal'];
            $tel = $data_result ['Tel'];
            $invoice_no = $data_result ['new_bill_nr'];
        }
        $global_config_ok = 1;
    } else {
        $global_config_ok = 0;
    }

    $title = 'FINAL EARNINGS/DEDUCTIONS';

    $headlineStyle = new Zend_Pdf_Style ();
    $headlineStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
    $headlineStyle->setFont($font, 10);
    $page->setStyle($headlineStyle);
    $page->drawText($company, $leftPos + 330, $topPos - 40);
    $page->drawText($address, $leftPos + 330, $topPos - 55);
    $page->drawText($town . ' - ' . $postal, $leftPos + 330, $topPos - 70);
    $page->drawText($tel, $leftPos + 330, $topPos - 85);

    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
    $headlineStyle2 = new Zend_Pdf_Style ();
    $headlineStyle2->setFont($font, 13);
    $page->setStyle($headlineStyle2);
    $page->drawText($title, $leftPos + 150, $topPos - 20);
    $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);

    $page->drawText('Date:  ' . date('d-m-Y'), $leftPos + 350, $topPos - 120);
    $page->drawRectangle($leftPos + 36, $topPos - 130, $leftPos + 500, $topPos - 130, Zend_Pdf_Page::SHAPE_DRAW_FILL_AND_STROKE);
  

    //$page->drawRectangle ( $leftPos + 36, $topPos - 170, $leftPos + 500, $topPos - 170, Zend_Pdf_Page::SHAPE_DRAW_FILL_AND_STROKE );
    //draw row headings
    $rectStyle = new Zend_Pdf_Style ();
    $rectStyle->setLineDashingPattern(array(2), 1.6);
    $rectStyle->setLineColor(new Zend_Pdf_Color_GrayScale(0.8));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
    $rectStyle->setFont($font, 10);
    $page->setStyle($rectStyle);
    $page->drawRectangle($leftPos + 10, $topPos - 135, $leftPos + 500, $topPos - 148, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawRectangle($leftPos + 10, $topPos - 135, $leftPos + 500, $topPos - 800, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('ID', $leftPos + 10, $topPos - 145);
    $page->drawText('Pay Type:', $leftPos + 50, $topPos - 145);
    $page->drawText('Emp Names', $leftPos + 240, $topPos - 145);
    $page->drawText('Amount', $leftPos + 380, $topPos - 145);

    $currpoint = 160;
       $sql = 'SELECT p.`ID`,p.`Pid`,p.`emp_names`,p.`pay_type`,p.`amount`,p.`payDate`,p.`payMonth` FROM `proll_payments` p 
        LEFT JOIN proll_paytypes k ON p.pay_type=k.PayType where p.paymonth like "'.$pmonth.'%"';
    
    if($ptype<>''){
       $sql = $sql . " and p.pay_type like '$ptype%'";
    }
    
//    echo $sql;
    
    $results = $db->Execute($sql);
    $resultsStyle = new Zend_Pdf_Style ();
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
    $resultsStyle->setFont($font, 9);
    $page->setStyle($resultsStyle);

    while ($row = $results->FetchRow()) {
        if ($topPos < 230) {
            array_push($pdf->pages, $page);
            $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
            $resultsStyle = new Zend_Pdf_Style ();
            $resultsStyle->setLineDashingPattern(array(2), 1.6);
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
            $resultsStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
            $resultsStyle->setFont($font, 9);
            $page->setStyle($resultsStyle);
            $pageHeight = $page->getHeight();
            $topPos = $pageHeight - 20;
            $currpoint = 30;

            $rectStyle = new Zend_Pdf_Style ();
            $rectStyle->setLineDashingPattern(array(2), 1.6);
            $rectStyle->setLineColor(new Zend_Pdf_Color_GrayScale(0.8));
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
            $rectStyle->setFont($font, 9);
            $page->setStyle($rectStyle);
//            $page->drawRectangle($leftPos + 32, $topPos - 30, $leftPos + 500, $topPos - 148, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
            $page->drawRectangle($leftPos + 32, $topPos - 20, $leftPos + 500, $topPos - 800, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        }
        $total = intval($row[total] + $total);
     
        $page->drawText($row[ID], $leftPos + 12, $topPos - $currpoint);
        $page->drawText($row[pay_type], $leftPos + 30, $topPos - $currpoint);
        $page->drawText(trim($row['emp_names']), $leftPos + 200, $topPos - $currpoint);
        $page->drawText($row['amount'], $leftPos + 380, $topPos - $currpoint);
        
        $page->drawText(number_format($runBal, 2), $leftPos + 450, $topPos - $currpoint);
        $topPos = $topPos - 20;
    }
    $page->drawRectangle($leftPos + 10, $topPos - $currpoint, $leftPos + 500, $topPos - $currpoint, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
     $topPos = $topPos - $currpoint;

    $topPos = $topPos - 10;
    array_push($pdf->pages, $page);
    header('Content-type: application/pdf');
    echo $pdf->render();
}

?>
