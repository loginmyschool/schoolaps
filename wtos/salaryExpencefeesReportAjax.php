<? 
/*
   # wtos version : 1.1
   # page called by ajax script in rbpBillReportDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?

function getResults($q,$keyFld='',$valFld='')
{

	global $os;
	$data=array();
	$totalQ=$os->mq($q);
	while($rec=$os->mfa($totalQ))
	{
	   
	   if($keyFld!='' && $valFld!='' )
	   {
	        $data[$rec[$keyFld]]=$rec[$valFld];
	   }
	   elseif($keyFld!='' && $valFld=='')
	   {
	     $data[$rec[$keyFld]]=$rec;
	   
	   }else
	   {
	      $data[]=$rec;
	   
	   }
	   
	    
	}
	return $data;
	
}
if($os->get('WT_searchListing')=='OK')
{
    $where='';
	$showPerPage= $os->post('showPerPage');
    $yearSearchVal=  $os->post('yearSearch_s');
 //$listingQuery1="SELECT sum(payble) paybleAmount_amt,sum(paid_amount) paidAmount,month   FROM fees where year='$yearSearchVal' and paid_date!=''  group by  month";
//	$rsRecords1=$os->mq($listingQuery1);
	
	
//$totalQ="SELECT sum(payble) payble_amt , sum(paid_amount) paid_amount ,  date_format(paid_date, '%M %Y') dm FROM fees  where  paid_date!='' group by  dm order by paid_date asc   ";

 $totalQ="SELECT sum(payble) payble_amt , sum(paid_amount) paid_amount ,CONCAT(month,' ',year) dm FROM fees  where  year='$yearSearchVal' GROUP BY month order by paid_date asc   ";
$fees_all2=getResults($totalQ,'dm','');
foreach($fees_all2 as $key=>$val)
{

	$monthAndYear=explode(" ",$key);
	$month=$monthAndYear[0];
	$year=$monthAndYear[1];
	$monthAndYear2=$os->feesMonth[$month]." ".$year;
	$val['dm']=$monthAndYear2;
	$fees_all[$monthAndYear2]=$val;	
}



$totalQ="SELECT sum(amount) exp_amt ,  date_format(dated, '%M %Y') dm FROM expense group by  dm order by dated asc   ";
$expense_all=getResults($totalQ,'dm','');


$totalQ="SELECT sum(paidAmount) paid_amount ,  date_format(paidDate, '%M %Y') dm FROM salary group by  dm order by paidDate asc   ";
$salary_all=getResults($totalQ,'dm','');


$totalQ="SELECT sum(paidRegistrationFees) paidRegistrationFees_amount ,  date_format(paymentDate, '%M %Y') dm FROM payment group by  dm order by paymentDate asc   ";
$regFees_all=getResults($totalQ,'dm','');
//_d($regFees_all);


/*$totalQ="SELECT sum(registrationFees) registrationFees_amount ,  date_format(admission_date, '%M %Y') dm FROM history group by  dm order by admission_date asc   ";
$totalRegFees_all=getResults($totalQ,'dm','');




 foreach($totalRegFees_all as $Key=>$Val)
 {
	  if (array_key_exists($Key,$regFees_all))
	  {
		
        $regFees_all[$Key]['registrationFees_amount']=$Val['registrationFees_amount'];
		
	  }
 }
*/



$beginDate= $yearSearchVal.'-01-01';
$endDate= $yearSearchVal.'-11-31';

$month=$os->dateIntervalList($beginDate,$endDate,$intervals='P1M',$format='F Y' ,$modify='+1 Month');// $begin $end  format 2012-08-01
//_d($month);
	$expense_all_temp=array();
	$salary_all_temp=array();
	
	$fees_all_temp=array();
	
	$regFees_all_temp=array();

foreach($month as $mVal)
{
$fees_all_temp[$mVal]=$fees_all[$mVal];
if($fees_all_temp[$mVal]=='')
{   
$fees_all_temp[$mVal]['payble_amt']=0;
$fees_all_temp[$mVal]['paid_amount']=0;
$fees_all_temp[$mVal]['dm']=$mVal;
}
	
	
	
$expense_all_temp[$mVal]=$expense_all[$mVal];
if($expense_all_temp[$mVal]=='')
{   
$expense_all_temp[$mVal]['exp_amt']=0;
$expense_all_temp[$mVal]['dm']=$mVal;
}




$regFees_all_temp[$mVal]=$regFees_all[$mVal];
if($regFees_all_temp[$mVal]=='')
{   
$regFees_all_temp[$mVal]['paidRegistrationFees_amount']=0;
$regFees_all_temp[$mVal]['dm']=$mVal;
}











$salary_all_temp[$mVal]=$salary_all[$mVal];
if($salary_all_temp[$mVal]=='')
{   
$salary_all_temp[$mVal]['paid_amount']=0;
$salary_all_temp[$mVal]['dm']=$mVal;

}


}
$expense_all=$expense_all_temp;
$salary_all=$salary_all_temp;

$fees_all=$fees_all_temp;

//_d($fees_all);

$regFees_all=$regFees_all_temp;
//_d($regFees_all);
?>
<div class="listingRecords">
<div class="pagingLinkCss">  </div>
<table style="width:100%;"> 

<tr>


