<?php 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
include($site['root-wtos'].'admission_admin_function_helpers.php');
$fees_payment_id = $_GET['fees_payment_id'];
$directprint=$os->get('directprint');
$copy_type=$os->get('copy_type');


$fees_payments_rs=$os->get_fees_payment(''," fees_payment_id='$fees_payment_id'  ");
$fees_payment= $os->mfa($fees_payments_rs);
$historyId=$fees_payment['historyId'];
$studentId=$fees_payment['studentId'];

$history= $os->rowByField('','history',$fld='studentId',$studentId,$where=" and historyId='$historyId' ",$orderby='');
$student= $os->rowByField('','student',$fld='studentId',$studentId,$where=" ",$orderby='');
$branch= $os->rowByField('','branch',$fld='branch_code',$history['branch_code'],$where=" ",$orderby='');
$branch_name=$branch['branch_name'];
 

//$student= $os->rowByField('','student',$fld='studentId',$studentId,$where=" ",$orderby='');

$fees_student_Ids=$fees_payment['fees_student_Ids'];
 
$querry="select * from fees_student where  fees_student_id IN (".$fees_student_Ids.") ";
$record_rs=$os->mq($querry);
$feesData=array();


 
			/*while($record=$os->mfa($record_rs))
			{
								
							$fees_student_id=$record['fees_student_id'];
							$querry_2="select * from fees_student_details where  fees_student_id ='$fees_student_id' ";
							$record_rs_2=$os->mq($querry_2);
							while($record_2=$os->mfa($record_rs_2))
							{
							 $record['details'][$record_2['fees_student_details_id']] =$record_2;
							}
								
			   				$feesData[$fees_student_id]=$record;
			   
				
			}*/
				
	 
	$schoolQ="select * from school_setting limit 1";
	$school_setting_rs =$os->mq($schoolQ);	
	$school_setting =$os->mfa($school_setting_rs);
	//$school_setting['school_name']=$school_setting['school_name'].'<br>gg'.$branch_name;
	
	//_d($school_setting );
	
	
	include('templateClass.php');
	$template_class=new templateClass();
	 if($branch['branch_name']!=''){ $template_class->school_setting['address']=$branch['branch_name'].'<br>'.$branch['address']; }
	  
	 if($branch['contact']!=''){ $template_class->school_setting['contact']=$branch['contact']  ;}
	
	 
	
	//render_fees_payment_receipt($template='print_receipt_template_1.php',$fees_block,$student_info_block,$school_setting)
	
		
	// _d($feesData);
	//_d($history);
	//_d($student);
	// _d($fees_payment);
  $image_barcode=$os->student_barcode_href($studentId);
  
   $addedBy=$os->rowByField('','admin','adminId',$fees_payment['addedBy']);
    //  _d($addedBy);
	
	 function n_f($number)
	 {
	   $number=number_format($number, 2, '.', '');
	  return $number;
	 }
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Payments</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   
   
</head>

<body>
<div style="width:780px; margin-top:10px; text-align:center;" id="printBtn">
<input type="button" onclick="printPage()" value="Print This Page" style="cursor:pointer" />&nbsp;&nbsp;
<input type="button" onclick="print_copy('both')" value="Print Student and Office Copy " style="cursor:pointer"  />&nbsp;&nbsp;
<input type="button" onclick="print_copy('student')" value="Print Student Copy" style="cursor:pointer"  />&nbsp;&nbsp;
<input type="button" onclick="print_copy('office')" value="Print Office Copy" style="cursor:pointer"  />
 


</div>

<div class="printArea">

