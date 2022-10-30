<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbcmpmDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbcmpmListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	

    $f_cmpmDate_s= $os->post('f_cmpmDate_s'); $t_cmpmDate_s= $os->post('t_cmpmDate_s');
   $andcmpmDate=$os->DateQ('cmpmDate',$f_cmpmDate_s,$t_cmpmDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andrbemployeeId=  $os->postAndQuery('rbemployeeId_s','rbemployeeId','%');

    $f_visitDate_s= $os->post('f_visitDate_s'); $t_visitDate_s= $os->post('t_visitDate_s');
   $andvisitDate=$os->DateQ('visitDate',$f_visitDate_s,$t_visitDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andcmpmStatus=  $os->postAndQuery('cmpmStatus_s','cmpmStatus','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( rbemployeeId like '%$searchKey%' Or cmpmStatus like '%$searchKey%' Or remarks like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbcmpm where rbcmpmId>0   $where   $andcmpmDate  $andrbemployeeId  $andvisitDate  $andcmpmStatus  $andremarks     order by rbcmpmId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Date</b></td>  
  <td ><b>Employee</b></td>  
  <td ><b>Visit Date</b></td>  
  <td ><b>PM Status</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbcmpmGetById('<? echo $record['rbcmpmId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $os->showDate($record['cmpmDate']);?> </td>  
  <td>  <? echo 
	$os->rowByField('name','rbemployee','rbemployeeId',$record['rbemployeeId']); ?></td> 
  <td><?php echo $os->showDate($record['visitDate']);?> </td>  
  <td> <? if(isset($os->cmpmStatus[$record['cmpmStatus']])){ echo  $os->cmpmStatus[$record['cmpmStatus']]; } ?></td> 
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
 





if($os->get('WT_rbcmpmEditAndSave')=='OK')
{
 $rbcmpmId=$os->post('rbcmpmId');
 
 
		 
 $dataToSave['cmpmDate']=$os->saveDate($os->post('cmpmDate')); 
 $dataToSave['alertDate']=$os->saveDate($os->post('alertDate')); 
 $dataToSave['rbemployeeId']=addslashes($os->post('rbemployeeId')); 
 $dataToSave['visitDate']=$os->saveDate($os->post('visitDate')); 
 $dataToSave['cmpmStatus']=addslashes($os->post('cmpmStatus')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbcmpmId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbcmpm',$dataToSave,'rbcmpmId',$rbcmpmId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbcmpmId>0 ){ $mgs= " Data updated Successfully";}
		if($rbcmpmId<1 ){ $mgs= " Data Added Successfully"; $rbcmpmId=  $qResult;}
		
		  $mgs=$rbcmpmId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbcmpmGetById')=='OK')
{
		$rbcmpmId=$os->post('rbcmpmId');
		
		if($rbcmpmId>0)	
		{
		$wheres=" where rbcmpmId='$rbcmpmId'";
		}
	    $dataQuery=" select * from rbcmpm  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['cmpmDate']=$os->showDate($record['cmpmDate']); 
 $record['alertDate']=$os->showDate($record['alertDate']); 
 $record['rbemployeeId']=$record['rbemployeeId'];
 $record['visitDate']=$os->showDate($record['visitDate']); 
 $record['cmpmStatus']=$record['cmpmStatus'];
 $record['remarks']=$record['remarks'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbcmpmDeleteRowById')=='OK')
{ 

$rbcmpmId=$os->post('rbcmpmId');
 if($rbcmpmId>0){
 $updateQuery="delete from rbcmpm where rbcmpmId='$rbcmpmId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
