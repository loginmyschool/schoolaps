<? 
/*
   # wtos version : 1.1
   # page called by ajax script in bookDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
exit();
  
$q_set_q="select registrationNo,  studentId from history where asession=2020 and  `branch_code` LIKE '%BAISHNABNAGAR%' ";
echo $q_set_q;
$k=0;
$q_set_q_rs=$os->mq($q_set_q);
while($row=$os->mfa( $q_set_q_rs))
{ 
    $k=$k+1;
	$registrationNo  = $row['registrationNo'];
	$studentId  = $row['studentId'];
	$otpPass=rand(1001,9999);
	 $p_set_p="update student set otpPass='$otpPass'  where   studentId ='$studentId' and registerNo='$registrationNo' ";
	 //$os->mq( $p_set_p);
	
	echo " $p_set_p <br> ";
 
}
echo $k;