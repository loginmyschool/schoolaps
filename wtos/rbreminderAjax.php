<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbreminderDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

// get UC and about to expire  data to set NC

$UCtoNCQ="update rbreminder set reminderStatus='NC' where reminderStatus='UC' and reminderStartDate<now() ";
$os->mq($UCtoNCQ);

 
?><?

if($os->get('WT_rbreminderListing')=='OK')
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
	$andrbcontactId=  $os->postAndQuery('rbcontactId_s','rbcontactId','=');
	$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');
	$andreminderType=  $os->postAndQuery('reminderType_s','reminderType','%');
	$andfrequency=  $os->postAndQuery('frequency_s','frequency','%');
	$andpriorDays=  $os->postAndQuery('priorDays_s','priorDays','%');
	
	$f_expiryDate_s= $os->post('f_expiryDate_s'); $t_expiryDate_s= $os->post('t_expiryDate_s');
	$andexpiryDate=$os->DateQ('expiryDate',$f_expiryDate_s,$t_expiryDate_s,$sTime='00:00:00',$eTime='59:59:59');
	
	$f_reminderStartDate_s= $os->post('f_reminderStartDate_s'); $t_reminderStartDate_s= $os->post('t_reminderStartDate_s');
	$andreminderStartDate=$os->DateQ('reminderStartDate',$f_reminderStartDate_s,$t_reminderStartDate_s,$sTime='00:00:00',$eTime='59:59:59');
	$andamount=  $os->postAndQuery('amount_s','amount','%');
	$andarrearAmount=  $os->postAndQuery('arrearAmount_s','arrearAmount','%');
	$andtotalPayableAmount=  $os->postAndQuery('totalPayableAmount_s','totalPayableAmount','%');
	$andtotalPaid=  $os->postAndQuery('totalPaid_s','totalPaid','%');
	$anddueAmount=  $os->postAndQuery('dueAmount_s','dueAmount','%');
	$andpaymentStatus=  $os->postAndQuery('paymentStatus_s','paymentStatus','%');
	$andreminderStatus=  $os->postAndQuery('reminderStatus_s','reminderStatus','%');
	$anddocketNo=  $os->postAndQuery('docketNo_s','docketNo','%');
	$andurl=  $os->postAndQuery('url_s','url','%');
	$andremarks=  $os->postAndQuery('remarks_s','remarks','%');
	$andrbproductId=  $os->postAndQuery('rbproductId_s','rbproductId','=');
	$andrbserviceId=  $os->postAndQuery('rbserviceId_s','rbserviceId','=');
	$andipAddress=  $os->postAndQuery('ipAddress_s','ipAddress','%');
	
	$searchKey=$os->post('searchKey');
	

    $rbcontactIds= $os->searchKeyGetIds($searchKey,'rbcontact','rbcontactId',$whereCondition='',$searchFields='');  
	$orrbcontactId='';
	if($rbcontactIds!='')
	{
	   $orrbcontactId= " or  rbcontactId IN ( $rbcontactIds) ";
	}
   
	
	if($searchKey!=''){
	$where ="and ( rbcontactId like '%$searchKey%' Or refCode like '%$searchKey%' Or reminderType like '%$searchKey%' Or frequency like '%$searchKey%' Or priorDays like '%$searchKey%' Or amount like '%$searchKey%' Or arrearAmount like '%$searchKey%' Or totalPayableAmount like '%$searchKey%' Or totalPaid like '%$searchKey%' Or dueAmount like '%$searchKey%' Or paymentStatus like '%$searchKey%' Or reminderStatus like '%$searchKey%' Or docketNo like '%$searchKey%' Or url like '%$searchKey%' Or remarks like '%$searchKey%' Or rbproductId like '%$searchKey%' Or rbserviceId like '%$searchKey%' Or ipAddress like '%$searchKey%'  Or bvNo like '%$searchKey%'  Or bvSubject like '%$searchKey%' ) $orrbcontactId ";
  
	}
		
	$listingQuery="  select * from rbreminder where rbreminderId>0   $where   $andrbcontactId  $andrefCode  $andreminderType  $andfrequency  $andpriorDays  $andexpiryDate  $andreminderStartDate  $andamount  $andarrearAmount  $andtotalPayableAmount  $andtotalPaid  $anddueAmount  $andpaymentStatus  $andreminderStatus  $anddocketNo  $andurl  $andremarks  $andrbproductId  $andrbserviceId  $andipAddress   $andrbcontactIds    order by rbreminderId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	
	$contactList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
	   $paymentList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbreminderId','rbpayment','rbreminderId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); // get payments
  
