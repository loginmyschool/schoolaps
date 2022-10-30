<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbsbillquoteDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbsbillquoteListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');

    $f_rbsbillquoteDate_s= $os->post('f_rbsbillquoteDate_s'); $t_rbsbillquoteDate_s= $os->post('t_rbsbillquoteDate_s');
   $andrbsbillquoteDate=$os->DateQ('rbsbillquoteDate',$f_rbsbillquoteDate_s,$t_rbsbillquoteDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andrbcontactId=  $os->postAndQuery('rbcontactId_s','rbcontactId','=');
$andorderNo=  $os->postAndQuery('orderNo_s','orderNo','%');
$andbillNo=  $os->postAndQuery('billNo_s','billNo','%');
$andbillSubject=  $os->postAndQuery('billSubject_s','billSubject','%');
$andrbemployeeId=  $os->postAndQuery('rbemployeeId_s','rbemployeeId','=');

    $f_expiryDate_s= $os->post('f_expiryDate_s'); $t_expiryDate_s= $os->post('t_expiryDate_s');
   $andexpiryDate=$os->DateQ('expiryDate',$f_expiryDate_s,$t_expiryDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andreminderStatus=  $os->postAndQuery('reminderStatus_s','reminderStatus','%');

	   
	$searchKey=$os->post('searchKey');
	
	
	$rbcontactIds= $os->searchKeyGetIds($searchKey,'rbcontact','rbcontactId',$whereCondition='',$searchFields='');
	$orrbcontactId='';
	if($rbcontactIds!='')
	{
	   $orrbcontactId= " or  rbcontactId IN ( $rbcontactIds) ";
	}

	
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or rbcontactId like '%$searchKey%' Or orderNo like '%$searchKey%' Or billNo like '%$searchKey%' Or billSubject like '%$searchKey%' Or rbemployeeId like '%$searchKey%' Or reminderStatus like '%$searchKey%' ) $orrbcontactId";
 
	}
		
	$listingQuery="  select * from rbsbillquote where rbsbillquoteId>0   $where   $andrefCode  $andrbsbillquoteDate  $andrbcontactId  $andorderNo  $andbillNo  $andbillSubject  $andrbemployeeId  $andexpiryDate  $andreminderStatus     order by rbsbillquoteId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	$contactList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Reffer Code</b></td>  
  <td ><b>Quotation Date</b></td>  
  <td ><b>Contacts</b></td>  
  <td ><b>Order No</b></td>  
  <td ><b>Bill No</b></td>  
  <td ><b>Bill Subject</b></td>  
  <td ><b>Employee</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbsbillquoteGetById('<? echo $record['rbsbillquoteId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['refCode']?> </td>  
  <td><?php echo $os->showDate($record['rbsbillquoteDate']);?> </td>  
  <td> <? $os->showContact($contactList[$record['rbcontactId']]); ?></td> 
  <td><?php echo $record['orderNo']?> </td>  
  <td><?php echo $record['billNo']?> </td>  
  <td><?php echo $record['billSubject']?> </td>  
  <td>  <? echo 
	$os->rowByField('name','rbemployee','rbemployeeId',$record['rbemployeeId']); ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbsbillquoteEditAndSave')=='OK')
{
 $rbsbillquoteId=$os->post('rbsbillquoteId');
 
 
		 
 $dataToSave['refCode']=addslashes($os->post('refCode')); 
 $dataToSave['rbsbillquoteDate']=$os->saveDate($os->post('rbsbillquoteDate')); 
 $dataToSave['rbcontactId']=addslashes($os->post('rbcontactId')); 
 $dataToSave['orderNo']=addslashes($os->post('orderNo')); 
 $dataToSave['billNo']=addslashes($os->post('billNo')); 
 $dataToSave['billSubject']=addslashes($os->post('billSubject')); 
 $dataToSave['quoteDetails']=addslashes($os->post('quoteDetails')); 
 $dataToSave['rbemployeeId']=addslashes($os->post('rbemployeeId')); 
 $dataToSave['productAmount']=addslashes($os->post('productAmount')); 
 $dataToSave['discountAmount']=addslashes($os->post('discountAmount')); 
 $dataToSave['discountedPrice']=addslashes($os->post('discountedPrice')); 
 $dataToSave['taxRate']=addslashes($os->post('taxRate')); 
 $dataToSave['taxAmount']=addslashes($os->post('taxAmount')); 
 $dataToSave['deliveryCharge']=addslashes($os->post('deliveryCharge')); 
 $dataToSave['installCharge']=addslashes($os->post('installCharge')); 
 $dataToSave['paybleAmount']=addslashes($os->post('paybleAmount')); 
 $dataToSave['paidAmount']=addslashes($os->post('paidAmount')); 
 $dataToSave['dueAmount']=addslashes($os->post('dueAmount')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 
 $dataToSave['frequency']=addslashes($os->post('frequency')); 
 $dataToSave['registerDate']=$os->saveDate($os->post('registerDate')); 
 $dataToSave['fromDate']=$os->saveDate($os->post('fromDate')); 
 $dataToSave['expiryDate']=$os->saveDate($os->post('expiryDate')); 
 $dataToSave['priorDays']=addslashes($os->post('priorDays')); 
 $dataToSave['reminderStart']=$os->saveDate($os->post('reminderStart')); 
 $dataToSave['reminderStatus']=addslashes($os->post('reminderStatus')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbsbillquoteId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbsbillquote',$dataToSave,'rbsbillquoteId',$rbsbillquoteId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbsbillquoteId>0 ){ $mgs= " Data updated Successfully";}
		if($rbsbillquoteId<1 ){ $mgs= " Data Added Successfully"; $rbsbillquoteId=  $qResult;}
		
		  $mgs=$rbsbillquoteId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbsbillquoteGetById')=='OK')
{
		$rbsbillquoteId=$os->post('rbsbillquoteId');
		
		if($rbsbillquoteId>0)	
		{
		$wheres=" where rbsbillquoteId='$rbsbillquoteId'";
		}
	    $dataQuery=" select * from rbsbillquote  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['refCode']=$record['refCode'];
 $record['rbsbillquoteDate']=$os->showDate($record['rbsbillquoteDate']); 
 $record['rbcontactId']=$record['rbcontactId'];
 $record['orderNo']=$record['orderNo'];
 $record['billNo']=$record['billNo'];
 $record['billSubject']=$record['billSubject'];
 $record['quoteDetails']=$record['quoteDetails'];
 $record['rbemployeeId']=$record['rbemployeeId'];
 $record['productAmount']=$record['productAmount'];
 $record['discountAmount']=$record['discountAmount'];
 $record['discountedPrice']=$record['discountedPrice'];
 $record['taxRate']=$record['taxRate'];
 $record['taxAmount']=$record['taxAmount'];
 $record['deliveryCharge']=$record['deliveryCharge'];
 $record['installCharge']=$record['installCharge'];
 $record['paybleAmount']=$record['paybleAmount'];
 $record['paidAmount']=$record['paidAmount'];
 $record['dueAmount']=$record['dueAmount'];
 $record['remarks']=$record['remarks'];
 $record['frequency']=$record['frequency'];
 $record['registerDate']=$os->showDate($record['registerDate']); 
 $record['fromDate']=$os->showDate($record['fromDate']); 
 $record['expiryDate']=$os->showDate($record['expiryDate']); 
 $record['priorDays']=$record['priorDays'];
 $record['reminderStart']=$os->showDate($record['reminderStart']); 
 $record['reminderStatus']=$record['reminderStatus'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbsbillquoteDeleteRowById')=='OK')
{ 

$rbsbillquoteId=$os->post('rbsbillquoteId');
 if($rbsbillquoteId>0){
 $updateQuery="delete from rbsbillquote where rbsbillquoteId='$rbsbillquoteId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
