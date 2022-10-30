<?php

session_start();
include('../wtosConfig.php'); // load configuration
include('os.php'); // load wtos Library
global $os, $site;
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if($os->get('dummy_registration')=='OK'){
    $dataToSave['name']="Student Demo";
    $dataToSave['guardian_name']="Guardian Demo";
    $dataToSave['mobile_student']=addslashes(rand(1000000000,9999999999));
    $dataToSave['otpPass']=addslashes(0000);
    $dataToSave['email_student']=addslashes(generateRandomString(10).'@temporary-mail.net');
    $dataToSave['student_type']='dummy';
    $dataToSave['addedDate']=$os->now();
    $dataToSave['addedBy']=0;
    // _d($dataToSave);
    $studentId=$os->save('student',$dataToSave);
    $dataToSave2['studentId']=$studentId;
    $dataToSave2['student_type']='dummy';
    $dataToSave2['class']= addslashes($os->post('classId'));
    $dataToSave2['asession']= 2021;
    $historyId=$os->save('history',$dataToSave2);
    echo $dataToSave['mobile_student'].'###'.$dataToSave['otpPass'];
    exit();
}

if($os->get('returnOTP')=='OK' && $os->post('generateLoginOTP')=='OK'  )
{

    include('../wtos/sendSms.php');

    $studentId=0;
    $mobileNo =$os->post('mobileNo');
    $dataToSave['mobileNo']= $mobileNo;
    $dataToSave['otpCode']=$os->generateOTP();
    $dataToSave['validFrom']=$os->now();
    $dataToSave['validTo']=$os->now();
    $dataToSave['dated']=$os->now();
    $dataToSave['status']='new'; //'new,used,expired',
    $dataToSave['usedDate']='0000-00-00 00:00:00';
    $dataToSave['note']='Login OTP';
    $otpId=$os->save('otp',$dataToSave,'otpId','');

    $studentD=$os->rowByField('','student','mobile_student',$mobileNo);
    if($studentD['studentId']>0)
    {

        $studentId=$studentD['studentId'];

        $dataToSave2['otpPass']=$dataToSave['otpCode'];

        $os->save('student',$dataToSave2,'studentId',$studentId);

    }
    if($studentId==0)

    {

        $teacherData=$os->rowByField('','teacher','mobile',$mobileNo);

        if($teacherData['teacherId']>0)

        {

            $teacherId=$teacherData['teacherId'];

            $dataToSave3['otpPass']=$dataToSave['otpCode'];

            $os->save('teacher',$dataToSave3,'teacherId',$teacherId);

        }

        else

        {

            $guardianData=$os->rowByField('','guardian','mobile',$mobileNo);

            if($guardianData['guardianId']>0)

            {

                $guardianId=$guardianData['guardianId'];

                $dataToSave4['otpPass']=$dataToSave['otpCode'];

                $os->save('guardian',$dataToSave4,'guardianId',$guardianId);

            }

        }

    }

    $smsObj= new sms;

    $smsText=$smsObj->template('New_OTP',array('#OTP#'=>$dataToSave['otpCode']));

    $smsNumbersStr= $dataToSave['mobileNo'];

    $smsObj->sendSMS($smsText,$smsNumbersStr);

    $os->saveSendingSms($smsText,$mobileNos=$smsNumbersStr ,$status='send',$note='Login OTP');

    exit();

}

