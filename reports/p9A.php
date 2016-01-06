<?php
/* Care2x Payroll deployment 01-01-2010
 * GNU General Public License
 * Copyright 2010 George Maina
 * georgemainake@gmail.com
 *
*/
error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require('roots.php');
require($root_path . 'include/inc_environment_global.php');
?>

<style type="text/css">
    <!--
    .style5 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
    .style15 {font-family: "Times New Roman", Times, serif; font-size: 13px;}
    .style16 {font-size: 12px}
    -->
</style>
<?php
$pid=$_POST['schParam1'];
    $sql = "SELECT p.`PID`, p.`FirstName`, p.`Surname`, p.`LastName`, p.`Pin_NO`,q.`CompanyName`, q.`Pin`  
        FROM proll_empregister p,proll_company q where pid='$pid'";
    $result = $db->Execute($sql);
    while ($row = $result->FetchRow()) {
        $pid = $row[0];
        $fname = $row[1];
        $sname = $row[2];
        $lname = $row[3];
        $pinNo = $row[4];
        $coName = $row[5];
        $coPin = $row[6];
    } 
    $months=array('JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER');
    createHeader($pid,$fname,$sname,$lname,$pinNo,$coName,$coPin);
    createTitles();

    for($i=0;$i<12;$i++){
        createRows($pid,$months[$i]);
    }

    createFooter();
    
    function createHeader($pid,$fname,$sname,$lname,$pinNo,$coName,$coPin){
       ?> <table width="85%" border="0">
    <tr>
        <td colspan="3"><div align="center"><strong>KENYA REVENUE AUTHORITY<br />
                    INCOME TAX DEPARTMENT <br />
                    TAX DEDUCTION CARD YEAR 2010 ....................</strong><br />
            </div></td>
    </tr>
    
    <tr>
        <td width="13%">Employer's Name:</td>
        <td width="56%" align="left"><?php echo $coName ?></td>
        <td width="31%">Employers Pin:
            <input type="text" name="employeePin" id="employeePin" value="<?php echo $pinNo ?>"/>
        </td>
    </tr>
    <tr>
        <td>Employee's Main Name:</td>
        <td align="left"><?php echo $fname . ' ' . $lname ?></td>
        <td>0</td>
    </tr>
    <tr>
        <td>Employee's Other Names:</td>
        <td align="left"><?php echo $sname ?></td>
        <td>Employees Pin:
            <input type="text" name="employerPin2" id="employerPin2" value="<?php echo $coPin ?>"/></td>
    </tr>
</table>
            <?php
    }
  


function createTitles(){
  ?>
<table width="85%" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="10%"><span class="style15">MONTH</span></td>
        <td width="5%"><span class="style15">Basic Pay<br />
                <br />
                <br />
                Kshs.<br />
            </span></td>
        <td width="6%"><span class="style15">Benefits - Non-Cash<br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="7%"><span class="style15">Value of Quarters<br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="8%"><span class="style15">Total Gross Pay A+B+C<br />
                <br />
                <br />
                Kshs.</span></td>
        <td colspan="3"><span class="style15">Defined Contribution Retirement Scheme<br />
                <br />
                Kshs.</span></td>
        <td width="6%"><span class="style15">OWNER OCCUPIED INTEREST ksh.<br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="7%"><span class="style15">RETIREMENT CONTRIBUTION & OWNER-OCCUPIED INTEREST<br />
                <br />
                Kshs.</span></td>
        <td width="6%"><span class="style15">COLUMN (D-G) <br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="9%"><span class="style15">TAX (ON) (H)<br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="5%"><span class="style15">MONTH RELIEF<br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="9%"><span class="style15">P.A.Y.E Tax<br />
                <br />
                <br />
                Kshs.</span></td>
    </tr>
    <tr>
        <td rowspan="2">0</td>
        <td rowspan="2"><blockquote>
                <p><span class="style16"> A</span></p>
            </blockquote></td>
        <td rowspan="2"><blockquote>
                <p><span class="style16">B</span></p>
            </blockquote></td>
        <td rowspan="2"><blockquote>
                <p><span class="style16">C</span></p>
            </blockquote></td>
        <td rowspan="2"><blockquote>
                <p><span class="style16">D</span></p>
            </blockquote></td>
        <td colspan="3"><div align="center">E</div></td>
        <td rowspan="2" valign="top"><span class="style16"> F<br />
                <br />
                Amount Deposited</span></td>
        <td rowspan="2" valign="top"><span class="style16">G<br />
                <br />
                <br />
                The Lowest of E added to F</span></td>
        <td valign="top"><blockquote>
                <p><span class="style16">H</span></p>
            </blockquote></td>
        <td valign="top"><blockquote>
                <p><span class="style16">J</span></p>
            </blockquote></td>
        <td valign="top"><blockquote>
                <p><span class="style16">K<br />
                        1162</span></p>
            </blockquote></td>
        <td valign="top"><blockquote>
                <p><span class="style16">L</span></p>
            </blockquote></td>
    </tr>
    <tr>
        <td width="6%"><span class="style16">E1 30% of A</span></td>
        <td width="6%"><span class="style16">E2 Actual Contribution</span></td>
        <td width="6%"><span class="style16">E3 Legal Limit</span></td>
        <td valign="top">0</td>
        <td valign="top"><span class="style16">Total <br />
                Ksh. 1162</span></td>
        <td valign="top">0</td>
    </tr>
<?php
}

