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
        <td>&nbsp;</td>
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
        <td rowspan="2">&nbsp;</td>
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
        <td valign="top">&nbsp;</td>
        <td valign="top"><blockquote>
                <p><span class="style16">L</span></p>
            </blockquote></td>
    </tr>
    <tr>
        <td width="6%"><span class="style16">E1 30% of A</span></td>
        <td width="6%"><span class="style16">E2 Actual Contribution</span></td>
        <td width="6%"><span class="style16">E3 Legal Limit</span></td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="2" valign="top"><span class="style16">Total <br />
                Ksh. 1162</span></td>
        <td valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">JANUARY</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">FEBRUARY</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">MARCH</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">APRIL</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">MAY</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">JUNE</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
         <?php
        $sql = "select pay_type,amount from proll_payments where pid='p001' and payMonth='July'";
        $result = $db->Execute($sql);
        while ($row = $result->FetchRow()) {
            $row[0] == 'Basic' ? $Jbasic = $row[1] : '';
           $Jbenefits =  '';
            $JvalueQtrs = '';
        }
        $JE1=30 / 100 * $Jbasic ;
        $Jactualcont=10 / 100 * $Jbasic;
        $Jamountdeposited=4000;
        $JsavingPlan=$Jactualcont+$Jamountdeposited;
        $JlegalLimit=20000;
        $Jrelief=1162;
        $JtotalGross=$Jbasic + $Jbenefits + $JvalueQtrs;

        ?>
        <td><span class="style5">JULY</span></td>
        <td><?php echo $Jbasic ?></td><!-- A basic Pay  -->
        <td><?php echo $Jbenefits ?></td><!-- B Benefits non cash  -->
        <td><?php echo $JvalueQtrs ?></td><!-- C Value of Quarters -->
        <td><?php echo $JtotalGross ?></td><!-- D Total Gross Pay -->
        <td><?php echo $JE1 ?></td><!-- E Defined Contribution Retirement-->
        <td><?php echo $Jactualcont ?></td><!-- E -->
        <td><?php echo $JlegalLimit ?></td><!-- E legal limit-->
        <td><?php echo $Jamountdeposited ?></td><!-- F Amount Deposited-->
        <td><?php echo $JsavingPlan?></td><!-- G Retirement contribution -->
        <td><?php echo $JtotalGross - $JsavingPlan ?></td><!-- Chargeable Pay-->
        <td><?php
            $sql2='select lower_limit,upper_limit,`value` from proll_rates where rate_name like "income%"';
            $result2=$db->Execute($sql2);
            while($row=$result2->FetchRow()) {
                $sql3='select pid,basicpay,CONCAT( b.surname," ", b.firstname ," ", b.LastName) aS empnames,date(now()),nssf from proll_empregister b where pid="P001"';
                $result3=$db->Execute($sql3);
                while($row3=$result3->FetchRow()) {
                    if($row3[1]>$row[0] && $row3[1]<$row[1]) {
                        $Jtax=$row[2]/100*($row3[1]-$row3[4]);
                        //$sql4="update proll_payments set amount='$tax',catID='Deduct' where pay_type='paye' and pid='$row3[0]'";
                        //$db->Execujte($sql4);
                    }
                }
            }
            echo $Jtax;
            ?></td><!-- Tax Charged -->
        <td colspan="2"><?php echo $Jrelief ?></td><!-- Monthly Relief --><!-- Insurance Relief -->
        <td><?php echo $Jtax-$Jrelief ?></td><!-- PAYE tax -->
    </tr>

    <tr>
        <?php
        $sql = "select pay_type,amount from proll_payments where pid='p001' and payMonth='August'";
        $result = $db->Execute($sql);
        while ($row = $result->FetchRow()) {
            $row[0] == 'Basic' ? $basic = $row[1] : '';
            $benefits =  '';
            $valueQtrs =  '';
        }
        $E1=30 / 100 * $basic ;
        $actualcont=10 / 100 * $basic;
        $amountdeposited=4000;
        $savingPlan=$actualcont+$amountdeposited;
        $legalLimit=20000;
        $relief=1162;
        $totalGross=$basic + $benefits + $valueQtrs;

        ?>
        <td><span class="style5">AUGUST</span></td>
        <td><?php echo $basic ?></td><!-- A basic Pay  -->
        <td><?php echo $benefits ?></td><!-- B Benefits non cash  -->
        <td><?php echo $valueQtrs ?></td><!-- C Value of Quarters -->
        <td><?php echo $totalGross ?></td><!-- D Total Gross Pay -->
        <td><?php echo $E1 ?></td><!-- E Defined Contribution Retirement-->
        <td><?php echo $actualcont ?></td><!-- E -->
        <td><?php echo $legalLimit ?></td><!-- E legal limit-->
        <td><?php echo $amountdeposited ?></td><!-- F Amount Deposited-->
        <td><?php echo $savingPlan?></td><!-- G Retirement contribution -->
        <td><?php echo $totalGross - $savingPlan ?></td><!-- Chargeable Pay-->
        <td><?php
            $sql2='select lower_limit,upper_limit,`value` from proll_rates where rate_name like "income%"';
            $result2=$db->Execute($sql2);
            while($row=$result2->FetchRow()) {
                $sql3='select pid,basicpay,CONCAT( b.surname," ", b.firstname ," ", b.LastName) aS empnames,date(now()),nssf from proll_empregister b where pid="P001"';
                $result3=$db->Execute($sql3);
                while($row3=$result3->FetchRow()) {
                    if($row3[1]>$row[0] && $row3[1]<$row[1]) {
                        $tax=$row[2]/100*($row3[1]-$row3[4]);
                        //$sql4="update proll_payments set amount='$tax',catID='Deduct' where pay_type='paye' and pid='$row3[0]'";
                        //$db->Execute($sql4);
                    }
                }
            }
            echo $tax;
            ?></td><!-- Tax Charged -->
        <td colspan="2"><?php echo $relief ?></td><!-- Monthly Relief --><!-- Insurance Relief -->
        <td><?php echo $tax-$relief ?></td><!-- PAYE tax -->

    </tr>
    <tr>
        <?php
        $sql = "select pay_type,amount from proll_payments where pid='p001' and payMonth='September'";
        $result = $db->Execute($sql);
        while ($row = $result->FetchRow()) {
            $row[0] == 'Basic' ? $Sbasic = $row[1] : '';
            $Sbenefits = '';
            $SvalueQtrs = '';
        }
        $SE1=30 / 100 * $Sbasic ;
        $Sactualcont=10 / 100 * $Sbasic;
        $Samountdeposited=4000;
        $SsavingPlan=$Sactualcont+$Samountdeposited;
        $SlegalLimit=20000;
        $Srelief=1162;
        $StotalGross=$Sbasic + $Sbenefits + $SvalueQtrs;

        ?>
        <td><span class="style5">SEPTEMBER</span></td>
        <td><?php echo $Sbasic ?></td><!-- A basic Pay  -->
        <td><?php echo $Sbenefits ?></td><!-- B Benefits non cash  -->
        <td><?php echo $SvalueQtrs ?></td><!-- C Value of Quarters -->
        <td><?php echo $StotalGross ?></td><!-- D Total Gross Pay -->
        <td><?php echo $SE1 ?></td><!-- E Defined Contribution Retirement-->
        <td><?php echo $Sactualcont ?></td><!-- E -->
        <td><?php echo $SlegalLimit ?></td><!-- E legal limit-->
        <td><?php echo $Samountdeposited ?></td><!-- F Amount Deposited-->
        <td><?php echo $SsavingPlan?></td><!-- G Retirement contribution -->
        <td><?php echo $StotalGross - $SsavingPlan ?></td><!-- Chargeable Pay-->
        <td><?php
            $sql2='select lower_limit,upper_limit,`value` from proll_rates where rate_name like "income%"';
            $result2=$db->Execute($sql2);
            while($row=$result2->FetchRow()) {
                $sql3='select pid,basicpay,CONCAT( b.surname," ", b.firstname ," ", b.LastName) aS empnames,date(now()),nssf from proll_empregister b where pid="P001"';
                $result3=$db->Execute($sql3);
                while($row3=$result3->FetchRow()) {
                    if($row3[1]>$row[0] && $row3[1]<$row[1]) {
                        $Stax=$row[2]/100*($row3[1]-$row3[4]);
                        //$sql4="update proll_payments set amount='$tax',catID='Deduct' where pay_type='paye' and pid='$row3[0]'";
                        //$db->Execute($sql4);
                    }
                }
            }
            echo $Stax;
            ?></td><!-- Tax Charged -->
        <td colspan="2"><?php echo $Srelief ?></td><!-- Monthly Relief --><!-- Insurance Relief -->
        <td><?php echo $Stax-$Srelief ?></td><!-- PAYE tax -->

    </tr>
    <tr>
        <td><span class="style5">OCTOBER</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">NOVEMBER</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">DECEMBER</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span class="style5">TOTALS</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<table width="85%" border="0">
    <tr>
        <td>To be completed by Employer at end of year<br />
            TOTAL CHARGEABLE PAY (COL.H) Kshs ...</td>
        <td>TOTAL TAX (COLL) Kshs. ........</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>NAME OF APPROVED INSTITUTION:</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>REGISTRATION NUMBER:</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>DATE OF REGISTRATION:</td>
    </tr>
    <tr>
        <td><strong><em>P.9A (HOSP)</em></strong></td>
        <td>&nbsp;</td>
    </tr>
</table>



