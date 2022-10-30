<?php

session_start();

include('../wtosConfig.php'); // load configuration

include('os.php'); // load wtos Library

$os->userDetails =$os->session($os->loginKey,'logedUser');

if($os->get('answer_by_student')=='OK' && $os->post('answer_by_student')=='OK'  )
{

    $studentId=$os->userDetails['studentId'];
    $questionId=$os->post('questionId');
    $examdetailsId=$os->post('examdetailsId');
    $exammId=$os->post('exammId');
    $answer=$os->post('answer');


    $dataToSave['studentId']=$studentId;
    $dataToSave['examId']=$exammId;
    $dataToSave['examdetailsId']=$examdetailsId;
    $dataToSave['questionId']=$questionId;
    $dataToSave['answerSelected']=$os->post('answer');

    if($questionId < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }
    $duplicate_query="select * from questionanswared where questionId='$questionId'  and examdetailsId='$examdetailsId'  and  studentId='$studentId'    ";
    $questionanswaredId=$os->isRecordExist($duplicate_query,'questionanswaredId');


    ///added by nafish
    if($answer==""){
        $delete_query = $os->mq("DELETE FROM questionanswared WHERE questionanswaredId='$questionanswaredId'");
        if($delete_query){
            print "successfully deleted";
        }
    }

    $qResult=$os->save('questionanswared',$dataToSave,'questionanswaredId',$questionanswaredId); ///    allowed char '\*#@/"~$^.,()|+_-=:��
    print $os->query;
    $total_marks_gain=0;
    $query="select   sum(IF(qa.answerSelected=q.correctAnswer , q.marks*1, q.negetive_marks * -1 )) total  from questionanswared qa , question q where q.questionId=qa.questionId  and q.examdetailsId=qa.examdetailsId   and  qa.studentId='$studentId' group by    qa.studentId, qa.examdetailsId  ";
    $rsResults=$os->mq($query);
    $record=$os->mfa( $rsResults);
    $total_marks_gain=$record['total'];

    $writtenMarks=$total_marks_gain;
    $totalMarks=$total_marks_gain;
    $percentage=0;

    $update_marks="update   resultsdetails set writtenMarks='$writtenMarks',totalMarks='$totalMarks' ,percentage='$percentage'  where examdetailsId='$examdetailsId'  and examId='$exammId'  and    start='1' and    studentId='$studentId'  ";

    $rsResults=$os->mq($update_marks);


    // echo $os->query;

    //echo 'ok';

    //	 studentId 	answerSelected 	marks 	status 	addedBy 	addedDate 	modifyBy 	modifyDate
    exit();
}

if($os->get('start_exam')=='OK' && $os->post('start_exam')=='OK'  )
{



    $studentId=$os->userDetails['studentId'];
    $exammId=$os->post('exammId');
    $examdetailsId=$os->post('examdetailsId');
    $examTitle=$os->post('examTitle');
    $subject_id=$os->post('subject_id');
    $subjectName=$os->post('subjectName');
    $class_id=$os->post('class_id');



    //$dataToSave['resultsId']=addslashes($os->post('resultsId'));
    $dataToSave['examId']=$exammId;
    $dataToSave['asession']=date('Y');
    $dataToSave['studentId']=$studentId;
    $dataToSave['examTitle']=$examTitle;
    $dataToSave['class']=$class_id;
    $dataToSave['examdetailsId']=$examdetailsId;
    $dataToSave['subjectName']=$subjectName;
    $dataToSave['subjectId']=$subject_id;

    $dataToSave['writtenMarks']=0;
    $dataToSave['viva']=0;
    $dataToSave['practical']=0;
    $dataToSave['totalMarks']=0;
    $dataToSave['percentage']=0;
    $dataToSave['grade']=0;
    $dataToSave['note']='Online';



    $duplicate_query="select * from resultsdetails where examdetailsId='$examdetailsId'  and class='$class_id'  and    subjectId='$subject_id' and    studentId='$studentId'  ";

    $rsResults=$os->mq($duplicate_query);
    $record_exist=$os->mfa( $rsResults);
    // _d($record_exist);

    $resultsdetailsId=$os->val($record_exist,'resultsdetailsId');
    $startTime_bystudent=$os->val($record_exist,'startTime');

    $dataToSave['modifyDate']=$os->now();
    //$dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($resultsdetailsId < 1){
        $dataToSave['start ']='1';
        $dataToSave['startTime']=$os->now();
        $startTime_bystudent=$os->now();
        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$studentId;
        $resultsdetailsId=$os->save('resultsdetails',$dataToSave,'resultsdetailsId',$resultsdetailsId);///    allowed char '\*#@/"~$^.,()|+_-=:��
    }


    $exam_query="select * from examdetails where examdetailsId='$examdetailsId' ";
    $rsResults=$os->mq($exam_query);
    $examdetails=$os->mfa( $rsResults);



    $duration=$examdetails['duration'];


    $startDate=$examdetails['startDate'];
    $startTime=$examdetails['startTime'];
    $endDate=$examdetails['endDate'];
    $endTime=$examdetails['endTime'];

    $time_now=$os->now();
    //$startTime_bystudent

    $d1=  strtotime($startTime_bystudent);
    $d2=  strtotime($time_now);
    $diff_sec=$d2-$d1;
    $duration_sec=(int)$duration*60;
    $remain_sec= $diff_sec<0?(int)$diff_sec - $duration_sec:$duration_sec - (int)$diff_sec;
    if($remain_sec<1){ $remain_sec=0;}




    echo   '##--EXAM-remain_sec-DATA--##'; echo $remain_sec ;echo   '##--EXAM-remain_sec-DATA--##';
    echo   '##--EXAM-startTime_bystudent-DATA--##'; echo $startTime_bystudent ;echo   '##--EXAM-startTime_bystudent-DATA--##';

    exit();
}

