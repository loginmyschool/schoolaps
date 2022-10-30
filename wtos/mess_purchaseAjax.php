<? 
/*
   # wtos version : 1.1
   # page called by ajax script in mess_purchaseDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_mess_purchaseListing')=='OK'){
		$where='';
		$showPerPage= $os->post('showPerPage');
		$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 
		$andmess_vendor_id=  $os->postAndQuery('mess_vendor_id_s','mess_vendor_id','%');
		$f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
		$anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
		$andbill_no=  $os->postAndQuery('bill_no_s','bill_no','%');
		$andtotal_bill_amount=  $os->postAndQuery('total_bill_amount_s','total_bill_amount','%');
		$andpayment_status=  $os->postAndQuery('payment_status_s','payment_status','%');
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andnote=  $os->postAndQuery('note_s','note','%');
		$searchKey=$os->post('searchKey');
		if($searchKey!=''){
		$where ="and ( mess_vendor_id like '%$searchKey%' Or bill_no like '%$searchKey%' Or total_bill_amount like '%$searchKey%' Or payment_status like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' )";
		}
		$listingQuery="  select * from mess_purchase where mess_purchase_id>0   $where   $andmess_vendor_id  $anddated  $andbill_no  $andtotal_bill_amount  $andpayment_status  $andbranch_code  $andnote  $andaddedBy   order by mess_purchase_id desc";
		$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
		$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
								<td >#</td>
								<td >Action </td>
								<td ><b>Mess Vendor</b></td>  
								<td ><b>Date</b></td>  
								<td ><b>Bill No</b></td>  
								<td ><b>Total Bill Amount</b></td>  
								<td ><b>Payment Status</b></td>  
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
								<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_mess_purchaseGetById('<? echo $record['mess_purchase_id'];?>')" >Edit</a></span>  <? } ?>  </td>

								<td>  <? echo 
								$os->rowByField('vendor_name','mess_vendor','mess_vendor_id',$record['mess_vendor_id']); ?></td> 
								<td><?php echo $os->showDate($record['dated']);?> </td>  
								<td><?php echo $record['bill_no']?> </td>  
								<td><?php echo $record['total_bill_amount']?> </td>  
								<td> <? if(isset($os->mess_purchase_payment_status[$record['payment_status']])){ echo  $os->mess_purchase_payment_status[$record['payment_status']]; } ?></td> 
								<td>  <? echo 
								$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
								<td><?php echo $record['note']?> </td>  

								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_mess_purchaseEditAndSave')=='OK')
{
 $mess_purchase_id=$os->post('mess_purchase_id');
 
 
		 
 $dataToSave['mess_vendor_id']=addslashes($os->post('mess_vendor_id')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['bill_no']=addslashes($os->post('bill_no')); 
 $dataToSave['total_bill_amount']=addslashes($os->post('total_bill_amount')); 
 $dataToSave['payment_status']=addslashes($os->post('payment_status')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($mess_purchase_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('mess_purchase',$dataToSave,'mess_purchase_id',$mess_purchase_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($mess_purchase_id>0 ){ $mgs= " Data updated Successfully";}
		if($mess_purchase_id<1 ){ $mgs= " Data Added Successfully"; $mess_purchase_id=  $qResult;}
		
		  $mgs=$mess_purchase_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_mess_purchaseGetById')=='OK')
{
		$mess_purchase_id=$os->post('mess_purchase_id');
		
		if($mess_purchase_id>0)	
		{
		$wheres=" where mess_purchase_id='$mess_purchase_id'";
		}
	    $dataQuery=" select * from mess_purchase  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['mess_vendor_id']=$record['mess_vendor_id'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['bill_no']=$record['bill_no'];
 $record['total_bill_amount']=$record['total_bill_amount'];
 $record['payment_status']=$record['payment_status'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_mess_purchaseDeleteRowById')=='OK')
{ 

$mess_purchase_id=$os->post('mess_purchase_id');
 if($mess_purchase_id>0){
 $updateQuery="delete from mess_purchase where mess_purchase_id='$mess_purchase_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
