<? 
/*
   # wtos version : 1.1
   # page called by ajax script in travel_driverDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_travel_driverListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andaddress=  $os->postAndQuery('address_s','address','%');
$andcontact=  $os->postAndQuery('contact_s','contact','%');
$andidcard_details=  $os->postAndQuery('idcard_details_s','idcard_details','%');
$andprovider_type=  $os->postAndQuery('provider_type_s','provider_type','%');
$andprovider_name=  $os->postAndQuery('provider_name_s','provider_name','%');
$andprovider_details=  $os->postAndQuery('provider_details_s','provider_details','%');
$andactive_status=  $os->postAndQuery('active_status_s','active_status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or address like '%$searchKey%' Or contact like '%$searchKey%' Or idcard_details like '%$searchKey%' Or provider_type like '%$searchKey%' Or provider_name like '%$searchKey%' Or provider_details like '%$searchKey%' Or active_status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from travel_driver where travel_driver_id>0   $where   $andname  $andaddress  $andcontact  $andidcard_details  $andprovider_type  $andprovider_name  $andprovider_details  $andactive_status     order by travel_driver_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Name</b></td>  
  <td ><b>Address</b></td>  
  <td ><b>Contact</b></td>  
  <td ><b>Driving License</b></td>  
  <td ><b>Idcard Details</b></td>  
  <td ><b>Provider Type</b></td>  
  <td ><b>Provider Name</b></td>  
  <td ><b>Provider Details</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_travel_driverGetById('<? echo $record['travel_driver_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $record['address']?> </td>  
  <td><?php echo $record['contact']?> </td>  
  <td><img src="<?php  echo $site['url'].$record['driving_license']; ?>"  height="70" width="70" /></td>  
  <td><?php echo $record['idcard_details']?> </td>  
  <td> <? if(isset($os->provider_type[$record['provider_type']])){ echo  $os->provider_type[$record['provider_type']]; } ?></td> 
  <td><?php echo $record['provider_name']?> </td>  
  <td><?php echo $record['provider_details']?> </td>  
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
 





if($os->get('WT_travel_driverEditAndSave')=='OK')
{
 $travel_driver_id=$os->post('travel_driver_id');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['address']=addslashes($os->post('address')); 
 $dataToSave['contact']=addslashes($os->post('contact')); 
 $driving_license=$os->UploadPhoto('driving_license',$site['root'].'wtos-images');
				   	if($driving_license!=''){
					$dataToSave['driving_license']='wtos-images/'.$driving_license;}
 $dataToSave['idcard_details']=addslashes($os->post('idcard_details')); 
 $dataToSave['provider_type']=addslashes($os->post('provider_type')); 
 $dataToSave['provider_name']=addslashes($os->post('provider_name')); 
 $dataToSave['provider_details']=addslashes($os->post('provider_details')); 
 $dataToSave['active_status']=addslashes($os->post('active_status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($travel_driver_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('travel_driver',$dataToSave,'travel_driver_id',$travel_driver_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($travel_driver_id>0 ){ $mgs= " Data updated Successfully";}
		if($travel_driver_id<1 ){ $mgs= " Data Added Successfully"; $travel_driver_id=  $qResult;}
		
		  $mgs=$travel_driver_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_travel_driverGetById')=='OK')
{
		$travel_driver_id=$os->post('travel_driver_id');
		
		if($travel_driver_id>0)	
		{
		$wheres=" where travel_driver_id='$travel_driver_id'";
		}
	    $dataQuery=" select * from travel_driver  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['address']=$record['address'];
 $record['contact']=$record['contact'];
 if($record['driving_license']!=''){
						$record['driving_license']=$site['url'].$record['driving_license'];}
 $record['idcard_details']=$record['idcard_details'];
 $record['provider_type']=$record['provider_type'];
 $record['provider_name']=$record['provider_name'];
 $record['provider_details']=$record['provider_details'];
 $record['active_status']=$record['active_status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_travel_driverDeleteRowById')=='OK')
{ 

$travel_driver_id=$os->post('travel_driver_id');
 if($travel_driver_id>0){
 $updateQuery="delete from travel_driver where travel_driver_id='$travel_driver_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
