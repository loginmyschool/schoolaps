<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbpaymentDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbpaymentListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrbreminderId=  $os->postAndQuery('rbreminderId_s','rbreminderId','%');
$andpaidAmount=  $os->postAndQuery('paidAmount_s','paidAmount','%');

    $f_paidDate_s= $os->post('f_paidDate_s'); $t_paidDate_s= $os->post('t_paidDate_s');
   $andpaidDate=$os->DateQ('paidDate',$f_paidDate_s,$t_paidDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andmethod=  $os->postAndQuery('method_s','method','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( rbreminderId like '%$searchKey%' Or paidAmount like '%$searchKey%' Or method like '%$searchKey%' Or remarks like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from rbpayment where rbpaymentId>0   $where   $andrbreminderId  $andpaidAmount  $andpaidDate  $andmethod  $andremarks     order by rbpaymentId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>rbreminderId</b></td>  
  <td ><b>paidAmount</b></td>  
  <td ><b>paidDate</b></td>  
  <td ><b>method</b></td>  
  <td ><b>remarks</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbpaymentGetById('<? echo $record['rbpaymentId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td>  <? echo 
	$os->rowByField('reminderType','rbreminder','rbreminderId',$record['rbreminderId']); ?></td> 
  <td><?php echo $record['paidAmount']?> </td>  
  <td><?php echo $os->showDate($record['paidDate']);?> </td>  
  <td><?php echo $record['method']?> </td>  
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
 





if($os->get('WT_rbpaymentEditAndSave')=='OK')
{
 $rbpaymentId=$os->post('rbpaymentId');
 
 
		 
 $dataToSave['paidAmount']=addslashes($os->post('paidAmount')); 
 $dataToSave['paidDate']=$os->saveDate($os->post('paidDate')); 
 $dataToSave['method']=addslashes($os->post('method')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbpaymentId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbpayment',$dataToSave,'rbpaymentId',$rbpaymentId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbpaymentId>0 ){ $mgs= " Data updated Successfully";}
		if($rbpaymentId<1 ){ $mgs= " Data Added Successfully"; $rbpaymentId=  $qResult;}
		
		  $mgs=$rbpaymentId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbpaymentGetById')=='OK')
{
		$rbpaymentId=$os->post('rbpaymentId');
		
		if($rbpaymentId>0)	
		{
		$wheres=" where rbpaymentId='$rbpaymentId'";
		}
	    $dataQuery=" select * from rbpayment  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['paidAmount']=$record['paidAmount'];
 $record['paidDate']=$os->showDate($record['paidDate']); 
 $record['method']=$record['method'];
 $record['remarks']=$record['remarks'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbpaymentDeleteRowById')=='OK')
{ 

$rbpaymentId=$os->post('rbpaymentId');
 if($rbpaymentId>0){
 $updateQuery="delete from rbpayment where rbpaymentId='$rbpaymentId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
