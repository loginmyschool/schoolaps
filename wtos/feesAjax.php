<? 

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php 

   #  

*/

include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);


 

?><?



if($os->get('WT_feesListing')=='OK')

 

{

    $where='';

	$showPerPage= $os->post('showPerPage');

	 	

	

$andhistoryId=  $os->postAndQuery('historyId_s','historyId','=');

 $andstudentId=  $os->postAndQuery('studentId_s','studentId','=');



    $f_from_date_s= $os->post('f_from_date_s'); $t_from_date_s= $os->post('t_from_date_s');

   $andfrom_date=$os->DateQ('from_date',$f_from_date_s,$t_from_date_s,$sTime='00:00:00',$eTime='23:59:59');



    $f_to_date_s= $os->post('f_to_date_s'); $t_to_date_s= $os->post('t_to_date_s');

   $andto_date=$os->DateQ('to_date',$f_to_date_s,$t_to_date_s,$sTime='00:00:00',$eTime='23:59:59');

$andmonth=  $os->postAndQuery('month_s','month','=');



$andYear=  $os->postAndQuery('year_s','year','=');





$andasession=  $os->postAndQuery('asession_s','asession','=');

$andfees_title=  $os->postAndQuery('fees_title_s','fees_title','%');

$andfees_amount=  $os->postAndQuery('fees_amount_s','fees_amount','%');

$anddiscount=  $os->postAndQuery('discount_s','discount','%');

$andpayble=  $os->postAndQuery('payble_s','payble','%');

$andpaid_amount=  $os->postAndQuery('paid_amount_s','paid_amount','%');

$andpaid_by=  $os->postAndQuery('paid_by_s','paid_by','%');

$andpaid_details=  $os->postAndQuery('paid_details_s','paid_details','%');



    $f_paid_date_s= $os->post('f_paid_date_s'); $t_paid_date_s= $os->post('t_paid_date_s');

   $andpaid_date=$os->DateQ('paid_date',$f_paid_date_s,$t_paid_date_s,$sTime='00:00:00',$eTime='23:59:59');

$andsubjects=  $os->postAndQuery('subjects_s','subjects','%');

$andremarks=  $os->postAndQuery('remarks_s','remarks','%');

$andstatus=  $os->postAndQuery('status_s','status','=');







$andClass=  $os->postAndQuery('classList_s','class','=');

$andSection=  $os->postAndQuery('section_s','section','=');



	   

	$searchKey=$os->post('searchKey');

	

	

	$studentIds= $os->searchKeyGetIds($searchKey,'student','studentId',$whereCondition='',$searchFields='');

	$orstudentId='';

	

	if($studentIds!='')

	{

	    $orstudentId= " or  studentId IN ( $studentIds) ";

	}

	

	

	

	if($searchKey!=''){

	 $where ="and ( historyId like '=$searchKey' Or studentId like '=$searchKey' Or class like '%$searchKey%'  Or section like '%$searchKey%' Or month like '%$searchKey%' Or year like '%$searchKey%' Or fees_title like '%$searchKey%' Or fees_amount like '%$searchKey%' Or discount like '%$searchKey%' Or payble like '%$searchKey%' Or paid_amount like '%$searchKey%' Or paid_by like '%$searchKey%' Or paid_details like '%$searchKey%' Or subjects like '%$searchKey%' Or remarks like '%$searchKey%' Or status like '%$searchKey%' )$orstudentId";

 

	}

		

	 $listingQuery="  select * from fees where feesId>0   $where   $andhistoryId  $andstudentId $andClass $andSection  $andfrom_date  $andto_date  $andmonth $andYear  $andasession  $andfees_title  $andfees_amount  $anddiscount  $andpayble  $andpaid_amount  $andpaid_by  $andpaid_details  $andpaid_date  $andsubjects  $andremarks  $andstatus     order by feesId desc";

	  

	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);

	$rsRecords=$resource['resource'];

	 

	// echo $rsRecords->queryString;

	 $receiptNoList= $os->getIdsDataFromQuery($rsRecords->queryString,'feesId','printreceiptno','tableId',$fields='',$returnArray=true,$relation='121',$otherCondition='and tableName="fees"');



	 

	 

 

