<?
include('wtosConfigLocal.php');
 
include($site['root-wtos'].'wtosCommon.php');
$MobileNo=$os->get('mobileNo');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? include('wtosHeader.php'); ?>
</head>
<body style="background-color:#FFFFFF;">

<? 

if($MobileNo=='')
{
include('login.php');
}
else
{
	include('login_mobile_otp.php');
}	
?>
 
</body>
	</html>
 