if($os->get('customerLogin')=='OK' && $os->post('customerRegistrationAndLogin')=='OK'  )
{

    $loginA='';

    $otpMsg='-result-ERROR-result- -MSG-Invalid OTP-MSG-';

    $mobileNo =$os->post('mobileNo');

    $otp =$os->post('otp');



    $studentData=$os->rowByField('','student','mobile_student',$mobileNo);

    if($studentData['studentId']>0)

    {

        $loginQ="select * from student where studentId>0 and  mobile_student='$mobileNo' and  otpPass='$otp'";

        $loginMq=$os->mq($loginQ);

        $loginData=$os->mfa($loginMq);

        $loginA['id']=$loginData['studentId'];

    }
    else
    {



        $teacherData=$os->rowByField('','teacher','mobile',$mobileNo);

        if($teacherData['teacherId']>0)

        {



            $loginQ="select * from teacher where teacherId>0 and  mobile='$mobileNo' and  otpPass='$otp'";

            $loginMq=$os->mq($loginQ);

            $loginData=$os->mfa($loginMq);

            $loginA['id']=$loginData['teacherId'];

        }





        else

        {



            $loginQ="select * from guardian where guardianId>0 and  mobile='$mobileNo' and  otpPass='$otp'";

            $loginMq=$os->mq($loginQ);

            $loginData=$os->mfa($loginMq);

            $loginA['id']=$loginData['guardianId'];

        }





    }





    if(isset($loginA['id']))

    {

        if($loginA['id']>0)

        {

            $otpMsg='-result-OK-result-  -mobileNo-'.$mobileNo.'-mobileNo-';

        }

    }



    echo $otpMsg;



    exit();

}

