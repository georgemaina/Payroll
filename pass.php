<?php

error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
//require_once('roots.php');
require ('include/inc_environment_global.php');

$sql="select pid,ID_NO from numbers where ID_NO is not null";
$results=$db->Execute($sql);
while($row=$results->FetchRow()){
    $sql="Update proll_empregister set ID_no='$row[1]' where pid='$row[0]'";
    if($db->Execute($sql)){
        echo "Updated Pid $row[0] ID to $row[1] <br>";
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

