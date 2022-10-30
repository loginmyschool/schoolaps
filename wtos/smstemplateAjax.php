<? 
/*
   # wtos version : 1.1
   # page called by ajax script in smstemplateDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_smstemplateListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andtemplatekey=  $os->postAndQuery('templatekey_s','templatekey','%');
$andtext=  $os->postAndQuery('text_s','text','%');
$andtemplatestatus=  $os->postAndQuery('templatestatus_s','templatestatus','%');
$andtemplateorder=  $os->postAndQuery('templateorder_s','templateorder','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( templatekey like '%$searchKey%' Or text like '%$searchKey%' Or templatestatus like '%$searchKey%' Or templateorder like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from smstemplate where smstemplateId>0   $where   $andtemplatekey  $andtext  $andtemplatestatus  $andtemplateorder     order by smstemplateId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Key</b></td>  
  <td ><b>Text</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Order</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_smstemplateGetById('<? echo $record['smstemplateId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['templatekey']?> </td>  
  <td><?php echo $record['text']?> </td>  
  <td> <? if(isset($os->templatestatus[$record['templatestatus']])){ echo  $os->templatestatus[$record['templatestatus']]; } ?></td> 
  <td><?php echo $record['templateorder']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_smstemplateEditAndSave')=='OK')
{
 $smstemplateId=$os->post('smstemplateId');
 
 
		 
 $dataToSave['templatekey']=addslashes($os->post('templatekey')); 
 $dataToSave['text']=addslashes($os->post('text')); 
 $dataToSave['templatestatus']=addslashes($os->post('templatestatus')); 
 $dataToSave['templateorder']=addslashes($os->post('templateorder')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($smstemplateId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('smstemplate',$dataToSave,'smstemplateId',$smstemplateId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($smstemplateId>0 ){ $mgs= " Data updated Successfully";}
		if($smstemplateId<1 ){ $mgs= " Data Added Successfully"; $smstemplateId=  $qResult;}
		
		  $mgs=$smstemplateId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_smstemplateGetById')=='OK')
{
		$smstemplateId=$os->post('smstemplateId');
		
		if($smstemplateId>0)	
		{
		$wheres=" where smstemplateId='$smstemplateId'";
		}
	    $dataQuery=" select * from smstemplate  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['templatekey']=$record['templatekey'];
 $record['text']=$record['text'];
 $record['templatestatus']=$record['templatestatus'];
 $record['templateorder']=$record['templateorder'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_smstemplateDeleteRowById')=='OK')
{ 

$smstemplateId=$os->post('smstemplateId');
 if($smstemplateId>0){
 $updateQuery="delete from smstemplate where smstemplateId='$smstemplateId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
