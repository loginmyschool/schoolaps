<? 
/*
   # wtos version : 1.1
   # page called by ajax script in budget_list_detailsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_budget_list_detailsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andbudget_list_id=  $os->postAndQuery('budget_list_id_s','budget_list_id','%');
$andparent_head_id=  $os->postAndQuery('parent_head_id_s','parent_head_id','%');
$andaccount_head_id=  $os->postAndQuery('account_head_id_s','account_head_id','%');
$anddescription=  $os->postAndQuery('description_s','description','%');
$andquantity=  $os->postAndQuery('quantity_s','quantity','%');
$andunit=  $os->postAndQuery('unit_s','unit','%');
$andtax_percent=  $os->postAndQuery('tax_percent_s','tax_percent','%');
$andrate_excl_tax=  $os->postAndQuery('rate_excl_tax_s','rate_excl_tax','%');
$andrate_incl_tax=  $os->postAndQuery('rate_incl_tax_s','rate_incl_tax','%');
$andtotal_excl_tax=  $os->postAndQuery('total_excl_tax_s','total_excl_tax','%');
$andtotal_incl_tax=  $os->postAndQuery('total_incl_tax_s','total_incl_tax','%');
$andtax_amount=  $os->postAndQuery('tax_amount_s','tax_amount','%');
$anduser_id=  $os->postAndQuery('user_id_s','user_id','%');
$andtype=  $os->postAndQuery('type_s','type','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( budget_list_id like '%$searchKey%' Or parent_head_id like '%$searchKey%' Or account_head_id like '%$searchKey%' Or description like '%$searchKey%' Or quantity like '%$searchKey%' Or unit like '%$searchKey%' Or tax_percent like '%$searchKey%' Or rate_excl_tax like '%$searchKey%' Or rate_incl_tax like '%$searchKey%' Or total_excl_tax like '%$searchKey%' Or total_incl_tax like '%$searchKey%' Or tax_amount like '%$searchKey%' Or user_id like '%$searchKey%' Or type like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from budget_list_details where budget_list_details_id>0   $where   $andbudget_list_id  $andparent_head_id  $andaccount_head_id  $anddescription  $andquantity  $andunit  $andtax_percent  $andrate_excl_tax  $andrate_incl_tax  $andtotal_excl_tax  $andtotal_incl_tax  $andtax_amount  $anduser_id  $andtype  $andstatus     order by budget_list_details_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Budget Purpose</b></td>  
  <td ><b>Parent Head Id</b></td>  
  <td ><b>Account Head Id</b></td>  
  <td ><b>Description</b></td>  
  <td ><b>Quantity</b></td>  
  <td ><b>Unit</b></td>  
  <td ><b>Tax Percent</b></td>  
  <td ><b>Rate Excl Tax</b></td>  
  <td ><b>Rate Incl Tax</b></td>  
  <td ><b>Total Excl Tax</b></td>  
  <td ><b>Total Incl Tax</b></td>  
  <td ><b>Tax Amount</b></td>  
  <td ><b>User Id</b></td>  
  <td ><b>Type</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_budget_list_detailsGetById('<? echo $record['budget_list_details_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('title','budget_list','budget_list_id',$record['budget_list_id']); ?></td> 
  <td><?php echo $record['parent_head_id']?> </td>  
  <td><?php echo $record['account_head_id']?> </td>  
  <td><?php echo $record['description']?> </td>  
  <td><?php echo $record['quantity']?> </td>  
  <td> <? if(isset($os->unit[$record['unit']])){ echo  $os->unit[$record['unit']]; } ?></td> 
  <td><?php echo $record['tax_percent']?> </td>  
  <td><?php echo $record['rate_excl_tax']?> </td>  
  <td><?php echo $record['rate_incl_tax']?> </td>  
  <td><?php echo $record['total_excl_tax']?> </td>  
  <td><?php echo $record['total_incl_tax']?> </td>  
  <td><?php echo $record['tax_amount']?> </td>  
  <td><?php echo $record['user_id']?> </td>  
  <td> <? if(isset($os->type[$record['type']])){ echo  $os->type[$record['type']]; } ?></td> 
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
 





if($os->get('WT_budget_list_detailsEditAndSave')=='OK')
{
 $budget_list_details_id=$os->post('budget_list_details_id');
 
 
		 
 $dataToSave['budget_list_id']=addslashes($os->post('budget_list_id')); 
 $dataToSave['parent_head_id']=addslashes($os->post('parent_head_id')); 
 $dataToSave['account_head_id']=addslashes($os->post('account_head_id')); 
 $dataToSave['description']=addslashes($os->post('description')); 
 $dataToSave['quantity']=addslashes($os->post('quantity')); 
 $dataToSave['unit']=addslashes($os->post('unit')); 
 $dataToSave['tax_percent']=addslashes($os->post('tax_percent')); 
 $dataToSave['rate_excl_tax']=addslashes($os->post('rate_excl_tax')); 
 $dataToSave['rate_incl_tax']=addslashes($os->post('rate_incl_tax')); 
 $dataToSave['total_excl_tax']=addslashes($os->post('total_excl_tax')); 
 $dataToSave['total_incl_tax']=addslashes($os->post('total_incl_tax')); 
 $dataToSave['tax_amount']=addslashes($os->post('tax_amount')); 
 $dataToSave['user_id']=addslashes($os->post('user_id')); 
 $dataToSave['type']=addslashes($os->post('type')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($budget_list_details_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('budget_list_details',$dataToSave,'budget_list_details_id',$budget_list_details_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($budget_list_details_id>0 ){ $mgs= " Data updated Successfully";}
		if($budget_list_details_id<1 ){ $mgs= " Data Added Successfully"; $budget_list_details_id=  $qResult;}
		
		  $mgs=$budget_list_details_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_budget_list_detailsGetById')=='OK')
{
		$budget_list_details_id=$os->post('budget_list_details_id');
		
		if($budget_list_details_id>0)	
		{
		$wheres=" where budget_list_details_id='$budget_list_details_id'";
		}
	    $dataQuery=" select * from budget_list_details  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['budget_list_id']=$record['budget_list_id'];
 $record['parent_head_id']=$record['parent_head_id'];
 $record['account_head_id']=$record['account_head_id'];
 $record['description']=$record['description'];
 $record['quantity']=$record['quantity'];
 $record['unit']=$record['unit'];
 $record['tax_percent']=$record['tax_percent'];
 $record['rate_excl_tax']=$record['rate_excl_tax'];
 $record['rate_incl_tax']=$record['rate_incl_tax'];
 $record['total_excl_tax']=$record['total_excl_tax'];
 $record['total_incl_tax']=$record['total_incl_tax'];
 $record['tax_amount']=$record['tax_amount'];
 $record['user_id']=$record['user_id'];
 $record['type']=$record['type'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_budget_list_detailsDeleteRowById')=='OK')
{ 

$budget_list_details_id=$os->post('budget_list_details_id');
 if($budget_list_details_id>0){
 $updateQuery="delete from budget_list_details where budget_list_details_id='$budget_list_details_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
