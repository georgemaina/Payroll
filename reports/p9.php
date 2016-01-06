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
<table width="85%" border="0">
    <tr>
        <td colspan="3"><div align="center"><strong>KENYA REVENUE AUTHORITY<br />
                    INCOME TAX DEPARTMENT <br />
                    TAX DEDUCTION CARD YEAR 2010 ....................</strong><br />
            </div></td>
    </tr>
    <?php
    $sql = "SELECT p.`PID`, p.`FirstName`, p.`Surname`, p.`LastName`, p.`Pin_NO`,q.`CompanyName`, q.`Pin`  FROM proll_empregister p,proll_company q where pid='p001'";
    $result = $db->Execute($sql);
    while ($row = $result->FetchRow()) {
        $fname = $row[1];
        $sname = $row[2];
        $lname = $row[3];
        $pinNo = $row[4];
        $coName = $row[5];
        $coPin = $row[6];
    } ?>
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
<table width="85%" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="7%"><span class="style15">MONTH</span></td>
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
        <td width="6%"><span class="style15">Savings Plan<br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="7%"><span class="style15">Retirement Contribution &amp; Savings Pan<br />
                <br />
                Kshs.</span></td>
        <td width="6%"><span class="style15">Chargedable Pay <br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="9%"><span class="style15">Tax Charged<br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="5%"><span class="style15">Monthly Relief <br />
                <br />
                <br />
                Kshs.</span></td>
        <td width="7%"><span class="style15">Insurance Relief<br />
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
        <td valign="top">0</td>
        <td valign="top"><blockquote>
                <p><span class="style16">L</span></p>
            </blockquote></td>
    </tr>
    <tr>
        <td width="6%"><span class="style16">E1 30% of A</span></td>
        <td width="6%"><span class="style16">E2 Actual Contribution</span></td>
        <td width="6%"><span class="style16">E3 Legal Limit</span></td>
        <td valign="top">0</td>
        <td valign="top">0</td>
        <td colspan="2" valign="top"><span class="style16">Total <br />
                Ksh. 1162</span></td>
        <td valign="top">0</td>
    </tr>
    <tr>
        <td><span class="style5">JANUARY</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">FEBRUARY</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">MARCH</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">APRIL</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">MAY</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">JUNE</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">JULY</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>

    <tr>
        <?php
        $sql = "select pay_type,amount from proll_payments where pid='p001'";
        $result = $db->Execute($sql);
        while ($row = $result->FetchRow()) {
            $row[0] == 'Basic' ? $basic = $row[1] : '';
            $row[0] == 'NSSF' ? $nssf = $row[1] : '';
            $row[0] == 'NHIF' ? $nhif = $row[1] : '';
        }
        ?>
        <td><span class="style5">AUGUST</span></td>
        <td><?php echo $basic ?></td>
        <td><?php echo $nssf ?></td>
        <td><?php echo $nhif ?></td>
        <td><?php echo $basic + $nssf + $nhif ?></td>
        <td><?php echo 30 / 100 * $basic ?></td>
        <td><?php echo 10 / 100 * $basic ?></td>
        <td>20000</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>

    </tr>
    <tr>
        <td><span class="style5">SEPTEMBER</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">OCTOBER</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">NOVEMBER</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">DECEMBER</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
    <tr>
        <td><span class="style5">TOTALS</span></td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td colspan="2">0</td>
        <td>0</td>
    </tr>
</table>
<table width="85%" border="0">
    <tr>
        <td>To be completed by Employer at end of year<br />
            TOTAL CHARGEABLE PAY (COL.H) Kshs ...</td>
        <td>TOTAL TAX (COLL) Kshs. ........</td>
    </tr>
    <tr>
        <td>0</td>
        <td>NAME OF APPROVED INSTITUTION:</td>
    </tr>
    <tr>
        <td>0</td>
        <td>REGISTRATION NUMBER:</td>
    </tr>
    <tr>
      <td>0</td>
      <td>DATE OF REGISTRATION:</td>
    </tr>
    <tr>
        <td><strong><em>P.9A (HOSP)</em></strong></td>
        <td>0</td>
    </tr>
</table>



