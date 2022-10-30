<? 
/*
   # wtos version : 1.1
   # page called by ajax script in student_applicationDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_student_applicationListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andstudent_enquiry_id=  $os->postAndQuery('student_enquiry_id_s','student_enquiry_id','%');
$andstudentId=  $os->postAndQuery('studentId_s','studentId','%');
$andsubject=  $os->postAndQuery('subject_s','subject','%');
$anddescription=  $os->postAndQuery('description_s','description','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( student_enquiry_id like '%$searchKey%' Or studentId like '%$searchKey%' Or subject like '%$searchKey%' Or description like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from student_application where student_application_id>0   $where   $andstudent_enquiry_id  $andstudentId  $andsubject  $anddescription  $andstatus     order by student_application_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Student enquiry</b></td>  
  <td ><b>Student</b></td>  
  <td ><b>Subject</b></td>  
  <td ><b>Description</b></td>  
  <td ><b>Status</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_student_applicationGetById('<? echo $record['student_application_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('title','student_enquiry','student_enquiry_id',$record['student_enquiry_id']); ?></td> 
  <td>  <? echo 
	$os->rowByField('name','student','studentId',$record['studentId']); ?></td> 
  <td><?php echo $record['subject']?> </td>  
  <td><?php echo $record['description']?> </td>  
  <td> <? if(isset($os->studentAppStatus[$record['status']])){ echo  $os->studentAppStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_student_applicationEditAndSave')=='OK')
{
 $student_application_id=$os->post('student_application_id');
 
 
		 
 $dataToSave['student_enquiry_id']=addslashes($os->post('student_enquiry_id')); 
 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['subject']=addslashes($os->post('subject')); 
 $dataToSave['description']=addslashes($os->post('description')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($student_application_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('student_application',$dataToSave,'student_application_id',$student_application_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($student_application_id>0 ){ $mgs= " Data updated Successfully";}
		if($student_application_id<1 ){ $mgs= " Data Added Successfully"; $student_application_id=  $qResult;}
		
		  $mgs=$student_application_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_student_applicationGetById')=='OK')
{
		$student_application_id=$os->post('student_application_id');
		
		if($student_application_id>0)	
		{
		$wheres=" where student_application_id='$student_application_id'";
		}
	    $dataQuery=" select * from student_application  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['student_enquiry_id']=$record['student_enquiry_id'];
 $record['studentId']=$record['studentId'];
 $record['subject']=$record['subject'];
 $record['description']=$record['description'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_student_applicationDeleteRowById')=='OK')
{ 

$student_application_id=$os->post('student_application_id');
 if($student_application_id>0){
 $updateQuery="delete from student_application where student_application_id='$student_application_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
