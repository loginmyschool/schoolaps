<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbserviceDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbserviceListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andserviceCode=  $os->postAndQuery('serviceCode_s','serviceCode','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or serviceCode like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbservice where rbserviceId>0   $where   $andname  $andserviceCode     order by rbserviceId desc";
	  
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
  <td ><b>Service Code</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbserviceGetById('<? echo $record['rbserviceId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $record['serviceCode']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbserviceEditAndSave')=='OK')
{
 $rbserviceId=$os->post('rbserviceId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['serviceCode']=addslashes($os->post('serviceCode')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbserviceId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbservice',$dataToSave,'rbserviceId',$rbserviceId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbserviceId>0 ){ $mgs= " Data updated Successfully";}
		if($rbserviceId<1 ){ $mgs= " Data Added Successfully"; $rbserviceId=  $qResult;}
		
		  $mgs=$rbserviceId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbserviceGetById')=='OK')
{
		$rbserviceId=$os->post('rbserviceId');
		
		if($rbserviceId>0)	
		{
		$wheres=" where rbserviceId='$rbserviceId'";
		}
	    $dataQuery=" select * from rbservice  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['serviceCode']=$record['serviceCode'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbserviceDeleteRowById')=='OK')
{ 

$rbserviceId=$os->post('rbserviceId');
 if($rbserviceId>0){
 $updateQuery="delete from rbservice where rbserviceId='$rbserviceId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
