<?
/*
   # wtos version : 1.1
   # main ajax process page : salaryAjax.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Salary';
//$ajaxFilePath= 'salaryAjax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
  include('wtosSearchAddAssign.php');
?>
  
<?
$studentQ="select * from student where studentId>0";
$studentMq=$os->mq($studentQ);
$i=0;
while($studentMfa=$os->mfa($studentMq))
{
	
	$studentD[$i]['accNo']=$studentMfa['accNo'];
	$studentD[$i]['adhar_no']=$studentMfa['adhar_no'];
	$studentD[$i]['name']=$studentMfa['name'];
	$i++;
}
shuffle($studentD);
//_d($studentD);
$studentQ2="select * from student where studentId>0";
$studentMq2=$os->mq($studentQ2);
$i=0;
while($studentMfa2=$os->mfa($studentMq2))
{
	 $accNo=$studentD[$i]["accNo"];
	
	$adharNo=$studentD[$i]['adhar_no'];
		$name=$studentD[$i]['name'];
	$studentId=$studentMfa2['studentId'];
	  $updateQ="update student set name='$name' , accNo='$accNo' , adhar_no ='$adharNo' where studentId>0 and studentId=$studentId";
	
	$os->mq($updateQ);
	
	$i++;
}

?>
<? include($site['root-wtos'].'bottom.php'); ?>