function createRows($pid,$payMonth){
    global $db;
    $sql="select pay_type,amount from proll_payments where pid='".$pid."' AND payMonth like '$payMonth%'";
     $result = $db->Execute($sql);
    while ($row = $result->FetchRow()) {
        $amounts[]=$row[1];
        $ptype[]=$row[0];
    }
   $A=$amounts[0]?$amounts[0]:"0";
   $B=0;
   $C=0;
   $D=intval($A+$B+$C);
   $e1=intval(0.3*$A);
   $e2=0;
   $e3=2000;
   $F=0;
   $G=min($e1,$e2,$e3);
   $H=$D-$G;
   for($i=0;$i<sizeof($ptype);$i++){
       if($ptype[$i]="PAYE"){
           $J=$amounts[$i]?$amounts[$i]:0;
       }
       if($ptype[$i]=="Relief"){
            $K=$amounts[$i];
       }else{
           $K=$amounts[$i]=1162;
       }
   }

   $L=$J-$K;
   
//echo $sql;
echo "
   <tr>
        <td width='6%'>$payMonth</td>
        <td width='6%'>$A</td>
        <td width='6%'>$B</td>
        <td width='6%'>$C</td>
        <td width='6%'>$D</td>
        <td width='4%'>$e1</td>
        <td width='4%'>$e2</td>
        <td width='4%'>$e3</td>
        <td width='6%'>$F</td>
        <td width='6%'>$G</td>
        <td width='6%'>$H</td>
        <td width='7%'>$J</td>
        <td width='7%'>$K</td>
        <td width='7%'>$L</td>
    </tr>
";

}

function createFooter(){
    ?>
    <table width="85%" border="1">
    <tr>
        <td>To be completed by Employer at end of year<br />
            TOTAL CHARGEABLE PAY (COL.H) Kshs </td>
        <td>TOTAL TAX (COLL) Kshs. </td>
    </tr>
    <tr>
        <td width="50%">
        IMPORTANT    <br>
        1. Use P9A (a) For all liable employees and where director/employee received<br>
                &nbsp;&nbsp;Benefits in addition to cash emoluments.<br>
                &nbsp;&nbsp;(b) Where an employee is eligible to deduction on owner occupier interest.<br>
2. (a) Deductible interest in respect of any month must not exceed Kshs. 12,500/=<br>
(See back of this card for further information required by the Department).
        </td>
        <td width="50%">
            b) Attach
            (i) Photostat copy of interest certificate and statement of account <br>&nbsp;&nbsp;from the
Financial Institution.<br>
&nbsp;&nbsp;(ii) The DECLARATION duly signed by the employee.<br>
NAMES OF FINANCIAL INSTITUTION ADVANCING MORTGAGE LOAN
______________________________________________<br>
L R NO. OF OWNER OCCUPIED PROPERTY: _________________<br>
DATE OF OCCUPATION OF HOUSE: _______________________
        </td>
    </tr>
</table>
<?php
}

?>
