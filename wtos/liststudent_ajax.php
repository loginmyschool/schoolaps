<? 
/*
   # wtos version : 1.1
   # page called by ajax script in liststudent_dataview.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_studentListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');
$andregisterNo=  $os->postAndQuery('registerNo_s','registerNo','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or registerNo like '%$searchKey%' )";
 
	}
		
	$listingQuery="  select * from student where studentId>0   $where   $andname  $andregisterNo     order by studentId desc";
	  $os->showPerPage=1000;
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
 <td ><b>Registration No</b></td>  
  <td ><b>Gender</b></td>  
 
  <td ><b>Father Name</b></td>  
  						
							 
 
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
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_studentGetById('<? echo $record['studentId'];?>')" >View</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
 <td><b><?php echo $record['registerNo']?></b> </td> 
  <td><?php echo $record['gender']?> </td>  
  
  <td style="font-size:11px;"><?php echo $record['father_name']?> </td>  
  
								
				 </tr>
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_studentEditAndSave')=='OK')
{
 $studentId=$os->post('studentId');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['dob']=$os->saveDate($os->post('dob')); 
 $dataToSave['age']=addslashes($os->post('age')); 
 $dataToSave['gender']=addslashes($os->post('gender')); 
 $dataToSave['registerDate']=$os->saveDate($os->post('registerDate')); 
 $dataToSave['registerNo']=addslashes($os->post('registerNo')); 
 $dataToSave['caste']=addslashes($os->post('caste')); 
 $dataToSave['apl_bpl']=addslashes($os->post('apl_bpl')); 
 $dataToSave['card_no']=addslashes($os->post('card_no')); 
 $dataToSave['minority']=addslashes($os->post('minority')); 
 $dataToSave['kanyashree']=addslashes($os->post('kanyashree')); 
 $dataToSave['yuvashree']=addslashes($os->post('yuvashree')); 
 $dataToSave['adhar_name']=addslashes($os->post('adhar_name')); 
 $dataToSave['adhar_dob']=$os->saveDate($os->post('adhar_dob')); 
 $dataToSave['adhar_no']=addslashes($os->post('adhar_no')); 
 $dataToSave['ph']=addslashes($os->post('ph')); 
 $dataToSave['ph_percent']=addslashes($os->post('ph_percent')); 
 $dataToSave['father_name']=addslashes($os->post('father_name')); 
 $dataToSave['father_ocu']=addslashes($os->post('father_ocu')); 
 $dataToSave['father_adhar']=addslashes($os->post('father_adhar')); 
 $dataToSave['mother_name']=addslashes($os->post('mother_name')); 
 $dataToSave['mother_ocu']=addslashes($os->post('mother_ocu')); 
 $dataToSave['mother_adhar']=addslashes($os->post('mother_adhar')); 
 $dataToSave['vill']=addslashes($os->post('vill')); 
 $dataToSave['po']=addslashes($os->post('po')); 
 $dataToSave['ps']=addslashes($os->post('ps')); 
 $dataToSave['dist']=addslashes($os->post('dist')); 
 $dataToSave['block']=addslashes($os->post('block')); 
 $dataToSave['pin']=addslashes($os->post('pin')); 
 $dataToSave['state']=addslashes($os->post('state')); 
 $dataToSave['guardian_name']=addslashes($os->post('guardian_name')); 
 $dataToSave['guardian_relation']=addslashes($os->post('guardian_relation')); 
 $dataToSave['guardian_address']=addslashes($os->post('guardian_address')); 
 $dataToSave['guardian_ocu']=addslashes($os->post('guardian_ocu')); 
 $dataToSave['anual_income']=addslashes($os->post('anual_income')); 
 $dataToSave['mobile_student']=addslashes($os->post('mobile_student')); 
 $dataToSave['mobile_guardian']=addslashes($os->post('mobile_guardian')); 
 $dataToSave['mobile_emergency']=addslashes($os->post('mobile_emergency')); 
 $dataToSave['email_student']=addslashes($os->post('email_student')); 
 $dataToSave['email_guardian']=addslashes($os->post('email_guardian')); 
 $dataToSave['mother_tongue']=addslashes($os->post('mother_tongue')); 
 $dataToSave['blood_group']=addslashes($os->post('blood_group')); 
 $dataToSave['eye_power']=addslashes($os->post('eye_power')); 
 $dataToSave['psychiatric_report']=addslashes($os->post('psychiatric_report')); 
 $dataToSave['religian']=addslashes($os->post('religian')); 
 $dataToSave['other_religian']=addslashes($os->post('other_religian')); 
 $dataToSave['image']=addslashes($os->post('image')); 
 $dataToSave['last_school']=addslashes($os->post('last_school')); 
 $dataToSave['last_class']=addslashes($os->post('last_class')); 
 $dataToSave['tc_no']=addslashes($os->post('tc_no')); 
 $dataToSave['tc_date']=$os->saveDate($os->post('tc_date')); 
 $dataToSave['studentRemarks']=addslashes($os->post('studentRemarks')); 
 $dataToSave['feesPayment']=addslashes($os->post('feesPayment')); 
 $dataToSave['board']=addslashes($os->post('board')); 
 $dataToSave['accNo']=addslashes($os->post('accNo')); 
 $dataToSave['accHolderName']=addslashes($os->post('accHolderName')); 
 $dataToSave['ifscCode']=addslashes($os->post('ifscCode')); 
 $dataToSave['branch']=addslashes($os->post('branch')); 
 $dataToSave['otpPass']=addslashes($os->post('otpPass')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($studentId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
         // $qResult=$os->save('student',$dataToSave,'studentId',$studentId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($studentId>0 ){ $mgs= " Data updated Successfully";}
		if($studentId<1 ){ $mgs= " Data Added Successfully"; $studentId=  $qResult;}
		
		  $mgs=$studentId."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_studentGetById')=='OK')
{
		$studentId=$os->post('studentId');
		
		if($studentId>0)	
		{
		$wheres=" where studentId='$studentId'";
		}
	    $dataQuery=" select * from student  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['dob']=$os->showDate($record['dob']); 
 $record['age']=$record['age'];
 $record['gender']=$record['gender'];
 $record['registerDate']=$os->showDate($record['registerDate']); 
 $record['registerNo']=$record['registerNo'];
 $record['caste']=$record['caste'];
 $record['apl_bpl']=$record['apl_bpl'];
 $record['card_no']=$record['card_no'];
 $record['minority']=$record['minority'];
 $record['kanyashree']=$record['kanyashree'];
 $record['yuvashree']=$record['yuvashree'];
 $record['adhar_name']=$record['adhar_name'];
 $record['adhar_dob']=$os->showDate($record['adhar_dob']); 
 $record['adhar_no']=$record['adhar_no'];
 $record['ph']=$record['ph'];
 $record['ph_percent']=$record['ph_percent'];
 $record['father_name']=$record['father_name'];
 $record['father_ocu']=$record['father_ocu'];
 $record['father_adhar']=$record['father_adhar'];
 $record['mother_name']=$record['mother_name'];
 $record['mother_ocu']=$record['mother_ocu'];
 $record['mother_adhar']=$record['mother_adhar'];
 $record['vill']=$record['vill'];
 $record['po']=$record['po'];
 $record['ps']=$record['ps'];
 $record['dist']=$record['dist'];
 $record['block']=$record['block'];
 $record['pin']=$record['pin'];
 $record['state']=$record['state'];
 $record['guardian_name']=$record['guardian_name'];
 $record['guardian_relation']=$record['guardian_relation'];
 $record['guardian_address']=$record['guardian_address'];
 $record['guardian_ocu']=$record['guardian_ocu'];
 $record['anual_income']=$record['anual_income'];
 $record['mobile_student']=$record['mobile_student'];
 $record['mobile_guardian']=$record['mobile_guardian'];
 $record['mobile_emergency']=$record['mobile_emergency'];
 $record['email_student']=$record['email_student'];
 $record['email_guardian']=$record['email_guardian'];
 $record['mother_tongue']=$record['mother_tongue'];
 $record['blood_group']=$record['blood_group'];
 $record['eye_power']=$record['eye_power'];
 $record['psychiatric_report']=$record['psychiatric_report'];
 $record['religian']=$record['religian'];
 $record['other_religian']=$record['other_religian'];
 $record['image']=$record['image'];
 $record['last_school']=$record['last_school'];
 $record['last_class']=$record['last_class'];
 $record['tc_no']=$record['tc_no'];
 $record['tc_date']=$os->showDate($record['tc_date']); 
 $record['studentRemarks']=$record['studentRemarks'];
 $record['feesPayment']=$record['feesPayment'];
 $record['board']=$record['board'];
 $record['accNo']=$record['accNo'];
 $record['accHolderName']=$record['accHolderName'];
 $record['ifscCode']=$record['ifscCode'];
 $record['branch']=$record['branch'];
 $record['otpPass']=$record['otpPass'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_studentDeleteRowById')=='OK')
{ 

$studentId=$os->post('studentId');
 if($studentId>0){
 $updateQuery="delete from student where studentId='$studentId'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 
