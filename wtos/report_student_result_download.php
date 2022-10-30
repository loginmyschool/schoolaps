<?php 
include('wtosConfigLocal.php');
set_time_limit (0);
include($site['root-wtos'].'wtosCommon.php');
$list[1] = array('SL','Name','Reg No.', 'Branch', 'Class','Exam','Subject Name');
 $listingQuery = $os->getSession('download_student_result_report_excel');
 
if($listingQuery==''){exit();}
$data = $os->mq($listingQuery);
$count=1;
$fileName='download_student_result_report.csv';
$fp = fopen($fileName, 'w');
fputcsv($fp, $list[1]);

$total_student=0;
$attended_student=0; 
  $fields =array();
while($record = $os->mfa($data)){

                               $total_student=$total_student +1 ;
								if($record['examTitle']!='')
								{
		                            
									$attended_student=$attended_student +1 ;
							    }		
								
      
		$fields[]=$count;
		$fields[]=$record['name'];
		$fields[]=$record['registerNo'];
		$fields[]=$record['branch'];
		$fields[]=$os->classList[$record['class']];
		$fields[]=$record['examTitle'];
		$fields[]=$record['subjectName'];
	 
		fputcsv($fp, $fields);
		$fields=array();
		$count++;	
	
}

$absent=$total_student - $attended_student;


$list[2] = array('total_student = '.$total_student,'','attended_student = '.$attended_student, '','Absent='.$absent,'',' ',' ','');
fputcsv($fp, $list[2]);

fclose($fp);
header('Content-Type: application/csv'); //Outputting the file as a csv file
header('Content-Disposition: attachment; filename='.$fileName); //Defining the name of the file and suggesting the browser to offer a 'Save to disk ' option
header('Pragma: no-cache');
readfile($fileName); //Reading the contents of the file
?>
