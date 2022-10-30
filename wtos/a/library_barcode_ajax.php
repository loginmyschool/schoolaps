<? 
/*
   # wtos version : 1.1
   # page called by ajax script in library_barcode.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_item_uniqueListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="
";
 
	}
		
	$listingQuery="  select * from item_unique where item_unique_id>0   $where      order by item_unique_id desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>item_id</b></td>  
  <td ><b>item_entry_detail_id</b></td>  
  <td ><b>is_ready</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_item_uniqueGetById('<? echo $record['item_unique_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['item_id']?> </td>  
  <td><?php echo $record['item_entry_detail_id']?> </td>  
  <td><?php echo $record['is_ready']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_item_uniqueEditAndSave')=='OK')
{
 $item_unique_id=$os->post('item_unique_id');
 
 
		 
 $dataToSave['is_ready']=addslashes($os->post('is_ready')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($item_unique_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('item_unique',$dataToSave,'item_unique_id',$item_unique_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($item_unique_id>0 ){ $mgs= " Data updated Successfully";}
		if($item_unique_id<1 ){ $mgs= " Data Added Successfully"; $item_unique_id=  $qResult;}
		
		  $mgs=$item_unique_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_item_uniqueGetById')=='OK')
{
		$item_unique_id=$os->post('item_unique_id');
		
		if($item_unique_id>0)	
		{
		$wheres=" where item_unique_id='$item_unique_id'";
		}
	    $dataQuery=" select * from item_unique  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['is_ready']=$record['is_ready'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_item_uniqueDeleteRowById')=='OK')
{ 

$item_unique_id=$os->post('item_unique_id');
 if($item_unique_id>0){
 $updateQuery="delete from item_unique where item_unique_id='$item_unique_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
