
<? session_start();
ob_start();
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
include('setupinfo/setupinfo.php');
ob_end_clean();
$studentId = $_GET['studentId'];



 $studentImgUrl =$os->rowByField('image','student','studentId',$studentId,$where) ;


//_d($propdata);
error_reporting(0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title><? echo $header['titletag'] ?></title>
<style>
.billTbl{ border-top:1px solid #000000; border-right:1px solid #000000;}
.billTbl td{ border-left:1px solid #000000; border-bottom:1px solid #000000; height:25px;}
.alignCenter td{ text-align:center;}
.paddingLeft td{ padding-left:15px;}
.bigTxt td{ font-size:12px;}
body{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;}
</style>
</head>
<body>



<img src="<?php  echo $site['url'].$studentImgUrl; ?>" />


</body>
 
</html>
