<? 
include('/home/jibantiazadmissi/public_html/wtosConfig.php');
##############################################
 

$site['base']='/home/jibantiazadmissi/public_html'.'/';

$site['server']='http://'.'jibantiazadmission.com'.'/';  
 
 	$wtSystemFolder='';	##'wtossystem/'
	$site['host']='localhost';
	
$site['folder']=$wtSystemFolder;

$site['application-folder']=$wtSystemFolder.'wtosApps/';# wtossystem/application/'

$site['library-folder']=$wtSystemFolder.'library/wtosLibrary/'; ##  'wtossystem/library/wtosLibrary/'

$site['uploadImage-folder']=$wtSystemFolder.'wtos-images/';## 'wtossystem/wtos-images/'

$site['admin-folder']=$wtSystemFolder.'wtos/';  // 'wtossystem/wtos/'

$site['global-property-folder']=$wtSystemFolder.'wtos/'; 

$site['plugin-folder']=$wtSystemFolder.'wtos/'; 





## non editable area 

$site['root']=$site['base'].$site['folder']; 

$site['root-wtos']=$site['base'].$site['admin-folder'];

$site['application']=$site['base'].$site['application-folder'];

$site['library']=$site['base'].$site['library-folder'];

$site['root-image']=$site['base'].$site['uploadImage-folder'];

$site['global-property']=$site['base'].$site['global-property-folder'];

$site['root-plugin']=$site['base'].$site['plugin-folder'];



$site['url-library']=$site['server'].$site['library-folder'];

$site['themePath']=$site['server'].$site['application-folder'];

$site['url']=$site['server'].$site['folder'];

$site['url-wtos']=$site['server'].$site['admin-folder'];

$site['url-image']=$site['server'].$site['uploadImage-folder'];

$site['url-plugin']=$site['server'].$site['plugin-folder'];

$site['loginKey']='wtos-'.$site['db'];

$site['loginKey-wtos']='wtos-'.$site['db'].'-wtos';

$site['environment']='0'; // -1 development  // 0 production 

$site['softwaremode']='demo'; // demo/live 




//_d($site);
##########################################
//include($site['root-wtos'].'wtosCommon.php');
 include($site['root-wtos'].'wtos.php');
// include('/home/jibantiazadmissi/public_html/wtos/'.'wtos.php');



ini_set('max_execution_time', '-1');
ini_set('memory_limit', '2048M');
include('sendSms.php');
$currentDate=$os->showDate($os->now());
$currentDateA=explode('-',$currentDate);
$monthV=$currentDateA[1];
$yearV=$currentDateA[2];


$cronsmsQ="SELECT count(*) as noOfSendingSms FROM cronsms  where  cronsmsId>0 and sendingMonth=$monthV  and sendingYear=$yearV";
$cronsmsMq=$os->mq($cronsmsQ);
$cronsmsData=$os->mfa($cronsmsMq);
if($cronsmsData['noOfSendingSms']>0)
{
	echo "Sms already sended.";
	exit();
}
  $cronSendSmsV = $os->rowByField('value','settings','keyword','cronSendSms') ;
?><?
if( $cronSendSmsV=='Yes')
{
$where='';
 

$andyear="and year <= $yearV";
$andmonth= "and month<=$monthV";
$searchMonthVal=$os->post('month_s');
$searchYearVal=$os->post('year_s');
//$feesQ="SELECT * FROM fees  where  feesId>0 and payble!=paid_amount $andmonth $andyear order by feesId asc";



$feesQ="SELECT * FROM fees  where  feesId>0 and payble!=paid_amount and feesDueDate<=CURDATE() order by feesId asc";
//$resource=$os->pagingQuery($feesQ,'100000000000000',false,true);
//$rsRecords=$resource['resource'];




$studentList= $os->getIdsDataFromQuery($feesQ,'studentId','student','studentId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
$historyList= $os->getIdsDataFromQuery($feesQ,'historyId','history','historyId',$fields='',$returnArray=true,$relation='121',$otherCondition='');

$rsRecords=$os->mq($feesQ);
while($record=$os->mfa($rsRecords))
{ 
$data[$record['historyId']]['totalMonthlyFeesDueAmt']=$data[$record['historyId']]['totalMonthlyFeesDueAmt']+$record['payble']-$record['paid_amount'];
$data[$record['historyId']]['feesMonths']=$data[$record['historyId']]['feesMonths'].$os->feesMonth[$record['month']].',';
$data[$record['historyId']]['MobileNo']=$studentList[$record['studentId']]['mobile_student'];
$data[$record['historyId']]['studentId']=$record['studentId'];
$data[$record['historyId']]['studentName']=$studentList[$record['studentId']]['name'];
}

foreach($data As $dueFeesD)
{
	$pendingMonth=rtrim($dueFeesD['feesMonths'],',');
	$smsText="Please pay fees rs ".$dueFeesD['totalMonthlyFeesDueAmt']." for the month of ".$pendingMonth." . Please ignore if already paid.";
	$smsObj= new sms;
	$smsNumbersStr=$dueFeesD['MobileNo'];
//$smsNumbersStr='9007636254';

	if(trim($smsText)!='')
	{
	
		//$smsObj->sendSMS($smsText,$smsNumbersStr);
		$os->saveCronSms($smsText,$mobileNos=$smsNumbersStr ,$status='send',$note='Fees Remainder',$dueFeesD['MobileNo'],$dueFeesD['studentId'],$dueFeesD['studentName'],$dueFeesD['totalMonthlyFeesDueAmt'],$pendingMonth);
		
	}
}
	
}
 