<? $os->startOB();?>   
<!-- -->


 
 <table style="color:#000000;"   >
 <tr>
    <td style="width:100px;"  > Name:  </td>
    <td><b><? echo $student['name'];  ?></b>  </td>
  </tr>
   <tr>
    <td  > Reg. No: </td>
    <td> <b> <? echo $student['registerNo'];  ?> </b>     </td>
  </tr>
  
  <tr>
    <td  > Class:  </td>
    <td><? echo $os->classList[$history['class']];  ?> - <? echo $history['asession'];  ?></td>
  </tr>
 <!-- <tr style="display:none;">
    <td>Sec Roll</td>
    <td><? echo $history['section'];  ?>  <? echo $history['roll_no'];  ?></td>
  </tr>-->
   
  
  <!--<tr>
    <td>DOB</td>
    <td><? echo $os->showDate($student['dob']);  ?></td>
  </tr>
  <tr>
    <td>Father Name</td>
    <td><? echo $student['father_name'];  ?></td>
  </tr>-->
  <tr>
    <td>Mobile:</td>
    <td><? echo $student['mobile_student'];  ?></td>
  </tr>
  
   <!--<tr style="display:none;">
    <td>Address</td>
    <td style="font-size:10px;"><? echo $student['vill'].' '.$student['po'].' '.$student['ps'].' '.$student['dist'].' '.$student['block'];   ?></td>
  </tr>-->
   
</table>
 
 
<? $student_info_block= $os->getOB();?>

<? $os->startOB();?>
 
 <table  class="">
 <tr>
    <td>Receipt No:</td>
    <td><b> <? echo $fees_payment['receipt_no'];  ?> </b></td>
  </tr>
 <tr>
    <td style="width:120px;"   > Paid Date:  </td>
    <td><? echo $os->showDate($fees_payment['paidDate']);  ?>  </td>
  </tr>
   
  
  <tr>
    <td>Generated By:</td>
    <td><? echo $addedBy['name'];  ?></td>
  </tr>
  <tr>
    <td>Print Date:</td>
    <td><? echo date('Y-m-d');  ?></td>
  </tr>
  
 <!-- <tr>
    <td>Paid Amount</td>
    <td><? echo $fees_payment['paidAmount'];  ?></td>
  </tr>
  -->
   
   
</table>
 

<? $fees_info_block= $os->getOB();?>

<? $os->startOB();?>

 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td>Description</td>
    
    <td align="right">Amount</td>
  </tr>
  
 <tr class="row_no_data">
				<td>&nbsp; </td>     
				<td>&nbsp; </td>
				</tr>


<? 

 
$rowcount=0;
$total=0;


$student_fees_amounts_arr=array();
if($fees_payment['student_fees_amounts_str']!='')
{
    $student_fees_amounts_arr=json_decode($fees_payment['student_fees_amounts_str'],true);
}

//_d( $student_fees_amounts_arr);

while($record=$os->mfa($record_rs))
{
	 
	$fees_student_id=$record['fees_student_id'];
	
	$amount_status_str=$student_fees_amounts_arr[$fees_student_id];
	$amount_status_arr=explode('-',$amount_status_str);
	$amount=(int)$amount_status_arr[0];
	$status_due=$amount_status_arr[1];
	
//	_d($record);		
		 
	$rowcount++;
	
	
	
	// waveoff data-------
	$amount_with_waive=0;
	   $waive_data['total']=0;
	   $waive_data['list_amount']=array();
	  
	    $waved_off_q=" select wo.*  from fees_waiveoff wo   
	    where wo.fees_student_id ='$fees_student_id'
	    and history_id='$historyId' and fees_payment_id='$fees_payment_id' ";
		
		 $waved_off_rs=$os->mq($waved_off_q);
		 while($row_w=$os->mfa( $waved_off_rs))
		{
			 $waive_amount=$row_w['waive_amount'];
			 
			  $waive_data['total']= $waive_data['total']+$waive_amount;
		 
		      $waive_data['list_amount'][$row_w['fees_waiveoff_id']]=$waive_amount;
		
		}   
	 $amount_with_waive= $amount+$waive_data['total'];
	  
	 // -------------------------
	
	 
	
	
	 $record['totalPayble']=$amount;
	 
	 $total=$total+$amount;
	
	
	 
	
	
	?>				
<tr class="row_data"  >
    <td style="font-weight:bold;">
	 
	
	<? echo $record['feesType'];  ?> Fees  <? echo $os->feesMonth[$record['month']];  ?> <? echo $record['year'];  ?> 
	     <? if(trim($status_due)=='installment'){ ?>  [ Due ] <?  } ?>
	
	  </td>     
    <td align="right"><? echo n_f($amount_with_waive);  ?></td>
  </tr>		 
		<? if($waive_data['total']>0){?>
						<tr class="row_data" style="font-size:11px; font-style:italic;">
						<td> &nbsp;&nbsp;  Waived Off amount
						
						</td>     
						<td align="right"><? echo $waive_data['total'];  ?></td>
						</tr>		
		
		<? }?>	   
	
	
	<?
			}
			
			
			for($i=$rowcount;$i<5;$i++)
			{
				?>
				<tr class="row_no_data">
				<td>&nbsp; </td>     
				<td>&nbsp; </td>
				</tr>		 <? 
			  
			
			}
			
			
			
 
 
