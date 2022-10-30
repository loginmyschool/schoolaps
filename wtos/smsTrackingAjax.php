<? 
/*
   # wtos version : 1.1
   # page called by ajax script in cronsmsDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_cronsmsListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andstudentId=  $os->postAndQuery('studentId_s','studentId','=');
$andname=  $os->postAndQuery('name_s','name','%');
$andsendingMonth=  $os->postAndQuery('sendingMonth_s','sendingMonth','%');
$andsmsText=  $os->postAndQuery('smsText_s','smsText','%');

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
   $anddated=$os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='23:59:59');
$andstatus=  $os->postAndQuery('status_s','status','%');
$andmobileNos=  $os->postAndQuery('mobileNos_s','mobileNos','%');
$andnote=  $os->postAndQuery('note_s','note','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( studentId like '%$searchKey%' Or name like '%$searchKey%' Or sendingMonth like '%$searchKey%' Or smsText like '%$searchKey%' Or status like '%$searchKey%' Or mobileNos like '%$searchKey%' Or note like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from cronsms where cronsmsId>0   $where   $andstudentId  $andname  $andsendingMonth  $andsmsText  $anddated  $andstatus  $andmobileNos  $andnote     order by cronsmsId desc";
	  
	$resource=$os->pagingQuery($listingQuery,'100',false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td style="display:none;">Action </td>
								

											
<td ><b>Student Id</b></td>  
  <td ><b>Name</b></td> 
<td ><b>Total Pending</b></td> 
<td ><b>Pending Month</b></td>  
  <td ><b>Sending Month</b></td>  
  <td ><b>Sms Text</b></td>  
  <td ><b>Date</b></td>  
  <td ><b>Status</b></td>  
  <td ><b>Mobile No</b></td>  
  <td ><b>Note</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							<td style="display:none;"> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_cronsmsGetById('<? echo $record['cronsmsId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['studentId']?> </td>  
  <td><?php echo $record['name']?> </td> 
 <td><?php echo $record['totalPendingAmt']?> </td> 
 <td><?php echo $record['totalPendingMonth']?> </td>   
  <td><?php echo $os->feesMonth[$record['sendingMonth']]?> </td>  
  <td><?php echo $record['smsText']?> </td>  
  <td><?php echo $os->showDate($record['dated']);?> </td>  
  <td><?php echo $record['status']?> </td>  
  <td><?php echo $record['mobileNos']?> </td>  
  <td><?php echo $record['note']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_cronsmsEditAndSave')=='OK')
{
 $cronsmsId=$os->post('cronsmsId');
 
 
		 
 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['sendingMonth']=addslashes($os->post('sendingMonth')); 
 $dataToSave['smsText']=addslashes($os->post('smsText')); 
 $dataToSave['dated']=$os->saveDate($os->post('dated')); 
 $dataToSave['status']=addslashes($os->post('status')); 
 $dataToSave['mobileNos']=addslashes($os->post('mobileNos')); 
 $dataToSave['note']=addslashes($os->post('note')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($cronsmsId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('cronsms',$dataToSave,'cronsmsId',$cronsmsId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($cronsmsId>0 ){ $mgs= " Data updated Successfully";}
		if($cronsmsId<1 ){ $mgs= " Data Added Successfully"; $cronsmsId=  $qResult;}
		
		  $mgs=$cronsmsId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_cronsmsGetById')=='OK')
{
		$cronsmsId=$os->post('cronsmsId');
		
		if($cronsmsId>0)	
		{
		$wheres=" where cronsmsId='$cronsmsId'";
		}
	    $dataQuery=" select * from cronsms  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['studentId']=$record['studentId'];
 $record['name']=$record['name'];
 $record['sendingMonth']=$record['sendingMonth'];
 $record['smsText']=$record['smsText'];
 $record['dated']=$os->showDate($record['dated']); 
 $record['status']=$record['status'];
 $record['mobileNos']=$record['mobileNos'];
 $record['note']=$record['note'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_cronsmsDeleteRowById')=='OK')
{ 

$cronsmsId=$os->post('cronsmsId');
 if($cronsmsId>0){
 $updateQuery="delete from cronsms where cronsmsId='$cronsmsId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}



if($os->get('cronSetSms')=='OK')
{ 
$cronSendSms_s=$os->post('cronSendSms_s');
$updateQuery= "update settings set value='$cronSendSms_s' where keyword='cronSendSms' ";
$os->mq($updateQuery);
echo 'Record Updated Successfully';
exit();
}
 
