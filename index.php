<?php
error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
require ('include/inc_environment_global.php');


//    if($_SESSION['userID']==''){
//    	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
//		    $uri = 'https://';
//        } else {
//            $uri = 'http://';
//        }
//        $uri .= $_SERVER['HTTP_HOST'];
//        header('Location: '.$uri.'/payroll/');
//       // exit;
//    }else{
//        if($_REQUEST['user']<>''){
//            $userId=$_REQUEST['user'];
//            $_SESSION['userID']=$userId;
//        }
//
//        echo $_SESSION['userID'];
//
//        $sql="Select * from proll_company";
//        $results=$db->Execute($sql);
//        $row=$results->FetchRow();
//        $_SESSION['companyBranch']=$row[CompanyBranch];
//
//    }
//  echo  $_SESSION['companyBranch'];
?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>payroll</title>
    <script>
        var Ext = Ext || {};
        Ext.theme = {
            name: ""
        };
    </script>
    <script src="../ext-6/build/ext-all-debug.js"></script>
    <script src="../ext-6/build/classic/theme-triton/theme-triton.js"></script>
    <link rel="stylesheet" href="../ext-6/build/classic/theme-triton/resources/theme-triton-all.css">
    <link rel="stylesheet" href="css/payroll.css">
    <script type="text/javascript" src="app.js"></script>
</head>
<body></body>
</html>