$paid=(int)$fees_payment['paidAmount'];
 //$currentDueAmount=$total-$fees_payment['paidAmount'];
 $currentDueAmount=(int)$fees_payment['currentDueAmount'];
 if($currentDueAmount<0){ $currentDueAmount=$currentDueAmount*-1;}
 
 $special_discount=(int)$fees_payment['special_discount'];
$paybleAmount=(int)$fees_payment['paybleAmount'];
 
 // _d($fees_payment);
?>

  
  <?  if($special_discount>0){ ?>
 <tr class="total_row">
    <td>Total amount<span class="inwordtext">   <? echo $os->no_to_words($total); ?> only</span> </td>
    <td align="right"><? echo n_f($total) ?> </td>
  </tr>
  
 <tr class="total_row">
    <td>Discount  </td>
    <td align="right"><? echo $special_discount ?> </td>
  </tr>
  
  <? } ?>
   <tr class="total_row">
    <td>Payble<span class="inwordtext">   <? echo $os->no_to_words($paybleAmount); ?> only</span> </td>
    <td align="right"><? echo n_f($paybleAmount); ?> </td>
  </tr>
  
  
   <tr class="total_row">
    <td>Paid <span class="inwordtext">   <? echo $os->no_to_words($paid); ?> only</span></td>
    <td align="right"><? echo n_f($paid) ?>  </td>
  </tr>
  
    <tr class="total_row">
    <td>
	<?  $due=$os->no_to_words($currentDueAmount); if(trim($due)==''){ $due='zero';} ?>
	Due <span class="inwordtext">   <? echo $due; ?> only</span></td>
    <td align="right"><? echo n_f($currentDueAmount); ?>  </td>
  </tr>
  
   
  
</table>



 
 
<? $fees_block= $os->getOB();

  
  
   
 if($copy_type=='student' || $copy_type=='both'  ) {     
echo  $template_class->render_fees_payment_receipt($fees_info_block,$fees_block,$student_info_block,$school_setting,$template='');
?>
<div style="text-align:center; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">Student Copy </div>
<? } ?>




<? if($copy_type=='office' || $copy_type=='both'  ) {   
?>
<? if( $copy_type=='both'  ) {   
?>
<br />

<div style="border-bottom:1px dotted #333333"> &nbsp; </div>

<br />
<? } ?>
<?

echo  $template_class->render_fees_payment_receipt($fees_info_block,$fees_block,$student_info_block,$school_setting,$template='');
 ?>
<div style="text-align:center; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">Office Copy </div>

<? } ?>

<style>
.printArea{ padding:10px;}
.row_data td{ color:#000000; border-bottom:1px dotted #333333;}
.ffes_block .row_data td{color:#000000; border-bottom:1px dotted #333333;}
.inwordtext{ color:#000000;}
.total_row td {
  
  border-top: 1px solid #666666;
   
}
 
</style>

<div>
 
  <script>
	function printPage(){
		document.getElementById("printBtn").style.display="none";
		window.print();
		
			setTimeout(() => {
			document.getElementById("printBtn").style.display="block";
			}, "3000")

		 
	}
	<?  if($directprint=='ok'  ){?>
	       printPage();
	     // window.close();
	<?  } ?>
	
	function print_copy(copy_type)
	{
	     var URLStr='printFeesReceipt.php?directprint=ok&copy_type='+copy_type+'&fees_payment_id='+<? echo $fees_payment_id; ?>;   		
	   window.location=URLStr;
	}
	
	
</script>

</body>
</html>
