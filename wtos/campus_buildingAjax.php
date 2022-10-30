<? 
/*
   # wtos version : 1.1
   # page called by ajax script in campus_buildingDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_campus_buildingListing')=='OK'){
		$where='';
		$showPerPage= $os->post('showPerPage');
		$andaddedBy=  $os->postAndQuery('addedBy_s','addedBy','='); 
		$andbuilding_name=  $os->postAndQuery('building_name_s','building_name','%');
		$andbranch_code=  $os->postAndQuery('branch_code_s','branch_code','%');
		$andnote=  $os->postAndQuery('note_s','note','%');
		$searchKey=$os->post('searchKey');
		if($searchKey!=''){
		$where ="and ( building_name like '%$searchKey%' Or branch_code like '%$searchKey%' Or note like '%$searchKey%' )";

		}

		$listingQuery="  select * from campus_building where campus_building_id>0   $where   $andbuilding_name  $andbranch_code  $andnote  $andaddedBy   order by campus_building_id desc";

		$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
		$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >

								<td >#</td>
								<td >Action </td>
								<td ><b>Building Name</b></td>  
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
								<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_campus_buildingGetById('<? echo $record['campus_building_id'];?>')" >Edit</a></span>  <? } ?>  </td>

								<td><?php echo $record['building_name']?> </td>  
								<td>  <? echo 
								$os->rowByField('branch_name','branch','branch_code',$record['branch_code']); ?></td> 
								<td><?php echo $record['note']?> </td>								
				 			</tr>
                          <?} ?>  
		</table> 
		</div>
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_campus_buildingEditAndSave')=='OK')
{
 $campus_building_id=$os->post('campus_building_id');
 
 
		 
 $dataToSave['building_name']=addslashes($os->post('building_name')); 
 $dataToSave['branch_code']=addslashes($os->post('branch_code')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($campus_building_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('campus_building',$dataToSave,'campus_building_id',$campus_building_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($campus_building_id>0 ){ $mgs= " Data updated Successfully";}
		if($campus_building_id<1 ){ $mgs= " Data Added Successfully"; $campus_building_id=  $qResult;}
		
		  $mgs=$campus_building_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_campus_buildingGetById')=='OK')
{
		$campus_building_id=$os->post('campus_building_id');
		
		if($campus_building_id>0)	
		{
		$wheres=" where campus_building_id='$campus_building_id'";
		}
	    $dataQuery=" select * from campus_building  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['building_name']=$record['building_name'];
 $record['branch_code']=$record['branch_code'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_campus_buildingDeleteRowById')=='OK')
{ 

$campus_building_id=$os->post('campus_building_id');
 if($campus_building_id>0){
 $updateQuery="delete from campus_building where campus_building_id='$campus_building_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