//s  _d($contactList);
  
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" id="ListingTable"  >
							<tr class="borderTitle" >
						
								<td >#</td>
								<td >Action </td>
								<td style="width:100px;"><b>Payment</b></td>   
                                 <td ><b>Date</b></td>   
								<td ><b>Id/Customer</b></td> 
								<td ><b>Bill/ Voucher No</b></td> 
							 
								
								
								<td ><b>Products/Service</b></td>  
								 
                                <td ><b>Status</b></td> 
								
								<td ><b>Exp Date</b></td>  
								
						    </tr>
							
							
							
							        <?php
								  
									$serial=$os->val($resource,'serial');  
									
									while($record=$os->mfa( $rsRecords)){ 
									$serial++;
									
									$blink=''; 
									$color='#000000';
									$colorBGClass='';
									$extraStyle='';
									if($record['reminderStatus']=='NC')
									{
									$blink='blink'; 
									$color=$os->remindStatusColor[$record['reminderStatus']];
									$extraStyle=';font-weight:bold;';
									}
									if($record['reminderStatus']=='Close')
									{
									  $colorBGClass="reminderStatusClose";
									
									}
									if($record['reminderStatus']=='NC')
									{
									  $colorBGClass="reminderStatusNC";
									
									}
									
								    $paymentListData= $paymentList[$record['rbreminderId']];
								
								    $colorBGClass='';
									
									
									$dueColor='style="color:#006600"';
									if($record['paymentStatus']=='Due')
									{
									  $dueColor='style="color:#FF3300"';
									}
								 
							     ?>	
							 
							 	<tr class="trListing <? echo $colorBGClass ?> "   >
								<td><?php echo $serial; ?>     </td>
								<td> 
									<? if($os->access('wtView')){ ?>
									<span  class="actionLink"><a href="javascript:void(0)"  onclick="WT_rbreminderGetById('<? echo $record['rbreminderId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span> 
								<!--	<span  class="actionLink"  ><a href="javascript:void(0)"  onclick="printRBReceipt('<? echo $record['rbreminderId'];?>')" >Print</a></span>  --> 
							 
									<? } ?>  
								</td>
                                <td> <span style="font-weight:bold"> <?php echo $record['totalPayableAmount'];?> </span> &nbsp;
								<span <? echo $dueColor ?>> <?php echo $record['paymentStatus'];?> </span>
								<br>
								<span style="font-size:10px;color:#006600;">
								<? 
								$payStatus=$os->payStatus[$record['paymentStatus']];
									$pstr='';
									$totalPaid=0;
									if(is_array($paymentListData))
									{
										foreach($paymentListData as $pay)
										{
															  
											$pDate=$os->showDate($pay['paidDate']);
											$pAmount=$pay['paidAmount'];
											$pstr= " $pDate <b> $pAmount </b><br>";
											echo $pstr;
											$totalPaid=$totalPaid+$pAmount;
										}
										$due=	$record['totalPayableAmount']-$totalPaid;		
										
										 if(count($paymentListData)>1){ 
										?>
										<span title="Due Amount <? echo $due ?>" style="font-weight:bold; color:#006600; border-top:1px solid #999999;"> Total Paid <?php echo  $totalPaid ?> </span><br />
										<? 
											}	  
									}
										
								
								?>
								
								
								 
								
								 
								
								</span>
								</td> 
								
								 
								
								<td ><?php echo $os->showDate($record['bvDate']);?></td>
								<td><b><?php echo $record['refCode']?></b> <br />
								<span style=" font-size:10px">
								<? 	$pCont=$contactList[$record['rbcontactId']]; ?>
								<?  echo $pCont['person'];  ?> <br />
								<span style="color:#00A429"><?  echo $pCont['phone'];  ?></span>&nbsp; <span style="color:#009EEA"><?  echo $pCont['email'];  ?></span>
								 
								
								 </span></td>  
								
								
								
								<td><?php echo $record['bvNo']?> </td>  
								 							
								<td>  
									<span><? echo $os->rowByField('name','rbproduct','rbproductId',$record['rbproductId']); ?></span><br>
									<span><? echo $os->rowByField('name','rbservice','rbserviceId',$record['rbserviceId']); ?></span>
									
									<?php echo $record['bvSubject']?>
									
									<?php echo $record['remarks']?>
								</td> 
								 
                                <td style="color:<? echo $color  ?>"> <? if(isset($os->remindStatus[$record['reminderStatus']])){ echo  $os->remindStatus[$record['reminderStatus']]; } ?></td>  
								<td>
								 <span style="color:#666666; font-size:11px; font-style:italic">R:<?php echo $os->showDate($record['registerDate']);?></span><br />
								 <span style="color:#0000CC; font-size:11px;">F:<?php echo $os->showDate($record['fromDate']);?></span>
								  
								<div class="statusarea <? echo $blink  ?>"style="color:<? echo $color  ?><? echo $extraStyle  ?> " > 
							
								
								T:<?php echo $os->showDate($record['expiryDate']);?></div> </td> 
								<!--<td><?php echo $record['priorDays']?> </td>  
								<td><?php echo $os->showDate($record['reminderStartDate']);?> </td>  -->		
						 	</tr>
                          <? 
						  	}

						  //	$fk= $os->rowByField('person','rbcontact','rbcontactId',$record['rbcontactId']);  
						 	

						  ?>  
		
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_rbreminderEditAndSave')=='OK')
{
 $rbreminderId=$os->post('rbreminderId');
 
 
		 
 $dataToSave['rbcontactId']=addslashes($os->post('rbcontactId')); 
 $dataToSave['refCode']=addslashes($os->post('refCode')); 
 $dataToSave['reminderType']=addslashes($os->post('reminderType')); 
 $dataToSave['frequency']=addslashes($os->post('frequency')); 
 $dataToSave['priorDays']=addslashes($os->post('priorDays')); 
 $dataToSave['expiryDate']=$os->saveDate($os->post('expiryDate')); 
 $dataToSave['reminderStartDate']=$os->saveDate($os->post('reminderStartDate')); 
 $dataToSave['amount']=addslashes($os->post('amount')); 
 $dataToSave['arrearAmount']=addslashes($os->post('arrearAmount')); 
 $dataToSave['totalPayableAmount']=addslashes($os->post('totalPayableAmount')); 
 $dataToSave['totalPaid']=addslashes($os->post('totalPaid')); 
 $dataToSave['dueAmount']=addslashes($os->post('dueAmount')); 
 $dataToSave['paymentStatus']=addslashes($os->post('paymentStatus')); 
 $dataToSave['reminderStatus']=addslashes($os->post('reminderStatus')); 
 $dataToSave['docketNo']=addslashes($os->post('docketNo')); 
 $dataToSave['url']=addslashes($os->post('url')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 
 $doucument1=$os->UploadPhoto('doucument1',$site['root'].'wtos-images');
				   	if($doucument1!=''){
					$dataToSave['doucument1']='wtos-images/'.$doucument1;}
 $document2=$os->UploadPhoto('document2',$site['root'].'wtos-images');
				   	if($document2!=''){
					$dataToSave['document2']='wtos-images/'.$document2;}
 $dataToSave['rbproductId']=addslashes($os->post('rbproductId')); 
 $dataToSave['rbserviceId']=addslashes($os->post('rbserviceId')); 
 $dataToSave['ipAddress']=addslashes($os->post('ipAddress')); 

	$dataToSave['taxAmount']=addslashes($os->post('taxAmount')); 
	$dataToSave['taxPercent']=addslashes($os->post('taxPercent')); 
	
	
	$dataToSave['registerDate']=$os->saveDate($os->post('registerDate')); 
	$dataToSave['fromDate']=$os->saveDate($os->post('fromDate')); 
	$dataToSave['inOutStatus']=addslashes($os->post('inOutStatus')); 
	$dataToSave['bvSubject']=addslashes($os->post('bvSubject')); 
	$dataToSave['bvDate']=$os->saveDate($os->post('bvDate')); 
	$dataToSave['bvNo']=addslashes($os->post('bvNo')); 
 
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($rbreminderId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('rbreminder',$dataToSave,'rbreminderId',$rbreminderId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($rbreminderId>0 ){ $mgs= " Data updated Successfully";}
		if($rbreminderId<1 ){ $mgs= " Data Added Successfully"; $rbreminderId=  $qResult;}
		
		  $mgs=$rbreminderId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_rbreminderGetById')=='OK')
{
		$rbreminderId=$os->post('rbreminderId');
		
		if($rbreminderId>0)	
		{
		$wheres=" where rbreminderId='$rbreminderId'";
		}
	    $dataQuery=" select * from rbreminder  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);

 
$record['rbcontactId']=$record['rbcontactId'];
$record['refCode']=$record['refCode'];
$record['reminderType']=$record['reminderType'];
$record['frequency']=$record['frequency'];
$record['priorDays']=$record['priorDays'];
$record['expiryDate']=$os->showDate($record['expiryDate']); 
$record['reminderStartDate']=$os->showDate($record['reminderStartDate']); 
$record['amount']=$record['amount'];
$record['arrearAmount']=$record['arrearAmount'];
$record['totalPayableAmount']=$record['totalPayableAmount'];
$record['totalPaid']=$record['totalPaid'];
$record['dueAmount']=$record['dueAmount'];
$record['paymentStatus']=$record['paymentStatus'];
$record['reminderStatus']=$record['reminderStatus'];
$record['docketNo']=$record['docketNo'];
$record['url']=$record['url'];
$record['remarks']=$record['remarks'];
if($record['doucument1']!=''){
				$record['doucument1']=$site['url'].$record['doucument1'];}
if($record['document2']!=''){
				$record['document2']=$site['url'].$record['document2'];}
$record['rbproductId']=$record['rbproductId'];
$record['rbserviceId']=$record['rbserviceId'];
$record['ipAddress']=$record['ipAddress'];

$record['registerDate']=$os->showDate($record['registerDate']); 
$record['fromDate']=$os->showDate($record['fromDate']); 

$record['bvDate']=$os->showDate($record['bvDate']); 

echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_rbreminderDeleteRowById')=='OK')
{ 

$rbreminderId=$os->post('rbreminderId');
 if($rbreminderId>0){
 $updateQuery="delete from rbreminder where rbreminderId='$rbreminderId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
