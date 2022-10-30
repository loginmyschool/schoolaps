<? 
/*
   # wtos version : 1.1
   # page called by ajax script in student_enquiryDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_student_enquiryListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andtitle=  $os->postAndQuery('title_s','title','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( title like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from student_enquiry where student_enquiry_id>0   $where   $andtitle  $andstatus     order by student_enquiry_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Title</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_student_enquiryGetById('<? echo $record['student_enquiry_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['title']?> </td>  
  <td> <? if(isset($os->activeStatus[$record['status']])){ echo  $os->activeStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_student_enquiryEditAndSave')=='OK')
{
 $student_enquiry_id=$os->post('student_enquiry_id');
 
 
		 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($student_enquiry_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('student_enquiry',$dataToSave,'student_enquiry_id',$student_enquiry_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($student_enquiry_id>0 ){ $mgs= " Data updated Successfully";}
		if($student_enquiry_id<1 ){ $mgs= " Data Added Successfully"; $student_enquiry_id=  $qResult;}
		
		  $mgs=$student_enquiry_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_student_enquiryGetById')=='OK')
{
		$student_enquiry_id=$os->post('student_enquiry_id');
		
		if($student_enquiry_id>0)	
		{
		$wheres=" where student_enquiry_id='$student_enquiry_id'";
		}
	    $dataQuery=" select * from student_enquiry  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['title']=$record['title'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_student_enquiryDeleteRowById')=='OK')
{ 

$student_enquiry_id=$os->post('student_enquiry_id');
 if($student_enquiry_id>0){
 $updateQuery="delete from student_enquiry where student_enquiry_id='$student_enquiry_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
