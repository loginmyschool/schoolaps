<?
session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?><?
if($os->get('WT_student_applicationEditAndSave')=='OK'){
	$student_application_id=$os->post('student_application_id');
	$dataToSave['student_enquiry_id']=addslashes($os->post('student_enquiry_id')); 
	$dataToSave['studentId']=addslashes($os->post('studentId')); 
	$dataToSave['subject']=addslashes($os->post('subject')); 
	$dataToSave['description']=addslashes($os->post('description')); 
	$dataToSave['status']='active'; 
	$dataToSave['modifyDate']=$os->now();
	$dataToSave['modifyBy']=0; 
	$dataToSave['addedDate']=$os->now();
	$dataToSave['addedBy']=0;

	$qResult=$os->save('student_application',$dataToSave,'student_application_id',$student_application_id);	
	if($qResult) {
		if($student_application_id>0 ){ $mgs= " Data updated Successfully";}
		if($student_application_id<1 ){ $mgs= " Data Added Successfully"; $student_application_id=  $qResult;}
		$mgs=$student_application_id."#-#".$mgs;
	}
	else
	{
		$mgs="Error#-#Problem Saving Data.";

	}
	echo $mgs;	
	exit();

} 
