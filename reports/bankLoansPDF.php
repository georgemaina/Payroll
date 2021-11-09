<?php
    error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require ('roots.php');
require ($root_path . 'include/inc_environment_global.php');
$pid = $_REQUEST['pid'];
$bankid=$_REQUEST['bankcode'];
$payType=$_REQUEST['payType'];
$payMonth=$_REQUEST['payMonth'];
require_once 'Zend/Pdf.php';
$pdf = new Zend_Pdf ();
$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

class Library_Pdf_Base extends Zend_Pdf {
    /**
     * Align text at left of provided coordinates
     */

    const TEXT_ALIGN_LEFT = 'left';

    /**
     * Align text at right of provided coordinates
     */
    const TEXT_ALIGN_RIGHT = 'right';

    /**
     * Center-text horizontally within provided coordinates
     */
    const TEXT_ALIGN_CENTER = 'center';

    /**
     * Extension of basic draw-text function to allow it to vertically center text
     *
     * @param Zend_Pdf_Page $page
     * @param string $text
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $position
     * @param string $encoding
     * @return self
     */
    public function drawText(Zend_Pdf_Page $page, $text, $x1, $y1, $x2 = null, $position = self::TEXT_ALIGN_LEFT, $encoding = null) {
        $bottom = $y1; // could do the same for vertical-centering

        switch ($position) {
            case self::TEXT_ALIGN_LEFT:
                $left = $x1;
                break;
            case self::TEXT_ALIGN_RIGHT:
                $text_width = $this->getTextWidth($text, $page->getFont(), $page->getFontSize());
                $left = $x1 - $text_width;
                break;
            case self::TEXT_ALIGN_CENTER:
                if (null === $x2) {
                    throw new Exception("Cannot center text horizontally, x2 is not provided");
                }
                $text_width = $this->getTextWidth($text, $page->getFont(), $page->getFontSize());
                $box_width = $x2 - $x1;
                $left = $x1 + ($box_width - $text_width) / 2;
                break;
            default:
                throw new Exception("Invalid position value \"$position\"");
        }

        // display multi-line text
        foreach (explode(PHP_EOL, $text) as $i => $line) {
            $page->drawText($line, $left, $bottom - $i * $page->getFontSize(), $encoding);
        }
        return $this;
    }

    /**
     * Return length of generated string in points
     *
     * @param string $string
     * @param Zend_Pdf_Resource_Font $font
     * @param int $font_size
     * @return double
     */
    public function getTextWidth($text, Zend_Pdf_Resource_Font $font, $font_size) {
        $drawing_text = iconv('', 'UTF-16BE', $text);
        $characters = array();
        for ($i = 0; $i < strlen($drawing_text); $i++) {
            $characters[] = (ord($drawing_text[$i++]) << 8) | ord($drawing_text[$i]);
        }
        $glyphs = $font->glyphNumbersForCharacters($characters);
        $widths = $font->widthsForGlyphs($glyphs);
        $text_width = (array_sum($widths) / $font->getUnitsPerEm()) * $font_size;
        return $text_width;
    }

}

createInvoiceTitle($db,$payType,$payMonth,$pdf,$page);

