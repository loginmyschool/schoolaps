<? 
/*
   # wtos version : 1.1
   # page called by ajax script in review_detailsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_review_detailsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andreview_subject_id=  $os->postAndQuery('review_subject_id_s','review_subject_id','%');
$andparent_id=  $os->postAndQuery('parent_id_s','parent_id','%');
$anduser_table=  $os->postAndQuery('user_table_s','user_table','%');
$anduser_table_id=  $os->postAndQuery('user_table_id_s','user_table_id','%');
$andcontact_no=  $os->postAndQuery('contact_no_s','contact_no','%');
$andreview_marks=  $os->postAndQuery('review_marks_s','review_marks','%');
$andreview_note=  $os->postAndQuery('review_note_s','review_note','%');

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( review_subject_id like '%$searchKey%' Or parent_id like '%$searchKey%' Or user_table like '%$searchKey%' Or user_table_id like '%$searchKey%' Or contact_no like '%$searchKey%' Or review_marks like '%$searchKey%' Or review_note like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from review_details where review_details_id>0   $where   $andreview_subject_id  $andparent_id  $anduser_table  $anduser_table_id  $andcontact_no  $andreview_marks  $andreview_note  $anddated  $andstatus     order by review_details_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Review Subject</b></td>  
  <td ><b>Parent Id</b></td>  
  <td ><b>User Table</b></td>  
  <td ><b>User Table Id</b></td>  
  <td ><b>Contact No</b></td>  
  <td ><b>Review Marks</b></td>  
  <td ><b>Review Note</b></td>  
  <td ><b>Dated</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_review_detailsGetById('<? echo $record['review_details_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('title','review_subject','review_subject_id',$record['review_subject_id']); ?></td> 
  <td><?php echo $record['parent_id']?> </td>  
  <td><?php echo $record['user_table']?> </td>  
  <td><?php echo $record['user_table_id']?> </td>  
  <td><?php echo $record['contact_no']?> </td>  
  <td><?php echo $record['review_marks']?> </td>  
  <td><?php echo $record['review_note']?> </td>  
  <td><?php echo $os->showDate($record['dated']);?> </td>  
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
 





if($os->get('WT_review_detailsEditAndSave')=='OK')
{
 $review_details_id=$os->post('review_details_id');
 
 
		 
 $dataToSave['review_subject_id']=addslashes($os->post('review_subject_id')); 
 $dataToSave['parent_id']=addslashes($os->post('parent_id')); 
 $dataToSave['user_table']=addslashes($os->post('user_table')); 
 $dataToSave['user_table_id']=addslashes($os->post('user_table_id')); 
 $dataToSave['contact_no']=addslashes($os->post('contact_no')); 
 $dataToSave['review_marks']=addslashes($os->post('review_marks')); 
 $dataToSave['review_note']=addslashes($os->post('review_note')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($review_details_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('review_details',$dataToSave,'review_details_id',$review_details_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($review_details_id>0 ){ $mgs= " Data updated Successfully";}
		if($review_details_id<1 ){ $mgs= " Data Added Successfully"; $review_details_id=  $qResult;}
		
		  $mgs=$review_details_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_review_detailsGetById')=='OK')
{
		$review_details_id=$os->post('review_details_id');
		
		if($review_details_id>0)	
		{
		$wheres=" where review_details_id='$review_details_id'";
		}
	    $dataQuery=" select * from review_details  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['review_subject_id']=$record['review_subject_id'];
 $record['parent_id']=$record['parent_id'];
 $record['user_table']=$record['user_table'];
 $record['user_table_id']=$record['user_table_id'];
 $record['contact_no']=$record['contact_no'];
 $record['review_marks']=$record['review_marks'];
 $record['review_note']=$record['review_note'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_review_detailsDeleteRowById')=='OK')
{ 

$review_details_id=$os->post('review_details_id');
 if($review_details_id>0){
 $updateQuery="delete from review_details where review_details_id='$review_details_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
