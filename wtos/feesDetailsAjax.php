<? 
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


if($os->get('studentListing')=='OK'&& $os->post('searchStudent')=='OK' )
{
	
$andFeesStatus=  $os->postAndQuery('feesStatus_s','status','=');
$andAsession=  $os->postAndQuery('asession_s','year','=');
$andClass=  $os->postAndQuery('classList_s','class','=');
$andSection=  $os->postAndQuery('section_s','section','=');
$studentQuery="select * from fees  where feesId>0  $andAsession $andClass $andSection  $andFeesStatus order by historyId";
$resource=$os->pagingQuery($studentQuery,$os->showPerPage,false,true);
$rsRecords=$resource['resource'];

$classQuery="SELECT DISTINCT class from fees  where feesId>0  $andAsession order by class";
$classMq=$os->mq($classQuery);


?>
<table>
<td>
<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td  style="display:none;">Action </td>
								


<td style="display:none;"><b>historyId</b></td>  
<td style="display:none;"><b>studentId</b></td>  
<td ><b>Student</b></td> 
<td ><b>Class</b></td>  
<td ><b>Month</b></td>  
<td ><b>Year</b></td>  
<td ><b>Payable Amt.</b></td> 
<td ><b>Paid Amount</b></td>  
<td ><b>Due Amount</b></td> 
<td ><b>Paid Date</b></td>  

<td ><b>Remarks</b></td>  
<td ><b>Status</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td style="display:none;"> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_feesGetById('<? echo $record['feesId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td style="display:none;"><?php echo $record['historyId']?> </td>  
  <td style="display:none;"><?php echo $record['studentId']?> </td>  
  <td >  <? echo $os->rowByField('name','student','studentId',$record['studentId']); ?> </td>
<td><strong><? echo $os->rowByField('class','history','historyId',$record['historyId']); ?></strong></td>
 
  <td> <? $os->editSelect($os->feesMonth,$record['month'],'fees','month','feesId',$record['feesId'], $inputNameID='editSelect',$extraParams='class="editSelect" ','') ?>  </td>
	
 <td> <? $os->editSelect($os->feesYear,$record['year'],'fees','year','feesId',$record['feesId'], $inputNameID='editSelect',$extraParams='class="editSelect" ','') ?>  </td>
			

 <td><?php //echo $record['payble']; 
 $os->editText($record['payble'],'fees','payble','feesId',$record['feesId'], $inputNameID='editText',$extraParams='class="editText" ');?>     </td>
 
 
 <td> 
 
 
 
 
 
 
 
<? 
$os->editText($record['paid_amount'],'fees','paid_amount','feesId',$record['feesId'], $inputNameID='editText',$extraParams='class="editText" ');

//$totalPaidAmount=$os->totalPaidAmt($record['historyId']);
//$os->editText($totalPaidAmount,'fees','paid_amount','feesId',$record['feesId'], $inputNameID='editText',$extraParams='class="editText" ');?>  </td>







<?$dueAmt=$record['payble']-$record['paid_amount'];
$style='';
if($dueAmt>0)
{
	$style="style=color:red";
}
?>


 <td  <? echo $style?>><?php   echo $dueAmt; ?></td>

 
   <td> 

<?
$os->editDate($os->showDate($record['paid_date']),'fees','paid_date','feesId',$record['feesId'], $inputNameID=rand(),$extraParams='class="wtDateClass textbox fWidth" ');
?>  
 </td>

 
 
 
 
   <td> 
<? $os->editText($record['remarks'],'fees','remarks','feesId',$record['feesId'], $inputNameID='editText',$extraParams='class="editText" ');?>  </td>

 
  

		<td> <? $os->editSelect($os->feesStatus,$record['status'],'fees','status','feesId',$record['feesId'], $inputNameID='editSelect',$extraParams='class="editSelect" ',$os->feesStatusColor) ?>  </td>
			


			
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
</td>
<td>
<!--
<p><strong>Class: <?echo $os->post('classList_s')?></strong></p>
<hr>
<p><strong>Collected Amount :<?echo $collectedAmt;?></strong></p>
<p><strong>Due Amount :<?echo ($payableAmt-$collectedAmt);?></strong></p>-->
<table border="0" cellspacing="0" cellpadding="0" class="noBorder">
<p><strong>YEAR :<?echo $os->post('asession_s');?></strong></p>
<hr>
<tr class="borderTitle">
<td ><strong>Class</strong></td>
<td ><strong>Payable Amt.</strong></td>
<td ><strong>Collected Amt.</strong></td>
<td ><strong>Due Amt.</strong></td>
</tr>
<?

$classAmtArray=$os->calTotalAmtAndColAmt($os->post('asession_s'));
//_d($classAmtArray);
$totalpayableAmt=0;
$totalpaidAmt=0;
$totaldueAmt=0;
while($classData=$os->mfa($classMq))
{
$feesClass=$classData['class'];
?>
<tr class="trListing" >
<td><?echo $feesClass;?></td>
<td><?echo $payableAmt=$classAmtArray[$feesClass]['payble'];?></td>
<td><?echo $paidAmt=$classAmtArray[$feesClass]['paid_amount'];?></td>
<td><?echo $dueAmt=($payableAmt-$paidAmt);?></td>
</tr>
<?
$totalpayableAmt=$totalpayableAmt+$payableAmt;
$totalpaidAmt=$totalpaidAmt+$paidAmt;
$totaldueAmt=$totaldueAmt+$dueAmt;
}?>
<tr class="trListing" >
<td><strong>Total:</strong></td>
<td><?echo $totalpayableAmt;?></td>
<td><?echo $totalpaidAmt;?></td>
<td><?echo $totaldueAmt;?></td>
</tr>

</table>







</td>
		
		
		</table>

<?
exit();
}


?> 
 