if($os->get('simple_login_ajax-----------------')=='OK' && $os->post('simple_login_ajax------------')=='OK'  )
{

    $login_username=trim($os->post('login_username'));
    $login_passcode=$os->post('login_passcode');
    global $site;
    $login_success=false;
    $redirect='';
    $return_array=array();
    $return_array['Login']='Fail';
    $return_array['redirect']='';

    $login_username=str_replace(array("'",'"',';','-',' ',"`",'select','union','or','#','%', 'where','=','.','delete','remove','alter'),'A',$login_username);



    $query="select * from student where mobile_student!='' and otpPass!='' and  registerNo='$login_username' and otpPass='$login_passcode' limit 1  ";
    $datars=$os->mq($query);
    $data=$os->mfa($datars);
    $studentId=$os->val($data,'studentId');
    if($studentId>0)
    {
        $answer_file = ANSWERS_PATH."/".$studentId.".json";
        if(!file_exists($answer_file)){
            file_put_contents($answer_file, "{}");
            chmod($answer_file, 0777);
        }
        $login_success=true;
        $loginKey=$site['loginKey'];
        $_SESSION[$loginKey]['logedUser']=$data;
        $_SESSION[$loginKey]['logedType']='STUDENT';
        $redirect=$site['url'].'myprofile';
        $return_array['Login']='Success';






        if($_SESSION['subscription_package_data']['subscription_structure_id']>0){
           $asession=$_SESSION['subscription_package_data']['asession'];
           $classId=$_SESSION['subscription_package_data']['classId'];
           $subscription_structure_id=$_SESSION['subscription_package_data']['subscription_structure_id'];
           $type=$_SESSION['subscription_package_data']['type'];
           $amount=$_SESSION['subscription_package_data']['amount'];


           $get_historyId=$os->rowByField('historyId','history','studentId',$studentId,$where="and asession='".$asession."'",$orderby='');
           $and_history_id=$get_historyId>0?"and historyId='$get_historyId'":'';
           $subscription_id=$get_historyId>0?$os->rowByField('subscription_id','subscription','studentId',$studentId,$where=" $and_history_id  ",$orderby=''):0;
           if($subscription_id>0){
            echo $mgs="##--Error--##You have already added ".$asession." subscription.Please visit my subscription.##--Error--##";
        }
        else{
            // //History Add Section//
            $dataToSave["studentId"] = addslashes($studentId);
            $dataToSave['asession']=addslashes($asession);
            $classId=$dataToSave['class']=addslashes($classId);
            $dataToSave['branch_code']=1;            
            $dataToSave['addedDate']=$os->now();
            $historyId=$get_historyId>0?$get_historyId:$os->save("history", $dataToSave);
            // //End History Add Section//

            // //Subscription Add Section//
            $and_asession="and asession='".$asession."'";
            $sub_str_a=$os->rowByField('','subscription_structure','subscription_structure_id',$subscription_structure_id);
            $dataToSave2["sub_str_details"] = addslashes(json_encode($sub_str_a));  
            $dataToSave2["studentId"] = addslashes($studentId);            
            $dataToSave2["subscription_structure_id"] = addslashes($subscription_structure_id);
            $dataToSave2["online_class"] = addslashes($type=='full_package'?1:0);
            $dataToSave2["online_exam"] = addslashes(($type=='full_package'||$type=='only_exam')?1:0);
            $dataToSave2['historyId']=addslashes($historyId);
            $dataToSave2['dated']=$os->now();           
            $dataToSave2['total_amount']=addslashes($amount);
            $dataToSave2['addedDate']=$os->now();
            $subscription_id=$os->save("subscription", $dataToSave2);           
            if($historyId>0&&$subscription_id>0){
                $_SESSION['paytm']['subscription_id']=$subscription_id;
                $_SESSION['paytm']['studentId']=$studentId;
                $_SESSION['paytm']['historyId']=$historyId;
                $redirect=$site['url'].'payment';
            }
        } 

    }
    unset($_SESSION['subscription_package_data']);    
    $return_array['redirect']=$redirect;

} 
else {

    $data = $os->mfa($os->mq("select * from admin where username!='' and password!='' and  username='$login_username' and password='$login_passcode' limit 1  "));
    $adminId = $os->val($data,'adminId');
    if($adminId>0)
    {
        $login_success=true;
        $loginKey_wtos=$site['loginKey-wtos'];
        $_SESSION[$loginKey_wtos]['logedUser']=$data;
        $_SESSION[$loginKey_wtos]['logedType']='ADMIN';
        $redirect=$site['url-wtos'].'staff_profile.php';

        $return_array['Login']='Success';
        $return_array['redirect']=$redirect;

    }


}


echo   '##--Login_process_result--##'; echo $return_array['Login'] ;echo   '##--Login_process_result--##';
echo   '##--Login_process_redirect--##'; echo $return_array['redirect'] ;echo   '##--Login_process_redirect--##';


exit();

}
if($os->get('simple_login_ajax')=='OK' && $os->post('simple_login_ajax')=='OK'  )
{

    $login_username=trim($os->post('login_username'));
    $login_passcode=$os->post('login_passcode');
    global $site;
    $login_success=false;
    $redirect='';
    $return_array=array();
    $return_array['Login']='Fail';
    $return_array['redirect']='';

   //  $login_username=str_replace(array("'",'"',';','-',' ',"`",'select','union','or','#','%', 'where','=','.','delete','remove','alter'),'A',$login_username);
     $login_username=str_replace(array("'",'|','&','*','^','and','"',';','`','select','union','or','#','%', 'where','=','.','delete','remove','alter'),'',$login_username);


    $query="select * from student where registerNo!='' and otpPass!='' and  registerNo='$login_username' and otpPass='$login_passcode' AND status_active!='N' limit 1  ";
    $datars=$os->mq($query);
    $data=$os->mfa($datars);
	$studentId=$os->val($data,'studentId');
    if($studentId>0)
    {
        $answer_file = ANSWERS_PATH."/".$studentId.".json";

        if(!file_exists($answer_file)){
            file_put_contents($answer_file, "{}");
            chmod($answer_file, 0777);
        }
        $login_success=true;
        $loginKey=$site['loginKey'];
        $_SESSION[$loginKey]['logedUser']=$data;
        $_SESSION[$loginKey]['logedType']='STUDENT';
        $redirect=$site['url'].'myprofile';

        $return_array['Login']='Success';
        $return_array['redirect']=$redirect;

    } else {
        
	   
		   $query_a="select * from admin where `username`!='' and `password`!='' and  `username`='$login_username' and `password`='$login_passcode' limit 1  ";
        $data = $os->mfa($os->mq($query_a));
	 
        $adminId = $os->val($data,'adminId');
        if($adminId>0)
        {
            $login_success=true;
            $loginKey_wtos=$site['loginKey-wtos'];
            $_SESSION[$loginKey_wtos]['logedUser']=$data;
            $_SESSION[$loginKey_wtos]['logedType']='ADMIN';
            $redirect=$site['url-wtos'].'staff_profile.php';

            $return_array['Login']='Success';
            $return_array['redirect']=$redirect;

        }


    }


    echo   '##--Login_process_result--##'; echo $return_array['Login'] ;echo   '##--Login_process_result--##';
    echo   '##--Login_process_redirect--##'; echo $return_array['redirect'] ;echo   '##--Login_process_redirect--##';


    exit();

}

