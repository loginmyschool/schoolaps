<? 
/*
   # wtos version : 1.1
   # page called by ajax script in paymentDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_paymentListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andhistoryId=  $os->postAndQuery('historyId_s','historyId','=');

    $f_paymentDate_s= $os->post('f_paymentDate_s'); $t_paymentDate_s= $os->post('t_paymentDate_s');
   $andpaymentDate=$os->DateQ('paymentDate',$f_paymentDate_s,$t_paymentDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andstudentId=  $os->postAndQuery('studentId_s','studentId','=');
$andpaidRegistrationFees=  $os->postAndQuery('paidRegistrationFees_s','paidRegistrationFees','%');
$anddueRegistrationFees=  $os->postAndQuery('dueRegistrationFees_s','dueRegistrationFees','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');
$andpaid_details=  $os->postAndQuery('paid_details_s','paid_details','%');
$andpaymentMode=  $os->postAndQuery('paymentMode_s','paymentMode','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( historyId like '%$searchKey%' Or studentId like '%$searchKey%' Or paidRegistrationFees like '%$searchKey%' Or dueRegistrationFees like '%$searchKey%' Or remarks like '%$searchKey%' Or paid_details like '%$searchKey%' Or paymentMode like '%$searchKey%' )";
 
	}
		
 	$listingQuery="  select * from payment where paymentId>0   $where   $andhistoryId  $andpaymentDate  $andstudentId  $andpaidRegistrationFees  $anddueRegistrationFees  $andremarks  $andpaid_details  $andpaymentMode     order by paymentId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
  $receiptNoList= $os->getIdsDataFromQuery($rsRecords->queryString,'paymentId','printreceiptno','tableId',$fields='',$returnArray=true,$relation='121',$otherCondition='and tableName="payment"');

?>

<?

$regFeesQuery="  select * from history where historyId>0   $where   $andhistoryId   $andstudentId   order by historyId desc";
$regFeesMq=$os->mq($regFeesQuery);
$regFeesData=$os->mfa($regFeesMq);



$totalPaidRegFeesQuery="SELECT sum(paidRegistrationFees) paidRegistrationFees_Amt  FROM payment where paymentId>0   $where   $andhistoryId   $andstudentId   ";
$totalRegFeesMq=$os->mq($totalPaidRegFeesQuery);
$totalRegFeesData=$os->mfa($totalRegFeesMq);
$paidRegFees=$totalRegFeesData['paidRegistrationFees_Amt'];

?>





<div class="listingRecords">
<div class="pagingLinkCss" style="display:none;" >Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   


</div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td style="display:none"><b>historyId</b></td>  
<td ><b>Receipt No</b></td> 
  <td ><b>Date</b></td>  
   
  <td style="display:none"><b>studentId</b></td>  
  <td ><b>Paid Registration Fees</b></td>  
  <td style="display:none"><b>Due Registration Fees</b></td>  
   
  <td ><b>Payment Mode</b></td>  
  						
  <td ><b>Paid Details</b></td>						 
 
	 <td ><b>Remarks</b></td>  
	 <td ><b>Collected By</b></td>  
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
							<!--<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_paymentGetById('<? echo $record['paymentId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span> 
							-->
							
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="checkEditDeletePassword('<? echo $record['paymentId'];?>','<? echo $record['addEditCounter'];?>');os.setAsCurrentRecords(this)" >Edit</a></span> 

							
							
							<? } ?> 

 <span  class="actionLink" ><a  href="javascript:void(0)" onclick="popUpWindow('regFeesPrint.php?historyId=<? echo $record['historyId'];?>&studentId=<? echo $record['studentId'];?>&paymentId=<? echo $record['paymentId'];?>', 50, 50, 1050, 620)">Print</a></span>
 
 
 
 <!-- <span  class="actionLink" ><a  href="javascript:void(0)" onclick="openRegFeesPrint('<? echo $record['historyId'];?>','<? echo $record['studentId'];?>','<? echo $record['paymentId'];?>','<? echo $receiptNoList[$record['paymentId']]['receiptNo'];?>')">Print</a></span>-->
							
	
							</td>
								
<td style="display:none"><?php echo $record['historyId']?> </td>  
<td ><?echo $receiptNoList[$record['paymentId']]['receiptNo']?> </td> 
  <td><?php echo $os->showDate($record['paymentDate']);?> </td> 
   
  <td style="display:none"><?php echo $record['studentId']?> </td>  
  <td><?php echo $record['paidRegistrationFees']?> </td>  
  <td style="display:none"><?php echo $record['dueRegistrationFees']?> </td>  
  
  <td> <? if(isset($os->paymentethod[$record['paymentMode']])){ echo  $os->paymentethod[$record['paymentMode']]; } ?></td> 

  <td><?php echo $record['paid_details']?> </td> 
	   <td><?php echo $record['remarks']?> </td>  
<td >  <? echo $os->rowByField('name','admin','adminId',$record['modifyBy']); ?></td>	   
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		<div >
Registration Fees : <span  style="color:#000099;font-weight:bold; "> <?php echo $regFeesData['registrationFees']?> </span>&nbsp; &nbsp;
Paid : <span  style="color:#00CC33;font-weight:bold; "> <?php echo $paidRegFees?> </span>&nbsp; &nbsp;
	  Due   :<span style="color:red;font-weight:bold;"> <?echo ($regFeesData['registrationFees']-$paidRegFees)?></span>	
		</div> 
		</div>
		
	 
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_paymentEditAndSave')=='OK')
{
	ini_set('max_execution_time', '-1');
ini_set('memory_limit', '2048M');
include('sendSms.php');
 $paymentId=$os->post('paymentId');
 
 
	
 $addEditCounter=$os->post('addEditCounter');	 
$historyId= $dataToSave['historyId']=addslashes($os->post('historyId')); 
 $dataToSave['paymentDate']=$os->saveDate($os->post('paymentDate')); 
 $studentId=$dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['paidRegistrationFees']=addslashes($os->post('paidRegistrationFees')); 
 $dataToSave['dueRegistrationFees']=addslashes($os->post('dueRegistrationFees')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 
 $dataToSave['paid_details']=addslashes($os->post('paid_details')); 
 $dataToSave['paymentMode']=addslashes($os->post('paymentMode')); 
$dataToSave['addEditCounter']=$addEditCounter+1; 
 
$dataToSave['receivedAmt']=addslashes($os->post('receivedAmt')); 
$dataToSave['refundAmt']=addslashes($os->post('refundAmt')); 
$dataToSave['paymentTime']=addslashes($os->post('paymentTime'));	





	
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($paymentId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('payment',$dataToSave,'paymentId',$paymentId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($paymentId>0 ){ $mgs= " Data updated Successfully";}
		if($paymentId<1 ){ $mgs= " Data Added Successfully"; $paymentId=  $qResult;
		
		}
		
		
		$os->getReceiptNo('payment',$paymentId,$historyId,$studentId);
		
		
		if($addEditCounter==0)
		{
		$mobileNoQuery=$os->rowByField('mobile_student','student','studentId',$studentId); 
		$smsObj= new sms;
		 $smsText="We have received  Rs.".$dataToSave['paidRegistrationFees']." for registration.Thank You";
		$smsNumbersStr=$mobileNoQuery;
		//$smsNumbersStr=9007636254;
		$smsObj->sendSMS($smsText,$smsNumbersStr);
		$os->saveSendingSms($smsText,$mobileNos=$smsNumbersStr , $status='send',$note='Registration Fees Payment');
		
		}
		
		 $addedBy=$os->userDetails['adminId'];
		  $description=json_encode($dataToSave);
		  
         $os->setLogRecord('payment',$qResult,'Edit Registration Fees',$addedBy,$description);
		  
		  
		
		
		  $mgs=$paymentId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 



if($os->get('checkEditDeletePassword')=='OK')
{
	
	 $paymentId=$os->post('paymentId');
	 $password=$os->post('password');
	$operationType=$os->post('operationType');
    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
	if($password==$editDeletePassword)
	{
		
		$msg="password matched#-#".$paymentId."#-#Edit Data";
		if($operationType=='deleteData')
		{
			$msg="password matched#-#".$paymentId."#-#Delete Data";
		}
	}
	else
	{
		$msg="wrong password";
	}
	echo $msg;
	exit();
	
}




 
if($os->get('WT_paymentGetById')=='OK')
{
		$paymentId=$os->post('paymentId');
		
		if($paymentId>0)	
		{
		$wheres=" where paymentId='$paymentId'";
		}
	    $dataQuery=" select * from payment  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['historyId']=$record['historyId'];
 $record['paymentDate']=$os->showDate($record['paymentDate']); 
 $record['studentId']=$record['studentId'];
 $record['paidRegistrationFees']=$record['paidRegistrationFees'];
 $record['dueRegistrationFees']=$record['dueRegistrationFees'];
 $record['remarks']=$record['remarks'];
 $record['paid_details']=$record['paid_details'];
 $record['paymentMode']=$record['paymentMode'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_paymentDeleteRowById')=='OK')
{ 

$paymentId=$os->post('paymentId');
 if($paymentId>0){
 $updateQuery="delete from payment where paymentId='$paymentId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
