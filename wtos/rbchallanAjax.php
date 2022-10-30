<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbchallanDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbchallanListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');
$andchallanNo=  $os->postAndQuery('challanNo_s','challanNo','%');
$andbillNo=  $os->postAndQuery('billNo_s','billNo','%');

    $f_challanDate_s= $os->post('f_challanDate_s'); $t_challanDate_s= $os->post('t_challanDate_s');
   $andchallanDate=$os->DateQ('challanDate',$f_challanDate_s,$t_challanDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andagentName=  $os->postAndQuery('agentName_s','agentName','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or challanNo like '%$searchKey%' Or billNo like '%$searchKey%' Or agentName like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbchallan where rbchallanId>0   $where   $andrefCode  $andchallanNo  $andbillNo  $andchallanDate  $andagentName     order by rbchallanId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Reffer Code</b></td>  
  <td ><b>Challan No</b></td>  
  <td ><b>Bill No</b></td>  
  <td ><b>Challan Date</b></td>  
  <td ><b>Agent Name</b></td>  
  <td ><b>Payment Status</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbchallanGetById('<? echo $record['rbchallanId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['refCode']?> </td>  
  <td><?php echo $record['challanNo']?> </td>  
  <td><?php echo $record['billNo']?> </td>  
  <td><?php echo $os->showDate($record['challanDate']);?> </td>  
  <td><?php echo $record['agentName']?> </td>  
  <td> <? if(isset($os->paymentStatusChallan[$record['paymentStatus']])){ echo  $os->paymentStatusChallan[$record['paymentStatus']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbchallanEditAndSave')=='OK')
{
 $rbchallanId=$os->post('rbchallanId');
 
 
		 
 $dataToSave['refCode']=addslashes($os->post('refCode')); 
 $dataToSave['challanNo']=addslashes($os->post('challanNo')); 
 $dataToSave['billNo']=addslashes($os->post('billNo')); 
 $dataToSave['challanDate']=$os->saveDate($os->post('challanDate')); 
 $dataToSave['agentName']=addslashes($os->post('agentName')); 
 $dataToSave['agentDetails']=addslashes($os->post('agentDetails')); 
 $dataToSave['paymentStatus']=addslashes($os->post('paymentStatus')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbchallanId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbchallan',$dataToSave,'rbchallanId',$rbchallanId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbchallanId>0 ){ $mgs= " Data updated Successfully";}
		if($rbchallanId<1 ){ $mgs= " Data Added Successfully"; $rbchallanId=  $qResult;}
		
		  $mgs=$rbchallanId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbchallanGetById')=='OK')
{
		$rbchallanId=$os->post('rbchallanId');
		
		if($rbchallanId>0)	
		{
		$wheres=" where rbchallanId='$rbchallanId'";
		}
	    $dataQuery=" select * from rbchallan  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['refCode']=$record['refCode'];
 $record['challanNo']=$record['challanNo'];
 $record['billNo']=$record['billNo'];
 $record['challanDate']=$os->showDate($record['challanDate']); 
 $record['agentName']=$record['agentName'];
 $record['agentDetails']=$record['agentDetails'];
 $record['paymentStatus']=$record['paymentStatus'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbchallanDeleteRowById')=='OK')
{ 

$rbchallanId=$os->post('rbchallanId');
 if($rbchallanId>0){
 $updateQuery="delete from rbchallan where rbchallanId='$rbchallanId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
