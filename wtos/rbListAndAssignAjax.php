<?php 
session_start();

include('wtosConfigLocal.php');// load configuration
include('wtos.php'); // load wtos Library
function nextDate($dateVal,$dateInterval){

  if($dateInterval==''){$dateInterval=30;}
             if($dateInterval==30)
			 {   $interval = "P1M"; }
			 
			 if($dateInterval==360)
			 {   $interval = "P1Y"; }
			 
		    	$date = new DateTime($dateVal);
		    	
		    	$newDate = new DateInterval($interval);
		    	$date->add($newDate);
		    	$retDate = $date->format('Y-m-d 00:00:00');

		    	return $retDate;

		    }
function prevDate($dateVal,$dateInterval)
              {

		    	$date = new DateTime($dateVal);
				$interval = "P".$dateInterval."D";
		    	$newDate = new DateInterval($interval);
		    	$date->sub($newDate);
		    	$retDate = $date->format('Y-m-d 00:00:00');
		    	return $retDate;
		    }
			
		
function rbListByCustomer($refCode,$rbcontactId)
{
    global $os;   
	
	$qRb="select * from  rbreminder where  refCode='$refCode' and  rbcontactId='$rbcontactId' order by expiryDate asc";
	
	$dataRS=$os->mq($qRb);
	
	       $cc=1;
			?>
			 
			<div class="popoupHead">All Reminders Of </div>
			<div class="popoupHead"><? echo $refCode ?></div>
			<div class="sasclear"> </div>
			<table class="RBListTable" cellpadding="0" cellspacing="0">
			 <tr onclick=""> 
			
			  <td> SL   </td>
			   <td>  From Date  </td>
			  <td>  Exp Date  </td>
			  <td>  Reminder Date  </td>
			   <td> IP </td>
			   <td> Status </td>
			  </tr>
			
			<? 			
			while($record=$os->mfa($dataRS)) 
			{ 
			?> 
			 
			<tr onclick=""> 
			<td><? echo $cc ?>   </td>
			<td><?php echo $os->showDate($record['fromDate']);?>  </td>
			<td><b><?php echo $os->showDate($record['expiryDate']);?>   </b></td>
			<td><?php echo $os->showDate($record['reminderStartDate']);?>   </td>
			<td><?php echo $record['ipAddress']?></td>
			<td><?php echo $record['reminderStatus']?></td>
			</tr><? $cc++;
			   $lastData=$record;
			 }	?> 
			</table>
		   <? 
		   $records=array();
		   $nextReminderCount=5;
		   for($i=1;$i<=$nextReminderCount;$i++)
		   {
				
				 
				$lastData['expiryDate']=nextDate($lastData['expiryDate'],$lastData['frequency']);
				$lastData['fromDate']=nextDate($lastData['fromDate'],$lastData['frequency']);
				$lastData['reminderStartDate']=prevDate($lastData['expiryDate'],$lastData['priorDays']);
				$lastData['reminderStatus']='Open';
			 	$records[$i] =$lastData;
			 
			
		   }
			 
			 
			 
			  ?>

     <div class="popoupHead" >Add Next Expected Reminders  </div>
	 
	 <div class="sasclear"> </div>
	 
	   <table class="RBListTable" cellpadding="0" cellspacing="0">
			 <tr onclick=""> 
			
			  <td> SL   </td>
			  <td>  From Date  </td>
			  <td>  Exp Date  </td>
			  <td>  Reminder Date  </td>
			   <td> IP </td>
			   <td> Status </td>
			   <td>  </td>
			  </tr>
			
			<? 	
			$cc=1;	
			foreach($records as $record) 
			{ 
			?> 
			 
			<tr onclick=""> 
			<td><? echo $cc ?>   </td>
			<td><?php echo $os->showDate($record['fromDate']);?>   </td>
			<td><b><?php echo $os->showDate($record['expiryDate']);?>   </b></td>
			<td><?php echo $os->showDate($record['reminderStartDate']);?>   </td>
			<td><?php echo $record['ipAddress']?></td>
			<td><?php echo $record['reminderStatus']?></td>
			 <td>  
			 <? $addStr=$record['refCode']."[RB:SEP]".$record['rbcontactId']."[RB:SEP]".$record['expiryDate']."[RB:SEP]".$record['reminderStartDate']."[RB:SEP]".$record['frequency']."[RB:SEP]".$record['priorDays'] ."[RB:SEP]".$record['ipAddress'] ."[RB:SEP]".$record['rbproductId'] ."[RB:SEP]".$record['rbserviceId']."[RB:SEP]".$record['amount']."[RB:SEP]".$record['taxPercent']."[RB:SEP]".$record['taxAmount']."[RB:SEP]".$record['totalPayableAmount']."[RB:SEP]".$record['registerDate']."[RB:SEP]".$record['fromDate']; ?> 
			 <span class="actionLink"><a href="javascript:void(0)" onclick="rb.addReminder('<? echo $addStr; ?>')">Add</a></span>  </td>
			</tr><? $cc++;
			  
			 }	?> 
			</table>
	 
	

<? 

}





