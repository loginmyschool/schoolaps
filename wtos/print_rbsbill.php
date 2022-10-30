<?php 
session_start();
include('wtosConfigLocal.php');// load configuration
include('wtos.php'); // load wtos Library
include('setupinfo/setupinfo.php');  

$rowId=$os->get('rowId');

$rbsbillId=$rowId;
 //$rbsbillId
$table=$os->rowByField('','rbsbill','rbsbillId',$rbsbillId);
$details=$os->rowsByField('','rbsbilldetails','rbsbillId',$rbsbillId);

$rbcontactId=$table['rbcontactId'];
$customer=$os->rowByField('','rbcontact','rbcontactId',$rbcontactId);


$customerCompany = $customer['company'];
$customerName = $customer['person'];
$designation='';
if($os->val($customer,'designation')!='')
{
  $designation = 'The '.$customer['designation'];
}

$customerBranch='';
if($os->val($customer,'branch')!='')
{
  $customerBranch = $customer['branch'];
}

$customerAddress = $customer['address'];
$customerEmail = $customer['email'];
$customerPhone = $customer['phone'];
$customerCst = '.....';
$customerVat = '.....';


$orderData=$table;
	// _d($orderData);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><? echo $company['companyName'] ?> INVOICE BILL</title>



</head>



<body>

<?php



	 

	if($rowId<1){

		echo '<div style="color:#FF0000; font-weight:bold; font-size:72px;" align="center">Error!</div>';
		exit();

	     }

?>

<div style="width:780px; margin-top:10px; text-align:right;" id="printBtn"><input type="button" onclick="printPage()" value="Print" />

&nbsp;<input type="button" value="Email" onclick="sentToMail()" style="display:none;" />

</div>



<div  id="emailBody" class="watermark" style="width:800px; margin:auto; padding:5px; border:1px solid #666666;">
<style>

