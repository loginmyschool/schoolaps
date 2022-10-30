<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbpbillquoteDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_rbpbillquoteListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');

    $f_rbpbillquoteDate_s= $os->post('f_rbpbillquoteDate_s'); $t_rbpbillquoteDate_s= $os->post('t_rbpbillquoteDate_s');
   $andrbpbillquoteDate=$os->DateQ('rbpbillquoteDate',$f_rbpbillquoteDate_s,$t_rbpbillquoteDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andrbcontactId=  $os->postAndQuery('rbcontactId_s','rbcontactId','=');
$andorderNo=  $os->postAndQuery('orderNo_s','orderNo','%');
$andbillNo=  $os->postAndQuery('billNo_s','billNo','%');
$andbillSubject=  $os->postAndQuery('billSubject_s','billSubject','%');

	   
	$searchKey=$os->post('searchKey');
	
	
	$rbcontactIds= $os->searchKeyGetIds($searchKey,'rbcontact','rbcontactId',$whereCondition='',$searchFields='');
	$orrbcontactId='';
	if($rbcontactIds!='')
	{
	   $orrbcontactId= " or  rbcontactId IN ( $rbcontactIds) ";
	}

	
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or rbcontactId like '%$searchKey%' Or orderNo like '%$searchKey%' Or billNo like '%$searchKey%' Or billSubject like '%$searchKey%' ) $orrbcontactId";
 
	}
		
	$listingQuery="  select * from rbpbillquote where rbpbillquoteId>0   $where   $andrefCode  $andrbpbillquoteDate  $andrbcontactId  $andorderNo  $andbillNo  $andbillSubject     order by rbpbillquoteId desc";
	  
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
  <td ><b>Date</b></td>  
  <td ><b>Contacts</b></td>  
  <td ><b>Order No</b></td>  
  <td ><b>Bill No</b></td>  
  <td ><b>Bill Subject</b></td>  
  <td ><b>Employee</b></td>  
  <td ><b>Payble Amount</b></td>  
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbpbillquoteGetById('<? echo $record['rbpbillquoteId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['refCode']?> </td>  
  <td><?php echo $os->showDate($record['rbpbillquoteDate']);?> </td>  
  <td>  <? $os->showContact($contactList[$record['rbcontactId']]); ?></td> 
  <td><?php echo $record['orderNo']?> </td>  
  <td><?php echo $record['billNo']?> </td>  
  <td><?php echo $record['billSubject']?> </td>  
  <td>  <? echo 
	$os->rowByField('name','rbemployee','rbemployeeId',$record['rbemployeeId']); ?></td> 
  <td><?php echo $record['paybleAmount']?> </td>  
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
 





if($os->get('WT_rbpbillquoteEditAndSave')=='OK')
{
 $rbpbillquoteId=$os->post('rbpbillquoteId');
 
 
		 
 $dataToSave['refCode']=addslashes($os->post('refCode')); 
 $dataToSave['rbpbillquoteDate']=$os->saveDate($os->post('rbpbillquoteDate')); 
 $dataToSave['rbcontactId']=addslashes($os->post('rbcontactId')); 
 $dataToSave['orderNo']=addslashes($os->post('orderNo')); 
 $dataToSave['billNo']=addslashes($os->post('billNo')); 
 $dataToSave['billSubject']=addslashes($os->post('billSubject')); 
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

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbpbillquoteId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbpbillquote',$dataToSave,'rbpbillquoteId',$rbpbillquoteId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbpbillquoteId>0 ){ $mgs= " Data updated Successfully";}
		if($rbpbillquoteId<1 ){ $mgs= " Data Added Successfully"; $rbpbillquoteId=  $qResult;}
		
		  $mgs=$rbpbillquoteId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbpbillquoteGetById')=='OK')
{
		$rbpbillquoteId=$os->post('rbpbillquoteId');
		
		if($rbpbillquoteId>0)	
		{
		$wheres=" where rbpbillquoteId='$rbpbillquoteId'";
		}
	    $dataQuery=" select * from rbpbillquote  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['refCode']=$record['refCode'];
 $record['rbpbillquoteDate']=$os->showDate($record['rbpbillquoteDate']); 
 $record['rbcontactId']=$record['rbcontactId'];
 $record['orderNo']=$record['orderNo'];
 $record['billNo']=$record['billNo'];
 $record['billSubject']=$record['billSubject'];
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

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbpbillquoteDeleteRowById')=='OK')
{ 

$rbpbillquoteId=$os->post('rbpbillquoteId');
 if($rbpbillquoteId>0){
 $updateQuery="delete from rbpbillquote where rbpbillquoteId='$rbpbillquoteId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
