<? 
/*
   # wtos version : 1.1
   # page called by ajax script in electric_billDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_electric_billListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
$andconsumer_id=  $os->postAndQuery('consumer_id_s','consumer_id','%');

    $f_period_from_s= $os->post('f_period_from_s'); $t_period_from_s= $os->post('t_period_from_s');
   $andperiod_from=$os->DateQ('period_from',$f_period_from_s,$t_period_from_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_period_to_s= $os->post('f_period_to_s'); $t_period_to_s= $os->post('t_period_to_s');
   $andperiod_to=$os->DateQ('period_to',$f_period_to_s,$t_period_to_s,$sTime='00:00:00',$eTime='59:59:59');
$andbill_no=  $os->postAndQuery('bill_no_s','bill_no','%');

    $f_bill_date_s= $os->post('f_bill_date_s'); $t_bill_date_s= $os->post('t_bill_date_s');
   $andbill_date=$os->DateQ('bill_date',$f_bill_date_s,$t_bill_date_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_due_date_s= $os->post('f_due_date_s'); $t_due_date_s= $os->post('t_due_date_s');
   $anddue_date=$os->DateQ('due_date',$f_due_date_s,$t_due_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andpayment_status=  $os->postAndQuery('payment_status_s','payment_status','%');

    $f_payment_date_s= $os->post('f_payment_date_s'); $t_payment_date_s= $os->post('t_payment_date_s');
   $andpayment_date=$os->DateQ('payment_date',$f_payment_date_s,$t_payment_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andpayment_mode=  $os->postAndQuery('payment_mode_s','payment_mode','%');
$andpayment_details=  $os->postAndQuery('payment_details_s','payment_details','%');
$andinvoice_no=  $os->postAndQuery('invoice_no_s','invoice_no','%');
$andmeter_no=  $os->postAndQuery('meter_no_s','meter_no','%');
$andnote=  $os->postAndQuery('note_s','note','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( branch_code like '%$searchKey%' Or consumer_id like '%$searchKey%' Or bill_no like '%$searchKey%' Or payment_status like '%$searchKey%' Or payment_mode like '%$searchKey%' Or payment_details like '%$searchKey%' Or invoice_no like '%$searchKey%' Or meter_no like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from electric_bill where electric_bill_id>0   $where   $andbranch_code  $andconsumer_id  $andperiod_from  $andperiod_to  $andbill_no  $andbill_date  $anddue_date  $andpayment_status  $andpayment_date  $andpayment_mode  $andpayment_details  $andinvoice_no  $andmeter_no  $andnote     order by electric_bill_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Branch</b></td>  
  <td ><b>Consumer Id</b></td>  
  <td ><b>Consume  period from</b></td>  
  <td ><b>Consume  period to</b></td>  
  <td ><b>Previous unit</b></td>  
  <td ><b>Present unit</b></td>  
  <td ><b>Consume Unit</b></td>  
  <td ><b>Rate</b></td>  
  <td ><b>Total Payble by Duedate</b></td>  
  <td ><b>Bill No</b></td>  
  <td ><b>Bill Date</b></td>  
  <td ><b>Due Date</b></td>  
  <td ><b>Payment Status</b></td>  
  <td ><b>Payment Date</b></td>  
  <td ><b>Payment Mode</b></td>  
  <td ><b>Payment Details</b></td>  
  <td ><b>Invoice No</b></td>  
  <td ><b>Document</b></td>  
  <td ><b>Amt For Curremt Month</b></td>  
  <td ><b>Payble through RTGS</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_electric_billGetById('<? echo $record['electric_bill_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
  <td><?php echo $record['consumer_id']?> </td>  
  <td><?php echo $os->showDate($record['period_from']);?> </td>  
  <td><?php echo $os->showDate($record['period_to']);?> </td>  
  <td><?php echo $record['previous_unit']?> </td>  
  <td><?php echo $record['present_unit']?> </td>  
  <td><?php echo $record['unit_consumed']?> </td>  
  <td><?php echo $record['rate']?> </td>  
  <td><?php echo $record['amount']?> </td>  
  <td><?php echo $record['bill_no']?> </td>  
  <td><?php echo $os->showDate($record['bill_date']);?> </td>  
  <td><?php echo $os->showDate($record['due_date']);?> </td>  
  <td> <? if(isset($os->payment_status[$record['payment_status']])){ echo  $os->payment_status[$record['payment_status']]; } ?></td> 
  <td><?php echo $os->showDate($record['payment_date']);?> </td>  
  <td> <? if(isset($os->payment_mode[$record['payment_mode']])){ echo  $os->payment_mode[$record['payment_mode']]; } ?></td> 
  <td><?php echo $record['payment_details']?> </td>  
  <td><?php echo $record['invoice_no']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['image']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['current_month_amount']?> </td>  
  <td><?php echo $record['payble_through_rtgs']?> </td>  
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
 





if($os->get('WT_electric_billEditAndSave')=='OK')
{
 $electric_bill_id=$os->post('electric_bill_id');
 
 
		 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['consumer_id']=addslashes($os->post('consumer_id')); 
 $dataToSave['period_from']=$os->saveDate($os->post('period_from')); 
 $dataToSave['period_to']=$os->saveDate($os->post('period_to')); 
 $dataToSave['previous_unit']=addslashes($os->post('previous_unit')); 
 $dataToSave['present_unit']=addslashes($os->post('present_unit')); 
 $dataToSave['unit_consumed']=addslashes($os->post('unit_consumed')); 
 $dataToSave['rate']=addslashes($os->post('rate')); 
 $dataToSave['amount']=addslashes($os->post('amount')); 
 $dataToSave['bill_no']=addslashes($os->post('bill_no')); 
 $dataToSave['bill_date']=$os->saveDate($os->post('bill_date')); 
 $dataToSave['due_date']=$os->saveDate($os->post('due_date')); 
 $dataToSave['payment_status']=addslashes($os->post('payment_status')); 
 $dataToSave['payment_date']=$os->saveDate($os->post('payment_date')); 
 $dataToSave['payment_mode']=addslashes($os->post('payment_mode')); 
 $dataToSave['payment_details']=addslashes($os->post('payment_details')); 
 $dataToSave['invoice_no']=addslashes($os->post('invoice_no')); 
 $dataToSave['meter_no']=addslashes($os->post('meter_no')); 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}
 $dataToSave['current_month_amount']=addslashes($os->post('current_month_amount')); 
 $dataToSave['payble_through_rtgs']=addslashes($os->post('payble_through_rtgs')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($electric_bill_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('electric_bill',$dataToSave,'electric_bill_id',$electric_bill_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($electric_bill_id>0 ){ $mgs= " Data updated Successfully";}
		if($electric_bill_id<1 ){ $mgs= " Data Added Successfully"; $electric_bill_id=  $qResult;}
		
		  $mgs=$electric_bill_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_electric_billGetById')=='OK')
{
		$electric_bill_id=$os->post('electric_bill_id');
		
		if($electric_bill_id>0)	
		{
		$wheres=" where electric_bill_id='$electric_bill_id'";
		}
	    $dataQuery=" select * from electric_bill  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['branch_code']=$record['branch_code'];
 $record['consumer_id']=$record['consumer_id'];
 $record['period_from']=$os->showDate($record['period_from']); 
 $record['period_to']=$os->showDate($record['period_to']); 
 $record['previous_unit']=$record['previous_unit'];
 $record['present_unit']=$record['present_unit'];
 $record['unit_consumed']=$record['unit_consumed'];
 $record['rate']=$record['rate'];
 $record['amount']=$record['amount'];
 $record['bill_no']=$record['bill_no'];
 $record['bill_date']=$os->showDate($record['bill_date']); 
 $record['due_date']=$os->showDate($record['due_date']); 
 $record['payment_status']=$record['payment_status'];
 $record['payment_date']=$os->showDate($record['payment_date']); 
 $record['payment_mode']=$record['payment_mode'];
 $record['payment_details']=$record['payment_details'];
 $record['invoice_no']=$record['invoice_no'];
 $record['meter_no']=$record['meter_no'];
 if($record['image']!=''){
						$record['image']=$site['url'].$record['image'];}
 $record['current_month_amount']=$record['current_month_amount'];
 $record['payble_through_rtgs']=$record['payble_through_rtgs'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_electric_billDeleteRowById')=='OK')
{ 

$electric_bill_id=$os->post('electric_bill_id');
 if($electric_bill_id>0){
 $updateQuery="delete from electric_bill where electric_bill_id='$electric_bill_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
