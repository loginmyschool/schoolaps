<? 
/*
   # wtos version : 1.1
   # page called by ajax script in salaryDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_salaryListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	$andteacherId=  $os->postAndQuery('teacherId_s','teacherId','=');
$andasession=  $os->postAndQuery('asession_s','asession','=');
$andmonth=  $os->postAndQuery('month_s','month','=');
$andyear=  $os->postAndQuery('year_s','year','=');

$andbase=  $os->postAndQuery('base_s','base','%');
$andother=  $os->postAndQuery('other_s','other','%');
$anddeduction=  $os->postAndQuery('deduction_s','deduction','%');
$andpayble=  $os->postAndQuery('payble_s','payble','%');
$andpaidAmount=  $os->postAndQuery('paidAmount_s','paidAmount','%');
$anddueAmount=  $os->postAndQuery('dueAmount_s','dueAmount','%');

    $f_paidDate_s= $os->post('f_paidDate_s'); $t_paidDate_s= $os->post('t_paidDate_s');
   $andpaidDate=$os->DateQ('paidDate',$f_paidDate_s,$t_paidDate_s,$sTime='00:00:00',$eTime='23:59:59');
$andpaidBy=  $os->postAndQuery('paidBy_s','paidBy','%');
$anddetails=  $os->postAndQuery('details_s','details','%');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andnote=  $os->postAndQuery('note_s','note','%');
$andremarks=  $os->postAndQuery('remarks_s','remarks','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( asession like '%$searchKey%' Or year like '%$searchKey%' Or month like '%$searchKey%' Or base like '%$searchKey%' Or other like '%$searchKey%' Or deduction like '%$searchKey%' Or payble like '%$searchKey%' Or paidAmount like '%$searchKey%' Or dueAmount like '%$searchKey%' Or paidBy like '%$searchKey%' Or details like '%$searchKey%' Or status like '%$searchKey%' Or note like '%$searchKey%' Or remarks like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from salary where salaryId>0   $where $andteacherId  $andasession  $andmonth $andyear  $andbase  $andother  $anddeduction  $andpayble  $andpaidAmount  $anddueAmount  $andpaidDate  $andpaidBy  $anddetails  $andstatus  $andnote  $andremarks     order by salaryId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td style="display:none"><b>Session</b></td> 

<td ><b>Year</b></td> 
 
  <td ><b>Month</b></td>  
   <td ><b>Paid To</b></td>  
  <td ><b>Salary Details</b></td>  
  <td ><b>Other</b></td>  
  <td ><b>Deduction</b></td>  
  <td ><b>Payble</b></td>  
  <td ><b>Paid Amount</b></td>  
  <td ><b>Due Amount</b></td>  
  <td ><b>Paid Date</b></td>  
  <td ><b>Paid By</b></td>  
  <td ><b>Details</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Note</b></td>  
  <td ><b>Remarks</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->checkAccess('Edit Salary')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="checkEditDeletePassword('<? echo $record['salaryId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
								
<td style="display:none"> <? if(isset($os->asession[$record['asession']])){ echo  $os->asession[$record['asession']]; } ?></td>


  <td><?php echo $record['year']?> </td> 
 
  <td> <? if(isset($os->feesMonth[$record['month']])){ echo  $os->feesMonth[$record['month']]; } ?></td> 
  
  <td>  <? echo 
	$os->rowByField('name','teacher','teacherId',$record['teacherId']); ?></td> 
  
  
  <td valign="top">
  
  
  <span class="gray">Actual Gross:</span><?php echo $record['actualGross']?> <br />
	<span class="gray">No Of:</span><?php echo $record['noOf']?><br /> 
	<span class="gray">No Of Amt: </span> <? echo $record['noOfAmt']; ?> <br />
	<span class="gray">Basic:</span><?php echo $record['base']?> <br />
	<span class="gray">H.R.A:</span><?php echo $record['hra']?><br /> 
	<span class="gray">C.A: </span> <? echo $record['ca']; ?> <br />
	<span class="gray">SPL:</span><?php echo $record['spl']?> <br />
	<span class="gray">total:</span><?php echo $record['total']?><br /> 
  
  
  </td>  
  <td valign="top">  
  <span class="gray">PF(%): </span> <? echo $record['pfPercent']; ?> <br />

	<span class="gray">PF Amt.:</span><?php echo $record['pfAmt']?><br /> 
	<span class="gray">ESIC(%): </span> <? echo $record['esicPercent']; ?> <br />
	<span class="gray">ESIC Amt.:</span><?php echo $record['esicAmt']?> <br />
	<span class="gray">P TAX:</span><?php echo $record['pTax']?><br /> 
	<span class="gray">NET: </span> <? echo $record['net']; ?> <br />
	<span class="gray">CTC: </span> <? echo $record['ctc']; ?> <br /> 
 <span class="gray">Other: </span> <?php echo $record['other']?> </td>  
  <td><?php echo $record['deduction']?> </td>  
  <td><?php echo $record['payble']?> </td>  
  <td><?php echo $record['paidAmount']?> </td>  
  <td><?php echo $record['dueAmount']?> </td>  
  <td><?php echo $os->showDate($record['paidDate']);?> </td>  
  <td><?php echo $record['paidBy']?> </td>  
  <td><?php echo $record['details']?> </td>  
  <td> <? if(isset($os->salaryStatus[$record['status']])){ echo  $os->salaryStatus[$record['status']]; } ?></td> 
  <td><?php echo $record['note']?> </td>  
  <td><?php echo $record['remarks']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_salaryEditAndSave')=='OK')
{
 $salaryId=$os->post('salaryId');
 
 
		 
 $dataToSave['asession']=addslashes($os->post('asession'));
 $dataToSave['year']=addslashes($os->post('year'));  
 $dataToSave['month']=addslashes($os->post('month')); 
 $dataToSave['base']=addslashes($os->post('base')); 
 $dataToSave['other']=addslashes($os->post('other')); 
 $dataToSave['deduction']=addslashes($os->post('deduction')); 
 $dataToSave['payble']=addslashes($os->post('payble')); 
 $dataToSave['paidAmount']=addslashes($os->post('paidAmount')); 
 $dataToSave['dueAmount']=addslashes($os->post('dueAmount')); 
 $dataToSave['paidDate']=$os->saveDate($os->post('paidDate')); 
 $dataToSave['paidBy']=addslashes($os->post('paidBy')); 
 $dataToSave['details']=addslashes($os->post('details')); 
 $dataToSave['status']=addslashes($os->post('status')); 
 $dataToSave['note']=addslashes($os->post('note')); 
 $dataToSave['remarks']=addslashes($os->post('remarks')); 
 $dataToSave['teacherId']=addslashes($os->post('teacherId')); 
 
 
 
 
 
 
 
 $dataToSave['actualGross']=addslashes($os->post('actualGross'));  
 $dataToSave['noOf']=addslashes($os->post('noOf')); 
 $dataToSave['noOfAmt']=addslashes($os->post('noOfAmt')); 
 $dataToSave['hra']=addslashes($os->post('hra')); 
 $dataToSave['ca']=addslashes($os->post('ca')); 
 $dataToSave['spl']=addslashes($os->post('spl')); 
 $dataToSave['total']=addslashes($os->post('total')); 
 $dataToSave['pfPercent']=addslashes($os->post('pfPercent')); 
 $dataToSave['pfAmt']=addslashes($os->post('pfAmt')); 
 $dataToSave['esicPercent']=addslashes($os->post('esicPercent')); 
 $dataToSave['esicAmt']=addslashes($os->post('esicAmt')); 
 $dataToSave['pTax']=addslashes($os->post('pTax')); 
 $dataToSave['net']=addslashes($os->post('net')); 
 $dataToSave['ctc']=addslashes($os->post('ctc')); 
 
 
 
 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($salaryId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('salary',$dataToSave,'salaryId',$salaryId);///    allowed char '\*#@/"~$^.,()|+_-=:££
          //echo $os->query;

		if($qResult)  
				{
		if($salaryId>0 ){ $mgs= " Data updated Successfully";$operation='Edit salary';}
		if($salaryId<1 ){ $mgs= " Data Added Successfully"; $salaryId=  $qResult;$operation='Add salary';}
		
		  $mgs=$salaryId."#-#".$mgs;
		  
		  
		   $addedBy=$os->userDetails['adminId'];
		  $description=json_encode($dataToSave);
		  
       $os->setLogRecord('salary',$qResult,$operation,$addedBy,$description);
		  
		  
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 


if($os->get('checkEditDeletePassword')=='OK')
{
	
	 $salaryId=$os->post('salaryId');
	 $password=$os->post('password');
	$operationType=$os->post('operationType');
    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
	if($password==$editDeletePassword)
	{
		//echo "password matched#-#".$salaryId;
		$msg="password matched#-#".$salaryId."#-#Edit Data";
		if($operationType=='deleteData')
		{
			$msg="password matched#-#".$salaryId."#-#Delete Data";
		}
	}
	else
	{
		$msg="wrong password";
	}
	echo $msg;
	exit();
	
}


 
if($os->get('WT_salaryGetById')=='OK')
{
		$salaryId=$os->post('salaryId');
		
		if($salaryId>0)	
		{
		$wheres=" where salaryId='$salaryId'";
		}
	    $dataQuery=" select * from salary  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['asession']=$record['asession'];
 $record['month']=$record['month'];
 $record['base']=$record['base'];
 $record['other']=$record['other'];
 $record['deduction']=$record['deduction'];
 $record['payble']=$record['payble'];
 $record['paidAmount']=$record['paidAmount'];
 $record['dueAmount']=$record['dueAmount'];
 $record['paidDate']=$os->showDate($record['paidDate']); 
 $record['paidBy']=$record['paidBy'];
 $record['details']=$record['details'];
 $record['status']=$record['status'];
 $record['note']=$record['note'];
 $record['remarks']=$record['remarks'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_salaryDeleteRowById')=='OK')
{ 

$salaryId=$os->post('salaryId');
 if($salaryId>0){
 $updateQuery="delete from salary where salaryId='$salaryId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
