<?php
include('../wtosConfig.php');
include('os.php'); 
?><?

if($os->get('WT_employeeEditAndSave')=='OK'){

	$employee_id=$os->post('employee_id');
	$dataToSave['full_name']=addslashes($os->post('full_name')); 
	$dataToSave['short_name']=addslashes($os->post('short_name')); 
	$contact_no=$dataToSave['contact_no']=addslashes($os->post('contact_no')); 
	$employee_q= "SELECT * FROM `employee` where contact_no='$contact_no'";
	$employee_mq=$os->mq($employee_q);
	if($employee_id==0&&$os->mfa($employee_mq)){
		echo $msgEnquiry='Error#-#Record already exist.';
		exit();
	}
	$dataToSave['dob']=$os->post('dob')?$os->saveDate($os->post('dob')):$os->now(); 
	$dataToSave['designation']=addslashes($os->post('designation')); 
	$dataToSave['type']=addslashes($os->post('type')); 
	$dataToSave['main_subject']=addslashes($os->post('main_subject')); 
	$dataToSave['others_subject']=addslashes($os->post('others_subject')); 
	$dataToSave['date_of_joining']=$os->post('date_of_joining')?$os->saveDate($os->post('date_of_joining')):$os->now(); 
	$dataToSave['previous_institute']=addslashes($os->post('previous_institute')); 
	$dataToSave['educational_qualification']=addslashes($os->post('educational_qualification')); 
	$dataToSave['fathers_mothers_name']=addslashes($os->post('fathers_mothers_name')); 
	$dataToSave['language']=addslashes($os->post('language')); 
	$dataToSave['nationality']=addslashes($os->post('nationality')); 
	$dataToSave['correspondent_address']=addslashes($os->post('correspondent_address')); 
	$dataToSave['permanent_address']=addslashes($os->post('permanent_address')); 
	$dataToSave['blood_group']=addslashes($os->post('blood_group')); 
	$dataToSave['bank_details']=addslashes($os->post('bank_details')); 
	$dataToSave['branch_name']=addslashes($os->post('branch_name')); 
	$image=$os->UploadPhoto('image',$site['root'].'wtos-images');
	if($image!=''){
		$dataToSave['image']='wtos-images/'.$image;}
		$dataToSave['modifyDate']=$os->now();
		// $dataToSave['modifyBy']=$os->userDetails['adminId']; 
		if($employee_id < 1){
			$dataToSave['addedDate']=$os->now();
			// $dataToSave['addedBy']=$os->userDetails['adminId'];
		}
        $qResult=$os->save('employee',$dataToSave,'employee_id',$employee_id);
        if($qResult)  
          {
          	if($employee_id>0 ){ $mgs= " Data updated Successfully";}
          	if($employee_id<1 ){ $mgs= " Data Added Successfully"; $employee_id=  $qResult;}

          	$mgs=$employee_id."#-#".$mgs;
          }
          else{
          	$mgs="Error#-#Problem Saving Data.";
          }
          echo $mgs;		

          exit();

      } 
