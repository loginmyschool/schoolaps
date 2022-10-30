<? 
/*
   # wtos version : 1.1
   # page called by ajax script in studentDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 
?><?

if($os->get('WT_studentListing')=='OK')
 
{
    $where='';
	$showPerPage= $os->post('showPerPage');
	 	
	
$andname=  $os->postAndQuery('name_s','name','%');

    $f_dob_s= $os->post('f_dob_s'); $t_dob_s= $os->post('t_dob_s');
   $anddob=$os->DateQ('dob',$f_dob_s,$t_dob_s,$sTime='00:00:00',$eTime='59:59:59');
$andage=  $os->postAndQuery('age_s','age','%');
$andgender=  $os->postAndQuery('gender_s','gender','%');

    $f_registerDate_s= $os->post('f_registerDate_s'); $t_registerDate_s= $os->post('t_registerDate_s');
   $andregisterDate=$os->DateQ('registerDate',$f_registerDate_s,$t_registerDate_s,$sTime='00:00:00',$eTime='59:59:59');
$andregisterNo=  $os->postAndQuery('registerNo_s','registerNo','%');
$anduid=  $os->postAndQuery('uid_s','uid','%');
$andcaste=  $os->postAndQuery('caste_s','caste','%');
$andsubcast=  $os->postAndQuery('subcast_s','subcast','%');
$andapl_bpl=  $os->postAndQuery('apl_bpl_s','apl_bpl','%');
$andminority=  $os->postAndQuery('minority_s','minority','%');
$andadhar_name=  $os->postAndQuery('adhar_name_s','adhar_name','%');

    $f_adhar_dob_s= $os->post('f_adhar_dob_s'); $t_adhar_dob_s= $os->post('t_adhar_dob_s');
   $andadhar_dob=$os->DateQ('adhar_dob',$f_adhar_dob_s,$t_adhar_dob_s,$sTime='00:00:00',$eTime='59:59:59');
$andadhar_no=  $os->postAndQuery('adhar_no_s','adhar_no','%');
$andph=  $os->postAndQuery('ph_s','ph','%');
$andph_percent=  $os->postAndQuery('ph_percent_s','ph_percent','%');
$anddisable=  $os->postAndQuery('disable_s','disable','%');
$anddisable_percent=  $os->postAndQuery('disable_percent_s','disable_percent','%');
$andfather_name=  $os->postAndQuery('father_name_s','father_name','%');
$andfather_ocu=  $os->postAndQuery('father_ocu_s','father_ocu','%');
$andfather_adhar=  $os->postAndQuery('father_adhar_s','father_adhar','%');
$andmother_name=  $os->postAndQuery('mother_name_s','mother_name','%');
$andmother_ocu=  $os->postAndQuery('mother_ocu_s','mother_ocu','%');
$andmother_adhar=  $os->postAndQuery('mother_adhar_s','mother_adhar','%');
$andvill=  $os->postAndQuery('vill_s','vill','%');
$andpo=  $os->postAndQuery('po_s','po','%');
$andps=  $os->postAndQuery('ps_s','ps','%');
$anddist=  $os->postAndQuery('dist_s','dist','%');
$andblock=  $os->postAndQuery('block_s','block','%');
$andpin=  $os->postAndQuery('pin_s','pin','%');
$andstate=  $os->postAndQuery('state_s','state','%');
$andguardian_name=  $os->postAndQuery('guardian_name_s','guardian_name','%');
$andguardian_relation=  $os->postAndQuery('guardian_relation_s','guardian_relation','%');
$andguardian_address=  $os->postAndQuery('guardian_address_s','guardian_address','%');
$andguardian_ocu=  $os->postAndQuery('guardian_ocu_s','guardian_ocu','%');
$andanual_income=  $os->postAndQuery('anual_income_s','anual_income','%');
$andmobile_student=  $os->postAndQuery('mobile_student_s','mobile_student','%');
$andmobile_guardian=  $os->postAndQuery('mobile_guardian_s','mobile_guardian','%');
$andmobile_emergency=  $os->postAndQuery('mobile_emergency_s','mobile_emergency','%');
$andemail_student=  $os->postAndQuery('email_student_s','email_student','%');
$andemail_guardian=  $os->postAndQuery('email_guardian_s','email_guardian','%');
$andmother_tongue=  $os->postAndQuery('mother_tongue_s','mother_tongue','%');
$andblood_group=  $os->postAndQuery('blood_group_s','blood_group','%');
$andreligian=  $os->postAndQuery('religian_s','religian','%');
$andother_religian=  $os->postAndQuery('other_religian_s','other_religian','%');
$andlast_school=  $os->postAndQuery('last_school_s','last_school','%');
$andlast_class=  $os->postAndQuery('last_class_s','last_class','%');
$andtc_no=  $os->postAndQuery('tc_no_s','tc_no','%');

    $f_tc_date_s= $os->post('f_tc_date_s'); $t_tc_date_s= $os->post('t_tc_date_s');
   $andtc_date=$os->DateQ('tc_date',$f_tc_date_s,$t_tc_date_s,$sTime='00:00:00',$eTime='59:59:59');
 $andremarks=  $os->postAndQuery('studentRemarks_s','studentRemarks','%');

	   
	$searchKey=$os->post('searchKey');
	if($searchKey!=''){
	$where ="and ( name like '%$searchKey%' Or age like '%$searchKey%' Or gender like '%$searchKey%' Or registerNo like '%$searchKey%' Or uid like '%$searchKey%' Or caste like '%$searchKey%' Or subcast like '%$searchKey%' Or apl_bpl like '%$searchKey%' Or minority like '%$searchKey%' Or adhar_name like '%$searchKey%' Or adhar_no like '%$searchKey%' Or ph like '%$searchKey%' Or ph_percent like '%$searchKey%' Or disable like '%$searchKey%' Or disable_percent like '%$searchKey%' Or father_name like '%$searchKey%' Or father_ocu like '%$searchKey%' Or father_adhar like '%$searchKey%' Or mother_name like '%$searchKey%' Or mother_ocu like '%$searchKey%' Or mother_adhar like '%$searchKey%' Or vill like '%$searchKey%' Or po like '%$searchKey%' Or ps like '%$searchKey%' Or dist like '%$searchKey%' Or block like '%$searchKey%' Or pin like '%$searchKey%' Or state like '%$searchKey%' Or guardian_name like '%$searchKey%' Or guardian_relation like '%$searchKey%' Or guardian_address like '%$searchKey%' Or guardian_ocu like '%$searchKey%' Or anual_income like '%$searchKey%' Or mobile_student like '%$searchKey%' Or mobile_guardian like '%$searchKey%' Or mobile_emergency like '%$searchKey%' Or email_student like '%$searchKey%' Or email_guardian like '%$searchKey%' Or mother_tongue like '%$searchKey%' Or blood_group like '%$searchKey%' Or religian like '%$searchKey%' Or other_religian like '%$searchKey%' Or last_school like '%$searchKey%' Or last_class like '%$searchKey%' Or tc_no like '%$searchKey%' Or studentRemarks like '%$searchKey%' )";
 
	}
		
    $listingQuery="  select * from student where studentId>0   $where   $andname  $anddob  $andage  $andgender  $andregisterDate  $andregisterNo  $anduid  $andcaste  $andsubcast  $andapl_bpl  $andminority  $andadhar_name  $andadhar_dob  $andadhar_no  $andph  $andph_percent  $anddisable  $anddisable_percent  $andfather_name  $andfather_ocu  $andfather_adhar  $andmother_name  $andmother_ocu  $andmother_adhar  $andvill  $andpo  $andps  $anddist  $andblock  $andpin  $andstate  $andguardian_name  $andguardian_relation  $andguardian_address  $andguardian_ocu  $andanual_income  $andmobile_student  $andmobile_guardian  $andmobile_emergency  $andemail_student  $andemail_guardian  $andmother_tongue  $andblood_group  $andreligian  $andother_religian  $andlast_school  $andlast_class  $andtc_no  $andtc_date  $andremarks     order by studentId desc";
	  
	$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
	$rsRecords=$resource['resource'];
	 
 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								
<td ><b>Id</b></td> 

<td ><b>Image</b></td> 										
<td ><b>Name</b></td> 
<td ><b>Father Name</b></td> 

<td ><b>Phone No</b></td>
 
  <td ><b>Dob</b></td>  
  <td ><b>age</b></td>  
  <td ><b>Register Date</b></td>  
  <td ><b>Register No</b></td>  
  <td style="display:none"><b>UID</b></td>  
  						
							 
 
						       	</tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								
							
						
							 ?>
							<tr class="trListing" >
							<td><?php echo $serial; ?>     </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_studentGetById('<? echo $record['studentId'];?>');os.setAsCurrentRecords(this)" >Edit</a></span>  <? } ?>  </td>
				<td ><b><?php echo $record['studentId']?></b> </td> 


<td > <a href=""><img  onclick="popUpWindow('showStudentImage.php?studentId=<? echo $record['studentId'];?>', 50, 50, 250, 250)"src="<?php  echo $site['url'].$record['image']; ?>"  height="50" width="50" /></a></td> 
 				
<td ><?php echo $record['name']?></td> 
				
<td><?php echo $record['father_name']?> </td> 
<td><?php echo $record['mobile_student']?> </td>  
  <td><?php echo $os->showDate($record['dob']);?> </td>  
  <td><?php echo $record['age']?> </td>  
  <td><?php echo $os->showDate($record['registerDate']);?> </td>  
  <td><?php echo $record['registerNo']?> </td>  
  <td style="display:none"><?php echo $record['uid']?> </td>  
  
								
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
 
  $dataToSave_2['board']=addslashes($os->post('board')); 
   $dataToSave_2['feesPayment']=addslashes($os->post('feesPayment')); 
	 $dataToSave_2['kanyashree']=addslashes($os->post('kanyashree')); 
   $dataToSave_2['yuvashree']=addslashes($os->post('yuvashree')); 	 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['dob']=$os->saveDate($os->post('dob')); 
 $dataToSave['age']=addslashes($os->post('age')); 
 $dataToSave['gender']=addslashes($os->post('gender')); 
 $dataToSave['registerDate']=$os->saveDate($os->post('registerDate')); 
 $dataToSave['registerNo']=addslashes($os->post('registerNo')); 
 $dataToSave['uid']=addslashes($os->post('uid')); 
 $dataToSave['caste']=addslashes($os->post('caste')); 
 $dataToSave['subcast']=addslashes($os->post('subcast')); 
 $dataToSave['apl_bpl']=addslashes($os->post('apl_bpl')); 
 $dataToSave['minority']=addslashes($os->post('minority')); 
 $dataToSave['adhar_name']=addslashes($os->post('adhar_name')); 
 $dataToSave['adhar_dob']=$os->saveDate($os->post('adhar_dob')); 
 $dataToSave['adhar_no']=addslashes($os->post('adhar_no')); 
 $dataToSave['ph']=addslashes($os->post('ph')); 
 $dataToSave['ph_percent']=addslashes($os->post('ph_percent')); 
 $dataToSave['disable']=addslashes($os->post('disable')); 
 $dataToSave['disable_percent']=addslashes($os->post('disable_percent')); 
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
 $dataToSave['religian']=addslashes($os->post('religian')); 
 $dataToSave['other_religian']=addslashes($os->post('other_religian')); 
 $image=$os->UploadPhoto('image',$site['root'].'wtos-images');
				   	if($image!=''){
					$dataToSave['image']='wtos-images/'.$image;}
 $dataToSave['last_school']=addslashes($os->post('last_school')); 
 $dataToSave['last_class']=addslashes($os->post('last_class')); 
 $dataToSave['tc_no']=addslashes($os->post('tc_no')); 
 $dataToSave['tc_date']=$os->saveDate($os->post('tc_date')); 
 $dataToSave['studentRemarks']=addslashes($os->post('studentRemarks')); 

 
		
		
		//$dataToSave['modifyDate']=$os->now();
		//$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($studentId < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('student',$dataToSave,'studentId',$studentId);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
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
 $record['uid']=$record['uid'];
 $record['caste']=$record['caste'];
 $record['subcast']=$record['subcast'];
 $record['apl_bpl']=$record['apl_bpl'];
 $record['minority']=$record['minority'];
 $record['adhar_name']=$record['adhar_name'];
 $record['adhar_dob']=$os->showDate($record['adhar_dob']); 
 $record['adhar_no']=$record['adhar_no'];
 $record['ph']=$record['ph'];
 $record['ph_percent']=$record['ph_percent'];
 $record['disable']=$record['disable'];
 $record['disable_percent']=$record['disable_percent'];
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
 $record['religian']=$record['religian'];
 $record['other_religian']=$record['other_religian'];
 if($record['image']!=''){
						$record['image']=$site['url'].$record['image'];}
 $record['last_school']=$record['last_school'];
 $record['last_class']=$record['last_class'];
 $record['tc_no']=$record['tc_no'];
 $record['tc_date']=$os->showDate($record['tc_date']); 
 $record['remarks']=$record['remarks'];

		
		
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


if($os->get('checkEditDeletePassword')=='OK')
{
	
	 $studentId=$os->post('studentId');
	 $password=$os->post('password');
	
    $editDeletePassword=$os->rowByField('editDeletePassword','admin','adminId',$os->userDetails['adminId']);
	if($password==$editDeletePassword)
	{
		echo "password matched#-#".$studentId;
		//echo "password matched#-#";
	}
	else
	{
		echo "wrong password";
	}
	exit();
	
}



 
