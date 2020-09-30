<?php

error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
//require_once('roots.php');
require ('include/inc_environment_global.php');

getAmount(1076);

function getAmount($pid) {
    global $db;

    $sql2 = 'select lower_limit,upper_limit,`value`,`rate` from proll_rates where RateName like "income%"';
    $result2 = $db->Execute($sql2);
    while ($row = $result2->FetchRow()) {
        $data[1][] = $row[0]; //lower limit
        $data[2][] = $row[1]; //upperlimit
        $data[3][] = $row[2]; //value
        $data[4][] = $row[3]; //rate
    }

    $sql3 = 'select lower_limit,upper_limit,`value`,`rate` from proll_rates where RateName like "Personal R%"';
    $result3 = $db->Execute($sql3);
    $row3 = $result3->FetchRow();
    $relief = $row3[0];

    $sql = 'Select pid,amount from proll_emp_payments where PayType="016" and pid="' . $pid . '"';
    $result1 = $db->Execute($sql);
    $nsRow = $result1->FetchRow();
    $nssf = $nsRow[1];

    $sql = 'Select pid,amount from proll_emp_payments where PayType="014" and pid="' . $pid . '"';
    $result1 = $db->Execute($sql);
    $nsRow = $result1->FetchRow();
    $pension = $nsRow[1];

    $sql = "SELECT p.pid,p.payname,t.`ReliefPercentage`,p.amount FROM proll_emp_payments p LEFT JOIN proll_paytypes t ON p.`PayType`=t.`ID` WHERE pid='$pid'
                AND t.TaxRelief='ON'";
    $result = $db->Execute($sql);
    $row = $result->FetchRow();
    $insuranceRelief = $row[amount];


    $sql = "Select pid,sum(amount) from proll_emp_payments where payname in (1,2) and pid='$pid'
        AND PayType IN (SELECT ID FROM proll_paytypes WHERE taxDeduct='ON')";
    $result = $db->Execute($sql);
	$finaltax =0; $tax =0; $k =0;$tax2 =0;$tax3 =0;$tax4 =0;
    while ($row = $result->FetchRow()) {
		echo "Nssf Amount ".$nssf."<br>";
		echo "Pension Amount ".$pension."<br>";
		echo "Personal Relief ".$relief."<br>";
		echo "Gross Pay ".$row[1]."<br>";

        $pay = $row[1] - $nssf - $pension;
		echo "Taxable Pay ".$pay."<br>";
//            echo "<br>Taxable Pay=".$pay;
        if ($pay < $data[2][0]) {
            $finaltax = 0;
			echo "Pay is less Than 12298 ".$row[1]."<br>";
        } else if ($pay == $data[2][0]) {
            $finaltax = $data[3][0] / 100 * $data[4][0];
			echo "Pay is ==12228 final tax is ".$finaltax ."<br>";
        } else if ($pay > $data[1][1] && $pay <= $data[2][1]) {
            $tax = $data[3][0] / 100 * $data[4][0];
            $balTax = $pay - $data[4][0];
            $k = $data[3][1] / 100 * $balTax;
            $finaltax = $tax + $k;
			echo "If Pay is 12229 and less than 23885 then final tax is ".$finaltax ."<br>";
        } else if ($pay > $data[1][2] && $pay <= $data[2][2]) {
            $tax = $data[3][0] / 100 * $data[4][0];
            $tax2 = $data[3][1] / 100 * $data[4][1];
            $balTax = $pay - ($data[4][0] + $data[4][1]);
            $k = $data[3][2] / 100 * $balTax;
            $finaltax = $tax + $k + $tax2;
			echo "If Pay is 23886 and less than 35472 then final tax is ".$tax.' '.$tax2.' '.$k.' '.$finaltax."<br>";
        } else if ($pay > $data[1][3] && $pay <= $data[2][3]) {
            $tax = $data[3][0] / 100 * $data[4][0];
            $tax2 = $data[3][1] / 100 * $data[4][1];
            $tax3 = $data[3][2] / 100 * $data[4][2];
            $balTax = $pay - ($data[4][0] + $data[4][1] + $data[4][2]);
            $k = $data[3][3] / 100 * $balTax;
            $finaltax = $tax + $k + $tax2 + $tax3;
			echo "If Pay is >35473 and less than 47059 then final tax is ".$finaltax ."<br>";
        } else if ($pay > $data[1][4]) {
            $tax = $data[3][0] / 100 * $data[4][0];
            $tax2 = $data[3][1] / 100 * $data[4][1];;
            $tax3 = $data[3][2] / 100 * $data[4][2];
            $tax4 = $data[3][3] / 100 * $data[4][3];
            $balTax = $pay-($data[4][0] + $data[4][1] + $data[4][2] + $data[4][3]);
            $k = $data[3][4] / 100 * $balTax;
            $finaltax = $tax + $k + $tax2 + $tax3 + $tax4;
			echo "Pay is greater 47060 and final tax is ".$finaltax ."<br>";
        } else {
            $finaltax = 0;
        }
        echo "<br>Final Tax=".($finaltax - $relief);
    }
}
    