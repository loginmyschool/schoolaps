<? 
/*
   # wtos version : 1.1
   # page called by ajax script in budget_listDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?

if($os->get('WT_budget_listListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andreference_no=  $os->postAndQuery('reference_no_s','reference_no','%');
$andtitle=  $os->postAndQuery('title_s','title','%');
$andparent_head_id=  $os->postAndQuery('parent_head_id_s','parent_head_id','%');
$andaccount_head_id=  $os->postAndQuery('account_head_id_s','account_head_id','%');
$andapproved_by=  $os->postAndQuery('approved_by_s','approved_by','%');
$andapproved_status=  $os->postAndQuery('approved_status_s','approved_status','%');
$anduser_id=  $os->postAndQuery('user_id_s','user_id','%');
$andbudget_for_month=  $os->postAndQuery('budget_for_month_s','budget_for_month','%');
$andbudget_for_year=  $os->postAndQuery('budget_for_year_s','budget_for_year','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( reference_no like '%$searchKey%' Or title like '%$searchKey%' Or parent_head_id like '%$searchKey%' Or account_head_id like '%$searchKey%' Or approved_by like '%$searchKey%' Or approved_status like '%$searchKey%' Or user_id like '%$searchKey%' Or budget_for_month like '%$searchKey%' Or budget_for_year like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from budget_list where budget_list_id>0   $where   $andreference_no  $andtitle  $andparent_head_id  $andaccount_head_id  $andapproved_by  $andapproved_status  $anduser_id  $andbudget_for_month  $andbudget_for_year  $andstatus     order by budget_list_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
	                            <td >#</td>
								<td >Action </td>
								<td ><b>Reference No</b></td>  
								<td ><b>Title</b></td>  
								<td ><b>Parent Head Id</b></td>  
								<td ><b>Account Head Id</b></td>
								<td ><b>Approved Status</b></td>    
								<td ><b>Approved By</b></td>  
								<td ><b>User Id</b></td>  
								<td ><b>Budget For Month</b></td>  
								<td ><b>budget_for_year</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_budget_listGetById('<? echo $record['budget_list_id'];?>')" >Edit</a></span>  <? } ?>  </td>

								<td><?php echo $record['reference_no']?> </td>  
								<td><?php echo $record['title']?> </td>  
								<td><?php echo $record['parent_head_id']?> </td>  
								<td><?php echo $record['account_head_id']?> </td>

								<td><?php echo $record['approved_status']?> </td>  
								<td><? echo $os->rowByField('name','admin','adminId',$record['approved_by']); ?> </td>    
								<td><?php echo $record['user_id']?> </td>  
								<td> <? if(isset($os->rentMonth[$record['budget_for_month']])){ echo  $os->rentMonth[$record['budget_for_month']]; } ?></td> 
								<td> <? if(isset($os->yearSearch[$record['budget_for_year']])){ echo  $os->yearSearch[$record['budget_for_year']]; } ?></td> 
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
 





if($os->get('WT_budget_listEditAndSave')=='OK')
{
 $budget_list_id=$os->post('budget_list_id');
 
 
		 
 $dataToSave['reference_no']=addslashes($os->post('reference_no')); 
 $dataToSave['title']=addslashes($os->post('title')); 
 $dataToSave['parent_head_id']=addslashes($os->post('parent_head_id')); 
 $dataToSave['account_head_id']=addslashes($os->post('account_head_id')); 
 //$dataToSave['approved_by']=addslashes($os->post('approved_by'));

$dataToSave['approved_by']=addslashes($os->userDetails['adminId']); 
 $dataToSave['approved_status']=addslashes($os->post('approved_status')); 
 $dataToSave['user_id']=addslashes($os->post('user_id')); 
 $dataToSave['budget_for_month']=addslashes($os->post('budget_for_month')); 
 $dataToSave['budget_for_year']=addslashes($os->post('budget_for_year')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($budget_list_id < 1){
			$dataToSave['addedDate']=$os->now();
			$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('budget_list',$dataToSave,'budget_list_id',$budget_list_id);///    allowed char '\*#@/"~$^.,()|+_-=:��

		if($os->post('reference_no')==''){
			$dataToSave2['reference_no']=$qResult;
			$os->save('budget_list',$dataToSave2,'budget_list_id',$qResult);	
		} 	
		if($qResult)  
				{
		if($budget_list_id>0 ){ $mgs= " Data updated Successfully";}
		if($budget_list_id<1 ){ $mgs= " Data Added Successfully"; $budget_list_id=  $qResult;}
		
		  $mgs=$budget_list_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_budget_listGetById')=='OK')
{
		$budget_list_id=$os->post('budget_list_id');
		
		if($budget_list_id>0)	
		{
		$wheres=" where budget_list_id='$budget_list_id'";
		}
	    $dataQuery=" select * from budget_list  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['reference_no']=$record['reference_no'];
 $record['title']=$record['title'];
 $record['parent_head_id']=$record['parent_head_id'];
 $record['account_head_id']=$record['account_head_id'];
 $record['approved_by']=$record['approved_by'];
 $record['approved_status']=$record['approved_status'];
 $record['user_id']=$record['user_id'];
 $record['budget_for_month']=$record['budget_for_month'];
 $record['budget_for_year']=$record['budget_for_year'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_budget_listDeleteRowById')=='OK')
{ 

$budget_list_id=$os->post('budget_list_id');
 if($budget_list_id>0){
 $updateQuery="delete from budget_list where budget_list_id='$budget_list_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