<td style="width:25%; vertical-align:top; padding-right:10px;">
<h3>Fees Report</h3>
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:100%;"  >
							<tr class="borderTitle" >
							<td ><b>Month</b></td>  
							<td ><b>Year</b></td>  
							<td ><b>Total</b></td>  
							<td ><b>Collected</b></td>  
							<td ><b>Due</b></td>  
						    </tr>
							<?php
							
							
							  $totalPaybleAmt=0;
						   $totalPaidAmt=0;
						   $totalDueAmt=0;
							
							
							foreach($fees_all as $record1){ 
							
							$monthAndYear=explode(" ",$record1['dm']);
							$dueAmount=$record1['payble_amt']-$record1['paid_amount'];
							?>
							<tr class="trListing" >
							
 <td> <? echo $monthAndYear[0] ?></td>  
  <td><?php echo $monthAndYear[1] ?> </td>  
  <td style="text-align:right;"><? echo (int) $record1['payble_amt'] ?>  </td>  
  <td style="text-align:right;"><?php echo (int) $record1['paid_amount']?> </td>  
  <td style="text-align:right;"><?php echo $dueAmount?> </td>  						
				 </tr>
				  <? 
				  $totalPaybleAmt=$totalPaybleAmt+$record1['payble_amt'];
				  $totalPaidAmt=$totalPaidAmt+$record1['paid_amount'];
				  $totalDueAmt=$totalDueAmt+$dueAmount;
				  } ?>  
			<tr class="trListing" >
			<td style="color:red"><strong>Total:</strong></td>
			<td></td>
			<td style="text-align:right;"><?echo $totalPaybleAmt;?></td>
			<td style="text-align:right;"><?echo $totalPaidAmt;?></td>
			<td style="text-align:right;"><?echo $totalDueAmt;?></td>	
            </tr>				 
</table>

</td> 	
		
	<td style="width:25%; padding-right:10px;">	
	<h3>Expense Report</h3>
	
	
	<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:100%;" >
							<tr class="borderTitle" >
							<td ><b>Month</b></td>  
							<td ><b>Year</b></td>  
							<td ><b>Total</b></td>  
							
						    </tr>
							<?php
							foreach($expense_all as $rec) { 
						$monthAndYear=explode(" ",$rec['dm']);
						//if($rec['exp_amt']>0){
							?>
							<tr class="trListing" >
							
 <td> <? echo $monthAndYear[0] ?> </td>  
  <td><?php echo $monthAndYear[1] ?> </td>  
  <td style="text-align:right;"><? echo (int) $rec['exp_amt'] ?> </td>  
  						
				 </tr>
						<? 
						//}
				 
				  $totalExpenseAmt=$totalExpenseAmt+$rec['exp_amt'];
				  } ?>  
			<tr class="trListing" >
			<td style="color:red"><strong>Total:</strong></td>
			<td></td>
			
			<td style="text-align:right;"><?echo $totalExpenseAmt;?></td>	
            </tr>				 
</table> 

</td>



	
	<td style="width:25%;">	
	
	
	<h3>Salary Report</h3>
	
	
			<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:100%;"  >
							<tr class="borderTitle" >
							<td ><b>Month</b></td>  
							<td ><b>Year</b></td>  
							<td ><b>Total</b></td>  
							
						    </tr>
							<?php
							foreach($salary_all as $rec) { 
						$monthAndYear=explode(" ",$rec['dm']);
						//if($rec['paid_amount']>0){
							?>
							<tr class="trListing" >
							
 <td> <? echo $monthAndYear[0] ?> </td>  
  <td><?php echo $monthAndYear[1] ?> </td>  
  <td style="text-align:right;"><? echo (int) $rec['paid_amount'] ?> </td>  
  						
				 </tr>
						<? 
						//}
				 
				  $totalSalaryPidAmt=$totalSalaryPidAmt+$rec['paid_amount'];
				  } ?>  
			<tr class="trListing" >
			<td style="color:red"><strong>Total:</strong></td>
			<td></td>
			
			<td style="text-align:right;"><?echo $totalSalaryPidAmt;?></td>	
            </tr>				 
</table> 
</td>		
		
		
		
		
		
		
	<td style="width:25%;">	
	
	
	<h3>Registration Fees Report</h3>
	
	
			<table  border="0" cellspacing="0" cellpadding="0" class="noBorder" style="width:100%;"  >
							<tr class="borderTitle" >
							<td ><b>Month</b></td>  
							<td ><b>Year</b></td> 
                           <!--  <td ><b>Total</b></td> -->							
							<td ><b>Collected</b></td>  
							<!--<td ><b>Due</b></td>  -->
						    </tr>
							<?php
							foreach($regFees_all as $rec) { 
						$monthAndYear=explode(" ",$rec['dm']);
						//if($rec['paid_amount']>0){
							?>
							<tr class="trListing" >
							
 <td> <? echo $monthAndYear[0] ?> </td>  
  <td><?php echo $monthAndYear[1] ?> </td>  
 <!-- <td><? echo (int) $rec['registrationFees_amount'] ?> </td>-->
  <td style="text-align:right;"><? echo (int) $rec['paidRegistrationFees_amount'] ?> </td>  
  		<!-- <td><? echo (int) ($rec['registrationFees_amount']- $rec['paidRegistrationFees_amount'])?> </td> 	-->			
				 </tr>
						<? 
						//}
				 
				  $totalRegFeesPaidAmt=$totalRegFeesPaidAmt+$rec['paidRegistrationFees_amount'];
				  $totalRegFeesAmt=$totalRegFeesAmt+$rec['registrationFees_amount'];
				  $dueRegFees=$totalRegFeesAmt-$totalRegFeesPaidAmt;
				  
				  } ?>  
			<tr class="trListing" >
			<td style="color:red"><strong>Total:</strong></td>
			<td></td>
			<!--<td><?echo $totalRegFeesAmt;?></td>-->
			<td style="text-align:right;"><?echo $totalRegFeesPaidAmt;?></td>	
			<!--<td><?echo $dueRegFees;?></td>-->	
            </tr>				 
</table> 
</td>		
		
		
	
		
		
		
		
		
		
		
</tr>		
		
	</table> 	
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 


