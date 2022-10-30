<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
if($os->get('studentListing')=='OK'&& $os->post('searchStudent')=='OK' )
{
 
$studentQuery="select * from teacher  where teacherId>0 and name!=''  and status='Active' ";
$resource=$os->pagingQuery($studentQuery,'1000',false,true);
$f_Date_s= $os->showdate($os->post('attendenceDate')); $t_Date_s= $os->showdate($os->post('attendenceDate'));
$andDate=$os->DateQ('dated',$f_Date_s,$t_Date_s,$sTime='00:00:00',$eTime='23:59:59');
 
$student=$resource['resource'];
$dateAndSubject=  $andDate." and absent_present='P'";
$attendenceList= $os->getIdsDataFromQuery($student->queryString,'teacherId','teacherattendance','teacherId',$fields='',$returnArray=true,$relation='121',$otherCondition=$dateAndSubject);


if(is_array($attendenceList))
{
  foreach($attendenceList as $attdata)
  { 
   
    // $key=$attdata['historyId'].'_'.$attdata['subjectId'].'_'.$os->showDate($attdata['dated']);
	 $presentData[$attdata['teacherId']]=$attdata['teacherId'];
  
  }
 

}


 

?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									
								

											
<td ><b>Name</b></td>  
 
	 
  						
					<td> Attendance</td>
 			
 
						       	</tr>
							
							
							
							<?php
								  
						  	
$serial=0;
while($studentData=$os->mfa($student))
{
  
$checked='';
 
  
 
  if(in_array($studentData['teacherId'],$presentData))
  {
  $checked='checked="checked"';
  }


	$serial++;?>
	<tr class="trListing" >
		<td><?php echo $serial; ?>     </td>
		<td> <? echo $studentData['name']; ?></td>
<td> <input <? echo $checked ?>  type="checkbox" id="checkbox_attendance_<? echo $studentData['teacherId'] ?>" onclick="attendenceSet('<? echo $studentData['teacherId'] ?>')"   /> </td>
 
	</tr>
 
 <? } ?>
							 
		</table> 
		</div>
		 

<?
exit();
 

////////end student data section

}

 


if($os->get('attendence')=='OK'&& $os->post('updateAttendence')=='OK' )
{
 $presentState='A';
 
 
 
$absent_present=$os->post('attendenceVal');
$teacherId=$os->post('teacherId');
 
$dated=$os->saveDate($os->post('attendenceDate'));
  
 
if(  $dated!='' && $teacherId!=''  )
{
		 $attendanceId="";
		 
		$dataToSave['absent_present']=$absent_present;
		$dataToSave['teacherId']=$teacherId;
		 
		$dataToSave['dated']=$dated;
		$dataToSave['addedDate']=$os->now();
	    $dataToSave['adminId']=$os->userDetails['adminId'];
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		
		 
		
		 
		$f_Date_s= $os->showdate($dataToSave['dated']); $t_Date_s= $os->showdate($dataToSave['dated']);
		$andDate=$os->DateQ('dated',$f_Date_s,$t_Date_s,$sTime='00:00:00',$eTime='23:59:59');
		$attendenceIdQuery="select teacherattendanceId from teacherattendance where  teacherId='$teacherId'   $andDate";
		$attendenceIdMq=$os->mq($attendenceIdQuery);
		$attendenceData=$os->mfa($attendenceIdMq);
		if(isset($attendenceData['teacherattendanceId']))
		{
			$teacherattendanceId=$attendenceData['teacherattendanceId'];
		}
		$qResult=$os->save('teacherattendance',$dataToSave,'teacherattendanceId',$teacherattendanceId);
		 
		
		$attendenceIdQuery="select absent_present from teacherattendance where  teacherId='$teacherId'  $andDate";
		$attendenceIdMq=$os->mq($attendenceIdQuery);
		$attendenceData=$os->mfa($attendenceIdMq);
		if(isset($attendenceData['absent_present']))
		{
			$presentState=$attendenceData['absent_present'];
		}
		
		
		
		
		  
		 

}

$arr['presentState']=$presentState;
$arr['teacherId']=$teacherId;

 

echo json_encode($arr);
exit();

}
////end student attendence section 

?> 
 

