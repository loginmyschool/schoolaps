<? 
/*
   # wtos version : 1.1
   # page called by ajax script in holidaysDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_holidaysListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andasession=  $os->postAndQuery('asession_s','asession','%');

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
$andevent=  $os->postAndQuery('event_s','event','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( asession like '%$searchKey%' Or event like '%$searchKey%' Or remarks like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from holidays where holidaysId>0   $where   $andasession  $anddated  $andevent  $andremarks     order by holidaysId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td style="display:none;"><b>Session</b></td>  
  <td ><b>Date</b></td>  
  <td ><b>Event</b></td>  
  <td ><b>Remarks</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_holidaysGetById('<? echo $record['holidaysId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td style="display:none;"><?php echo $record['asession']?> </td>  
  <td><?php echo $os->showDate($record['dated']);?> </td>  
  <td><?php echo $record['event']?> </td>  
  <td><?php echo $record['remarks']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_holidaysEditAndSave')=='OK')
{
 $holidaysId=$os->post('holidaysId');
 
 
		 
 $dataToSave['asession']=addslashes($os->post('asession')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['event']=addslashes($os->post('event')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($holidaysId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('holidays',$dataToSave,'holidaysId',$holidaysId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($holidaysId>0 ){ $mgs= " Data updated Successfully";}
		if($holidaysId<1 ){ $mgs= " Data Added Successfully"; $holidaysId=  $qResult;}
		
		  $mgs=$holidaysId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_holidaysGetById')=='OK')
{
		$holidaysId=$os->post('holidaysId');
		
		if($holidaysId>0)	
		{
		$wheres=" where holidaysId='$holidaysId'";
		}
	    $dataQuery=" select * from holidays  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['asession']=$record['asession'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['event']=$record['event'];
 $record['remarks']=$record['remarks'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_holidaysDeleteRowById')=='OK')
{ 

$holidaysId=$os->post('holidaysId');
 if($holidaysId>0){
 $updateQuery="delete from holidays where holidaysId='$holidaysId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
