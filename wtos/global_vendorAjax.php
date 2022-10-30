<? 
/*
   # wtos version : 1.1
   # page called by ajax script in global_vendorDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_global_vendorListing')=='OK'){
		$where='';
		$showPerPage= $os->post('showPerPage');
		$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 
		$andvendor_name=  $os->postAndQuery('vendor_name_s','vendor_name','%');
		$andmobile=  $os->postAndQuery('mobile_s','mobile','%');
		$andemail=  $os->postAndQuery('email_s','email','%');
		$andaddress=  $os->postAndQuery('address_s','address','%');
		$andactive_status=  $os->postAndQuery('active_status_s','active_status','%');
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andnote=  $os->postAndQuery('note_s','note','%');
		$searchKey=$os->post('searchKey');
		
		if($searchKey!=''){
		$where ="and ( vendor_name like '%$searchKey%' Or mobile like '%$searchKey%' Or email like '%$searchKey%' Or address like '%$searchKey%' Or active_status like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' )";
	 
		}
			
		$listingQuery="  select * from global_vendor where global_vendor_id>0   $where   $andvendor_name  $andmobile  $andemail  $andaddress  $andactive_status  $andbranch_code  $andnote  $andaddedBy   order by global_vendor_id desc";
		  
		$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
		$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
								<td >#</td>
								<td >Action </td>
								<td ><b>Vendor Name</b></td>  
								<td ><b>Mobile</b></td>  
								<td ><b>Email</b></td>  
								<td ><b>Address</b></td>  
								<td ><b>Active Status</b></td>  
								<td ><b>Branch Code</b></td>  
								<td ><b>Note</b></td>   
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
									<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_global_vendorGetById('<? echo $record['global_vendor_id'];?>')" >Edit</a></span>  <? } ?>  </td>

									<td><?php echo $record['vendor_name']?> </td>  
									<td><?php echo $record['mobile']?> </td>  
									<td><?php echo $record['email']?> </td>  
									<td><?php echo $record['address']?> </td>  
									<td> <? if(isset($os->global_vendor_active_status[$record['active_status']])){ echo  $os->global_vendor_active_status[$record['active_status']]; } ?></td> 
									<td>  <? echo 
									$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
									<td><?php echo $record['note']?> </td>
				 		</tr>
                          <?}?>  
							
		</table> 
		</div>
		<br />			
<?php 
exit();
	
}
 





if($os->get('WT_global_vendorEditAndSave')=='OK')
{
 $global_vendor_id=$os->post('global_vendor_id');
 
 
		 
 $dataToSave['vendor_name']=addslashes($os->post('vendor_name')); 
 $dataToSave['mobile']=addslashes($os->post('mobile')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['active_status']=addslashes($os->post('active_status')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($global_vendor_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('global_vendor',$dataToSave,'global_vendor_id',$global_vendor_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($global_vendor_id>0 ){ $mgs= " Data updated Successfully";}
		if($global_vendor_id<1 ){ $mgs= " Data Added Successfully"; $global_vendor_id=  $qResult;}
		
		  $mgs=$global_vendor_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_global_vendorGetById')=='OK')
{
		$global_vendor_id=$os->post('global_vendor_id');
		
		if($global_vendor_id>0)	
		{
		$wheres=" where global_vendor_id='$global_vendor_id'";
		}
	    $dataQuery=" select * from global_vendor  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['vendor_name']=$record['vendor_name'];
 $record['mobile']=$record['mobile'];
 $record['email']=$record['email'];
 $record['address']=$record['address'];
 $record['active_status']=$record['active_status'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_global_vendorDeleteRowById')=='OK')
{ 

$global_vendor_id=$os->post('global_vendor_id');
 if($global_vendor_id>0){
 $updateQuery="delete from global_vendor where global_vendor_id='$global_vendor_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
