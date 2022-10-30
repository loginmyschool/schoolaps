<?
function pbill($listingQuery)
{
global $os,$site;

 $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];

  $contactList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');
  $paymentList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbpbillId','rbpbillpayment','rbpbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); // get payments
	$productList= $os->getIdsDataFromQuery($rsRecords->queryString,'rbpbillId','rbpbilldetails','rbpbillId',$fields='',$returnArray=true,$relation='12M',$otherCondition=''); 
	
	$prodNameList= $os->getProductsArray();
	 
	
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

		<? } ?>

<?
function sbill($listingQuery)
{
global $os,$site;

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

		 

<? } ?>