function createInvoiceTitle($db,$payType,$payMonth,$pdf,$page) {
    require ('roots.php');
////    require_once 'Zend/Pdf.php';
//    require_once '../My_Pdf.php';
//    $pdf = new Zend_Pdf ();
//    $mpdf=new My_Pdf();
//    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
    $pdfBase=new Library_Pdf_Base();
      
    $pageHeight = $page->getHeight();
    $width = $page->getWidth();
    $topPos = $pageHeight - 10;
    $leftPos = 11;
    $config_type = 'main_info_%';
    $sql = "SELECT * FROM proll_company";
    $global_result = $db->Execute($sql);
    if ($global_result) {
        while ($data_result = $global_result->FetchRow()) {
            $company = $data_result ['CompanyName'];
            $address = $data_result ['Address'];
            $town = $data_result ['Physical Address'];
            $postal = $data_result ['Postal'];
            $tel = $data_result ['Phone'];
            $email = $data_result ['email'];
            $bankTitle = $data_result ['bankTitle'];
            $country=$data_result ['country'];
            $topMessage = $data_result ['topMessage'];
            $bottomMessage = $data_result ['bottomMessage'];
        }
        $global_config_ok = 1;
    } else {
        $global_config_ok = 0;
    }

    $title = 'BANK LOAN DEDUCTIONS';
    $totalAmount='';

    $headlineStyle = new Zend_Pdf_Style ();
    $headlineStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
    $headlineStyle->setFont($font, 10);
    $page->setStyle($headlineStyle);
    $page->drawText($company, $leftPos + 200, $topPos - 15);
    
     $headlineStyle4 = new Zend_Pdf_Style ();
    $headlineStyle4->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
    $headlineStyle4->setFont($font, 10);
    $page->setStyle($headlineStyle4);
   // $page->drawText($bankTitle, $leftPos + 150, $topPos - 30);
    $page->drawText($address.','.$town.','.$country.','.$postal.',Tel:'.$tel, $leftPos + 190, $topPos - 30);
    $page->drawText($email, $leftPos + 220, $topPos - 45);
    
    $headlineStyle4 = new Zend_Pdf_Style ();
    $headlineStyle4->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
    $headlineStyle4->setFont($font, 10);
    $page->setStyle($headlineStyle4);
    $page->drawText($title, $leftPos + 220, $topPos - 60);

        
    $sqlb="Select payType from proll_paytypes where ID='$payType'";
    $result=$db->Execute($sqlb);
    $row=$result->FetchRow();
    
    $page->drawText($row[payType], $leftPos + 240, $topPos - 80);

    $topPos=$topPos-40;
    $page->drawText('Emp No:', $leftPos + 12, $topPos - 60);
    $page->drawText('Name:', $leftPos + 55, $topPos - 60);
    $page->drawText('Account No:', $leftPos + 220, $topPos - 60);
    $page->drawText('ID Number ', $leftPos + 320, $topPos - 60);
//    $page->drawText('Branch', $leftPos + 400, $topPos - 60);
    $page->drawText('Amount ', $leftPos + 410, $topPos - 60);
//    $page->setLineWidth(0.9);
//    $page->drawLine($leftPos + 12, $topPos - 105, $leftPos + 550, $topPos - 105, Zend_Pdf_Page::SHAPE_DRAW_STROKE);

    $payName=$row[payType];
    $sql = "SELECT DISTINCT p.`PID`, p.`FirstName`, p.`Surname`, p.`LastName`, p.`Account_No`, 
        p.`ID_No` FROM proll_empregister p LEFT JOIN proll_payments m ON p.`PID`=m.`Pid`
         WHERE  p.empstatus='Active' AND m.`payMonth`='$payMonth' AND m.`pay_type`='$row[payType]'";

    $result = $db->Execute($sql);
    //echo $sql;
    $numRows = $result->RecordCount();
   // $row1=$result->FetchRow();
   // $page->drawText($row1['BankName'].' '.$row1['BankBranch'], $leftPos + 200, $topPos - 50);
    $page->setLineWidth(0.5);
    $page->drawLine($leftPos + 12, $topPos - 62, $leftPos + 550, $topPos - 62, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $dataStyle = new Zend_Pdf_Style ();
    $dataStyle->setFillColor(new Zend_Pdf_Color_RGB(0.1, 0.1, 0.1));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
    $dataStyle->setFont($font, 8);
    $page->setStyle($dataStyle);
     $currpoint = 80;
     
    $total=0;
    while ($row = $result->FetchRow()) {
       
        if ($topPos < 100) {
            array_push($pdf->pages, $page);
            $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
            $resultsStyle = new Zend_Pdf_Style ();
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
            $resultsStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
            $resultsStyle->setFont($font, 8);
            $page->setStyle($resultsStyle);
            $pageHeight = $page->getHeight();
            $topPos = $pageHeight -10;
            $currpoint = 15;
          
        }
        $dataStyle = new Zend_Pdf_Style ();
        $dataStyle->setFillColor(new Zend_Pdf_Color_RGB(0.1, 0.1, 0.1));
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
        $dataStyle->setFont($font, 8);
        $page->setStyle($dataStyle);

        $page->drawText($row['PID'] , $leftPos + 12, $topPos - $currpoint);
        $page->drawText(strtoupper($row['FirstName']) . ' ' . strtoupper($row['Surname']) . ' ' . strtoupper($row['LastName']), $leftPos + 45, $topPos - $currpoint);
        $page->drawText($row['Account_No'], $leftPos + 220, $topPos - $currpoint);
        $page->drawText($row['ID_No'] , $leftPos + 320, $topPos - $currpoint);
      //  $page->drawText($row['BankBranch'] , $leftPos + 400, $topPos - $currpoint);

        $sql = "select pid,amount from proll_payments where Pay_Type ='$payName' and paymonth='$payMonth' and pid='$row[PID]'";
        //echo $sql;
        $result2 = $db->Execute($sql);
        $sumRows = $result2->FetchRow();
        
        $amount=  $sumRows[1];
        $pdfBase->drawText($page, "Ksh ".number_format($amount,2), $leftPos + 450, $topPos - $currpoint,$leftPos + 450,right);
        
        if($amount==0){
            $sql1="Insert into proll_empregister_inactive(pid) values( $row[PID])";
            $db->Execute($sql1);
//            echo $sql1;
        }

        $total=$total+$amount;

        $topPos = $topPos - 15;
    }

    $page->setLineWidth(0.5);
    $page->drawLine($leftPos + 390, $topPos-75, $leftPos + 480, $topPos-75, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawLine($leftPos + 390, $topPos-87, $leftPos + 480, $topPos-87, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawLine($leftPos + 390, $topPos-90, $leftPos + 480, $topPos-90, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $totalStyle = new Zend_Pdf_Style ();
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
    $totalStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $totalStyle->setFont($font, 10);
    $page->setStyle($totalStyle);
    $page->drawText('TOTAL', $leftPos + 350, $topPos - 84);
    //$page->drawText("Ksh ".number_format($total,2), $leftPos + 400, $topPos - 10);
    $pdfBase->drawText($page, "Ksh ".number_format($total,2), $leftPos + 450, $topPos - 84,$leftPos + 450,right);

    $dataStyle = new Zend_Pdf_Style ();
    $dataStyle->setFillColor(new Zend_Pdf_Color_RGB(0.1, 0.1, 0.1));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
    $dataStyle->setFont($font, 8);
    $page->setStyle($dataStyle);
    $page->setLineWidth(0.5);

    $topPos=$topPos-100;
    $page->drawLine($leftPos + 12, $topPos - 20, $leftPos + 550, $topPos - 20, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('PREPAIRED BY ', $leftPos + 12, $topPos - 60);
    $page->drawLine($leftPos + 100, $topPos - 60, $leftPos + 200, $topPos - 60, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('SIGN ', $leftPos + 220, $topPos - 60);
    $page->drawLine($leftPos + 250, $topPos - 60, $leftPos + 350, $topPos - 60, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('DATE ', $leftPos + 360, $topPos - 60);
    $page->drawLine($leftPos + 400, $topPos - 60, $leftPos + 500, $topPos - 60, Zend_Pdf_Page::SHAPE_DRAW_STROKE);


    $page->drawText('CHECKED BY  ', $leftPos + 12, $topPos - 90);
    $page->drawLine($leftPos + 100, $topPos - 90, $leftPos + 200, $topPos - 90, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('SIGN ', $leftPos + 220, $topPos - 90);
    $page->drawLine($leftPos + 250, $topPos - 90, $leftPos + 350, $topPos - 90, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('DATE ', $leftPos + 360, $topPos - 90);
    $page->drawLine($leftPos + 400, $topPos - 90, $leftPos + 500, $topPos - 90, Zend_Pdf_Page::SHAPE_DRAW_STROKE);

    $page->drawText('AUTHORIZED BY ', $leftPos + 12, $topPos - 120);
    $page->drawLine($leftPos + 100, $topPos - 120, $leftPos + 200, $topPos - 120, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('SIGN ', $leftPos + 220, $topPos - 120);
    $page->drawLine($leftPos + 250, $topPos - 120, $leftPos + 350, $topPos - 120, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawText('DATE ', $leftPos + 360, $topPos - 120);
    $page->drawLine($leftPos + 400, $topPos - 120, $leftPos + 500, $topPos - 120, Zend_Pdf_Page::SHAPE_DRAW_STROKE);






      $topPos = $topPos - 10;
     array_push($pdf->pages, $page);
    header('Content-type: application/pdf');
    echo $pdf->render();
}

?>
