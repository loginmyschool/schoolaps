<? 
/*
   # wtos version : 1.1
   # page called by ajax script in vehicle_configDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_vehicle_configListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andvehicle_type=  $os->postAndQuery('vehicle_type_s','vehicle_type','%');
$andvehicle_distance=  $os->postAndQuery('vehicle_distance_s','vehicle_distance','%');
$andvehicle_price=  $os->postAndQuery('vehicle_price_s','vehicle_price','%');
$andasession=  $os->postAndQuery('asession_s','asession','%');
$andclass_id=  $os->postAndQuery('class_id_s','class_id','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( vehicle_type like '%$searchKey%' Or vehicle_distance like '%$searchKey%' Or vehicle_price like '%$searchKey%' Or asession like '%$searchKey%' Or class_id like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from vehicle_config where vehicle_config_id>0   $where   $andvehicle_type  $andvehicle_distance  $andvehicle_price  $andasession  $andclass_id     order by vehicle_config_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>vehicle type</b></td>  
  <td ><b>vehicle distance</b></td>  
  <td ><b>vehicle price</b></td>  
  <td ><b>asession</b></td>  
  <td ><b>class</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_vehicle_configGetById('<? echo $record['vehicle_config_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['vehicle_type']?> </td>  
  <td><?php echo $record['vehicle_distance']?> </td>  
  <td><?php echo $record['vehicle_price']?> </td>  
  <td><?php echo $record['asession']?> </td>  
  <td> <? if(isset($os->classList[$record['class_id']])){ echo  $os->classList[$record['class_id']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_vehicle_configEditAndSave')=='OK')
{
 $vehicle_config_id=$os->post('vehicle_config_id');
 
 
		 
 $dataToSave['vehicle_type']=addslashes($os->post('vehicle_type')); 
 $dataToSave['vehicle_distance']=addslashes($os->post('vehicle_distance')); 
 $dataToSave['vehicle_price']=addslashes($os->post('vehicle_price')); 
 $dataToSave['asession']=addslashes($os->post('asession')); 
 $dataToSave['class_id']=addslashes($os->post('class_id')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($vehicle_config_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('vehicle_config',$dataToSave,'vehicle_config_id',$vehicle_config_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($vehicle_config_id>0 ){ $mgs= " Data updated Successfully";}
		if($vehicle_config_id<1 ){ $mgs= " Data Added Successfully"; $vehicle_config_id=  $qResult;}
		
		  $mgs=$vehicle_config_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_vehicle_configGetById')=='OK')
{
		$vehicle_config_id=$os->post('vehicle_config_id');
		
		if($vehicle_config_id>0)	
		{
		$wheres=" where vehicle_config_id='$vehicle_config_id'";
		}
	    $dataQuery=" select * from vehicle_config  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['vehicle_type']=$record['vehicle_type'];
 $record['vehicle_distance']=$record['vehicle_distance'];
 $record['vehicle_price']=$record['vehicle_price'];
 $record['asession']=$record['asession'];
 $record['class_id']=$record['class_id'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_vehicle_configDeleteRowById')=='OK')
{ 

$vehicle_config_id=$os->post('vehicle_config_id');
 if($vehicle_config_id>0){
 $updateQuery="delete from vehicle_config where vehicle_config_id='$vehicle_config_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