.billTbl{ border-top:1px solid #000000; border-right:1px solid #000000;}

.billTbl td{ border-left:1px solid #000000; border-bottom:1px solid #000000; height:25px;}

.alignCenter td{ text-align:center;}

.paddingLeft td{ padding-left:15px;}

.bigTxt td{ font-size:12px;}

body{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;}
/*.watermark{ background:#FFFFFF url(<? echo $company['watermark'] ?>) no-repeat center center; background-size: 105% auto;}*/
.watermark{ background:#FFFFFF url(<? echo $company['watermark'] ?>) repeat;}
</style>


<div style="width:745px; font-weight:normal; font-size:14px; margin-top:10px;">

<table border="0" cellpadding="0" cellspacing="0" width="100%;">

	<tr>

		<td rowspan="3">
		<img src="<? echo $company['logo'] ?>" height="80" />
		</td><td align="center" >
		<font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:25px; font-weight:bold;"><? echo $company['companyName'] ?> </font><br />
		<? echo $company['address'] ?></td>

	</tr>

	<tr>

		<td  align="center"> <? echo $company['contactInfo'] ?></td> 

	</tr>

	<tr>

		<td  align="center" style="font-size:11px"> email us: <? echo $company['email'] ?>
		<br />INVOICE BILL
		</td> 

	</tr>

</table>

</div>

<div style="margin-top:20px;">

<table width="780" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:2px; font-size:14px;">

  <tr>

    <td align="left" valign="middle" ><? echo $orderData['billSubject']; ?>
	</td>

    <td align="right" valign="middle" >   &nbsp;&#x2751;<font style=" font-style:italic; font-size:11px;">Owner's copy </font>

  &nbsp;&#x2751; <font style=" font-style:italic;font-size:11px;"> Transport Copy </font>

    &nbsp;&#x2751;  <font style=" font-style:italic;font-size:11px;"> Buyer's copy </font></td>

  </tr>

</table>



</div>

<div style="width:780px; ">





<table border="0" cellpadding="2" cellspacing="0" width="100%;" class="billTbl">

  <tr>

    <td rowspan="5" valign="top" style="padding-left:5px;">To<br />

	<? if($designation!=''){ ?><? echo $designation ?><br /> <? 	} ?>
	<? if($customerName!=''){ ?>  <b><?php echo $customerName;?></b><br />   <? 	} ?>
	<? if($customerCompany!=''){ ?><?php echo $customerCompany;?><? 	} ?>
	<? if($customerBranch!=''){ ?><?php echo $customerBranch;?><br /><? 	} ?>
	<?php echo wordwrap($customerAddress,90, "<br />\n");?>  <br />
   <?php echo $customerPhone;?>   <?php echo $customerEmail;?>
		

	

	</td>

    <td width="125">Date</td>

    <td width="190"> <?php echo $os->showDate($orderData['billDate']);?></td>

  </tr>

  <tr>

    <td>BILL No. </td>

    <td> <?php echo $orderData['billNo'];?></td>

  </tr>

   

  

   <tr>

    <td>Customer Order No. </td>

    <td> <?php echo $orderData['orderNo'];?></td>

  </tr>

 

</table>









</div>







<table width="780" border="0" cellspacing="0" cellpadding="0" class="billTbl bigTxt" style="margin-top:20px;">

			  

			  
 <tr>

			<td valign="middle">&nbsp;<img src="<?php echo $site['url-wtos'];?>images/s.gif" alt="*" border="0" /> AMC Period</td>

			 

			<td valign="middle" >&nbsp;From : <b><?php echo $os->showDate($orderData['fromDate']);?> </b> &nbsp; &nbsp; Expiry Date : <b> <?php echo $os->showDate($orderData['expiryDate']);?> </b></td>

			  </tr>
			<tr>

			<td valign="middle">&nbsp;<img src="<?php echo $site['url-wtos'];?>images/s.gif" alt="*" border="0" /> Install Date</td>

			 

			<td valign="middle">&nbsp;<?php echo $os->showDate($orderData['registerDate']);?> </td>

			  </tr>  

			  <tr>

			<td valign="middle">&nbsp;<img src="<?php echo $site['url-wtos'];?>images/s.gif" alt="*" border="0" /> Service TAX NO</td>

			 

			<td valign="middle">&nbsp; <? echo $company['serviceTaxNo']; ?></td>

			  </tr>

			  

			</table>



<table width="780"  border="0" cellspacing="0" cellpadding="0" class="billTbl alignCenter watermark-s" style="margin-top:15px;">

	<tr>

		<td width="50"><b>SL NO.</b></td>

		<td width="410"><b>DESCRIPTION</b></td>

		<td width="100"><b>QUANTITY</b></td>

		<td width="90"><b>RATE</b></td>

		<td width="130"><b>AMOUNT</b></td>

	</tr>

	<?php

	$totalRow = 0;
	$i=1;
	
	while($val =$os->mfa($details)){
		$totalRow++;
		$rbproductId = $val['rbproductId'];
		$product = $os->rowByField('','rbproduct','rbproductId',$rbproductId); 
		
		$productModel=$product['model'];
		$productName=$product['name'];
		
		if($val['model']!=''){
		$productModel=  $val['model'];
		}
   
   
    
	?>

	<tr>

		<td style="border-bottom:none; "><?php echo $i;?></td>

		<td  style="border-bottom:none; text-align:left; padding-left:10px; padding-top:5px;"><b><?php echo $productName;?></b><span style=" font-size:10px">
		
		<? if($productModel!=''){ ?><br /> [Model: <? echo $productModel; ?>] <? } ?>
		<? if(isset($val['serialNo'])){ ?><br /> [Sl. No.: <? echo $val['serialNo']; ?>] <? } ?>
		
		</span></td>

		<td  style="border-bottom:none;"><?php echo $val['quantity'];?></td>

		<td  style="border-bottom:none;"><?php echo $val['unitPrice'];?></td>

		<td style="text-align:right; border-bottom:none;padding-right:5px; height:29px;"><?php echo $val['totalPrice'];?></td>

	</tr>

	<?php

		$i++;

	 	}

	 ?>

	 

	 

	 <?php 

		 if($totalRow<7){

		 for($c=$totalRow;$c<7;$c++){

	 ?>

	 

	 

	 <tr>

		<td style="border-bottom:none;">&nbsp;</td>

		<td  style="border-bottom:none;">&nbsp;</td>

		<td  style="border-bottom:none;">&nbsp;</td>

		<td  style="border-bottom:none;">&nbsp;</td>

		<td style="text-align:right;border-bottom:none; padding-right:5px; height:29px;">&nbsp;</td>

	</tr>

	 

	 

	  <?php }}?>

	  

	  

	   <tr>

		<td  >&nbsp;</td>

		<td  style="  text-align:left; padding-left:10px;" align="left">Sub Total<br />

		

		Discount<br />
 
		<!-- Vat @ <? echo $orderData['taxRate'].' %'; ?> <br />-->

		 

		  <font style="font-size:14px;"> &#x2751;  </font>Service Charge @ &nbsp; <?php if($orderData['taxRate']>0){echo $orderData['taxRate'].' %';}?><br /> 
<!--
		Delivery Charge<br />

		Installation Charge<br />
-->
		

<!--		Round Off.<br />-->
 
		

		</td>

		<td   >&nbsp;</td>

		<td  >&nbsp;</td>

		<td style="text-align:right;  padding-right:5px; height:29px;"><?php echo $orderData['productAmount'];?>

				<br /><?php echo $orderData['discountAmount'];?>

		<br /><?php echo $orderData['taxAmount'];?>

	 
		<br /><?php

					$grandTotal = round($orderData['paybleAmount']);

					$roundOff = $grandTotal-$orderData['paybleAmount'];

				//	echo round($roundOff,2);

				?>

		<br />

		</td>

	</tr>

	 

	

	 

	

	 

	 

	<tr>

		<td>&nbsp;</td>

		<td  align="left" style="font-size:18px; font-family:"Times New Roman", Times, serif" ><b style="font-family:"Times New Roman", Times, serif;">Grand Total</b></td>

		<td >&nbsp;</td>

		<td>&nbsp;</td>

		<td style="text-align:right;  padding-right:5px; font-size:18px;"><?php echo number_format($grandTotal,2);?></td>

	</tr>

	<tr>

		<td colspan="10" style="text-align:left; font-size:15px;"> Total in Words :<b> <?php

							if($orderData['paybleAmount']>0){								

								echo nl2br($os->no_to_words($grandTotal)).' only.';

							}

						?> </b>   </td>

		 

	</tr>

	 

</table>



 

			



	 



<div style="width:780px; font-weight:bold; margin-top:15px; font-style:italic; font-size:15px;">TERMS AND CONDITION</div>

<div style="width:780px;margin-top:10px;">

	1) Goods once sold will not be return back.<br />

	2) Our responsibility ceases as soon as goods are handed over to carrier/buyer of this representative.<br />

	3) All disputes regarding this bill are subject to kolkata Jurisdiction.<br />

	4) Payment against presentation of document.<br />

	<!--5) Payment should be made against Delivery by DD in favor of GENESIS Automation Systems at Kolkata.<br />

	6) Please Pay by A/c. Payee Cheque only.-->

	 

	 

	 

	 

	

	

 

	<br />

	

	<br />

	

	Please send us your Bank Draft/Cheque or Account Transfer at our SBI bank account  for Rs. <span style="font-weight:bold; border-bottom:1px solid #333333;">&nbsp;<?php echo number_format($grandTotal,2);?>&nbsp;</span>(Rupees<span style="font-weight:bold; border-bottom:1px solid #333333;">&nbsp;<?php echo nl2br($os->no_to_words($grandTotal)).' only.';?>&nbsp;</span>) 

	in favor of M/s <? echo $company['companyName'] ?>. Payable at Kolkata.<br /><br />

	For <b><? echo $company['companyName'] ?></b>

	<table width="99%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div style="margin-top:25px; padding-left:50px; font-style:inherit; font-weight:bold;">Authorised Signatory</div></td>

    <td style="text-align:right; font-weight:bold;font-size:18px;">Please Pay  <? echo $company['accountNo'] ?><br />

	VENDOR ID : <? echo $company['vendorId'] ?></td>

  </tr>

</table>

	

</div>	



</div>

<?php

	$_SESSION['bill-email-send']['emailId'] = $customerEmail;

	$_SESSION['bill-email-send']['fileName'] = 'Invoice Bill ('.date("d-m-Y").').html';

	$_SESSION['bill-email-send']['subject'] = 'GENESIS-Invoice-Bill';

	$_SESSION['bill-email-send']['fromName'] = 'GENESIS.';

	

	$_SESSION['bill-email-send']['fromEmail'] = 'admin@webtrackers.co.in';

?>

<script>

	function printPage(){

		document.getElementById("printBtn").style.display="none";

		window.print();

		document.getElementById("printBtn").style.display="block";

	}

	function sentToMail()

 	{		

	//	window.open('<? echo $site['url'] ?>sendMail.php','','width=715,height=130','top=200,left=300');

	}

</script>

</body>

</html>


	
	
	 
	