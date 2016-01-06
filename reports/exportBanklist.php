<?php
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
header("Pragma: public");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: pre-check=0, post-check=0, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Transfer-Encoding: none");
header("Content-Type: application/vnd.ms-excel;");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=Invoices".date('Y-m-d h:m:s').".xls");
require('roots.php');
require($root_path.'include/inc_environment_global.php');
?>
<html>
<body>
<table border="0">
<tr>
    <th>PID</th>
    <th>Names</th>
    <th>ID No</th>
    <th>NHIF NO</th>
    <th>Amount</th>
</tr>
<?php
$sql = "SELECT p.`Pid`, p.`emp_names`,p.`pay_type`, p.`amount`,e.ID_no,e.nhif_no FROM proll_payments p inner join proll_empregister e
on p.Pid=e.PID where pay_type ='nhif'";
    $result=$db->Execute($sql);
    while($row = $result->FetchRow($result))
{
?>
<tr>
    <td><?=$row['pid']?></td>
    <td><?=$row['emp_names']?></td>
    <td><?=$row['ID_no']?></td>
    <td><?=$row['nhif_no']?></td>
    <td><?=$row['amount']?></td>
</tr>
<?php
}
?>
</table>
</body>
</html>