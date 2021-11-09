<?php
error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require ('roots.php');
require ($root_path . 'include/inc_environment_global.php');
require 'PHPMailerAutoload.php';

require ('roots.php');
require_once 'Zend/Pdf.php';

$paymonth = $_REQUEST['slipMnth'];
$spid = $_REQUEST['pid'];
$spid2 = $_REQUEST['pid2'];
$period=date('Y');

$dept = $_REQUEST['deptID'];
$branch = $_REQUEST['branch'];

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


$sql = "SELECT distinct p.Pid, CONCAT(p.surname ,' ', p.firstname ,' ', p.lastname) AS empnames,
    p.EmpBranch,d.deptName,p.basicpay,c.payMonth,p.pin_no,p.id,c.payDate,p.ID_No FROM proll_empRegister p
    LEFT JOIN proll_payments c on p.PID=c.Pid left  join proll_departments d on p.department=d.ID
    where c.payMonth= '$paymonth' and period='$period'";
//echo $sql;

$result2 = $db->Execute($sql);
$numRows = $result2->RecordCount();

while ($row = $result2->FetchRow()) {
    $pdf = new Zend_Pdf ();
    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
        $coName = strtoupper($coRow['CompanyName']);
        $pid = $row['Pid'];
        $empnames = $row['empnames'];
        $dept = $row['deptName'];
        $branch = $row['EmpBranch'];
        $pn_no = $row['pin_no'];
        $id = $row['id'];
        $idNo=$row['ID_No'];
        $payDates = date_create($row['payDate']);
        $payDate = date_format($payDates, "Y");

        createPaySlips($paymonth, $pid, $idNo, $empnames, $dept, $branch,$payDate,$period, $pdf, $page);
       
        // header('Content-type: application/pdf');
       
}


