<? 
/*
   # wtos version : 1.1
   # page called by ajax script in travel_detailsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_travel_detailsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andteacherId=  $os->postAndQuery('teacherId_s','teacherId','%');
$andpurpose=  $os->postAndQuery('purpose_s','purpose','%');
$andtraveller_names=  $os->postAndQuery('traveller_names_s','traveller_names','%');
$andsource=  $os->postAndQuery('source_s','source','%');
$anddestination=  $os->postAndQuery('destination_s','destination','%');

    $f_start_date_s= $os->post('f_start_date_s'); $t_start_date_s= $os->post('t_start_date_s');
   $andstart_date=$os->DateQ('start_date',$f_start_date_s,$t_start_date_s,$sTime='00:00:00',$eTime='59:59:59');

    $f_end_date_s= $os->post('f_end_date_s'); $t_end_date_s= $os->post('t_end_date_s');
   $andend_date=$os->DateQ('end_date',$f_end_date_s,$t_end_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andstart_meter_reading=  $os->postAndQuery('start_meter_reading_s','start_meter_reading','%');
$andend_meter_reading=  $os->postAndQuery('end_meter_reading_s','end_meter_reading','%');
$anddistance_traveled=  $os->postAndQuery('distance_traveled_s','distance_traveled','%');
$andvehicle_regno=  $os->postAndQuery('vehicle_regno_s','vehicle_regno','%');
$andvehicle_model=  $os->postAndQuery('vehicle_model_s','vehicle_model','%');
$andvehicle_make=  $os->postAndQuery('vehicle_make_s','vehicle_make','%');
$andrate_per_km=  $os->postAndQuery('rate_per_km_s','rate_per_km','%');
$andtotal_km=  $os->postAndQuery('total_km_s','total_km','%');
$andprice_on_km=  $os->postAndQuery('price_on_km_s','price_on_km','%');
$andrate_per_hour=  $os->postAndQuery('rate_per_hour_s','rate_per_hour','%');
$andtotal_hour=  $os->postAndQuery('total_hour_s','total_hour','%');
$andprice_on_hour=  $os->postAndQuery('price_on_hour_s','price_on_hour','%');
$andcotract_price=  $os->postAndQuery('cotract_price_s','cotract_price','%');
$andfuel_price=  $os->postAndQuery('fuel_price_s','fuel_price','%');
$andother_price_details=  $os->postAndQuery('other_price_details_s','other_price_details','%');
$andother_price=  $os->postAndQuery('other_price_s','other_price','%');
$andtotal_price=  $os->postAndQuery('total_price_s','total_price','%');
$andstatus_approved=  $os->postAndQuery('status_approved_s','status_approved','%');
$andstatus_paid=  $os->postAndQuery('status_paid_s','status_paid','%');
$andpayment_reference=  $os->postAndQuery('payment_reference_s','payment_reference','%');

    $f_paid_date_s= $os->post('f_paid_date_s'); $t_paid_date_s= $os->post('t_paid_date_s');
   $andpaid_date=$os->DateQ('paid_date',$f_paid_date_s,$t_paid_date_s,$sTime='00:00:00',$eTime='59:59:59');
$andactive_status=  $os->postAndQuery('active_status_s','active_status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( teacherId like '%$searchKey%' Or purpose like '%$searchKey%' Or traveller_names like '%$searchKey%' Or source like '%$searchKey%' Or destination like '%$searchKey%' Or start_meter_reading like '%$searchKey%' Or end_meter_reading like '%$searchKey%' Or distance_traveled like '%$searchKey%' Or vehicle_regno like '%$searchKey%' Or vehicle_model like '%$searchKey%' Or vehicle_make like '%$searchKey%' Or rate_per_km like '%$searchKey%' Or total_km like '%$searchKey%' Or price_on_km like '%$searchKey%' Or rate_per_hour like '%$searchKey%' Or total_hour like '%$searchKey%' Or price_on_hour like '%$searchKey%' Or cotract_price like '%$searchKey%' Or fuel_price like '%$searchKey%' Or other_price_details like '%$searchKey%' Or other_price like '%$searchKey%' Or total_price like '%$searchKey%' Or status_approved like '%$searchKey%' Or status_paid like '%$searchKey%' Or payment_reference like '%$searchKey%' Or active_status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from travel_details where travel_details_id>0   $where   $andteacherId  $andpurpose  $andtraveller_names  $andsource  $anddestination  $andstart_date  $andend_date  $andstart_meter_reading  $andend_meter_reading  $anddistance_traveled  $andvehicle_regno  $andvehicle_model  $andvehicle_make  $andrate_per_km  $andtotal_km  $andprice_on_km  $andrate_per_hour  $andtotal_hour  $andprice_on_hour  $andcotract_price  $andfuel_price  $andother_price_details  $andother_price  $andtotal_price  $andstatus_approved  $andstatus_paid  $andpayment_reference  $andpaid_date  $andactive_status     order by travel_details_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Driver</b></td>  
  <td ><b>Purpose</b></td>  
  <td ><b>Traveller Names</b></td>  
  <td ><b>Source</b></td>  
  <td ><b>Destination</b></td>  
  <td ><b>Start Date</b></td>  
  <td ><b>End Date</b></td>  
  <td ><b>Start Meter Reading</b></td>  
  <td ><b>End Meter Reading</b></td>  
  <td ><b>Distance Traveled</b></td>  
  <td ><b>Vehicl Reg No</b></td>  
  <td ><b>Vehicle Model</b></td>  
  <td ><b>Vehicle Make</b></td>  
  <td ><b>Rate Per (km)</b></td>  
  <td ><b>Total (km)</b></td>  
  <td ><b>Price On (km)</b></td>  
  <td ><b>Rate/hour</b></td>  
  <td ><b>Total Hour</b></td>  
  <td ><b>Price On Hour</b></td>  
  <td ><b>Cotract Price</b></td>  
  <td ><b>Fuel Price</b></td>  
  <td ><b>Other Price Details</b></td>  
  <td ><b>Other Price</b></td>  
  <td ><b>Total Price</b></td>  
  <td ><b>Approved Status</b></td>  
  <td ><b>Paid Status</b></td>  
  <td ><b>Payment Reference</b></td>  
  <td ><b>Paid Date</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_travel_detailsGetById('<? echo $record['travel_details_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('name','teacher','teacherId',$record['teacherId']); ?></td> 
  <td><?php echo $record['purpose']?> </td>  
  <td><?php echo $record['traveller_names']?> </td>  
  <td><?php echo $record['source']?> </td>  
  <td><?php echo $record['destination']?> </td>  
  <td><?php echo $os->showDate($record['start_date']);?> </td>  
  <td><?php echo $os->showDate($record['end_date']);?> </td>  
  <td><?php echo $record['start_meter_reading']?> </td>  
  <td><?php echo $record['end_meter_reading']?> </td>  
  <td><?php echo $record['distance_traveled']?> </td>  
  <td><?php echo $record['vehicle_regno']?> </td>  
  <td><?php echo $record['vehicle_model']?> </td>  
  <td><?php echo $record['vehicle_make']?> </td>  
  <td><?php echo $record['rate_per_km']?> </td>  
  <td><?php echo $record['total_km']?> </td>  
  <td><?php echo $record['price_on_km']?> </td>  
  <td><?php echo $record['rate_per_hour']?> </td>  
  <td><?php echo $record['total_hour']?> </td>  
  <td><?php echo $record['price_on_hour']?> </td>  
  <td><?php echo $record['cotract_price']?> </td>  
  <td><?php echo $record['fuel_price']?> </td>  
  <td><?php echo $record['other_price_details']?> </td>  
  <td><?php echo $record['other_price']?> </td>  
  <td><?php echo $record['total_price']?> </td>  
  <td> <? if(isset($os->travel_approved_status[$record['status_approved']])){ echo  $os->travel_approved_status[$record['status_approved']]; } ?></td> 
  <td> <? if(isset($os->travel_paid_status[$record['status_paid']])){ echo  $os->travel_paid_status[$record['status_paid']]; } ?></td> 
  <td><?php echo $record['payment_reference']?> </td>  
  <td><?php echo $os->showDate($record['paid_date']);?> </td>  
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
 





if($os->get('WT_travel_detailsEditAndSave')=='OK')
{
 $travel_details_id=$os->post('travel_details_id');
 
 
		 
 $dataToSave['teacherId']=addslashes($os->post('teacherId')); 
 $dataToSave['purpose']=addslashes($os->post('purpose')); 
 $dataToSave['traveller_names']=addslashes($os->post('traveller_names')); 
 $dataToSave['source']=addslashes($os->post('source')); 
 $dataToSave['destination']=addslashes($os->post('destination')); 
 $dataToSave['start_date']=$os->saveDate($os->post('start_date')); 
 $dataToSave['end_date']=$os->saveDate($os->post('end_date')); 
 $dataToSave['start_meter_reading']=addslashes($os->post('start_meter_reading')); 
 $dataToSave['end_meter_reading']=addslashes($os->post('end_meter_reading')); 
 $dataToSave['distance_traveled']=addslashes($os->post('distance_traveled')); 
 $dataToSave['vehicle_regno']=addslashes($os->post('vehicle_regno')); 
 $dataToSave['vehicle_model']=addslashes($os->post('vehicle_model')); 
 $dataToSave['vehicle_make']=addslashes($os->post('vehicle_make')); 
 $dataToSave['rate_per_km']=addslashes($os->post('rate_per_km')); 
 $dataToSave['total_km']=addslashes($os->post('total_km')); 
 $dataToSave['price_on_km']=addslashes($os->post('price_on_km')); 
 $dataToSave['rate_per_hour']=addslashes($os->post('rate_per_hour')); 
 $dataToSave['total_hour']=addslashes($os->post('total_hour')); 
 $dataToSave['price_on_hour']=addslashes($os->post('price_on_hour')); 
 $dataToSave['cotract_price']=addslashes($os->post('cotract_price')); 
 $dataToSave['fuel_price']=addslashes($os->post('fuel_price')); 
 $dataToSave['other_price_details']=addslashes($os->post('other_price_details')); 
 $dataToSave['other_price']=addslashes($os->post('other_price')); 
 $dataToSave['total_price']=addslashes($os->post('total_price')); 
 $dataToSave['status_approved']=addslashes($os->post('status_approved')); 
 $dataToSave['status_paid']=addslashes($os->post('status_paid')); 
 $dataToSave['payment_reference']=addslashes($os->post('payment_reference')); 
 $dataToSave['paid_date']=$os->saveDate($os->post('paid_date')); 
 $dataToSave['active_status']=addslashes($os->post('active_status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($travel_details_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('travel_details',$dataToSave,'travel_details_id',$travel_details_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($travel_details_id>0 ){ $mgs= " Data updated Successfully";}
		if($travel_details_id<1 ){ $mgs= " Data Added Successfully"; $travel_details_id=  $qResult;}
		
		  $mgs=$travel_details_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_travel_detailsGetById')=='OK')
{
		$travel_details_id=$os->post('travel_details_id');
		
		if($travel_details_id>0)	
		{
		$wheres=" where travel_details_id='$travel_details_id'";
		}
	    $dataQuery=" select * from travel_details  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['teacherId']=$record['teacherId'];
 $record['purpose']=$record['purpose'];
 $record['traveller_names']=$record['traveller_names'];
 $record['source']=$record['source'];
 $record['destination']=$record['destination'];
 $record['start_date']=$os->showDate($record['start_date']); 
 $record['end_date']=$os->showDate($record['end_date']); 
 $record['start_meter_reading']=$record['start_meter_reading'];
 $record['end_meter_reading']=$record['end_meter_reading'];
 $record['distance_traveled']=$record['distance_traveled'];
 $record['vehicle_regno']=$record['vehicle_regno'];
 $record['vehicle_model']=$record['vehicle_model'];
 $record['vehicle_make']=$record['vehicle_make'];
 $record['rate_per_km']=$record['rate_per_km'];
 $record['total_km']=$record['total_km'];
 $record['price_on_km']=$record['price_on_km'];
 $record['rate_per_hour']=$record['rate_per_hour'];
 $record['total_hour']=$record['total_hour'];
 $record['price_on_hour']=$record['price_on_hour'];
 $record['cotract_price']=$record['cotract_price'];
 $record['fuel_price']=$record['fuel_price'];
 $record['other_price_details']=$record['other_price_details'];
 $record['other_price']=$record['other_price'];
 $record['total_price']=$record['total_price'];
 $record['status_approved']=$record['status_approved'];
 $record['status_paid']=$record['status_paid'];
 $record['payment_reference']=$record['payment_reference'];
 $record['paid_date']=$os->showDate($record['paid_date']); 
 $record['active_status']=$record['active_status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_travel_detailsDeleteRowById')=='OK')
{ 

$travel_details_id=$os->post('travel_details_id');
 if($travel_details_id>0){
 $updateQuery="delete from travel_details where travel_details_id='$travel_details_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
