<?php
include('wtosConfigLocal.php');
set_time_limit (0);
include($site['root-wtos'].'wtosCommon.php');
$list[0] =array($os->getSession('yearlyDueRegfeesReportExcelHeader'));
$list[1] = array('Sl No','Student Id','Name','Mobile','Class','Due Amount');
$regFeesQ= $os->getSession('yearlyDueRegfeesReportExcel');

$rsRecords=$os->mq($regFeesQ);
$studentList= $os->getIdsDataFromQuery($regFeesQ,'studentId','student','studentId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
$historyList= $os->getIdsDataFromQuery($regFeesQ,'historyId','history','historyId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
$regPaymentList= $os->getIdsDataFromQuery($regFeesQ,'historyId','payment','historyId',$fields='',$returnArray=true,$relation='12M',$otherCondition='order by paymentDate DESC');





$count=1;
$fileName='registrationDueFeesReport.csv';
$fp = fopen($fileName, 'w');
fputcsv($fp, $list[0]);
fputcsv($fp, $list[1]);

foreach($rsRecords as $record)
{
	$totalRegPaidVal=0;
	
foreach($regPaymentList[$record['historyId']] as $paymentData)
{

$totalRegPaidVal=$totalRegPaidVal+$paymentData['paidRegistrationFees'];
}
$totalDueAmt=$record['registrationFees']-$totalRegPaidVal;
 if($totalDueAmt>0)
							 {
$fields[]=$count;
$fields[]=$record['studentId'];
$fields[]=$studentList[$record['studentId']]['name'];
$fields[]=$studentList[$record['studentId']]['mobile_student'];
$fields[]=$historyList[$record['historyId']]['class'];
$fields[]=$totalDueAmt;
fputcsv($fp, $fields);
$fields=array();
$count++;	
							 }
}
fclose($fp);
header('Content-Type: application/csv'); //Outputting the file as a csv file
header('Content-Disposition: attachment; filename='.$fileName); //Defining the name of the file and suggesting the browser to offer a 'Save to disk ' option
header('Pragma: no-cache');
 readfile($fileName); //Reading the contents of the file
?>

