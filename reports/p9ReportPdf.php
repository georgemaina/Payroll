<?php

require ('roots.php');
require ($root_path . 'include/inc_environment_global.php');
$pid = $_REQUEST['pid'];
$payMonth = $_REQUEST['payMonth'];

require_once 'Zend/Pdf.php';
$pdf = new Zend_Pdf ();
$page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);

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

createP9Report($db, $pid, $pdf, $page);

function getWrappedText($string, Zend_Pdf_Style $style, $max_width) {
    $wrappedText = '';
    $lines = explode("\n", $string);
    foreach ($lines as $line) {
        $words = explode(' ', $line);
        $word_count = count($words);
        $i = 0;
        $wrappedLine = '';
        while ($i < $word_count) {
            /* if adding a new word isn't wider than $max_width,
              we add the word */
            if (widthForStringUsingFontSize($wrappedLine . ' ' . $words[$i]
                            , $style->getFont()
                            , $style->getFontSize()) < $max_width) {
                if (!empty($wrappedLine)) {
                    $wrappedLine .= ' ';
                }
                $wrappedLine .= $words[$i];
            } else {
                $wrappedText .= $wrappedLine . "\n";
                $wrappedLine = $words[$i];
            }
            $i++;
        }
        $wrappedText .= $wrappedLine . "\n";
    }
    return $wrappedText;
}

/**
 * found here, not sure of the author :
 * http://devzone.zend.com/article/2525-Zend_Pdf-tutorial#comments-2535
 */
function widthForStringUsingFontSize($string, $font, $fontSize) {
    $drawingString = iconv('UTF-8', 'UTF-16BE//IGNORE', $string);
    $characters = array();
    for ($i = 0; $i < strlen($drawingString); $i++) {
        $characters[] = (ord($drawingString[$i++]) << 8 ) | ord($drawingString[$i]);
    }
    $glyphs = $font->glyphNumbersForCharacters($characters);
    $widths = $font->widthsForGlyphs($glyphs);
    $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
    return $stringWidth;
}