if($os->get('wt_ajax_chain')=='OK' && $os->post('wt_ajax_chain')=='OK')
{



    $output_type=$os->post('output_type');
    $field_id=$os->post('field_id');
    $tableField=$os->post('tableField');
    $conditions_val_str=$os->post('conditions_val_str');

    $query_plus=$os->post('query_plus');
    $call_back_php=$os->post('call_back_php');
    $call_back_script=$os->post('call_back_script');



    $tableField_arr=explode(',',$tableField);

    $table=$tableField_arr['0'];
    $table_id_fleld=$tableField_arr[1];
    $table_val_fleld=$tableField_arr[2];
    $conditions_str='';
    if($conditions_val_str!='')// asession=asession_s,vehicle_type=vehicle_type_id
    {

        $conditions_val_arr=explode(',',$conditions_val_str);
        $conditions_val_arr=array_filter($conditions_val_arr);
        foreach($conditions_val_arr as $condStr)
        {
            $condArr=explode('=', $condStr);

            //_d($condArr);
            if(trim($condArr[0])){
                $conditions_str= $conditions_str .  " and  ".$condArr[0]." = '".$condArr[1]."'";
            }
        }


    }




    $arr=array(); $val='';
    $query2="select * from $table where  $table_id_fleld!=''   $conditions_str $query_plus ";
    $rsResults=$os->mq($query2);

    $val=0;
    while($record=$os->mfa( $rsResults))
    {
        $arr[$record[$table_id_fleld]]=$record[$table_val_fleld];
        $val=$record[$table_val_fleld];
    }

    if($call_back_php!='')
    {
        // $call_back_php=$call_back_php."(&$arr)";
        $os->$call_back_php($arr,$val); // example subject_by_exam(&$arr,&$val)

    }

    echo '##--ajax_chain_data_fild--##';
    echo $field_id;
    echo '##--ajax_chain_data_fild--##';
    echo '##--ajax_chain_data--##';
    if($output_type=='html') {

        echo '<option value=""> </option>';
        $os->onlyOption($arr,'');
    }else
    {
        echo  $val;

    }
    echo '##--ajax_chain_data--##';

    echo '##--output_type--##';
    echo $output_type;
    echo '##--output_type--##';
    echo "##-call_back_script-##"; echo $call_back_script;echo "##-call_back_script-##";



    exit();
}


if($os->get('change_profile_picture')=='OK' && $os->post('change_profile_picture')=='OK'){
    $filename = $os->UploadPhoto("profile_picture",$site["root-image"]);
    if ($filename!=""){
        $dataToSave = [];
        $dataToSave["profile_picture"] = $filename;
        $studentId = $os->loggedUser()["studentId"];

        if($os->save("student", $dataToSave, "studentId", $studentId)){
            print  $site["url-image"].$filename;
        } else {
            print 0;
        }
    }

}


if($os->get('set_subs_str')=='OK'){   
    $_SESSION['subscription_package_data']['subscription_structure_id']=$os->post('subscription_structure_id');
    $_SESSION['subscription_package_data']['classId']=$os->post('classId');
    $_SESSION['subscription_package_data']['asession']=$os->post('asession');
    $_SESSION['subscription_package_data']['type']=$os->post('type');
    $_SESSION['subscription_package_data']['amount']=$os->post('amount');

    // _d($_SESSION['subscription_package_data']);
    exit;
}

?>
