<? 
/*
   # wtos version : 1.1
   # page called by ajax script in online_formDataView.php 
   #  
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

 include('admission_helper_function.php');
?><?

if($os->get('WT_online_formListing')=='OK')
 {
		$where='';
		$showPerPage= $os->post('showPerPage');
		$discount_percent=array(''=>'','RS'=>'RS','%'=>'%');
		
		$andname=  $os->postAndQuery('name_s','name','%');
		
		$f_dob_s= $os->post('f_dob_s'); $t_dob_s= $os->post('t_dob_s');
		$anddob=$os->DateQ('dob',$f_dob_s,$t_dob_s,$sTime='00:00:00',$eTime='59:59:59');
		$andgender=  $os->postAndQuery('gender_s','gender','%');
		$anduid=  $os->postAndQuery('uid_s','uid','%');
		$andcaste=  $os->postAndQuery('caste_s','caste','%');
		$andsubcast=  $os->postAndQuery('subcast_s','subcast','%');
		$andapl_bpl=  $os->postAndQuery('apl_bpl_s','apl_bpl','%');
		$andpo=  $os->postAndQuery('po_s','po','%');
		$andps=  $os->postAndQuery('ps_s','ps','%');
		$andclass_id=  $os->postAndQuery('class_id_s','class_id','=');
		$andasession=  $os->postAndQuery('asession_s','asession','%');
		$searchKey=$os->post('searchKey');
		if($searchKey!='')
		{
			$where ="and ( name like '%$searchKey%' Or gender like '%$searchKey%' Or uid like '%$searchKey%' Or caste like '%$searchKey%' Or subcast like '%$searchKey%' Or apl_bpl like '%$searchKey%' Or po like '%$searchKey%' Or ps like '%$searchKey%' Or class_id like '%$searchKey%' Or asession like '%$searchKey%' )";
			
		}
			
		$listingQuery="  select * from online_form where online_form_id>0   $where   $andname  $anddob  $andgender  $anduid  $andcaste  $andsubcast  $andapl_bpl  $andpo  $andps  $andclass_id  $andasession     order by online_form_id desc";
		  
		$os->showPerPage=300;  
		$resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
		$rsRecords=$resource['resource'];
		$onlineform_ststus=array (''=>'', 'Approved' => 'Approved', 'Rejected' => 'Rejected'  );
		$onlineform_ststus_color=array (''=>'','Approved' => '9FFFB8','Rejected' => 'FF8080');
		 
?>
<div class="listingRecords">
<div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

<table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
							<tr class="borderTitle" >
						
	                            <td >#</td>
									<td >Action </td>
								

											
<td ><b>Name</b></td>  
  <td ><b>DOB</b></td>  
  <td ><b>Image</b></td>  
  <td ><b>Gender</b></td>  
  <td ><b>UID</b></td>  
  <td ><b>Street/Vill/Location</b></td>  
  <td ><b>PO</b></td>  
  <td ><b>Ps</b></td>  
  <td ><b>class_id</b></td>  
  <td ><b>Year</b></td>  
   
  <td ><b>Marks %</b></td>  
  <td ><b>Last Class</b></td>  
  <td ><b>Institute</b></td>  
  <td ><b>Status</b></td>
   <td style="width:95px;" ><b>Admission <br /> Discount</b></td>
    <td  style="width:95px;"  ><b>Monthly <br />  Discount</b></td>
	 <td ><b>Donation</b></td>
	 <td ><b>Donat.<br /> Install.</b></td>
	 </tr>
							
							
							
							<?php
								  
						  	 $serial=$os->val($resource,'serial');  
						 
							while($record=$os->mfa( $rsRecords)){ 
							 $serial++;
							    
								$className='';
								
								if($record['status']=='Approved')
								{
								 $className='application_Approved';
								}
								
								if($record['status']=='Rejected')
								{
								 $className='application_Rejected';
								}
								
								
						
							 ?>
							<tr class="trListing  <? echo $className ?>">
							<td><input type="checkbox" name="online_form_ids[]" value="<? echo $record['online_form_id'];?>" /> &nbsp;<?php echo $serial; ?>
							 <? if($record['status']=='Approved'){ ?>
							    <? } ?> </td>
							<td> 
							<? if($os->access('wtView')){ ?>
							<span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_online_formGetById('<? echo $record['online_form_id'];?>')" >Edit</a></span>  <? } ?>  </td>
								
<td><?php echo $record['name']?> </td>  
  <td><?php echo $os->showDate($record['dob']);?> </td>  
  <td><?php if( $record['image']!=''){ ?>  <img src="<? echo $site['url'].$record['image'];?> " height="40" />  <? } ?>  </td>  
  <td> <? if(isset($os->gender[$record['gender']])){ echo  $os->gender[$record['gender']]; } ?></td> 
  <td><?php echo $record['uid']?> </td>  
  <td><?php echo $record['vill']?> </td>  
  <td><?php echo $record['po']?> </td>  
  <td><?php echo $record['ps']?> </td>  
  <td> <? if(isset($os->classList[$record['class_id']])){ echo  $os->classList[$record['class_id']]; } ?></td> 
  <td> <? if(isset($os->asession[$record['asession']])){ echo  $os->asession[$record['asession']]; } ?></td> 
  <td><?php echo $record['marks_percent']?> </td> 
  <td><?php echo $record['last_institute_name']?> </td> 
  <td><?php echo $record['last_institute_address']?> </td> 
  <td align="right"> <? $os->editSelect($onlineform_ststus,$record['status'],'online_form','status','online_form_id',$record['online_form_id'], $inputNameID='editSelect'.$serial,$extraParams='class="editSelect" ',$onlineform_ststus_color) ?>    
  </td> 
  <td >  
  <? $os->editText($record['discountValueAdmission'],'online_form','discountValueAdmission','online_form_id',$record['online_form_id'], $inputNameID='editText_sp',$extraParams='class="editText_sp" '); ?>
  <? $os->editSelect($discount_percent,$record['discountTypeAdmission'],'online_form','discountTypeAdmission','online_form_id',$record['online_form_id'], $inputNameID='editSelect'.$serial,$extraParams='class="editSelect" ',$onlineform_ststus_color) ?>
  </td>
    <td>
	
	<? $os->editText($record['discountValueMonthly'],'online_form','discountValueMonthly','online_form_id',$record['online_form_id'], $inputNameID='editText_sp',$extraParams='class="editText_sp" '); ?>
  <? $os->editSelect($discount_percent,$record['discountTypeMonthly'],'online_form','discountTypeMonthly','online_form_id',$record['online_form_id'], $inputNameID='editSelect'.$serial,$extraParams='class="editSelect" ',$onlineform_ststus_color) ?>
	
	</td>
	 <td > 
	 <? $os->editText($record['donation'],'online_form','donation','online_form_id',$record['online_form_id'], $inputNameID='editText',$extraParams='class="editText" '); ?>  </td>
   						
				 
				 
	<td > 
	 <? $os->editText($record['donation_installment'],'online_form','donation_installment','online_form_id',$record['online_form_id'], $inputNameID='editText_donation_installment',$extraParams='class="editText_donation_installment" '); ?>  
	 
	 </td>
   						
				 </tr>
				 
				 
                          <? 
						  
						 
						  } ?>  
							
		
			
			
							 
		</table> 
		
		
		
		</div>
		
		<br />
		
		
						
<?php 
exit();
	
}
 





if($os->get('WT_online_formEditAndSave')=='OK')
{
 $online_form_id=$os->post('online_form_id');
 
 
		 
 $dataToSave['name']=addslashes($os->post('name')); 
 $dataToSave['dob']=$os->saveDate($os->post('dob')); 
 $dataToSave['age']=addslashes($os->post('age')); 
 $dataToSave['gender']=addslashes($os->post('gender')); 
 $dataToSave['uid']=addslashes($os->post('uid')); 
 $dataToSave['caste']=addslashes($os->post('caste')); 
 $dataToSave['subcast']=addslashes($os->post('subcast')); 
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
 $dataToSave['feesPayment']=addslashes($os->post('feesPayment')); 
 $dataToSave['board']=addslashes($os->post('board')); 
 $dataToSave['accNo']=addslashes($os->post('accNo')); 
 $dataToSave['accHolderName']=addslashes($os->post('accHolderName')); 
 $dataToSave['ifscCode']=addslashes($os->post('ifscCode')); 
 $dataToSave['branch']=addslashes($os->post('branch')); 
 $dataToSave['otpPass']=addslashes($os->post('otpPass')); 
 $dataToSave['applicaton_date']=addslashes($os->post('applicaton_date')); 
 $dataToSave['class_id']=addslashes($os->post('class_id')); 
 $dataToSave['asession']=addslashes($os->post('asession')); 
 $dataToSave['last_class_id']=addslashes($os->post('last_class_id')); 
 $dataToSave['last_class_session']=addslashes($os->post('last_class_session')); 
 $dataToSave['marks_percent']=addslashes($os->post('marks_percent')); 
 $dataToSave['last_institute_name']=addslashes($os->post('last_institute_name')); 
 $dataToSave['last_institute_address']=addslashes($os->post('last_institute_address')); 

 
		
		
		$dataToSave['modifyDate']=$os->now();
		$dataToSave['modifyBy']=$os->userDetails['adminId']; 
		
		if($online_form_id < 1){
		
		$dataToSave['addedDate']=$os->now();
		$dataToSave['addedBy']=$os->userDetails['adminId'];
		}
		
		 
          $qResult=$os->save('online_form',$dataToSave,'online_form_id',$online_form_id);///    allowed char '\*#@/"~$^.,()|+_-=:££ 	
		if($qResult)  
				{
		if($online_form_id>0 ){ $mgs= " Data updated Successfully";}
		if($online_form_id<1 ){ $mgs= " Data Added Successfully"; $online_form_id=  $qResult;}
		
		  $mgs=$online_form_id."#-#".$mgs;
		}
		else
		{
		$mgs="Error#-#Problem Saving Data.";
		
		}
		//_d($dataToSave);
		echo $mgs;		
 
exit();
	
} 
 
if($os->get('WT_online_formGetById')=='OK')
{
		$online_form_id=$os->post('online_form_id');
		
		if($online_form_id>0)	
		{
		$wheres=" where online_form_id='$online_form_id'";
		}
	    $dataQuery=" select * from online_form  $wheres ";
		$rsResults=$os->mq($dataQuery);
		$record=$os->mfa( $rsResults);
		
		 
 $record['name']=$record['name'];
 $record['dob']=$os->showDate($record['dob']); 
 $record['age']=$record['age'];
 $record['gender']=$record['gender'];
 $record['uid']=$record['uid'];
 $record['caste']=$record['caste'];
 $record['subcast']=$record['subcast'];
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
 $record['studentRemarks']=$record['studentRemarks'];
 $record['feesPayment']=$record['feesPayment'];
 $record['board']=$record['board'];
 $record['accNo']=$record['accNo'];
 $record['accHolderName']=$record['accHolderName'];
 $record['ifscCode']=$record['ifscCode'];
 $record['branch']=$record['branch'];
 $record['otpPass']=$record['otpPass'];
 $record['applicaton_date']=$record['applicaton_date'];
 $record['class_id']=$record['class_id'];
 $record['asession']=$record['asession'];
 $record['last_class_id']=$record['last_class_id'];
 $record['last_class_session']=$record['last_class_session'];
 $record['marks_percent']=$record['marks_percent'];
 $record['last_institute_name']=$record['last_institute_name'];
 $record['last_institute_address']=$record['last_institute_address'];

		
		
		echo  json_encode($record);	 
 
exit();
	
}
 
 
if($os->get('WT_online_formDeleteRowById')=='OK')
{ 

$online_form_id=$os->post('online_form_id');
 if($online_form_id>0){
 $updateQuery="delete from online_form where online_form_id='$online_form_id'";
 $os->mq($updateQuery);
    echo 'Record Deleted Successfully';
 }
 exit();
}
 

if($os->post('registration_data_entry')=='OK' && $os->get('confirm_excel_upload')=='OK')
{ 

		$asession=$os->post('form_asession');
		$class_id=$os->post('form_class_id');
		$result_Data=application_excel_entry($asession,$class_id,$file_name='application_form_data_file');
		
		echo $result_Data['message'];
		exit();
} 

if($os->post('apply_bulk_action_to_selected_result')=='OK' && $os->get('apply_bulk_action_to_selected_result')=='OK')
{ 

		$online_form_ids_str=$os->post('online_form_ids_str');
		$action=$os->post('action');
		
		if($action=='set_Approved')
		{   $online_form_ids_str=$online_form_ids_str.'00000';
		             $query_update="update online_form set status='Approved' where  online_form_id IN ($online_form_ids_str) "; 
					 $os->mq($query_update);
			
		}
		if($action=='set_Rejeceted')
		{   $online_form_ids_str=$online_form_ids_str.'00000';
		             $query_update="update online_form set status='Rejected' where  online_form_id IN ($online_form_ids_str) "; 
					 $os->mq($query_update);
			
		}
		
		if($action=='set_Deleted')
		{   		 $online_form_ids_str=$online_form_ids_str.'00000';
		             $query_update="delete from  online_form   where  online_form_id IN ($online_form_ids_str) "; 
					 $os->mq($query_update);
			
		}
		
		
		
		
	
	exit();	 
}
 	 
  
 