if($os->get('RB_GetAllREminder')=='OK' && $os->post('RETURN')=='rbListHTML')
{
   
	$refCode=$os->post('refCode');
	$rbcontactId=$os->post('rbcontactId');
	$containerId=$os->post('containerId');

	echo '[RB:SEPERATOR]';
	?>
	
	<div id="rbListByCustomerPOPUP" class="RB_popupBOX"  >	 
            <div class="RBpopoupClose" onclick="rb.popUpClose('rbAllByCustomerContainer')">X</div>
	
	<? 
	rbListByCustomer($refCode,$rbcontactId);
	?>
	</div>
 <?   
 exit();
}

if($os->get('RB_addNextREminder')=='OK' && $os->post('RETURN')=='rbListHTML')
{
    $newDataArr=array();
	$refCode=$os->post('refCode');
	$rbcontactId=$os->post('rbcontactId');
	$containerId=$os->post('containerId');
	$addStr=$os->post('addStr');
	$newDataArr=explode('[RB:SEP]',$addStr);
	 
	$dataToSave['refCode']=$newDataArr[0];
	$dataToSave['rbcontactId']=$newDataArr[1];
	$dataToSave['expiryDate']=$newDataArr[2];
	$dataToSave['reminderStartDate']=$newDataArr[3];
	$dataToSave['frequency']=$newDataArr[4];
	$dataToSave['priorDays']=$newDataArr[5];
	$dataToSave['ipAddress']=$newDataArr[6];
	$dataToSave['rbproductId']=$newDataArr[7];
	$dataToSave['rbserviceId']=$newDataArr[8];
	
	$dataToSave['amount']=$newDataArr[9];
	$dataToSave['taxPercent']=$newDataArr[10];
	$dataToSave['taxAmount']=$newDataArr[11];
	$dataToSave['totalPayableAmount']=$newDataArr[12];
	$dataToSave['registerDate']=$newDataArr[13];
	$dataToSave['fromDate']=$newDataArr[14];
	
	 
	 
	  
	 
	 
	
	
	$dataToSave['paymentStatus']=current ($os->payStatus); 
	$dataToSave['reminderStatus']=current ($os->remindStatus); 
		
		
		
		
	$dataToSave['addedDate']=$os->now();
	$dataToSave['addedBy']=$os->userDetails['adminId'];
    $qResult=$os->save('rbreminder',$dataToSave);
		
	echo '[RB:SEPERATOR]';
	?>
	<div class="RBpopoupClose" onclick="rb.popUpClose('rbAllByCustomerContainer')">X</div>
	<? 
	rbListByCustomer($refCode,$rbcontactId);
	
 exit();
}