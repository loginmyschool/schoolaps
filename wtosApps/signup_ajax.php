<?
session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
?>
<?
if($os->get('register_student')=='OK'){
    //$studentId=$os->post('studentId');
    $dataToSave['name']=addslashes($os->post('name'));
    $mobile_student=$dataToSave['mobile_student']=addslashes($os->post('mobile_student'));
   // $dataToSave['registerNo']=addslashes($os->post('mobile_student'));
    $dataToSave['otpPass']=addslashes(trim($os->post('otpPass')));    
    $dataToSave['dob']=addslashes($os->post('dob'));
    $dob=explode('-',$os->post('dob'));
    $dataToSave['dob']=$os->saveDate($dob[2].'-'.$dob[1].'-'.$dob[0]);
    $dataToSave['father_name']=addslashes($os->post('father_name'));
    $dataToSave['vill']=addslashes($os->post('vill'));
    $dataToSave['po']=addslashes($os->post('po'));
    $dataToSave['ps']=addslashes($os->post('ps'));
    $dataToSave['dist']=addslashes($os->post('dist'));
    $dataToSave['block']=addslashes($os->post('block'));
    $dataToSave['pin']=addslashes($os->post('pin'));
    $dataToSave['state']=addslashes($os->post('state'));
    $dataToSave['addedDate']=$os->now();
    $dataToSave['student_type']='nonresidential';
    $student_mq = $os->mq("SELECT * FROM student WHERE mobile_student='$mobile_student' limit 1");           
    $student_data=$os->mfa($student_mq);
    if($student_data['studentId']>0){
        $mgs=$student_data['studentId']."#-#This mobile number is registered. Please Sign in to continue.#-#ALREADY_ADDED";
    }
    else{
        $qResult=$os->save('student',$dataToSave);

        // //History Add Section//
            $dataToSave2["studentId"] = addslashes($qResult);
            $dataToSave2['asession']=addslashes($os->post('asession_s'));
            $dataToSave2['class']=addslashes($os->post('class_s'));
            $dataToSave2['branch_code']=addslashes($os->post('branch_code'));            
            $dataToSave2['addedDate']=$os->now();
            $historyId=$os->save("history", $dataToSave2);
            // //End History Add Section//
        if($qResult){
            $mgs= "Record added successfully.Please Login."; 
            $studentId=  $qResult;
            $mgs=$studentId."#-#".$mgs.'#-#NEW_ADDED';
            $_SESSION['registration_studentId']=$studentId;
            
        }
        else{
            $mgs="Error#-#Problem Saving Data.";
        }
    }
    echo $mgs;
    exit();
}
