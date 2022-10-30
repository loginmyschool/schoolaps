<?php
include('wtosConfigLocal.php');
set_time_limit (0);
include($site['root-wtos'].'wtosCommon.php');
$list[0] =array($os->getSession('downloadCollectedByHeader'));
$list[1] = array('Sl No','Expense Head','Date','Expense Details','Amount','Expence To','Expence By');
$listingQuery = $os->getSession('downloadExpenseDataQuery');

if($listingQuery==''){exit();}
$listingMq = $os->mq($listingQuery);
$count=1;
$fileName='expenseReport.csv';
$fp = fopen($fileName, 'w');
fputcsv($fp, $list[0]);
fputcsv($fp, $list[1]);

while($record = $os->mfa($listingMq))
{
$fields[]=$count;
$fields[]=$record['expenseHead'];
$fields[]=$os->showDate($record['dated']);
$fields[]=$record['expenseDetails'];
$fields[]=$record['amount'];
$fields[]=$record['expenceTo'];
$fields[]=$os->rowByField('name','admin','adminId',$record['modifyBy']);;
fputcsv($fp, $fields);
$fields=array();
$count++;	
}
fclose($fp);

header('Content-Type: application/csv'); //Outputting the file as a csv file
header('Content-Disposition: attachment; filename='.$fileName); //Defining the name of the file and suggesting the browser to offer a 'Save to disk ' option
header('Pragma: no-cache');
readfile($fileName); //Reading the contents of the file

?>

