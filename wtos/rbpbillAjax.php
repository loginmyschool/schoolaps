<?
/*
   # wtos version : 1.1
   # page called by ajax script in rbpbillDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_rbpbillListing')=='OK')
{
    $where='';
	$showPerPage= $os->post('showPerPage');



	$f_billDate_s= $os->post('f_billDate_s'); $t_billDate_s= $os->post('t_billDate_s');
	$andbillDate=$os->DateQ('billDate',$f_billDate_s,$t_billDate_s,$sTime='00:00:00',$eTime='59:59:59');
	$andrbcontactId=  $os->postAndQuery('rbcontactId_s','rbcontactId','=');
	$andorderNo=  $os->postAndQuery('orderNo_s','orderNo','%');
	$andbillNo=  $os->postAndQuery('billNo_s','billNo','%');
	$andbillSubject=  $os->postAndQuery('billSubject_s','billSubject','%');
	$andpaymentStatus=  $os->postAndQuery('paymentStatus_s','paymentStatus','%');
	$andrbemployeeId=  $os->postAndQuery('rbemployeeId_s','rbemployeeId','=');
	$andremarks=  $os->postAndQuery('remarks_s','remarks','%');


	$searchKey=$os->post('searchKey');
	
	
	$rbcontactIds= $os->searchKeyGetIds($searchKey,'rbcontact','rbcontactId',$whereCondition='',$searchFields='');
	$orrbcontactId='';
	if($rbcontactIds!='')
	{
	   $orrbcontactId= " or  rbcontactId IN ( $rbcontactIds) ";
	}

	
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or rbcontactId like '%$searchKey%' Or orderNo like '%$searchKey%' Or billNo like '%$searchKey%' Or billSubject like '%$searchKey%' Or paymentStatus like '%$searchKey%' Or rbemployeeId like '%$searchKey%' Or remarks like '%$searchKey%' ) $orrbcontactId";

	}

	$listingQuery="  select * from rbpbill where rbpbillId>0   $where   $andbillDate  $andrbcontactId  $andorderNo  $andbillNo  $andbillSubject  $andpaymentStatus  $andrbemployeeId  $andremarks     order by rbpbillId desc";

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];

  $contactList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
  $paymentList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbpbillId','rbpbillpayment','rbpbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); // get payments
	$productList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbpbillId','rbpbilldetails','rbpbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); 
	
	$prodNameList= $os->getProductsArray();
	
	
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" width="100%"  >
							<tr class="borderTitle" >

	                            <td >#</td>
									<td >Action </td>



<td ><b>Date/Status</b></td>
<td ><b>Contacts</b></td>
<td ><b>Products</b></td>
<td ><b>Payble</b></td>
<td><b>Payments</b></td>




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
									
									$paymentListData= $paymentList[$record['rbpbillId']];
									
									
									
									
									//  _d($record);
									//  _d($paymentListData);
									$colorBGClass='';
									
									
									$dueColor='style="color:#006600"';
									if($record['paymentStatus']=='Due')
									{
									$dueColor='style="color:#FF3300"';
									}



							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td>
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbpbillGetById('<? echo $record['rbpbillId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?> <br /><br /> <span  class="actionLink"  ><a href="javascript:void(0)"  onclick="printData('<? echo $record['rbpbillId'];?>')" >Print</a></span> </td>

        <td style=" color:#666666; font-size:11px;">
		 Bill No: <b><?php echo  $record['billNo'] ;?> </b> <br />
		 Date: <i> <?php echo $os->showDate($record['billDate']);?> </i>  <br />
		
		Status:   <span <? echo $dueColor ?>> <b><?php echo $record['paymentStatus'];?> </b> </span>
		<? if($record['remarks']!=""){ ?> <br />
	    Remarks:  <br />
		<span style=" color:#C400C4; font-size:11px;"> <?php echo $record['remarks']?> <? } ?>  </span>
		
		</td>
		 <td> <?php echo $record['refCode']?> <br />  <? $os->showContact($contactList[$record['rbcontactId']]); ?></td>
		  <td> <? $os->showProduct($productList[$record['rbpbillId']],$prodNameList); ?></td>
			<td>
			
			
<table  class="showProductTable"  border="0" cellpadding="0" cellspacing="0" >
  <tr> <td style="width:80px;">Product Amt</td> <td style="text-align:right; width:20px;"><?php echo $record['productAmount']?>  </td> </tr>
  <tr> <td>-Discount</td> <td style="text-align:right;"><?php echo $record['discountAmount']?>  </td> </tr>
  <tr> <td>+Tax<span style="color:#666666; font-size:10px;">@<?php echo $record['taxRate']?>%</span></td> <td style="text-align:right;"><?php echo $record['taxAmount']?>  </td> </tr>
  <tr> <td>+Delivery</td> <td style="text-align:right;"><?php echo $record['deliveryCharge']?>  </td> </tr>
  <tr> <td>+Install </td> <td style="text-align:right;"><?php echo $record['installCharge']?>  </td> </tr>
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

				 </tr>
                          <?


						  } ?>





		</table>



		</div>

		<br />



<?php
exit();

}






if($os->get('WT_rbpbillEditAndSave')=='OK')
{
 $rbpbillId=$os->post('rbpbillId');



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




		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId'];

		if($rbpbillId < 1){

		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}


          $qResult=$os->save('rbpbill',$dataToSave,'rbpbillId',$rbpbillId);///    allowed char '\*#@/"~$^.,()|+_-=:��
		if($qResult)
				{
		if($rbpbillId>0 ){ $mgs= " Data updated Successfully";}
		if($rbpbillId<1 ){ $mgs= " Data Added Successfully"; $rbpbillId=  $qResult;}

		  $mgs=$rbpbillId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";

		}
		//_d($dataToSave);
		echo $mgs;

exit();

}

if($os->get('WT_rbpbillGetById')=='OK')
{
		$rbpbillId=$os->post('rbpbillId');

		if($rbpbillId>0)
		{
		$wheres=" where rbpbillId='$rbpbillId'";
		}
	    $dataQuery=" select * from rbpbill  $wheres ";
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



		echo  json_encode($record);

exit();

}


if($os->get('WT_rbpbillDeleteRowById')=='OK')
{

$rbpbillId=$os->post('rbpbillId');
 if($rbpbillId>0){
 $updateQuery="delete from rbpbill where rbpbillId='$rbpbillId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
