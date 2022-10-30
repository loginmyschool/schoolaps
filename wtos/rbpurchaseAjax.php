<?
/*
   # wtos version : 1.1
   # page called by ajax script in rbpurchaseDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='rb';
$os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_rbpurchaseListing')=='OK')

{
    $where='';
	$showPerPage= $os->post('showPerPage');


$andrefCode=  $os->postAndQuery('refCode_s','refCode','%');

    $f_rbpurchaseDate_s= $os->post('f_rbpurchaseDate_s'); $t_rbpurchaseDate_s= $os->post('t_rbpurchaseDate_s');
   $andrbpurchaseDate=$os->DateQ('rbpurchaseDate',$f_rbpurchaseDate_s,$t_rbpurchaseDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andrbvenderId=  $os->postAndQuery('rbvenderId_s','rbvenderId','=');
$andorderNo=  $os->postAndQuery('orderNo_s','orderNo','%');
$andbillNo=  $os->postAndQuery('billNo_s','billNo','%');
$andbillSubject=  $os->postAndQuery('billSubject_s','billSubject','%');
$andpaymentStatus=  $os->postAndQuery('paymentStatus_s','paymentStatus','%');
$andrbemployeeId=  $os->postAndQuery('rbemployeeId_s','rbemployeeId','=');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');


	$searchKey=$os->post('searchKey');
	
	
	 
	
	
	if($searchKey!=''){
	$where ="and ( refCode like '%$searchKey%' Or rbvenderId like '%$searchKey%' Or orderNo like '%$searchKey%' Or billNo like '%$searchKey%' Or billSubject like '%$searchKey%' Or paymentStatus like '%$searchKey%' Or rbemployeeId like '%$searchKey%' Or remarks like '%$searchKey%' )";

	}

	$listingQuery="  select * from rbpurchase where rbpurchaseId>0   $where   $andrefCode  $andrbpurchaseDate  $andrbvenderId  $andorderNo  $andbillNo  $andbillSubject  $andpaymentStatus  $andrbemployeeId  $andremarks     order by rbpurchaseId desc";

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
  $contactList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
  $paymentList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbpurchaseId','rbpurchasepayment','rbpurchaseId',$fields='',$returnArray=true,$relation='12M',$otherCondition='');$productList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbpurchaseId','rbpurchasedetails','rbpurchaseId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); 
	//_d($productList);
	$prodNameList= $os->getProductsArray();
 //_d($prodNameList);
?>
 <div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
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
							
							 
									
									
									$paymentListData= $paymentList[$record['rbpurchaseId']];
									
									
									
									
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_rbpurchaseGetById('<? echo $record['rbpurchaseId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?> <br />    </td>

        <td style=" color:#666666; font-size:11px;">
		 Bill No: <b><?php echo  $record['billNo'] ;?> </b> <br />
		 Date: <i> <?php echo $os->showDate($record['rbpurchaseDate']);?> </i>  <br />
		
		Status:   <span <? echo $dueColor ?>> <b><?php echo $record['paymentStatus'];?> </b> </span>
		<? if($record['remarks']!=""){ ?> <br />
	    Remarks:  <br />
		<span style=" color:#C400C4; font-size:11px;"> <?php echo $record['remarks']?> <? } ?>  </span>
		
		</td>
		 <td> <?php echo $record['refCode']?> <br />  <? echo  $os->rowByField('name','rbvender','rbvenderId',$record['rbvenderId']); ?></td>
		  <td> <? $os->showProduct($productList[$record['rbpurchaseId']],$prodNameList); ?></td>
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

				 
				   
				 </tr>
				 
				 
				 
				 
                          <?


						  } ?>





		</table>



		</div>

		


<?php
exit();

}






if($os->get('WT_rbpurchaseEditAndSave')=='OK')
{
 $rbpurchaseId=$os->post('rbpurchaseId');



 $dataToSave['refCode']=addslashes($os->post('refCode'));
 $dataToSave['rbpurchaseDate']=$os->saveDate($os->post('rbpurchaseDate'));
 $dataToSave['rbvenderId']=addslashes($os->post('rbvenderId'));
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
 $dataToSave['paybleAmount']=addslashes($os->post('paybleAmount'));
 $dataToSave['paidAmount']=addslashes($os->post('paidAmount'));
 $dataToSave['dueAmount']=addslashes($os->post('dueAmount'));
 $dataToSave['remarks']=addslashes($os->post('remarks'));




		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId'];

		if($rbpurchaseId < 1){

		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}


          $qResult=$os->save('rbpurchase',$dataToSave,'rbpurchaseId',$rbpurchaseId);///    allowed char '\*#@/"~$^.,()|+_-=:��
		if($qResult)
				{
		if($rbpurchaseId>0 ){ $mgs= " Data updated Successfully";}
		if($rbpurchaseId<1 ){ $mgs= " Data Added Successfully"; $rbpurchaseId=  $qResult;}

		  $mgs=$rbpurchaseId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";

		}
		//_d($dataToSave);
		echo $mgs;

exit();

}

if($os->get('WT_rbpurchaseGetById')=='OK')
{
		$rbpurchaseId=$os->post('rbpurchaseId');

		if($rbpurchaseId>0)
		{
		$wheres=" where rbpurchaseId='$rbpurchaseId'";
		}
	    $dataQuery=" select * from rbpurchase  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);


 $record['refCode']=$record['refCode'];
 $record['rbpurchaseDate']=$os->showDate($record['rbpurchaseDate']);
 $record['rbvenderId']=$record['rbvenderId'];
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
 $record['paybleAmount']=$record['paybleAmount'];
 $record['paidAmount']=$record['paidAmount'];
 $record['dueAmount']=$record['dueAmount'];
 $record['remarks']=$record['remarks'];



		echo  json_encode($record);

exit();

}


if($os->get('WT_rbpurchaseDeleteRowById')=='OK')
{

$rbpurchaseId=$os->post('rbpurchaseId');
 if($rbpurchaseId>0){
 $updateQuery="delete from rbpurchase where rbpurchaseId='$rbpurchaseId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
