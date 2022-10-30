<? session_start();
ob_start();
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
include('setupinfo/setupinfo.php');
ob_end_clean();
$feesId = $_GET['feesId'];
$Query="select * from fees where  feesId='$feesId' "; 
$result=$os->mq($Query);
$record=$os->mfa($result);


$historyId=$record['historyId'];
$studentId=$record['studentId'];

$studentQuery="select * from student where  studentId='$studentId' "; 
$studentResult=$os->mq($studentQuery);
$studentData=$os->mfa($studentResult);
$historyData=$os->rowByField('','history','historyId',$historyId);

//$receiptNo=$os->getReceiptNo('fees',$feesId,$historyId,$studentId);
 $receiptNoQuery="select * from printreceiptno where printreceiptnoId>0 and  studentId='$studentId' and historyId='$historyId' and tableId='$feesId' and tableName='fees'"; 
$receiptNoMq=$os->mq($receiptNoQuery);
$receiptNoData=$os->mfa($receiptNoMq);

$receiptNo=$receiptNoData['receiptNo'];
error_reporting(0);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title><? echo $header['titletag'] ?></title>
<style>
.billTbl{ border-top:1px solid #000000; border-right:1px solid #000000;}
.billTbl td{ border-left:1px solid #000000; border-bottom:1px solid #000000;}
.alignCenter td{ text-align:center;}
.paddingLeft td{ padding-left:15px;}
.bigTxt td{ font-size:12px;}
body{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;}
</style>
</head>
<body>
<?php

	 
?>
<div style="width:815px; margin-top:10px; margin-left:475px;" id="printBtn"><input type="button" onclick="printPage()" value="Print" />
&nbsp;<input type="button" value="Email" onclick="sentToMail()" style="display:none;" />
</div>
<?for($i=0;$i<2;$i++){
	
	if($i==0)
	{
		$copy='Student Copy';
	}
	else
	{
		$copy='Office Copy';
	}
	
	
	?>
</br>

<div class="watermark" style="width:835px; margin:auto; padding:5px; border:1px solid #666666;">
<style>
.watermark{ background:#FFFFFF url(<? echo $company['watermark'] ?>) repeat;}
</style>

<div style="" id="emailBody">

<?php include('billHeader.php'); ?> 

<div style="width:815px; ">
<div style="text-align:center; font-style:italic;"><span style="float:left;"><b>Receipt No: </b><?echo $receiptNo;?></span><b>Fees</b>
<span style="float:right;"><?echo $copy;?></span>



</div>


<table border="0" cellpadding="2" cellspacing="0" width="100%;" class="billTbl">
  <tr>
    <td rowspan="5" valign="top" style="padding-left:5px;"> 
	
	 <span style="font-size:15px"><b><?php echo $studentData['name'];?><!--[<?echo $studentData['studentId']?>]--> </b></span>
<br />	 class: <?echo $historyData['class'];?> <!--Section:<?echo $historyData['section'];?>--> Roll No: <?echo $historyData['roll_no'];?>
		<br />
	<br />
    <span style="font-size:15px">Address:</span><br />
 <span style="font-size:18px"><?php echo $studentData['vill'];?>	 </span>	<br />
<?php echo $studentData['po'];?>,	 <?php echo $studentData['pin'];?>, <?php echo $studentData['state'];?><br />
 
	 
	
	</td>
    <td width="125">Student Id</td>
    <td width="190"><b> <?php echo $studentData['studentId'];?></b> </td>
  </tr>
  
  <tr>
    <td>Month </td>
    <td> <?php echo $os->feesMonth[$record['month']];?> </td>
  </tr>
  
  <tr>
    <td>Year </td>
    <td> <?php echo $record['year'];?> </td>
  </tr>
  <tr>  
    <td>Paid Date </td>
    <td>  <?php   echo $os->showDate($record['paid_date']);?> 
		</td>
  </tr>
  
    
 
</table>




</div>

 

<table width="815"  border="0" cellspacing="0" cellpadding="0" class="billTbl paddingLeft" style="margin-top:15px;">
	<tr>
		<td width="410"><b>DESCRIPTION</b></td>
		<td width="130"><b>AMOUNT</b></td>
	</tr>
	
	<tr>  
		<td  style="border-bottom:none;">Fees Amount</td>
		<td style="text-align:right; border-bottom:none;padding-right:5px; height:29px;"><?php echo $record['fees_amount'];?></td>
	</tr>
	
	<tr>
		<td  style="border-bottom:none;">Discount</td>
		<td style="text-align:right; border-bottom:none;padding-right:5px; height:29px;"><?php echo $record['discount'];?></td>
	</tr>
	
	
	<tr>
		<td  style="border-bottom:none;">Fine</td>
		<td style="text-align:right; border-bottom:none;padding-right:5px; height:29px;"><?php echo $record['fineAmount'];?></td>
	</tr>

	
	
	<tr>
		<td  style="">Medicine</td>
		<td style="text-align:right; padding-right:5px; height:29px;"><?php echo $record['medicineAmount'];?></td>
	</tr>

	
	
	
	  
	   
	
	<tr>
		<td >Total Payble: <b><?echo nl2br($os->no_to_words($record['payble'])).' only.';?></b></td>
		<td style="text-align:right;padding-right:5px; height:29px;" ><b>
		<?echo $record['payble'];?></b></td>
		 
		 
		 
	</tr>
	
	 
	
	 
	 
	
	
	 
</table>
<table width="815" border="0" cellspacing="0" cellpadding="0" style="margin-top:15px;" class="billTbl paddingLeft">
<tr>
<td width="410">
Paid amount : <b><?echo nl2br($os->no_to_words($record['paid_amount'])).' only.';?></b>
</td>
<td style="text-align:right;padding-right:5px; height:29px;" width="130">
<b><?echo $record['paid_amount'];?></b>
</td>
</tr>





 </table>
			

<table style="margin-top:65px;">	
<tr>
<td width="535">Collected By - <b><? echo $os->rowByField('name','admin','adminId',$record['modifyBy']); ?></b>
</td>
<td><b>Authorized Signature...........................</b>
</td>
</tr>

</table>	

<?php //include('billFooter.php'); ?> 


</div>


 </div>                                       





<?}
?>


<script>
	function printPage(){
		document.getElementById("printBtn").style.display="none";
		window.print();
		document.getElementById("printBtn").style.display="block";
	}
	function sentToMail()
 	{		
		//window.open('<? echo $site['url'] ?>sendMail.php','','width=715,height=130','top=200,left=300');
	}
</script>
</body>
 
</html>
