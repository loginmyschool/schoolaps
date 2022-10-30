<?
/*
   # wtos version : 1.1
   # page called by ajax script in rbsbillDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);
$UCtoNCQ="update rbsbill set reminderStatus='NC' where reminderStart<now() and  (reminderStatus='UC' or reminderStatus='UW')";
$os->mq($UCtoNCQ);

?><?

if($os->get('WT_rbsbillListing')=='OK')

{
	$where='';
	$showPerPage= $os->post('showPerPage');
	
	
	$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');
	
	$f_billDate_s= $os->post('f_billDate_s'); $t_billDate_s= $os->post('t_billDate_s');
	$andbillDate=$os->DateQ('billDate',$f_billDate_s,$t_billDate_s,$sTime='00:00:00',$eTime='59:59:59');
	$andrbcontactId=  $os->postAndQuery('rbcontactId_s','rbcontactId','=');
	$andorderNo=  $os->postAndQuery('orderNo_s','orderNo','%');
	$andbillNo=  $os->postAndQuery('billNo_s','billNo','%');
	$andbillSubject=  $os->postAndQuery('billSubject_s','billSubject','%');
	$andpaymentStatus=  $os->postAndQuery('paymentStatus_s','paymentStatus','%');
	$andrbemployeeId=  $os->postAndQuery('rbemployeeId_s','rbemployeeId','=');
	$andpaybleAmount=  $os->postAndQuery('paybleAmount_s','paybleAmount','%');
	
	$f_registerDate_s= $os->post('f_registerDate_s'); $t_registerDate_s= $os->post('t_registerDate_s');
	$andregisterDate=$os->DateQ('registerDate',$f_registerDate_s,$t_registerDate_s,$sTime='00:00:00',$eTime='59:59:59');
	
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
	$where ="and ( refCode like '%$searchKey%' Or rbcontactId like '%$searchKey%' Or orderNo like '%$searchKey%' Or billNo like '%$searchKey%' Or billSubject like '%$searchKey%' Or paymentStatus like '%$searchKey%' Or rbemployeeId like '%$searchKey%' Or paybleAmount like '%$searchKey%' Or reminderStatus like '%$searchKey%' ) $orrbcontactId";

	}

	$listingQuery="  select * from rbsbill where rbsbillId>0   $where   $andrefCode  $andbillDate  $andrbcontactId  $andorderNo  $andbillNo  $andbillSubject  $andpaymentStatus  $andrbemployeeId  $andpaybleAmount  $andregisterDate  $andexpiryDate  $andreminderStatus     order by rbsbillId desc";

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];

	$contactList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
	$paymentList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbsbillId','rbsbillpayment','rbsbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition='');
	$productList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbsbillId','rbsbilldetails','rbsbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); 	
	$prodNameList= $os->getProductsArray();
	$cmpmList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbsbillId','rbcmpm','rbsbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); 
	$msgList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbsbillId','smshistory','rbsbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); 
 

?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >

	                            <td >#</td>
									<td style="width:50px;" >Action </td>



<td ><b>Date/Status</b></td>
<td ><b>Contacts/ SMS</b></td>
<td  ><b>Products</b></td>
<td ><b>Payble</b></td>
<td style="width:124px;"> <b>Payments</b></td>
<td style="width:120px;"> Dated </td>




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
									
									$paymentListData= $paymentList[$record['rbsbillId']];
									
									
									
									
									//  _d($record);
									//  _d($paymentListData);
									$colorBGClass='';
									
									
									$dueColor='style="color:#006600"';
									if($record['paymentStatus']=='Due')
									{
									$dueColor='style="color:#FF3300"';
									}

                                $cmpmListData=$cmpmList[$record['rbsbillId']];
								
								 $msgListData=$msgList[$record['rbsbillId']];
								
								 

							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td>
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbsbillGetById('<? echo $record['rbsbillId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?> <br /><br /> <span  class="actionLink"  ><a href="javascript:void(0)"  onclick="printData('<? echo $record['rbsbillId'];?>')" >Print</a></span>
							
							
							<br /> <br /> <span  class="actionLink" ><a href="javascript:void(0)" onclick=" rb.popUpOpen('quickSMSPOPUP'); ajaxViewsms('<? echo $record['rbsbillId'];?>');" style="background-color:#00AE00; font-weight:bold;" >&raquo; <? echo count($msgListData);?></a>
							</span> 
							 </td>

        <td style=" color:#666666; font-size:11px;">
		 Bill No: <b><?php echo  $record['billNo'] ;?> </b> <br />
		 Date: <i> <?php echo $os->showDate($record['billDate']);?> </i>  <br />
		
		Status:   <span <? echo $dueColor ?>> <b><?php echo $record['paymentStatus'];?> </b> </span>
		<? if($record['remarks']!=""){ ?> <br />
	    Remarks:  <br />
		<span style=" color:#C400C4; font-size:11px;"> <?php echo $record['remarks']?> <? } ?>  </span>
		
		</td>
		 <td> <?php echo $record['refCode']?> <br />  <? $os->showContact($contactList[$record['rbcontactId']]); ?>
		 
		 <br /> <? echo $os->showMsgHistory($msgListData); ?>
		 
		 </td>
		  <td> <? $os->showProduct($productList[$record['rbsbillId']],$prodNameList); ?></td>
			<td>
			
			
<table  class="showProductTable"  border="0" cellpadding="0" cellspacing="0" >
  <tr> <td style="width:80px;">Product Amt</td> <td style="text-align:right; width:20px;"><?php echo $record['productAmount']?>  </td> </tr>
  <tr> <td>-Discount</td> <td style="text-align:right;"><?php echo $record['discountAmount']?>  </td> </tr>
  <tr> <td>+Tax<span style="color:#666666; font-size:10px;">@<?php echo $record['taxRate']?>%</span></td> <td style="text-align:right;"><?php echo $record['taxAmount']?>  </td> </tr>
  <tr style="display:none;"> <td>+Delivery</td> <td style="text-align:right;"><?php echo $record['deliveryCharge']?>  </td> </tr>
  <tr style="display:none;"> <td>+Install </td> <td style="text-align:right;"><?php echo $record['installCharge']?>  </td> </tr>
  <tr> <td><span style="font-weight:bold"> Total</span> </td> <td style="text-align:right;"><span style="font-weight:bold; font-size:13px;"> <?php echo $record['paybleAmount'];?> </span>  </td>
   </tr>
 
</table>

			</td>

        <td>       
         
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
        $due=	$record['paybleAmount']-$totalPaid;
 
        if(count($paymentListData)>1){
        ?>
        <span title="Due Amount <? echo $due ?>" style="font-weight:bold; color:#006600; border-top:1px solid #999999;"> Total Paid <?php echo  $totalPaid ?> </span><br />
        <?
        }
        }
		
		 
		 if( $due>1)
		 {
		  ?>
        <span  style="font-weight:bold; color:#FF0000; border:1px dotted #FF0000; margin-top:2px;">Due <?php echo  $due ?> </span><br />
        <?
		 }
		
		
		
        ?>
        </span></td>

				 
				 <td >
				    <span style="color:<? echo $color  ?>"><b> <? if(isset($os->remindStatus[$record['reminderStatus']])){ echo  $os->remindStatus[$record['reminderStatus']]; } ?> </b></span> <br />
				 
								 <span style="color:#666666; font-size:11px; font-style:italic">R:<?php echo $os->showDate($record['registerDate']);?></span><br />
								 <span style="color:#0000CC; font-size:11px;">F:<?php echo $os->showDate($record['fromDate']);?></span>
								  
								<div class="statusarea <? echo $blink  ?>"style="color:<? echo $color  ?><? echo $extraStyle  ?> " > 
							
								
								T:<?php echo $os->showDate($record['expiryDate']);?></div>
								
								<? if(is_array($cmpmListData)) { ?>
								
								<div style=" background-color:#FFFFE1; font-size:10px; margin-top:2px; padding:1px 3px 3px 3px; border:1px dotted #AAAA00;">
								<div style=" color:#0062C4">Maintenance Dates</div>
								
								
								<?
								 foreach($cmpmListData as $cmpm)
								 {
								   $cmpmstr=$os->showDate($cmpm['cmpmDate']).'   '.$cmpm['cmpmStatus'] ;
								   echo  $cmpmstr."<br>";
								 
								 }
								
								?>
								</div>
								<? } ?>
								
								
								 </td> 
				 </tr>
				 
				 
				 
				 
                          <?


						  } ?>





		</table>



		</div>

		 



<?php
exit();

}


if($os->get('WT_rbsbillEditAndSave')=='OK')
{
 $rbsbillId=$os->post('rbsbillId');



 $dataToSave['refCode']=addslashes($os->post('refCode'));
 $dataToSave['billDate']=$os->saveDate($os->post('billDate'));
 $dataToSave['rbcontactId']=addslashes($os->post('rbcontactId'));
 $dataToSave['orderNo']=addslashes($os->post('orderNo'));
 $dataToSave['billNo']=addslashes($os->post('billNo'));
 $dataToSave['billSubject']=addslashes($os->post('billSubject'));
 $dataToSave['paymentStatus']=addslashes($os->post('paymentStatus'));
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

		if($rbsbillId < 1){

		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}


          $qResult=$os->save('rbsbill',$dataToSave,'rbsbillId',$rbsbillId);///    allowed char '\*#@/"~$^.,()|+_-=:��
		if($qResult)
				{
		if($rbsbillId>0 ){ $mgs= " Data updated Successfully";}
		if($rbsbillId<1 ){ $mgs= " Data Added Successfully"; $rbsbillId=  $qResult;}

		  $mgs=$rbsbillId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";

		}
		//_d($dataToSave);
		echo $mgs;

exit();

}

if($os->get('WT_rbsbillGetById')=='OK')
{
		$rbsbillId=$os->post('rbsbillId');

		if($rbsbillId>0)
		{
		$wheres=" where rbsbillId='$rbsbillId'";
		}
	    $dataQuery=" select * from rbsbill  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);


 $record['refCode']=$record['refCode'];
 $record['billDate']=$os->showDate($record['billDate']);
 $record['rbcontactId']=$record['rbcontactId'];
 $record['orderNo']=$record['orderNo'];
 $record['billNo']=$record['billNo'];
 $record['billSubject']=$record['billSubject'];
 $record['paymentStatus']=$record['paymentStatus'];
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


if($os->get('WT_rbsbillDeleteRowById')=='OK')
{

$rbsbillId=$os->post('rbsbillId');
 if($rbsbillId>0){
 $updateQuery="delete from rbsbill where rbsbillId='$rbsbillId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