function createP9Report($db, $pid, $pdf, $page) {
    require ('roots.php');
////    require_once 'Zend/Pdf.php';
//    require_once '../My_Pdf.php';
//    $pdf = new Zend_Pdf ();
//    $mpdf=new My_Pdf();
//    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

    $pdfBase = new Library_Pdf_Base();

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
            $country = $data_result ['country'];
            $topMessage = $data_result ['topMessage'];
            $bottomMessage = $data_result ['bottomMessage'];
            $pinNo = $data_result["PinNo"];
        }
        $global_config_ok = 1;
    } else {
        $global_config_ok = 0;
    }
    
    $sql="Select * from proll_empregister where pid='$pid'";
    $results=$db->Execute($sql);
    $row=$results->FetchRow();
    
    $empPin=$row[Pin_NO];
    $surName=$row[Surname];
    $FirstName=$row[FirstName];
    $LastName=$row[LastName];

    $title = 'Payroll P9 Report';
    $totalAmount = '';


    $headlineStyle = new Zend_Pdf_Style ();
    $headlineStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
    $headlineStyle->setFont($font, 12);
    $page->setStyle($headlineStyle);
    $page->drawText("KENYA REVENUE AUTHORITY", $leftPos + 300, $topPos - 10);
    $page->drawText("DOMESTIC TAXES DEPARTMENT", $leftPos + 290, $topPos - 25);
    $page->drawText("TAX DEDUCTION CARD YEAR " . date("Y"), $leftPos + 285, $topPos - 40);


    $headlineStyle = new Zend_Pdf_Style ();
    $headlineStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
    $headlineStyle->setFont($font, 10);
    $page->setStyle($headlineStyle);
    $topPos=$topPos+70;
    $page->drawText("Employers Name: " , $leftPos + 10, $topPos - 110);
    $page->drawText("Employees Main Name:"  , $leftPos + 10, $topPos - 125);
    $page->drawText("Employees  Name: " , $leftPos + 10, $topPos - 140);
    $page->drawText("Employers Pin:", $leftPos + 600, $topPos - 110);
    $page->drawText("Employees Pin:", $leftPos + 600, $topPos - 140);
    
    $itemStyle = new Zend_Pdf_Style ();
    $itemStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
    $itemStyle->setFont($font, 10);
    $page->setStyle($itemStyle);
    $page->drawText($company, $leftPos + 100, $topPos - 110);
    $page->drawText($surName, $leftPos + 120, $topPos - 125);
    $page->drawText($FirstName . ' ' . $LastName, $leftPos + 125, $topPos - 140);
    $page->drawText($pinNo, $leftPos + 670, $topPos - 110);
    $page->drawText($empPin, $leftPos + 670, $topPos - 140);

   
    $rectStyle = new Zend_Pdf_Style ();
   // $rectStyle->setLineDashingPattern(array(2), 0);
    $rectStyle->setLineWidth(0.2);
    //$rectStyle->setLineColor(new Zend_Pdf_Color_GrayScale(0.5));
    
    $page->setStyle($rectStyle);
    $page->drawRectangle($leftPos + 8, $topPos - 150, $leftPos + 820, $topPos - 310, Zend_Pdf_Page::SHAPE_DRAW_STROKE); 
    $page->drawLine($leftPos + 8, $topPos - 235, $leftPos + 820, $topPos - 235, Zend_Pdf_Page::SHAPE_DRAW_STROKE); 
    $page->drawLine($leftPos + 55, $topPos - 150, $leftPos + 55,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //A
    $page->drawLine($leftPos + 95, $topPos - 150, $leftPos + 95,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE);  //B
    $page->drawLine($leftPos + 145, $topPos - 150, $leftPos + 145,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //C
    $page->drawLine($leftPos + 190, $topPos - 150, $leftPos + 190,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //D
    $page->drawLine($leftPos + 235, $topPos - 150, $leftPos + 235,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //E
    $page->drawLine($leftPos + 345, $topPos - 150, $leftPos + 345,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //F
    $page->drawLine($leftPos + 435, $topPos - 150, $leftPos + 435,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //G
    $page->drawLine($leftPos + 525, $topPos - 150, $leftPos + 525,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //H
    $page->drawLine($leftPos + 585, $topPos - 150, $leftPos + 585,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //I
    $page->drawLine($leftPos + 635, $topPos - 150, $leftPos + 635,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE);//J
    $page->drawLine($leftPos + 685, $topPos - 150, $leftPos + 685,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //K
    $page->drawLine($leftPos + 745, $topPos - 150, $leftPos + 745,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //L
    $page->drawLine($leftPos + 275, $topPos - 265, $leftPos + 275,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //E1
    $page->drawLine($leftPos + 310, $topPos - 265, $leftPos + 310,$topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //E2
    $page->drawLine($leftPos + 245, $topPos - 265, $leftPos + 345,$topPos - 265, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //E MID
    $page->drawLine($leftPos + 525, $topPos - 265, $leftPos + 820,$topPos - 265, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //H MID
    $page->drawRectangle($leftPos + 8, $topPos - 310, $leftPos + 820, $topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    $page->drawRectangle($leftPos + 8, $topPos - 490, $leftPos + 820, $topPos - 520, Zend_Pdf_Page::SHAPE_DRAW_STROKE);
    
    $headlineStyle4 = new Zend_Pdf_Style ();
    $headlineStyle4->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
    $headlineStyle4->setFont($font, 10);
    $page->setStyle($headlineStyle4);
    

    $topPos = $topPos - 150;
    $page->drawText('MONTH:', $leftPos + 10, $topPos - 15);
    $basicPay = explode("\n", getWrappedText('Basic Salary', $headlineStyle, 6));  // COLUMN A
    foreach ($basicPay as $line) {
        $page->drawText($line, $leftPos + 60, $topPos);
        $topPos-=15;
    }
    $benefits = explode("\n", getWrappedText('Benefits- Non-Cash', $headlineStyle, 25));  // COLUMN B
    foreach ($benefits as $line2) {
        $page->drawText($line2, $leftPos + 100, $topPos + 60);
        $topPos-=15;
    }

    $coulumnC = explode("\n", getWrappedText('Value of Quarters', $headlineStyle, 35));  // COLUMN C
    foreach ($coulumnC as $line2) {
        $page->drawText($line2, $leftPos + 150, $topPos + 105);
        $topPos-=15;
    }

    $coulumnD = explode("\n", getWrappedText('Total Gross Pay', $headlineStyle, 35));  // COLUMN D
    foreach ($coulumnD as $line2) {
        $page->drawText($line2, $leftPos + 200, $topPos + 150);
        $topPos-=15;
    }

    $coulumnE = explode("\n", getWrappedText('Defined Contribution Retirement Scheme', $headlineStyle, 90));  // COLUMN E
    foreach ($coulumnE as $line2) {
        $page->drawText($line2, $leftPos + 250, $topPos + 210);
        $topPos-=15;
    }

    $coulumnF = explode("\n", getWrappedText('Owner Occupied Interest', $headlineStyle, 90));  // COLUMN F
    foreach ($coulumnF as $line2) {
        $page->drawText($line2, $leftPos + 350, $topPos + 255);
        $topPos-=15;
    }

    $coulumnG = explode("\n", getWrappedText('Retirement Contribution & Owner Occupied Interest', $headlineStyle, 80));  // COLUMN G
    foreach ($coulumnG as $line2) {
        $page->drawText($line2, $leftPos + 440, $topPos + 300);
        $topPos-=15;
    }

    $coulumnH = explode("\n", getWrappedText('Chargeable Pay', $headlineStyle, 40));  // COLUMN H
    foreach ($coulumnH as $line2) {
        $page->drawText($line2, $leftPos + 530, $topPos + 390);
        $topPos-=15;
    }

    $coulumnI = explode("\n", getWrappedText('Tax Charged', $headlineStyle, 40));  // COLUMN I
    foreach ($coulumnI as $line2) {
        $page->drawText($line2, $leftPos + 590, $topPos + 435);
        $topPos-=15;
    }

    $coulumnJ = explode("\n", getWrappedText('Personal Relief', $headlineStyle, 40));  // COLUMN J
    foreach ($coulumnJ as $line2) {
        $page->drawText($line2, $leftPos + 640, $topPos + 480);
        $topPos-=15;
    }

    $coulumnK = explode("\n", getWrappedText('Insurance Relief', $headlineStyle, 40));  // COLUMN K
    foreach ($coulumnK as $line2) {
        $page->drawText($line2, $leftPos + 690, $topPos + 540);
        $topPos-=15;
    }

    $coulumnL = explode("\n", getWrappedText('PAYE Tax (J-K)', $headlineStyle, 40));  // COLUMN L
    foreach ($coulumnL as $line2) {
        $page->drawText($line2, $leftPos + 750, $topPos + 585);
        $topPos-=15;
    }

    $topPos = $topPos + 580;
    $page->drawText('Kshs:', $leftPos + 60, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 100, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 160, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 210, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 250, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 350, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 440, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 530, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 590, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 640, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 690, $topPos - 15);
    $page->drawText('Kshs:', $leftPos + 750, $topPos - 15);

    $page->drawText('A:', $leftPos + 60, $topPos - 30);
  
    $page->drawText('B', $leftPos + 100, $topPos - 30);
    $page->drawText('C', $leftPos + 160, $topPos - 30);
    $page->drawText('D', $leftPos + 210, $topPos - 30);
    $page->drawText('E', $leftPos + 250, $topPos - 30);
    $page->drawText('F', $leftPos + 350, $topPos - 30);
    $page->drawText('G', $leftPos + 440, $topPos - 30);
    $page->drawText('H', $leftPos + 530, $topPos - 30);
    $page->drawText('J', $leftPos + 590, $topPos - 30);
    $page->drawText('K', $leftPos + 640, $topPos - 30);
    $page->drawText('1162', $leftPos + 650, $topPos - 45);
    $page->drawText('Total', $leftPos + 650, $topPos - 65);
    $page->drawText('', $leftPos + 690, $topPos - 30);
    $page->drawText('L', $leftPos + 750, $topPos - 30);

    $topPos = $topPos - 640;
    
    $E1 = explode("\n", getWrappedText('E1 30% of A', $headlineStyle, 20));  // COLUMN L
    foreach ($E1 as $line2) {
        $page->drawText($line2, $leftPos + 250, $topPos + 580);
        $topPos-=15;
    }

    $E2 = explode("\n", getWrappedText('E2 Actual', $headlineStyle, 20));  // COLUMN L
    foreach ($E2 as $line2) {
        $page->drawText($line2, $leftPos + 280, $topPos + 640);
        $topPos-=30;
    }
    $E3 = explode("\n", getWrappedText('E3 Actual', $headlineStyle, 20));  // COLUMN L
    foreach ($E3 as $line2) {
        $page->drawText($line2, $leftPos + 315, $topPos + 730);
        $topPos-=30;
    }
    $interest = explode("\n", getWrappedText('Amount of Interest', $headlineStyle, 50));  // COLUMN L
    foreach ($interest as $line2) {
        $page->drawText($line2, $leftPos + 350, $topPos + 835);
        $topPos-=15;
    }
    $lowest = explode("\n", getWrappedText('The Lowest of E added to F', $headlineStyle, 60));  // COLUMN L
    
    $itemStyles = new Zend_Pdf_Style ();
    $itemStyles->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
    $itemStyles->setFont($font, 8);
    $page->setStyle($itemStyles);
    foreach ($lowest as $line2) {
        $page->drawText($line2, $leftPos + 440, $topPos + 880);
        $topPos-=15;
    }

    $payMonths= array('January','February','March','April','May','June','July','August','September','October','November','December');
    
    $topPos=$topPos+885;
    for($x=0;$x<count($payMonths);$x++)
    {
        $page->drawLine($leftPos + 8, $topPos - 10, $leftPos + 820,$topPos - 10, Zend_Pdf_Page::SHAPE_DRAW_STROKE); //H MID
        $page->drawText($payMonths[$x], $leftPos + 10, $topPos - 20);
        
        $sql="SELECT
                `ID`,`PID`,`EmpNames`,`payrollYear`,`payrollMonth`,`ColumnA`,`ColumnB`, `ColumnC`,`ColumnD`,`ColumnE1`,
                `ColumnE2`,`ColumnE3`,`ColumnF`, `ColumnG`,`ColumnH`,`ColumnJ`,`ColumnK`,`ColumnL`
              FROM `proll_p9a` where pid='$pid'";
        //echo $sql;
        $results=$db->Execute($sql);
        $colASum=0;$colBSum=0;$colCSum=0;$colDSum=0;$colESum=0;$colFSum=0;$colGSum=0;$colHSum=0;
        $colJSum=0;$colKSum=0;$colLSum=0;
        while($row=$results->FetchRow()){
            if($row['payrollMonth']==$payMonths[$x]){
                $page->drawText($row['ColumnA'], $leftPos + 60, $topPos - 20);
                $page->drawText($row['ColumnB'], $leftPos + 100, $topPos - 20);
                $page->drawText($row['ColumnC'], $leftPos + 160, $topPos - 20);
                $page->drawText($row['ColumnD'], $leftPos + 200, $topPos - 20);
                $page->drawText($row['ColumnE1'], $leftPos + 250, $topPos - 20);
                $page->drawText($row['ColumnE2'], $leftPos + 280, $topPos - 20);
                $page->drawText($row['ColumnE3'], $leftPos + 320, $topPos - 20);
                $page->drawText($row['ColumnF'], $leftPos + 360, $topPos - 20);
                $page->drawText($row['ColumnG'], $leftPos + 450, $topPos - 20);
                $page->drawText($row['ColumnH'], $leftPos + 540, $topPos - 20);
                //$page->drawText($row['ColumnI'], $leftPos + 600, $topPos - 20);
                $page->drawText($row['ColumnJ'], $leftPos + 600, $topPos - 20);
                $page->drawText($row['ColumnK'], $leftPos + 650, $topPos - 20);
                $page->drawText($row['ColumnL'], $leftPos + 750, $topPos - 20);
            }
            $colASum=$colASum+$row['ColumnA'];$colBSum=$colBSum+$row['ColumnB'];$colCSum=$colCSum+$row['ColumnC'];
            $colDSum=$colDSum+$row['ColumnD'];$colE1Sum=$colE1Sum+$row['ColumnE1'];$colE2Sum=$colE2Sum+$row['ColumnE2'];
            $colE3Sum=$colE3Sum+$row['ColumnE3'];$colFSum=$colFSum+$row['ColumnF'];
            $colGSum=$colGSum+$row['ColumnG'];$colHSum=$colHSum+$row['ColumnH'];
            $colKSum=$colKSum+$row['ColumnK'];$colJSum=$colJSum+$row['ColumnJ'];$colLSum=$colLSum+$row['ColumnL'];
        }
        
        $topPos-=15;
    }
    $topPos=$topPos - 20;
    $itemStyle2 = new Zend_Pdf_Style ();
    $itemStyle2->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
    $itemStyle2->setFont($font, 8);
    $page->setStyle($itemStyle2);
    $page->drawText("TOTALS", $leftPos + 10, $topPos - 10);
    $page->drawText($colASum, $leftPos + 60, $topPos - 10);
    $page->drawText($colBSum, $leftPos + 100, $topPos - 10);
    $page->drawText($colCSum, $leftPos + 160, $topPos - 10);
    $page->drawText($colDSum, $leftPos + 200, $topPos - 10);
    $page->drawText($colE1Sum, $leftPos + 245, $topPos - 10);
    $page->drawText($colE2Sum, $leftPos + 280, $topPos - 10);
    $page->drawText($colE3Sum, $leftPos + 315, $topPos - 10);
    $page->drawText($colFSum, $leftPos + 360, $topPos - 10);
    $page->drawText($colGSum, $leftPos + 450, $topPos - 10);
    $page->drawText($colHSum, $leftPos + 540, $topPos - 10);
    $page->drawText($colJSum, $leftPos + 600, $topPos - 10);
    $page->drawText($colKSum, $leftPos + 650, $topPos - 10);
    $page->drawText($colLSum, $leftPos + 750, $topPos - 10);
    
    $topPos=$topPos - 20;
    $itemStyle3 = new Zend_Pdf_Style ();
    $itemStyle3->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
    $itemStyle3->setFont($font, 10);
    $page->setStyle($itemStyle3);
    $page->drawText("TOTAL TAX (COL. L) Ksh. ".number_format($colLSum,2), $leftPos + 350, $topPos - 10);
    $page->drawText("TOTAL CHARGEABLE PAY (COL. H) Ksh. ".number_format($colHSum,2), $leftPos + 10, $topPos - 30);
    
    $itemStyle4 = new Zend_Pdf_Style ();
    $itemStyle4->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
    $itemStyle4->setFont($font, 8);
    $page->setStyle($itemStyle4);
    $page->drawText("To be completed by Employer at the end of the year", $leftPos + 10, $topPos - 20);

    $topPos = $topPos - 10;
    array_push($pdf->pages, $page);
    header('Content-type: application/pdf');
    echo $pdf->render();
}

?>
