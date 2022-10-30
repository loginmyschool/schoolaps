<? 
/*
   # wtos version : 1.1
   # page called by ajax script in guardianDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='a';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_guardianListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');

    $f_joinDate_s= $os->post('f_joinDate_s'); $t_joinDate_s= $os->post('t_joinDate_s');
   $andjoinDate=$os->DateQ('joinDate',$f_joinDate_s,$t_joinDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andpermanentAddress=  $os->postAndQuery('permanentAddress_s','permanentAddress','%');
$andrecentAddress=  $os->postAndQuery('recentAddress_s','recentAddress','%');
$andmobile=  $os->postAndQuery('mobile_s','mobile','%');
$andemail=  $os->postAndQuery('email_s','email','%');
$andnote=  $os->postAndQuery('note_s','note','%');
$andotpPass=  $os->postAndQuery('otpPass_s','otpPass','%');
$andrelation=  $os->postAndQuery('relation_s','relation','%');
$andstudentName=  $os->postAndQuery('studentName_s','studentName','%');
$andclass=  $os->postAndQuery('class_s','class','%');
$andstudentId=  $os->postAndQuery('studentId_s','studentId','%');
$andstatus=  $os->postAndQuery('status_s','status','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or permanentAddress like '%$searchKey%' Or recentAddress like '%$searchKey%' Or mobile like '%$searchKey%' Or email like '%$searchKey%' Or note like '%$searchKey%' Or otpPass like '%$searchKey%' Or relation like '%$searchKey%' Or studentName like '%$searchKey%' Or class like '%$searchKey%' Or studentId like '%$searchKey%' Or status like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from guardian where guardianId>0   $where   $andname  $andjoinDate  $andpermanentAddress  $andrecentAddress  $andmobile  $andemail  $andnote  $andotpPass  $andrelation  $andstudentName  $andclass  $andstudentId  $andstatus     order by guardianId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Name</b></td>  
  <td ><b>Join Date</b></td>  
  <td ><b>Permanent Address</b></td>  
  <td ><b>Recent Address</b></td>  
  <td ><b>Mobile</b></td>  
  <td ><b>Email</b></td>  
  <td ><b>Note</b></td>  
  <td ><b>Otp Pass</b></td>  
  <td ><b>Relation</b></td>  
  <td ><b>Student Name</b></td>  
  <td ><b>Class</b></td>  
  <td ><b>Student Id</b></td>  
  <td ><b>Status</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing">
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_guardianGetById('<? echo $record['guardianId'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $os->showDate($record['joinDate']);?> </td>  
  <td><?php echo $record['permanentAddress']?> </td>  
  <td><?php echo $record['recentAddress']?> </td>  
  <td><?php echo $record['mobile']?> </td>  
  <td><?php echo $record['email']?> </td>  
  <td><?php echo $record['note']?> </td>  
  <td><?php echo $record['otpPass']?> </td>  
  <td><?php echo $record['relation']?> </td>  
  <td><?php echo $record['studentName']?> </td>  
  <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td> 
  <td><?php echo $record['studentId']?> </td>  
  <td> <? if(isset($os->guardianStatus[$record['status']])){ echo  $os->guardianStatus[$record['status']]; } ?></td> 
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_guardianEditAndSave')=='OK')
{
 $guardianId=$os->post('guardianId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['joinDate']=$os->saveDate($os->post('joinDate')); 
 $dataToSave['permanentAddress']=addslashes($os->post('permanentAddress')); 
 $dataToSave['recentAddress']=addslashes($os->post('recentAddress')); 
 $dataToSave['mobile']=addslashes($os->post('mobile')); 
 $dataToSave['email']=addslashes($os->post('email')); 
 $dataToSave['note']=addslashes($os->post('note')); 
 $dataToSave['otpPass']=addslashes($os->post('otpPass')); 
 $dataToSave['relation']=addslashes($os->post('relation')); 
 $dataToSave['studentName']=addslashes($os->post('studentName')); 
 $dataToSave['class']=addslashes($os->post('class')); 
 $dataToSave['studentId']=addslashes($os->post('studentId')); 
 $dataToSave['status']=addslashes($os->post('status')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($guardianId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('guardian',$dataToSave,'guardianId',$guardianId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($guardianId>0 ){ $mgs= " Data updated Successfully";}
		if($guardianId<1 ){ $mgs= " Data Added Successfully"; $guardianId=  $qResult;}
		
		  $mgs=$guardianId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_guardianGetById')=='OK')
{
		$guardianId=$os->post('guardianId');
		
		if($guardianId>0)	
		{
		$wheres=" where guardianId='$guardianId'";
		}
	    $dataQuery=" select * from guardian  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['joinDate']=$os->showDate($record['joinDate']); 
 $record['permanentAddress']=$record['permanentAddress'];
 $record['recentAddress']=$record['recentAddress'];
 $record['mobile']=$record['mobile'];
 $record['email']=$record['email'];
 $record['note']=$record['note'];
 $record['otpPass']=$record['otpPass'];
 $record['relation']=$record['relation'];
 $record['studentName']=$record['studentName'];
 $record['class']=$record['class'];
 $record['studentId']=$record['studentId'];
 $record['status']=$record['status'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_guardianDeleteRowById')=='OK')
{ 

$guardianId=$os->post('guardianId');
 if($guardianId>0){
 $updateQuery="delete from guardian where guardianId='$guardianId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
