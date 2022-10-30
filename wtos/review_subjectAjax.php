<? 
/*
   # wtos version : 1.1
   # page called by ajax script in review_subjectDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_review_subjectListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andparent_id=  $os->postAndQuery('parent_id_s','parent_id','%');
$andtitle=  $os->postAndQuery('title_s','title','%');
$andallow_user=  $os->postAndQuery('allow_user_s','allow_user','%');
$andview_order=  $os->postAndQuery('view_order_s','view_order','%');
$andactive_status=  $os->postAndQuery('active_status_s','active_status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( parent_id like '%$searchKey%' Or title like '%$searchKey%' Or allow_user like '%$searchKey%' Or view_order like '%$searchKey%' Or active_status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from review_subject where review_subject_id>0   $where   $andparent_id  $andtitle  $andallow_user  $andview_order  $andactive_status     order by review_subject_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Parent Id</b></td>  
  <td ><b>Title</b></td>  
  <td ><b>Allow User</b></td>  
  <td ><b>View Order</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_review_subjectGetById('<? echo $record['review_subject_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php //echo $record['parent_id']?> 

	 <? echo 
	$os->rowByField('title','review_subject','review_subject_id',$record['parent_id']); ?>

</td>  
  <td><?php echo $record['title']?> </td>  
  <td> <? if(isset($os->allow_user[$record['allow_user']])){ echo  $os->allow_user[$record['allow_user']]; } ?></td> 
  <td><?php echo $record['view_order']?> </td>  
  <td> <? if(isset($os->activeStatus[$record['active_status']])){ echo  $os->activeStatus[$record['active_status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_review_subjectEditAndSave')=='OK')
{
 $review_subject_id=$os->post('review_subject_id');
 
 
		 
 $dataToSave['parent_id']=addslashes($os->post('parent_id')); 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['allow_user']=addslashes($os->post('allow_user')); 
 $dataToSave['view_order']=addslashes($os->post('view_order')); 
 $dataToSave['active_status']=addslashes($os->post('active_status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($review_subject_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('review_subject',$dataToSave,'review_subject_id',$review_subject_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($review_subject_id>0 ){ $mgs= " Data updated Successfully";}
		if($review_subject_id<1 ){ $mgs= " Data Added Successfully"; $review_subject_id=  $qResult;}
		
		  $mgs=$review_subject_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_review_subjectGetById')=='OK')
{
		$review_subject_id=$os->post('review_subject_id');
		
		if($review_subject_id>0)	
		{
		$wheres=" where review_subject_id='$review_subject_id'";
		}
	    $dataQuery=" select * from review_subject  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['parent_id']=$record['parent_id'];
 $record['title']=$record['title'];
 $record['allow_user']=$record['allow_user'];
 $record['view_order']=$record['view_order'];
 $record['active_status']=$record['active_status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_review_subjectDeleteRowById')=='OK')
{ 

$review_subject_id=$os->post('review_subject_id');
 if($review_subject_id>0){
 $updateQuery="delete from review_subject where review_subject_id='$review_subject_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
