<? 
/*
   # wtos version : 1.1
   # page called by ajax script in historyDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_historyListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andasession=  $os->postAndQuery('asession_s','asession','%');
$andregistrationNo=  $os->postAndQuery('registrationNo_s','registrationNo','%');
$andclass=  $os->postAndQuery('class_s','class','%');
$andsection=  $os->postAndQuery('section_s','section','%');
$andadmission_no=  $os->postAndQuery('admission_no_s','admission_no','%');
$andadmission_date=  $os->postAndQuery('admission_date_s','admission_date','%');
$androll_no=  $os->postAndQuery('roll_no_s','roll_no','%');
$andstudentId=  $os->postAndQuery('studentId_s','studentId','%');
$andfull_marks=  $os->postAndQuery('full_marks_s','full_marks','%');
$andobtain_marks=  $os->postAndQuery('obtain_marks_s','obtain_marks','%');
$andpercentage=  $os->postAndQuery('percentage_s','percentage','%');
$andpass_fail=  $os->postAndQuery('pass_fail_s','pass_fail','%');
$andgrade=  $os->postAndQuery('grade_s','grade','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( asession like '%$searchKey%' Or registrationNo like '%$searchKey%' Or class like '%$searchKey%' Or section like '%$searchKey%' Or admission_no like '%$searchKey%' Or admission_date like '%$searchKey%' Or roll_no like '%$searchKey%' Or studentId like '%$searchKey%' Or full_marks like '%$searchKey%' Or obtain_marks like '%$searchKey%' Or percentage like '%$searchKey%' Or pass_fail like '%$searchKey%' Or grade like '%$searchKey%' Or remarks like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from history where historyId>0   $where   $andasession  $andregistrationNo  $andclass  $andsection  $andadmission_no  $andadmission_date  $androll_no  $andstudentId  $andfull_marks  $andobtain_marks  $andpercentage  $andpass_fail  $andgrade  $andremarks     order by historyId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Session</b></td>  
  <td ><b>RegistrationNo</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Section</b></td>  
  <td ><b>StudentId</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_historyGetById('<? echo $record['historyId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td> <? if(isset($os->asession[$record['asession']])){ echo  $os->asession[$record['asession']]; } ?></td> 
  <td><?php echo $record['registrationNo']?> </td>  
  <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td> 
  <td> <? if(isset($os->section[$record['section']])){ echo  $os->section[$record['section']]; } ?></td> 
  <td>  <? echo 
	$os->rowByField('name','Student','StudentId',$record['studentId']); ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_historyEditAndSave')=='OK')
{
 $historyId=$os->post('historyId');
 
 
		 
 $dataToSave['asession']=addslashes($os->post('asession')); 
 $dataToSave['registrationNo']=addslashes($os->post('registrationNo')); 
 $dataToSave['class']=addslashes($os->post('class')); 
 $dataToSave['section']=addslashes($os->post('section')); 
 $dataToSave['admission_no']=addslashes($os->post('admission_no')); 
 $dataToSave['admission_date']=addslashes($os->post('admission_date')); 
 $dataToSave['roll_no']=addslashes($os->post('roll_no')); 
 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['full_marks']=addslashes($os->post('full_marks')); 
 $dataToSave['obtain_marks']=addslashes($os->post('obtain_marks')); 
 $dataToSave['percentage']=addslashes($os->post('percentage')); 
 $dataToSave['pass_fail']=addslashes($os->post('pass_fail')); 
 $dataToSave['grade']=addslashes($os->post('grade')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 

 
 $dataToSave_2['name']=addslashes($os->post('name')); 
 $dataToSave_2['dob']=addslashes($os->post('dob')); 
 $dataToSave_2['age']=addslashes($os->post('age')); 
 $dataToSave_2['gender']=addslashes($os->post('gender')); 	
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($historyId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		  $studentId=$os->save('student',$dataToSave_2,'studentId',$dataToSave['studentId']);
		  $dataToSave['studentId']=$studentId;
		  
		  
          $qResult=$os->save('history',$dataToSave,'historyId',$historyId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($historyId>0 ){ $mgs= " Data updated Successfully";}
		if($historyId<1 ){ $mgs= " Data Added Successfully";$historyId=  $qResult;}
		
		  $mgs=$historyId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_historyGetById')=='OK')
{
		$historyId=$os->post('historyId');
		
		if($historyId>0)	
		{
		$wheres=" where historyId='$historyId'";
		}
	    $dataQuery=" select * from history  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['asession']=$record['asession'];
 $record['registrationNo']=$record['registrationNo'];
 $record['class']=$record['class'];
 $record['section']=$record['section'];
 $record['admission_no']=$record['admission_no'];
 $record['admission_date']=$record['admission_date'];
 $record['roll_no']=$record['roll_no'];
 $record['studentId']=$record['studentId'];
 $record['full_marks']=$record['full_marks'];
 $record['obtain_marks']=$record['obtain_marks'];
 $record['percentage']=$record['percentage'];
 $record['pass_fail']=$record['pass_fail'];
 $record['grade']=$record['grade'];
 $record['remarks']=$record['remarks'];
 
 
    $studentId=$record['studentId'];
    $wheres=" where studentId='$studentId'";
	$dataQuery=" select * from student  $wheres ";
	$rsResults=$os->mq($dataQuery);
	$record_stu=$os->mfa( $rsResults);
 
 $record['name']=$record_stu['name'];
 $record['dob']=$record_stu['dob'];
 $record['age']=$record_stu['age'];
 $record['gender']=$record_stu['gender'];

		
		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_historyDeleteRowById')=='OK')
{ 

$historyId=$os->post('historyId');
 if($historyId>0){
 $updateQuery="delete from history where historyId='$historyId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
