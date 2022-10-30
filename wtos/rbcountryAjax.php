<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbcountryDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbcountryListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andcountryStatus=  $os->postAndQuery('countryStatus_s','countryStatus','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or countryStatus like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbcountry where rbcountryId>0   $where   $andname  $andcountryStatus     order by rbcountryId desc";
	  
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
  <td ><b>Country Status</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbcountryGetById('<? echo $record['rbcountryId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td> <? if(isset($os->activeInactive[$record['countryStatus']])){ echo  $os->activeInactive[$record['countryStatus']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbcountryEditAndSave')=='OK')
{
 $rbcountryId=$os->post('rbcountryId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['countryStatus']=addslashes($os->post('countryStatus')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbcountryId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbcountry',$dataToSave,'rbcountryId',$rbcountryId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbcountryId>0 ){ $mgs= " Data updated Successfully";}
		if($rbcountryId<1 ){ $mgs= " Data Added Successfully"; $rbcountryId=  $qResult;}
		
		  $mgs=$rbcountryId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbcountryGetById')=='OK')
{
		$rbcountryId=$os->post('rbcountryId');
		
		if($rbcountryId>0)	
		{
		$wheres=" where rbcountryId='$rbcountryId'";
		}
	    $dataQuery=" select * from rbcountry  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['countryStatus']=$record['countryStatus'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbcountryDeleteRowById')=='OK')
{ 

$rbcountryId=$os->post('rbcountryId');
 if($rbcountryId>0){
 $updateQuery="delete from rbcountry where rbcountryId='$rbcountryId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