?>

<div class="listingRecords">

<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>



<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >

							<tr class="borderTitle" >

						

	                            <td >#</td>

									<td style="width:100px;">Action </td>

								



											

<td style="display:none"><b>historyId</b></td>  

 <td ><b>Receipt No</b></td>  

  <td ><b>Id</b></td>  

 

  <td style="display:none"><b>From Date</b></td>  

  <td style="display:none"><b>To Date</b></td>  

  

  <td ><b>Student</b></td> 



  

  <td ><b>Month</b></td>  

  <td ><b>Year</b></td>  

  <td style="display:none"><b>Fees Title</b></td>  

  <td class="hidemeondemand" ><b>Fees</b></td>  

  <td  class="hidemeondemand"><b>Discount</b></td> 

 <td  class="hidemeondemand"><b>Fine</b></td> 

 <td  class="hidemeondemand"><b>Medicine</b></td>  

  <td ><b>Payble</b></td>  

  <td ><b>Paid Amount</b></td>  

  <td style="display:none"><b>Paid By</b></td>  

  <td style="display:none"><b>Paid Details</b></td>  

  <td ><b>Paid Date</b></td>  

  <td style="display:none"><b>Subjects</b></td>  

  <td ><b>Remarks</b></td>  

  <td ><b>Status</b></td>  

   <td ><b>Collected By</b></td>  

  						

							 

 

						       	</tr>

							

							

							

							<?php

								  

						  	 $serial=$os->val($resource,'serial');  

						 

							while($record=$os->mfa( $rsRecords)){ 

							 $serial++;

							    

								

							

						

							 ?>

							<tr class="trListing" >

							<td><?php echo $serial; ?>     </td>

							<td> 

							<? if($os->checkAccess('Edit Fees')){ ?>

							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="checkEditDeletePassword('<? echo $record['feesId'];?>','<? echo $record['addEditCounter'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?> 





 <span  class="actionLink" ><a  href="javascript:void(0)" onclick="popUpWindow('feesPrint.php?feesId=<? echo $record['feesId'];?>', 50, 50, 1050, 620)">Print</a></span>

 

  <!--<span  class="actionLink" ><a  href="javascript:void(0)" onclick="openMonthlyFeesPrint('<? echo $record['feesId'];?>','<? echo $receiptNoList[$record['feesId']]['receiptNo'];?>')">Print</a></span>-->

							

							

							</span> 





							</td>

								

<td style="display:none"><?php echo $record['historyId']?> </td>  

<td ><?echo $receiptNoList[$record['feesId']]['receiptNo']?> </td>  

  <td ><b><?php echo $record['studentId']?></b> </td> 



  

  <td style="display:none"><?php echo $os->showDate($record['from_date']);?> </td>  

  <td style="display:none"><?php echo $os->showDate($record['to_date']);?> </td>  

  

  

  

  <td >  <? echo $os->rowByField('name','student','studentId',$record['studentId']); ?> 

  <?  //echo $os->rowByField('class','history','historyId',$record['historyId']); ?> 

  <? // echo $os->rowByField('section','history','historyId',$record['historyId']); ?> 

  </td>



  

  <td> <? if(isset($os->feesMonth[$record['month']])){ echo  $os->feesMonth[$record['month']]; } ?></td> 

  <td> <? if(isset($os->feesYear[$record['year']])){ echo  $os->feesYear[$record['year']]; } ?></td> 

  <td style="display:none"><?php echo $record['fees_title']?> </td>  

  <td class="hidemeondemand"><?php echo $record['fees_amount']?> </td>  

  <td class="hidemeondemand"><?php echo $record['discount']?> </td> 



 <td class="hidemeondemand"><?php echo $record['fineAmount']?> </td> 

  <td class="hidemeondemand"><?php echo $record['medicineAmount']?> </td> 



  

  <td title="Fees:<?php echo $record['fees_amount']?>  Discount:<?php echo $record['discount']?>  Fine:<?php echo $record['fineAmount']?>  Medicine:<?php echo $record['medicineAmount']?>"> <b><?php echo $record['payble']?></b> </td>  

  <td><?php echo $record['paid_amount']?> </td>  

  <td style="display:none"><?php echo $record['paid_by']?> </td>  

  <td style="display:none"><?php echo $record['paid_details']?> </td>  

  <td><?php echo $os->showDate($record['paid_date']);?> </td>  

  <td style="display:none"><?php echo $record['subjects']?> </td>  

  <td><?php echo $record['remarks']?> </td>  

  <?

  $style='';

  if($record['status']=='Unpaid')

  {

	  $style="style=color:red";

  }

  else{$style="style=color:green";}

  ?>

  

  

  <td <?echo $style;?>><b> <? if(isset($os->feesStatus[$record['status']])){ echo  $os->feesStatus[$record['status']]; } ?></b></td> 

  

		 <td >  <? echo $os->rowByField('name','admin','adminId',$record['modifyBy']); ?></td>  						

				 </tr>

                          <? 

						  

						 

						  } ?>  

							

		

			

			

							 

		</table> 

		

		

		

		</div>

		

		<br />

		

		

						

<?php 

exit();

	

}

 











