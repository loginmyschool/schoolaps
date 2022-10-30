<?
session_start();
include('../wtosConfig.php');
include('os.php'); // load wtos Library
global $os, $site;
?>
<?
if($os->get('set_password')=='OK'){

    $dob=explode('-',$os->post('dob'));
    $dob_val=$dob[2].'-'.$dob[1].'-'.$dob[0];
    $and_dob=$os->DateQ('dob',$dob_val,$dob_val,$sTime='00:00:00',$eTime='23:59:59');
    $student_q="SELECT * FROM student WHERE mobile_student='".$os->post('mobile_student')."' and name='".$os->post('name')."' $and_dob limit 1";
    $student_mq = $os->mq($student_q);           
    $student_data=$os->mfa($student_mq);
    if($student_data['studentId']>0){
        $dataToSave['otpPass']=$os->post('otpPass');
        $qResult=$os->save('student',$dataToSave,'studentId',$student_data['studentId']);
        $mgs="Password change successfully.Please check.";
    }
    else{
        $mgs="Something went wrong.";
    }

    echo $mgs;
    exit();
}