function createPaySlips($paymonth, $pid, $idNo, $empnames, $dept, $branch,$payDate,$period, $pdf, $page) {
    global $db;
    $debug=false;

    $pageHeight = $page->getHeight();
    $width = $page->getWidth();
    $topPos = $pageHeight - 10;
    $leftPos = -8;
       $config_type = 'main_info_%';
    $sql1 = 'SELECT * FROM proll_company';
    $result1 = $db->Execute($sql1);
    $coRow = $result1->FetchRow();
    $coName = strtoupper($coRow['CompanyName']);

        $pdfBase = new Library_Pdf_Base();
        $lineStyle1 = new Zend_Pdf_Style ();
        $lineStyle1->setFillColor(new Zend_Pdf_Color_RGB(0.4, 0.2, 0.12));
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $lineStyle1->setFont($font, 10);
        $page->setStyle($lineStyle1);
        $starLine = '***************************************************************';
        $page->drawText($starLine, $leftPos + 36, $topPos - 22);

        $headingStyle1 = new Zend_Pdf_Style ();
        $headingStyle1->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
        $headingStyle1->setLineDashingPattern(array(1), 0.6);
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER_BOLD);
        $headingStyle1->setFont($font, 12);
        $page->setStyle($headingStyle1);

        $pdfBase->drawText($page, $coName, $leftPos + 36, $topPos - 28, TEXT_ALIGN_LEFT);
        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - 38);

        $normalStyle = new Zend_Pdf_Style ();
        $normalStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $normalStyle->setFont($font, 10);
        $page->setStyle($normalStyle);

        $page->drawText("Payroll No: ", $leftPos + 36, $topPos - 50);
        $page->drawText($pid, $leftPos + 100, $topPos - 50);
        $topPos=$topPos-10;
        $page->drawText("Names:" , $leftPos + 36, $topPos - 50);
        $page->drawText( $empnames, $leftPos + 100, $topPos - 50);
        $page->drawText("Period: ", $leftPos + 36, $topPos - 60);
        $page->drawText($paymonth, $leftPos + 100, $topPos - 60);
        $page->drawText($payDate, $leftPos + 150, $topPos - 60);
        $page->drawText("Branch :", $leftPos + 36, $topPos - 70);
        $page->drawText($branch, $leftPos + 100, $topPos - 70);
        $page->drawText("Department :", $leftPos + 36, $topPos - 80);
        $page->drawText($dept, $leftPos + 100, $topPos - 80);
        $page->drawText("Pin_No :", $leftPos + 36, $topPos - 90);
        $page->drawText($pid, $leftPos + 100, $topPos - 90);
        $page->drawText("ID NO :", $leftPos + 180, $topPos - 90);
        $page->drawText($idNo, $leftPos + 220, $topPos - 90);

        $headingStyle = new Zend_Pdf_Style ();
        $headingStyle->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER_BOLD);
        $headingStyle->setFont($font, 11);
        $page->setStyle($headingStyle);


        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - 105);

        $page->setStyle($headingStyle);
        $page->drawText('Earnings :-', $leftPos + 36, $topPos - 110);
        $page->drawText(' Amount', $leftPos + 170, $topPos - 110);
        $page->drawText(' Bal', $leftPos + 240, $topPos - 110);

        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - 120);



        $sql = "select a.Pid, a.emp_names,c.id,a.pay_type,a.amount,a.Notes FROM proll_payments a
            LEFT JOIN proll_paytypes b on a.pay_type=b.PayType
            LEFT JOIN proll_paycategory c on b.CatID=c.ID
            where a.catid in('Earnings','Benefits') and period='$period' and amount>0 and pid='$pid' and a.paymonth='$paymonth' order by b.ID asc";
        //echo $sql;
        $result = $db->Execute($sql);
        $numRows = $result->RecordCount();
        $currpos = 125;


        $page->setStyle($normalStyle);

        while ($row = $result->FetchRow()) {
            $page->drawText('* ' . ucwords(strtolower($row[3])), $leftPos + 36, $topPos - $currpos);
        //            $page->drawText(number_format($row[4], 2), $leftPos + 180, $topPos - $currpos);
            $pdfBase->drawText($page, number_format($row[4], 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
            $currpos = $currpos + 10;
        }


        $sql = 'select pid,sum(amount) as grosspay from proll_payments where catID IN("Earnings","Benefits") 
            and pid="' . $pid . '" and paymonth="' . $paymonth . '" AND pay_type<>"PENSION"  and period="'.$period.'"';
        $result = $db->Execute($sql);
        $numRows = $result->RecordCount();
        $sumRows = $result->FetchRow();

        //Gross Pay
        $page->drawText("* Gross Pay", $leftPos + 36, $topPos - $currpos);
        $pdfBase->drawText($page, number_format($sumRows[1], 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        $grossPay=$sumRows[1];
        //        $page->drawText(number_format($sumRows[1], 2), $leftPos + 180, $topPos - $currpos);
        $currpos = $currpos + 20;
        //Tax Calculation
        $page->setStyle($headingStyle);
        $page->drawText('Tax Details :-', $leftPos + 36, $topPos - $currpos);
        $currpos = $currpos + 10;
        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - $currpos);
        $currpos = $currpos + 5;


        $sql = "select a.Pid, a.emp_names,c.id,a.pay_type,a.amount,a.Notes FROM proll_payments a
                        LEFT JOIN proll_paytypes b on a.pay_type=b.PayType
                        LEFT JOIN proll_paycategory c on b.CatID=c.ID
                        where c.id='Deductions' and period='$period' and pid='$pid' and a.paymonth='$paymonth'";
        $result = $db->Execute($sql);
        $numRows = $result->RecordCount();

        $page->setStyle($normalStyle);

        $currpos = $currpos + 20;

        $sql = "SELECT a.Pid, a.emp_names,a.pay_type,a.amount,a.Notes FROM proll_payments a
     WHERE  pid='$pid' AND a.paymonth='$paymonth'and period='$period' AND pay_type IN('N.S.S.F','Pension','N.H.I.F ')";
        $result = $db->Execute($sql);
        $numRows = $result->RecordCount();
        while ($numRows = $result->FetchRow()) {
            if ($numRows[2]== 'N.S.S.F') {
                $lable = 'N.S.S.F';
            } else {
                $lable = $numRows[2];
            }
            $page->drawText('* ' . $lable, $leftPos + 36, $topPos - $currpos+15);

        //            $page->drawText(number_format($numRows[3], 2), $leftPos + 180, $topPos - $currpos);
            $pdfBase->drawText($page, number_format($numRows[3], 2), $leftPos + 220, $topPos - $currpos  +15, $leftPos + 220, right);
            if($numRows[2]=='N.S.S.F'){
                $nssf=$numRows[3];
            }
            if($numRows[2]=='PENSION'){ 
                $pension=$numRows[3];
            }
            $currpos = $currpos + 10;
        }

        $pyesql = "select pid,sum(amount) as grosspay from proll_payments where catID IN('Earnings','Benefits')
         and pid='$pid' and paymonth='$paymonth' AND pay_type NOT IN ('PENSION') and period='$period'";
        $pyeresult = $db->Execute($pyesql);
        $pyerow = $pyeresult->FetchRow();
        $page->drawText("* Taxable Pay", $leftPos + 36, $topPos - $currpos+10);
        //        $page->drawText(number_format($pyerow[1], 2), $leftPos + 180, $topPos - $currpos);

        $pdfBase->drawText($page, number_format($pyerow[1]-$nssf-$pension, 2), $leftPos + 220, $topPos - $currpos+10, $leftPos + 220, right);

        $currpos = $currpos + 10;

        $isql = "SELECT amount,t.`ReliefPercentage` FROM proll_payments p LEFT JOIN proll_paytypes t
               ON P.`pay_type`=T.`PayType`
               WHERE pid='$pid' AND paymonth='$paymonth' and period='$period' AND T.`TaxRelief`='on'";
        $iresult = $db->Execute($isql);
        $icount = $iresult->RecordCount();
        $irow = $iresult->FetchRow();
        $insuranceRelief = $irow[0];
        
        $pyesql1 = "select amount from proll_payments where pid='$pid' and period='$period' and pay_type='paye'
        and paymonth='$paymonth'";

        //    echo $pyesql1;
        $pyeresult1 = $db->Execute($pyesql1);
        $pyerow1 = $pyeresult1->FetchRow();
        $txCharged = $pyerow1[0];
        $page->drawText('* Tax Charged', $leftPos + 36, $topPos - $currpos);
        $pdfBase->drawText($page, number_format($txCharged+1162, 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        //        $page->drawText(number_format($txCharged, 2), $leftPos + 180, $topPos - $currpos);

        $currpos = $currpos + 10;
        $pyesql2 = "select amount from proll_payments where pid='$pid' and pay_type='Personal Relief' 
                      and paymonth='$paymonth' and period='$period' ";

        $pyeresult2 = $db->Execute($pyesql2);
        $pyerow2 = $pyeresult2->FetchRow();
        $txRelief = $pyerow2[0];

        $page->drawText('* Tax Relief', $leftPos + 36, $topPos - $currpos);
        $pdfBase->drawText($page, number_format($txRelief, 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        
        if($icount>0){
            $currpos = $currpos + 10;
            $page->drawText('* Insurance Relief', $leftPos + 36, $topPos - $currpos);
            $pdfBase->drawText($page, number_format($insuranceRelief, 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        }
        //        $page->drawText(number_format($txRelief, 2), $leftPos + 180, $topPos - $currpos);
        $currpos = $currpos + 10;
        $page->drawText('* Tax Deducted', $leftPos + 36, $topPos - $currpos);
        $pdfBase->drawText($page, number_format($txCharged, 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        //        $page->drawText(number_format($txCharged - $txRelief, 2), $leftPos + 180, $topPos - $currpos);

        $currpos = $currpos + 10;
        $currpos = $currpos + 10;

        //enter salary deductions
        $page->setStyle($headingStyle);
        $page->drawText('Deductions :-', $leftPos + 36, $topPos - $currpos);
        $currpos = $currpos + 10;
        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - $currpos);

        $page->setStyle($normalStyle);
        $currpos = $currpos + 5;

        $sql = "select a.Pid, a.emp_names,c.id,a.pay_type,a.amount,a.Notes,a.balance FROM proll_payments a
                inner join proll_paytypes b on a.pay_type=b.PayType
                inner join proll_paycategory c on b.CatID=c.ID
                where a.catid='Deductions' and amount>0 and pid='$pid' and a.paymonth='$paymonth' and period='$period' ";
        $result = $db->Execute($sql);
        $numRows = $result->RecordCount();

        while ($row = $result->FetchRow()) {
            $balance = $row[6] ? $row[6] : "0";
            if (ucwords(strtolower($row[3])) == 'Nssf') {
                $lable = 'N.S.S.F';
            } else if (ucwords(strtolower($row[3])) == 'N.h.i.f') {
                $lable = 'N.H.I.F';
            } else {
                $lable = ucwords(strtolower($row[3]));
            }

            $page->drawText('* ' . $lable, $leftPos + 36, $topPos - $currpos);
            $pdfBase->drawText($page, number_format($row[4], 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        //            $page->drawText(number_format($row[4], 2), $leftPos + 180, $topPos - $currpos);
            if (empty($balance) || $balance == 0) {
                $balance = '';
            } else {
                $balance = number_format($balance, 2);
            }
            $pdfBase->drawText($page, $balance, $leftPos + 280, $topPos - $currpos, $leftPos + 280, right);
        //            $page->drawText($balance, $leftPos + 260, $topPos - $currpos);
            $currpos = $currpos + 10;
        }

        $sql3 = "SELECT pid,catID,Pay_type,Amount,Balance FROM proll_payments
                 WHERE pid='$pid' AND 
                 pay_type IN('GRATUITY','NSSF') and paymonth='$paymonth' and period='$period'";
        if ($debug) echo $sql3;

        $request3 = $db->Execute($sql3);
        $numRows3 = $request3->RecordCount();
        $count3 = 0;
        $currpos = $currpos + 10;
        $page->setStyle($headingStyle);
        $page->drawText('Information :-', $leftPos + 36, $topPos - $currpos);
        $currpos = $currpos + 10;
        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - $currpos);
        $currpos = $currpos + 10;
           $page->setStyle($normalStyle);
        while ($numRows3 = $request3->FetchRow()) {
            if (ucwords(strtolower($numRows3['Pay_type'])) == 'N.s.s.f') {
                $lable = 'N.S.S.F';
            } else {
                $lable = ucwords(strtolower($numRows3['Pay_type']));
            }
            $page->drawText('* ' .$lable, $leftPos + 36, $topPos - $currpos);
            $pdfBase->drawText($page, number_format($numRows3['Amount'],2), $leftPos + 220, $topPos - $currpos, $leftPos + 280, right);

            $currpos = $currpos + 10;
        }
        
               $dsqlr = "SELECT * FROM proll_rates";
        $requestr = $db->Execute($dsqlr);
            while($numRowsr = $requestr->FetchRow()){
                if($numRowsr['RateName']=='NSSF Company'){
                    $nssfCo = $numRowsr['Value'];
                     $page->drawText('* ' .$numRowsr['RateName'], $leftPos + 36, $topPos - $currpos);
                    $pdfBase->drawText($page, number_format($nssfCo,2), $leftPos + 220, $topPos - $currpos, $leftPos + 280, right);
                    $currpos=$currpos+10;
        //                    $page->drawText('* PENSION', $leftPos + 36, $topPos - $currpos);
        //                    $pdfBase->drawText($page, number_format($pension,2), $leftPos + 220, $topPos - $currpos, $leftPos + 280, right);
                }
            }
           
        //        $page->drawText(nu
        $currpos = $currpos + 20;
        $page->setStyle($headingStyle);
        $page->drawText('Summary :-', $leftPos + 36, $topPos - $currpos);
        $currpos = $currpos + 10;
        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - $currpos);

        $page->setStyle($normalStyle);


        $currpos = $currpos + 5;
        $sql = "select pid,sum(amount) as deductions from proll_payments where catID IN('Deductions') and pid='$pid' and
        paymonth='$paymonth' AND pay_type NOT IN ('paye','Personal Relief')  and period='$period'";
       // echo $sql;

        $result = $db->Execute($sql);
        $numRows = $result->RecordCount();
        $diffRows = $result->FetchRow();
        $tx = intval($txCharged );
        $deductions = intval($diffRows[1] + $tx);
        //net Pay
        $page->drawText("* Less Deductions", $leftPos + 36, $topPos - $currpos);
        $pdfBase->drawText($page, number_format($deductions, 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        //        $page->drawText(number_format($deductions, 2), $leftPos + 180, $topPos - $currpos);
        $currpos = $currpos + 10;
        $page->drawText("* Net Pay", $leftPos + 36, $topPos - $currpos);

        //        $page->drawText(number_format(($sumRows[1] - $deductions), 2), $leftPos + 180, $topPos - $currpos);
        $pdfBase->drawText($page, number_format(($grossPay - $deductions), 2), $leftPos + 220, $topPos - $currpos, $leftPos + 220, right);
        $currpos = $currpos + 10;
        $currpos = $currpos + 10;

        $sql = 'select BankID,BranchId,Account_no from proll_empregister where pid="' . $pid . '"';
        $result = $db->Execute($sql);
        $AcRows = $result->FetchRow();
        $currpos = $currpos + 10;

        $page->setStyle($headingStyle);
        $page->drawText("Payment Details :-", $leftPos + 36, $topPos - $currpos);
        $currpos = $currpos + 10;

        $page->setStyle($lineStyle1);
        $page->drawText($starLine, $leftPos + 36, $topPos - $currpos);
        //        $page->drawText("Bank", $leftPos + 36, $topPos - $currpos);

        $currpos = $currpos + 10;
        //        $page->drawText(":", $leftPos + 36, $topPos - $currpos);
        $page->drawText($AcRows[0], $leftPos + 36, $topPos - $currpos);

        $currpos = $currpos + 10;
        //        $page->drawText(":", 100, $topPos - $currpos);
        $page->drawText($AcRows[1], $leftPos + 36, $topPos - $currpos);

        $currpos = $currpos + 10;
        //        $page->drawText(":", 130, $topPos - $currpos);
        $page->drawText($AcRows[2], $leftPos + 36, $topPos - $currpos);

        $currpos = $currpos + 50;
        $page->drawText("Sign ______________________________", $leftPos + 36, $topPos - $currpos);

     $topPos = $topPos - 10;
     array_push($pdf->pages, $page);
     $pdf->save(dirname(__FILE__) . "/emails/".$pid.".pdf");
    //  echo $pdf->render();
     unset($pdf);

}


$mail = new PHPMailer;

$body ="Find attached your payslip "; // file_get_contents('contents.html');

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->Username = 'george@chak.or.ke';
$mail->Password = '@@Kibe2021**';
$mail->setFrom('george@chak.or.ke', 'Human Resource');
//$mail->addReplyTo('list@example.com', 'List manager');
$mail->Subject = "Payslip for the month of ".$paymonth ." ".$period;
$mail->msgHTML($body);

$sqlm="SELECT pid,CONCAT(firstname,' ',lastname,' ',surname) AS empNames,email,`ID_No` FROM proll_empregister";
$result=$db->Execute($sqlm);

foreach ($result as $row) { //This iterator syntax only works in PHP 5.4+
    $mail->addAddress($row['email'], $row['empNames']);
    
    $file_to_attach = 'emails/'.$row['pid'].'.pdf';

    $mail->AddAttachment( $file_to_attach , $row['empNames'].'.pdf' );

    if (!$mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br />';
        break; //Abandon sending
    } else {
        echo "Message sent to :" . $row['empNames'] . ' (' . str_replace("@", "&#64;", $row['email']) . ')<br />';
        //Mark it as sent in the DB
    }
    // Clear all addresses and attachments for next loop
    $mail->clearAddresses();
    $mail->clearAttachments();
}