if($os->get('WT_feesEditAndSave')=='OK')

{

	

ini_set('max_execution_time', '-1');

ini_set('memory_limit', '2048M');

include('sendSms.php');

	

	

 $feesId=$os->post('feesId');

 $historyId=$os->post('historyId');

 

 

 $addEditCounter=$os->post('addEditCounter');

 

 

$clsAndSecQuery=$os->rowByField('class,section','history','historyId',$historyId); 



$historyId=$dataToSave['historyId']=addslashes($os->post('historyId')); 

$studentId=$dataToSave['studentId']=addslashes($os->post('studentId')); 

$dataToSave['from_date']=$os->saveDate($os->post('from_date')); 

$dataToSave['to_date']=$os->saveDate($os->post('to_date')); 

$dataToSave['month']=addslashes($os->post('month')); 

$dataToSave['year']=addslashes($os->post('year')); 

$dataToSave['fees_title']=addslashes($os->post('fees_title')); 

$dataToSave['fees_amount']=addslashes($os->post('fees_amount')); 

$dataToSave['discount']=addslashes($os->post('discount')); 

$dataToSave['payble']=addslashes($os->post('payble')); 

$dataToSave['paid_amount']=addslashes($os->post('paid_amount')); 

$dataToSave['paid_by']=addslashes($os->post('paid_by')); 

$dataToSave['paid_details']=addslashes($os->post('paid_details')); 

$dataToSave['paid_date']=$os->saveDate($os->post('paid_date')); 

$dataToSave['subjects']=addslashes($os->post('subjects')); 

$dataToSave['remarks']=addslashes($os->post('remarks')); 

$dataToSave['asession']=addslashes($os->post('asession')); 

$dataToSave['receivedAmt']=addslashes($os->post('receivedAmt')); 

$dataToSave['refundAmt']=addslashes($os->post('refundAmt')); 

$dataToSave['paymentTime']=addslashes($os->post('paymentTime'));

$dataToSave['addEditCounter']=$addEditCounter+1; 





 if($dataToSave['payble']==$dataToSave['paid_amount'])

 {

	  $dataToSave['status']="Paid"; 

 }

 

else

{

	$dataToSave['status']="Unpaid";

}

 

 

  $dataToSave['fineAmount']=addslashes($os->post('fineAmount')); 

 $dataToSave['medicineAmount']=addslashes($os->post('medicineAmount')); 

 



 $dataToSave['class']=addslashes($clsAndSecQuery['class']); 

 $dataToSave['section']=addslashes($clsAndSecQuery['section']); 

		

		

		$dataToSave['modifyDate']=$os->now();

		$dataToSave['modifyBy']=$os->userDetails['adminId']; 

		

		if($feesId < 1){

		

		$dataToSave['addedDate']=$os->now();

		$dataToSave['addedBy']=$os->userDetails['adminId'];

		}

		

		 

          $qResult=$os->save('fees',$dataToSave,'feesId',$feesId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	

		if($qResult)  

				{

		if($feesId>0 ){ $mgs= " Data updated Successfully";}

		if($feesId<1 ){

			

		$mgs= " Data Added Successfully"; $feesId=  $qResult;

		

		}

		

		$os->getReceiptNo('fees',$feesId,$historyId,$studentId);

		

		

		

		if($addEditCounter==0)

		{

			

		 $mobileNoQuery=$os->rowByField('mobile_student','student','studentId',$studentId); 

		$smsObj= new sms;

		 $smsText="We have received Rs.".$dataToSave['paid_amount']." for the month of ". $os->feesMonth[$dataToSave['month']].".Thank you";

		$smsNumbersStr=$mobileNoQuery;

		//$smsNumbersStr=7595836017;

		$smsObj->sendSMS($smsText,$smsNumbersStr);

		$os->saveSendingSms($smsText,$mobileNos=$smsNumbersStr , $status='send',$note='Fees Payment');

		}

		

		  

		  $addedBy=$os->userDetails['adminId'];

		  $description=json_encode($dataToSave);

		  

       $os->setLogRecord('fees',$qResult,'Edit Fees',$addedBy,$description);

		  

		  

		  

		  

		 

		  $mgs=$feesId."#-#".$mgs; 

		  

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

	

	 $feesId=$os->post('feesId');

	 $password=$os->post('password');

	 $operationType=$os->post('operationType');

	

    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);

	if($password==$editDeletePassword)

	{

		$msg="password matched#-#".$feesId."#-#Edit Data";

		if($operationType=='deleteData')

		{

			$msg="password matched#-#".$feesId."#-#Delete Data";

		}

		

		echo $msg;

	}

	else

	{

		echo "wrong password";

	}

	exit();

	

}





 

if($os->get('WT_feesGetById')=='OK')

{

	

	

	

		

		$feesId=$os->post('feesId');

		

		if($feesId>0)	

		{

		$wheres=" where feesId='$feesId'";

		}

	    $dataQuery=" select * from fees  $wheres ";

		$rsResults=$os->mq($dataQuery);

		$record=$os->mfa( $rsResults);

		

		 

 $record['historyId']=$record['historyId'];

 $record['studentId']=$record['studentId'];

 $record['from_date']=$os->showDate($record['from_date']); 

 $record['to_date']=$os->showDate($record['to_date']); 

 $record['month']=$record['month'];

 $record['year']=$record['year'];

 $record['fees_title']=$record['fees_title'];

 $record['fees_amount']=$record['fees_amount'];

 $record['discount']=$record['discount'];

 $record['payble']=$record['payble'];

 $record['paid_amount']=$record['paid_amount'];

 $record['paid_by']=$record['paid_by'];

 $record['paid_details']=$record['paid_details'];

 $record['paid_date']=$os->showDate($record['paid_date']); 

 $record['subjects']=$record['subjects'];

 $record['remarks']=$record['remarks'];

 $record['status']=$record['status'];



		

		

		echo  json_encode($record);	

	

	

	

		 

 

exit();

	

}

 

 

if($os->get('WT_feesDeleteRowById')=='OK')

{ 



$feesId=$os->post('feesId');

 if($feesId>0){

 $updateQuery="delete from fees where feesId='$feesId'";

 $os->mq($updateQuery);

    echo 'Record Deleted Successfully';

 }

 exit();

}

 

