<?php
    error_reporting(E_COMPILE_ERROR | E_ERROR | E_CORE_ERROR);
    require ('include/inc_environment_global.php');


    if($_SESSION['userID']==''){
    	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		    $uri = 'https://';
        } else {
            $uri = 'http://';
        }
        $uri .= $_SERVER['HTTP_HOST'];
        header('Location: '.$uri.'/payroll/');
        exit;
    }else{
        if($_REQUEST['user']<>''){
            $userId=$_REQUEST['user'];
            $_SESSION['userID']=$userId;
        }

        //echo $_SESSION['userID'];
        $sql="Select * from proll_company";
        $results=$db->Execute($sql);
        $row=$results->FetchRow();
        $_SESSION['companyBranch']=$row[CompanyBranch];

    }
  //  echo  $_SESSION['companyBranch'];
?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>payroll</title>
    <script>
        //var Params=window.location.search.substring(1);
           // alert("Logged In as "+Params);
        </script>
    <script src="../../../Ext-4/ext-all.js"></script>
    <script src="CryptoJS/rollups/md5.js"></script>
    <link rel="stylesheet" href="../../../Ext-4/resources/ext-theme-classic/ext-theme-classic-all.css">
    <link rel="stylesheet" href="css/payroll.css">
    <script type="text/javascript" src="app.js"></script>
</head>
<body></body>
</html>