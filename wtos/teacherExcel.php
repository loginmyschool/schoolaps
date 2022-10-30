<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$field=trim($_GET['field'], ',');
$fieldNameA=explode(',',$field);
foreach($fieldNameA AS $key)
{
	$excelColumnNameA[]=$os->teacherExcelA[$key];
}
array_unshift($excelColumnNameA,"SL");
set_time_limit (0);
$list[0] = $excelColumnNameA;
$listingQuery = $os->getSession('downloadTeacherExcel');
if($listingQuery==''){exit();}
$data = $os->mq($listingQuery);
$fileName='downloadTeacher.csv';
$fp = fopen($fileName, 'w');
fputcsv($fp, $list[0]);
$count=1;
	while($record = $os->mfa($data))
	 	{
			for($i=0;$i<count($fieldNameA);$i++)
			{
					//if(stripos($fieldNameA[$i],"date"))
						if(DateTime::createFromFormat('Y-m-d H:i:s',$record[$fieldNameA[$i]])==true)
					{
						$fields[]=$os->showDate($record[$fieldNameA[$i]]);
					}
					else
					{
						$fields[]=$record[$fieldNameA[$i]];
					}
					
			}
			array_unshift($fields,$count);
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
