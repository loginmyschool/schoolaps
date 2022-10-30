<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rblocationDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rblocationListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andlocationStatus=  $os->postAndQuery('locationStatus_s','locationStatus','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or locationStatus like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rblocation where rblocationId>0   $where   $andname  $andlocationStatus     order by rblocationId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>name</b></td>  
  <td ><b>location Status</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rblocationGetById('<? echo $record['rblocationId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td> <? if(isset($os->activeInactive[$record['locationStatus']])){ echo  $os->activeInactive[$record['locationStatus']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rblocationEditAndSave')=='OK')
{
 $rblocationId=$os->post('rblocationId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['locationStatus']=addslashes($os->post('locationStatus')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rblocationId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rblocation',$dataToSave,'rblocationId',$rblocationId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rblocationId>0 ){ $mgs= " Data updated Successfully";}
		if($rblocationId<1 ){ $mgs= " Data Added Successfully"; $rblocationId=  $qResult;}
		
		  $mgs=$rblocationId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rblocationGetById')=='OK')
{
		$rblocationId=$os->post('rblocationId');
		
		if($rblocationId>0)	
		{
		$wheres=" where rblocationId='$rblocationId'";
		}
	    $dataQuery=" select * from rblocation  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['locationStatus']=$record['locationStatus'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rblocationDeleteRowById')=='OK')
{ 

$rblocationId=$os->post('rblocationId');
 if($rblocationId>0){
 $updateQuery="delete from rblocation where rblocationId='$rblocationId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
