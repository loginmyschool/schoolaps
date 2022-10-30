<?php


global $os,$site,$session_selected,$bridge,$pageVar;
$ajaxFilePath= $site['url'].'wtosApps/page_my_online_exam_ajax.php';
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$exam_started='';
$activate_cache=true;
//$activate_cache=false;
//echo 'P.T - 03 NEET 2021 Exam postponed due to tecnical reason. Next exam date will be declared soon. ';

//exit();

function encode_decode($value,$decode=false)
{
    $salt='wtos';

    if($decode==false)
    {
        $value =base64_encode($value);
        $value=$value.$salt;
        $value =base64_encode($value);
    }
    if($decode==true)
    {
        $value =base64_decode($value);
        $value=str_replace($salt,'',$value);
        $value =base64_decode($value);
    }

    return $value;
}

if(!$os->isLogin() )
{
    header("Location: ".$site['url']."login");
}
else{



    $studentId=$os->userDetails['studentId'];

    if($activate_cache==false){
        $os->unsetSession('student_data',$studentId); //  session cache history data  // comment out to activate cache
    }
    $student_data=$os->getSession('student_data',$studentId);
    if(!isset($student_data['studentId']))
    {
        $student_data=$os->rowByField('','history','studentId',$studentId,$where="  ",$orderby='  asession desc ');
        $os->setSession($student_data,$key1='student_data',$studentId);
    }




    $name=$os->userDetails['name'];
    $image = $os->userDetails['image'];
    $historyId=$student_data['historyId'];
    $class=$student_data['class'];

    $asession =$student_data['asession'];



    if($student_data['branch_code']!='')
    {
        $student_branch=$student_data['branch_code'];
    }
    else
    {
        $student_branch=$os->userDetails['branch'];
    }

    // list of all subject per class

    if($activate_cache==false)
    {
        $os->unsetSession('subject_list',$class);
    }
    $subject_list=$os->getSession('subject_list',$class);
    if(!isset($subject_list))
    {
        $subject_list=$os->get_subjects_by_class($class);
        $os->setSession($subject_list,$key1='subject_list',$class);
    }

    // student   subjects  details


    $student_electives=array();
    $student_subjects=array();
    $notallow_subjects=array();
    if($student_data['elective_subject_ids']!='')
    {
        $student_electives = explode(',',$student_data['elective_subject_ids']);
        $student_electives=array_filter($student_electives);
        $student_subjects=$student_electives;

    }


    foreach($subject_list as $subjct)
    {
        $subjectId=$subjct['subjectId'];
        if($subjct['elective']!=1 )
        {
            $student_subjects[$subjectId]=$subjectId;
        }

        if($subjct['elective']==1 &&  !in_array($subjectId,$student_electives) )
        {
            $notallow_subjects[$subjectId]=$subjectId;
        }


    }

    $student_data['student_electives']=$student_electives;
    $student_data['student_subjects']=$student_subjects;
    $student_data['notallow_subjects']=$notallow_subjects;

    /*
    //added by nafish ahmed
    $subscribed_subjects = [];
    $student_data['student_electives']=[];
    $student_data['student_subjects']=[];
    $student_data['notallow_subjects']=[];
    $subscriptions = $os->mq("SELECT * FROM subscription_details sd
        INNER JOIN subscription s ON s.subscription_id= sd.subscription_id
        WHERE s.historyId=$historyId
        AND DATE(NOW()) >= DATE(s.from_date) AND DATE(NOW()) <= DATE(s.to_date)");
    while($row = $os->mfa($subscriptions)){
        $subscribed_subjects[] = $row["subjectId"];
    }
    foreach($subject_list as $subjct)
    {
        $subjectId=$subjct['subjectId'];
        if(in_array($subjectId, $subscribed_subjects)){
            $student_subjects[$subjectId] = $subjectId;
        } else {
            $notallow_subjects[$subjectId] = $subjectId;
        }
    }
    //added by nafish ahmed
    */


    // student elective subjects

    ?> Welcome <? echo $name ?><?

    $exam_id_segment  = $os->val($pageVar['segment'], 2);




    /**
     * Listing page
     */
    if(!$exam_id_segment)
    {


         // check for subscription  and allow free exam


		  $admission_type='';
		   $student_type_student=$os->userDetails['student_type'];


		   if($student_type_student=='nonresidential')
		   {
		   	   $admission_type='subscription';
		   }

		 $valid_subscription=false;
		 if($admission_type=='subscription')
		 {

			$subscription_data =$os->rowByField('','subscription','historyId',$historyId,$where=" and  payment_status = 'Paid' ",$orderby='');
		    if($subscription_data)
			{
			  $valid_subscription=true;
			}


		 }

	     $and_allow_only_free_exam='';
		 if($admission_type=='subscription' &&  $valid_subscription==false)
		 {
		   $and_allow_only_free_exam=' and  e.for_non_subscriber = 1 ';

		 }

	//  _d($student_data);
	  //  _d($valid_subscription);


	    /*$and_exam_group_ids_elective_filter='';
        if(count($student_subjects)>0){
        $and_exam_group_ids_elective_filter=" and  eg.exam_group_id  IN(
        SELECT eed.exam_group_id FROM examdetails eed WHERE eed.subjectId IN (".implode(',',$student_subjects).")

        )";
        }*/


        // if exam having only one elective subjects
        $and_not_exam_group_ids_only_elective='';
        if(count($notallow_subjects)>0){
            $and_not_exam_group_ids_only_elective=" and  eg.exam_group_id  NOT IN( 
					
					SELECT eed2.exam_group_id FROM examdetails eed2 WHERE  eed2.exam_group_id IN(
					
					SELECT eed.exam_group_id FROM examdetails eed  WHERE eed.subjectId IN (".implode(',',$notallow_subjects).")
					
					) group by eed2.exam_group_id  having count(*)=1
					
					
					 )";


        }



        $and_mode_online="and   eg.exam_mode ='Online'";
        $exam_group_ids="select distinct(egca.exam_group_id) from exam_group_class_access egca where egca.asession='$asession' and  egca.class='$class'   ";
        $exam_and_group="Select  eg.exam_group_name, eg.exam_group_id, eg.exam_start_datetime, eg.exam_end_datetime,  eg.examId ,e.examTitle,e.publish_result, 
        IF(DATE(eg.exam_start_datetime)=DATE(NOW()),'today',IF(DATE(eg.exam_start_datetime)>DATE(NOW()),'upcoming','past')) AS stat  
        from exam_group eg  
					INNER JOIN  exam e ON( e.examId =eg.examId)
					where  (e.branch_codes ='' || e.branch_codes LIKE '%\"$student_branch\"%') 
					and   eg.exam_group_id IN($exam_group_ids) and eg.question_verified='Yes' and e.publish_result!='Yes'
					$and_mode_online
					$and_not_exam_group_ids_only_elective
					$and_allow_only_free_exam
					ORDER BY eg.exam_start_datetime";


        /*$exam_and_group="Select  eg.exam_group_name, eg.exam_group_id, eg.exam_start_datetime, eg.exam_end_datetime,  eg.examId ,e.examTitle,e.publish_result  from exam_group eg
    INNER JOIN  exam e ON( e.examId =eg.examId)
    where  (eg.branch_codes ='' || eg.branch_codes LIKE '%,$student_branch,%')
    and   eg.exam_group_id IN($exam_group_ids) and eg.question_verified='Yes'
    ";	 */

        /*$exam_and_group="Select  eg.exam_group_name, eg.exam_group_id, eg.exam_start_datetime,  eg.examId ,e.examTitle,e.publish_result  from exam_group eg
               INNER JOIN  exam e ON( e.examId =eg.examId)
            INNER JOIN  exam_group_class_access egca ON( egca.exam_group_id =eg.exam_group_id)
            where  (eg.branch_codes ='' || eg.branch_codes ='$student_branch')
            and  egca.asession='$asession' and  egca.class='$class' ;
            ";
        */


        $exam_list=array();
        $lister = ["today"=>[]];
        $rsResults=$os->mq($exam_and_group);
        while($record=$os->mfa( $rsResults))
        {

            $lister[$record["stat"]][$record['examId']]['examTitle']=$record['examTitle'];
            $lister[$record["stat"]][$record['examId']]['publish_result']=$record['publish_result'];
            $lister[$record["stat"]][$record['examId']]['exam_group'][$record['exam_group_id']]=$record;

            $exam_list[$record['examId']]['examTitle']=$record['examTitle'];
            $exam_list[$record['examId']]['publish_result']=$record['publish_result'];
            $exam_list[$record['examId']]['exam_group'][$record['exam_group_id']]=$record;
        }


		// _d($lister);


        ?>
        <div class="uk-text-danger">
            Note: The list is for unpublished and upcoming tests only. Check the results section for published results
        </div>
        <!------Today Exam------>
        <div class="uk-card uk-card-default uk-card-small uk-card-outline uk-margin-small">
            <div class="uk-card-header">
                <h5>Today Exam</h5>
            </div>
            <div class="uk-card-body">
                <?
                if(empty($lister["today"])){
                    print "No exam scheduled yet.";
                }
                foreach($lister["today"] as $examId => $row_exam)
                {
                    ?>
                    <h4 class="uk-text-bold" title="E:<? echo  $examId; ?>"> <? echo $row_exam['examTitle']; ?> </h4>
                    <div class="uk-grid uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
                        <?


                        $exam_group=$os->val($row_exam ,'exam_group');
                        if(is_array($exam_group))
                        {

                            foreach($exam_group as $exam_group_id=>$row_exam_group)
                            {

                                $starttimestamp = strtotime(date_format(date_create($row_exam_group["exam_start_datetime"]), "Y-m-d H:i:s"))  ;
                                $endtimestamp = strtotime(date_format(date_create($row_exam_group["exam_end_datetime"]), "Y-m-d H:i:s"));
                                $nowtimestamp =  strtotime(date("Y-m-d H:i:s"));
                                $resulttimestamp = $endtimestamp+(30*60);

                                $exam_group_id_enc=encode_decode($exam_group_id);
                                ?>
                                <div>
                                    <div class="uk-card  uk-card-secondary uk-card-body uk-text-center ">
                                        <h4 title="E:<? echo  $examId; ?>  EG:<? echo $row_exam_group['exam_group_id'] ?>"><? echo $row_exam_group['exam_group_name'] ?> </h4>
                                        <table class="uk-margin uk-margin-auto uk-text-small">
                                            <tr>
                                                <td>Exam Date</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><? echo date("d-m-Y", $starttimestamp);?></td>
                                            </tr>
                                            <tr>
                                                <td>Exam Time</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><?=date("h:i A", $starttimestamp)?></td>
                                            </tr>
                                        </table>



                                        <? if($nowtimestamp>$starttimestamp && $endtimestamp>$nowtimestamp){?>
                                            <p style="color: orange">Exam has started</p>
                                        <? } ?>


                                        <div class="buttons">

                                            <? if ($endtimestamp>=$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >START</a>
                                            <? } ?>
                                            <? if ($endtimestamp<$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >Provisional OMR Sheet</a>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            <? }

                        }
                        ?>
                    </div>
                <? }
                ?>
            </div>
        </div>
        <!------Today Exam------>
        <div class="uk-card uk-card-default uk-card-small uk-card-outline uk-margin-small uk-hidden">
            <div class="uk-card-header">
                <h5>Upcoming Exam</h5>
            </div>
            <div class="uk-card-body">
                <?
                if(empty($lister["upcoming"])){
                    print "No exam scheduled yet.";
                }
                foreach($lister["upcoming"] as $examId => $row_exam)
                {
                    ?>
                    <h4 class="uk-text-bold" title="E:<? echo  $examId; ?>"> <? echo $row_exam['examTitle']; ?> </h4>
                    <div class="uk-grid uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
                        <?


                        $exam_group=$os->val($row_exam ,'exam_group');
                        if(is_array($exam_group))
                        {

                            foreach($exam_group as $exam_group_id=>$row_exam_group)
                            {

                                $starttimestamp = strtotime(date_format(date_create($row_exam_group["exam_start_datetime"]), "Y-m-d H:i:s"))  ;
                                $endtimestamp = strtotime(date_format(date_create($row_exam_group["exam_end_datetime"]), "Y-m-d H:i:s"));
                                $nowtimestamp =  strtotime(date("Y-m-d H:i:s"));
                                $resulttimestamp = $endtimestamp+(30*60);

                                $exam_group_id_enc=encode_decode($exam_group_id);
                                ?>
                                <div>
                                    <div class="uk-card  uk-card-secondary uk-card-body uk-text-center ">
                                        <h4 title="E:<? echo  $examId; ?>  EG:<? echo $row_exam_group['exam_group_id'] ?>"><? echo $row_exam_group['exam_group_name'] ?> </h4>
                                        <table class="uk-margin uk-margin-auto uk-text-small">
                                            <tr>
                                                <td>Exam Date</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><? echo date("d-m-Y", $starttimestamp);?></td>
                                            </tr>
                                            <tr>
                                                <td>Exam Time</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><?=date("h:i A", $starttimestamp)?></td>
                                            </tr>
                                        </table>



                                        <? if($nowtimestamp>$starttimestamp && $endtimestamp>$nowtimestamp){?>
                                            <p style="color: orange">Exam has started</p>
                                        <? } ?>


                                        <div class="buttons">

                                            <? if ($endtimestamp>=$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >START</a>
                                            <? } ?>
                                            <? if ($endtimestamp<$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >Provisional OMR Sheet</a>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            <? }

                        }
                        ?>
                    </div>
                <? }
                ?>
            </div>
        </div>
        <!------Past Exam------>
        <div class="uk-card uk-card-default uk-card-small uk-card-outline uk-margin-small uk-hidden">
            <div class="uk-card-header">
                <h5>Past Exam</h5>
            </div>
            <div class="uk-card-body">
                <?
                if(empty($lister["past"])){
                    print "No exam scheduled yet.";
                }
                foreach($lister["past"] as $examId => $row_exam)
                {
                    ?>
                    <h4 class="uk-text-bold" title="E:<? echo  $examId; ?>"> <? echo $row_exam['examTitle']; ?> </h4>
                    <div class="uk-grid uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
                        <?


                        $exam_group=$os->val($row_exam ,'exam_group');
                        if(is_array($exam_group))
                        {

                            foreach($exam_group as $exam_group_id=>$row_exam_group)
                            {

                                $starttimestamp = strtotime(date_format(date_create($row_exam_group["exam_start_datetime"]), "Y-m-d H:i:s"))  ;
                                $endtimestamp = strtotime(date_format(date_create($row_exam_group["exam_end_datetime"]), "Y-m-d H:i:s"));
                                $nowtimestamp =  strtotime(date("Y-m-d H:i:s"));
                                $resulttimestamp = $endtimestamp+(30*60);

                                $exam_group_id_enc=encode_decode($exam_group_id);
                                ?>
                                <div>
                                    <div class="uk-card  uk-card-secondary uk-card-body uk-text-center ">
                                        <h4 title="E:<? echo  $examId; ?>  EG:<? echo $row_exam_group['exam_group_id'] ?>"><? echo $row_exam_group['exam_group_name'] ?> </h4>
                                        <table class="uk-margin uk-margin-auto uk-text-small">
                                            <tr>
                                                <td>Exam Date</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><? echo date("d-m-Y", $starttimestamp);?></td>
                                            </tr>
                                            <tr>
                                                <td>Exam Time</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><?=date("h:i A", $starttimestamp)?></td>
                                            </tr>
                                        </table>



                                        <? if($nowtimestamp>$starttimestamp && $endtimestamp>$nowtimestamp){?>
                                            <p style="color: orange">Exam has started</p>
                                        <? } ?>


                                        <div class="buttons">

                                            <? if ($endtimestamp>=$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >START</a>
                                            <? } ?>
                                            <? if ($endtimestamp<$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >Provisional OMR Sheet</a>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            <? }

                        }
                        ?>
                    </div>
                <? }
                ?>
            </div>
        </div>

        <div class="uk-card uk-card-default uk-card-small uk-card-outline uk-margin-small">
            <div class="uk-card-header">
                <h5>All Exams</h5>
            </div>
            <div class="uk-card-body">

                <?
                foreach($exam_list as $examId => $row_exam)
                {
                    ?>
                    <h4 class="uk-text-bold" title="E:<? echo  $examId; ?>"> <? echo $row_exam['examTitle']; ?> </h4>
                    <div class="uk-grid uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
                        <?


                        $exam_group=$os->val($row_exam ,'exam_group');
                        if(is_array($exam_group))
                        {

                            foreach($exam_group as $exam_group_id=>$row_exam_group)
                            {

                                $starttimestamp = strtotime(date_format(date_create($row_exam_group["exam_start_datetime"]), "Y-m-d H:i:s"))  ;
                                $endtimestamp = strtotime(date_format(date_create($row_exam_group["exam_end_datetime"]), "Y-m-d H:i:s"));
                                $nowtimestamp =  strtotime(date("Y-m-d H:i:s"));
                                $resulttimestamp = $endtimestamp+(30*60);

                                $exam_group_id_enc=encode_decode($exam_group_id);
                                ?>
                                <div>
                                    <div class="uk-card  uk-card-secondary uk-card-body uk-text-center ">
                                        <h4 title="E:<? echo  $examId; ?>  EG:<? echo $row_exam_group['exam_group_id'] ?>"><? echo $row_exam_group['exam_group_name'] ?> </h4>
                                        <table class="uk-margin uk-margin-auto uk-text-small">
                                            <tr>
                                                <td>Exam Date</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><? echo date("d-m-Y", $starttimestamp);?></td>
                                            </tr>
                                            <tr>
                                                <td>Exam Time</td>
                                                <td>:</td>
                                                <td class="uk-text-left"><?=date("h:i A", $starttimestamp)?></td>
                                            </tr>
                                        </table>



                                        <? if($nowtimestamp>$starttimestamp && $endtimestamp>$nowtimestamp){?>
                                            <p style="color: orange">Exam has started</p>
                                        <? } ?>


                                        <div class="buttons">

                                            <? if ($endtimestamp>=$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >START</a>
                                            <? } ?>
                                            <? if ($endtimestamp<$nowtimestamp){?>
                                                <a class="uk-button uk-button-default uk-button-small " href="<? echo $site['url'];?>OnlineExam/<? echo $exam_group_id_enc ?>" >Provisional OMR Sheet</a>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            <? }

                        }
                        ?>
                    </div>
                <? }
                ?>
            </div>
        </div>
        <?

    }
    /**
     * Exam Details page
     */
    if($exam_id_segment){


        $exam_group_id_enc = isset($exam_id_segment)?$exam_id_segment:"";
        $exam_group_id =encode_decode($exam_group_id_enc,true);
        $exam_group_id=(int)$exam_group_id;


        ##   submit paper button  666999
        $submit_paper_conform=$os->post('submit_paper_conform');
        if($submit_paper_conform=='OK')
        {
            $submit_time=$os->now();
            $update_submit_query ="update exam_group_history set  submit_paper='1',  submit_time='$submit_time' where  
		exam_group_id='$exam_group_id' and  studentId='$studentId' and  historyId='$historyId' ";
            $os->mq($update_submit_query);

        }
        ##   submit paper button  666999





        /* $exam_data_query="
           SELECT  eg.exam_group_name, eg.exam_group_id,eg.question_verified, eg.exam_start_datetime,eg.exam_end_datetime, eg.examId ,e.examTitle,e.publish_result ,
                   group_concat(ed.examdetailsId) examdetailsIds ,egh.submit_paper, egh.exam_start isStarted ,egh.exam_start_time isStartedTime
           FROM exam_group eg
           INNER JOIN  exam e ON( e.examId =eg.examId)
           INNER JOIN  exam_group_class_access egca ON( egca.exam_group_id =eg.exam_group_id)
           INNER JOIN  examdetails ed ON( ed.exam_group_id =eg.exam_group_id and ed.exam_group_id='$exam_group_id')
           LEFT JOIN  exam_group_history egh ON( egh.exam_group_id =eg.exam_group_id and egh.historyId='$historyId')

           WHERE  (eg.branch_codes ='' || eg.branch_codes ='$student_branch')
                   and  egca.asession='$asession' and  egca.class='$class' and  eg.exam_group_id='$exam_group_id'
           GROUP BY eg.exam_group_id ;
       ";
       $rsResults=$os->mq($exam_data_query);
       $row_examdetails=$os->mfa( $rsResults) ;
       */


        // split query for  above join 444555	 ----------------------------------------------------------------



        if($activate_cache==false){
            $os->unsetSession('row_examdetails',$exam_group_id);
        }

        $row_examdetails=$os->getSession('row_examdetails',$exam_group_id);
        if(!$row_examdetails)
        {
            $exam_group__q=" SELECT  eg.exam_group_name, eg.exam_group_id,eg.question_verified, eg.exam_start_datetime,eg.exam_end_datetime, eg.examId 
				FROM exam_group eg  WHERE    eg.exam_group_id='$exam_group_id'  ";
            $exam_group__q_rs=$os->mq($exam_group__q);
            $row_examdetails=$os->mfa( $exam_group__q_rs);
            $os->setSession($row_examdetails,$key1='row_examdetails',$exam_group_id);
        }

        if($activate_cache==false){
            $os->unsetSession('exam_data_other',$exam_group_id);
        }
        $exam_data_other=$os->getSession('exam_data_other',$exam_group_id);
        if(!$exam_data_other)
        {
            // elective filters
            $and_not_my_elective_subject='';
            if(count($notallow_subjects)>0){
                $and_not_my_elective_subject=" and   ed.subjectId NOT IN (".implode(',',$notallow_subjects).") ";

            }

            $exam_data_query="
				SELECT e.examTitle,e.publish_result , group_concat(ed.examdetailsId) examdetailsIds ,  
				       concat('{',group_concat(concat('\"',ed.examdetailsId,'\":\"',s.subjectName,'\"')),'}') as subjectIds
				FROM exam_group eg  
				INNER JOIN  exam e ON( e.examId =eg.examId)			
				INNER JOIN  examdetails ed ON( ed.exam_group_id =eg.exam_group_id and ed.exam_group_id='$exam_group_id')	
				INNER JOIN subject s on ed.subjectId = s.subjectId
				WHERE   eg.exam_group_id='$exam_group_id'  
				$and_not_my_elective_subject
				GROUP BY eg.exam_group_id 
				";
            $rsResults=$os->mq($exam_data_query);
            $exam_data_other=$os->mfa( $rsResults) ;
            $os->setSession($exam_data_other,$key1='exam_data_other',$exam_group_id);
        }


        $row_examdetails['examTitle']=$os->val($exam_data_other,'examTitle');
        $row_examdetails['publish_result']=$os->val($exam_data_other,'publish_result');
        $row_examdetails['examdetailsIds']=$os->val($exam_data_other,'examdetailsIds');
        $row_examdetails["subjectIds"] = json_decode($exam_data_other["subjectIds"]);





        $exam_group_history_q=" select  *  from exam_group_history egh 
			where egh.exam_group_id ='$exam_group_id' and egh.historyId='$historyId'";
        $exam_group_history_q_rs=$os->mq($exam_group_history_q);
        $row_exam_group_history=$os->mfa( $exam_group_history_q_rs);

        $row_examdetails['submit_paper']=$os->val($row_exam_group_history,'submit_paper');
        $row_examdetails['isStarted']=$os->val($row_exam_group_history,'exam_start');
        $row_examdetails['isStartedTime']=$os->val($row_exam_group_history,'exam_start_time');
        $row_examdetails['question_set']=$os->val($row_exam_group_history,'question_set');



        // split query for  above join 444555	 end   -----------------------------------------------------------------------


        $subjectName=$row_examdetails['exam_group_name'];
        $examTitle=$row_examdetails['examTitle'];
        $examId = $row_examdetails["examId"];

        $examdetailsIds = $row_examdetails["examdetailsIds"];



        // delete all question from cache if question not verified  load qustion and save to session cache
        if($activate_cache==false){
            $os->unsetSession('question_rows',$exam_group_id);
        }

        $question_rows=$os->getSession('question_rows',$exam_group_id);
        if(!$question_rows)
        {
            $question_rows=array();

            $q_set_q=" select  *  from question q 		
			where q.examdetailsId IN ($examdetailsIds) ORDER BY  q.examdetails_section_id ASC,q.viewOrder asc";


            $q_set_q_rs=$os->mq($q_set_q);
            while($row_question=$os->mfa( $q_set_q_rs))
            {
                $question_rows[$row_question["examdetailsId"]][$row_question["examdetails_section_id"]][$row_question['questionId']]=$row_question;

            }
            $os->setSession($question_rows,$key1='question_rows',$exam_group_id);
        }


        //============ Exam Details Section Start ==============//
        if($activate_cache==false){
            $os->unsetSession('examdetails_sections',$exam_group_id);
        }
        $examdetails_sections = $os->getSession('examdetails_sections',$exam_group_id);
        if(!$examdetails_sections){
            $sections = [];
            $eds_query = $os->mq("SELECT * FROM examdetails_section WHERE examdetailsId IN($examdetailsIds)");
            while($eds = $os->mfa($eds_query)){
                $sections[$eds["examdetails_section_id"]] = $eds;
            }
            $os->setSession($sections, $key1='examdetails_sections', $exam_group_id);
            $examdetails_sections = $sections;
        }

        //============ Exam details section end ===============//









        $starttimestamp = strtotime(date_format(date_create($row_examdetails["exam_start_datetime"]), "Y-m-d H:i:s"))  ;
        $endtimestamp = strtotime(date_format(date_create($row_examdetails["exam_end_datetime"]), "Y-m-d H:i:s"));
        $nowtimestamp =  strtotime(date("Y-m-d H:i:s"));

        $exam_time_over=false;
        ///Condtions
        $exam_status  = "";
        if($endtimestamp<$nowtimestamp ){
            $exam_status = "exam_over";
            $exam_time_over=true;
        }
        if($row_examdetails["submit_paper"]){
            $exam_status = "exam_over";

        }
        if($starttimestamp<=$nowtimestamp && $nowtimestamp<=$endtimestamp && $row_examdetails["submit_paper"]!=1){
            $exam_status = "exam_live";
        }
        if($nowtimestamp<$starttimestamp && $row_examdetails["submit_paper"]!=1){
            $exam_status = "exam_not_live";
        }







        /**
         * Pre exam stuff
         */
        if($exam_status=="exam_not_live"){
            ?>
            <div class="uk-width-medium uk-margin-auto" >

                <div id="loading_div">


                    <table class="uk-margin-auto">

                        <tr>
                            <td style="color:black" colspan="3"><h2><?=$row_examdetails["examTitle"]?></h2></td>
                        </tr>
                        <tr class="text-m">
                            <td>Exam Date</td>
                            <td>:</td>
                            <td style="color:#000099; font-weight:bold;"><?= date("d-m-Y",$starttimestamp); ?></td>
                        </tr>
                        <tr class="text-m">
                            <td>Exam Time</td>
                            <td>:</td>
                            <td style="color:#000099; font-weight:bold;"><?= date("h:i:s A",$starttimestamp); ?></td>
                        </tr>
                    </table>
                    <div class="uk-text-center uk-margin">
                        Please be patience , your exam will start automatically after
                        <div id="Exam_timer_div">
                            <div style="">
                                <div id="clockdiv" >

                        <span>
                            <b class="uk-text-bolder text-xxl"  style="color: green" id="time_minuite"></b>
                            <small class="text-m"><b>Min</b></small>
                        </span>

                                    <span class=" m-top-xs">
                            <b class="uk-text-bolder text-xxl"  style="color: green" id="time_second"></b>
                            <small class="text-m"><b>Sec</b></small>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-text-center">
                    <small class="m-top-l uk-text-danger ">
                        If you are not redirected automatically after countdown , please <a href="">click here</a>;
                    </small>
                </div>

            </div>
            <script>
                window.addEventListener("load", function (){
                    let tiiiiime = Math.floor(Math.random() * 10000);
                    startTimer(<?=$starttimestamp-$nowtimestamp ?>, ()=>{
                        document.querySelector("#loading_div").innerHTML = "Please wait while your paper is loading...";
                        setTimeout(()=>{
                            window.location.href = "";
                        }, tiiiiime);

                    });
                })
            </script>
            <?
        }
        /**
         *
         */
        if($exam_status=="exam_live"){
            $examStartedTime = $row_examdetails["isStartedTime"];
            //save if exam is not started


            if(!$row_examdetails["isStarted"]){
                $isShowQuestion = "Yes";
                $examStartedTime = $os->now();
                //save exam  group history

                $dataToSave['studentId']=$studentId;
                $dataToSave['exam_group_id']=$exam_group_id;
                $dataToSave['historyId']=$historyId;
                $dataToSave['submit_paper'] = 0;
                $dataToSave['exam_start']='1';
                $dataToSave['exam_start_time']=$examStartedTime;

                $startexamquery = $os->save('exam_group_history',$dataToSave,'','');///    allowed char '\*#@/"~$^.,()|+_-=:��
            }




            //calculate remaining time
            $startedtimestamp = strtotime($examStartedTime);
            $endedtimestamp  = $endtimestamp;
            $absolute_duration = $endedtimestamp-$startedtimestamp;
            $time_lapse = ($nowtimestamp - $startedtimestamp);
            $remaining_time = $absolute_duration-$time_lapse;


            $remaining_time = $endtimestamp-$nowtimestamp;

            if($remaining_time<0){
                $remaining_time = 0;
            };
            ?>


            <div id="Exam_paper_id">

                <!---Exam timer--->
                <div id="Exam_timer_div" class="examtimerdiv" style="z-index: 9999" >
                    <div style="background-color: background-color: rgba(0,0,0,0.3)">
                        <div id="clockdiv" class="uk-text-center" style="font-size: 0px">

                            <div class="" style="background-color: rgba(0,0,0,0.3);">
                                <b class="minutes uk-text-bolder text-l" id="time_minuite"></b>
                                <small class="text-xs"><b>Min</b></small>
                            </div>

                            <div class=" m-top-xs" style="background-color: rgba(0,0,0,0.3)">
                                <b class="seconds uk-text-bolder text-l" id="time_second"></b>
                                <small class="text-xs"><b>Sec</b></small>
                            </div>

                        </div>
                    </div>
                </div>
                <!----questions-->
                <table class="uk-width-expand answer-table">
                    <tr>
                        <td colspan="2">
                            <div class="text-l uk-margin-remove p-s  uk-margin-small-bottom uk-card-secondary">
                                <h4 style="color:#FFFFFF;"> <? echo $examTitle ?>  <? echo $subjectName ?></h4>
                                <span class="text-s" id="Exam_timer_start"></span>
                            </div>

                        </td>
                    </tr>


                </table>
                    <?

                    // get answer from file
                    $answers_file=$studentId.'.json';
                    $answers_file_path=ANSWERS_PATH.'/'.$answers_file;
                    $answers_data = @json_decode( file_get_contents($answers_file_path));



                    $serial=0;
                    $attempt = [];
                    $question_ids = [];
                    foreach($question_rows as $edId=>$section_questions)
                    {

                        foreach ($section_questions as $edsId=>$questions){
                            if(isset($examdetails_sections[$edsId])){
                                $sec = $examdetails_sections[$edsId];
                                ?>
                                <h5><?= $row_examdetails["subjectIds"]->$edId?> - <?= $sec["name"];?></h5>
                                <?
                            }
                            ?>
                            <div id="section_<?= $edsId?>" max-attempt="<?= $examdetails_sections[$edsId]["max_attempt"] ?? 50000 ?>">
                                <?
                                foreach ($questions as $question_row){
                                    $questionId=$question_row['questionId'];

                                    $radioName="ans_".$questionId;
                                    $question_ids[]=$questionId;
                                    $examdetailsId=$question_row["examdetailsId"];

                                    $radio_value=0;
                                    if(isset($answers_data->$questionId)){
                                        $radio_value=(int)$answers_data->$questionId;
                                    }


                                    ?>
                                    <div  id="question-no-<?=$questionId;?>" class="uk-position-relative uk-card uk-card-default uk-card-small uk-card-body uk-margin-small uk-card-outline">
                                        <div style="font-size: 9px" class="uk-margin-remove uk-text-italic uk-position-absolute uk-position-top-right uk-background-muted">
                                            <table>
                                                <tr>
                                                    <td style="color: #1ea0c3">Marks:</td>
                                                    <td><? echo  $question_row['marks']; ?></td>


                                                    <?if($question_row['negetive_marks']>0){?>
                                                        <td style="color: #1ea0c3">Nagative Marks:</td>
                                                        <td><? echo  $question_row['negetive_marks']; ?></td>
                                                    <?}?>

                                                </tr>
                                            </table>

                                        </div>

                                        <div class="uk-position-absolute uk-position-top-left uk-background-secondary p-left-s p-right-s" style="color: white; border-bottom-right-radius: 5px"><? echo $question_row['viewOrder']; ?></div>
                                        <table>
                                            <tr>
                                                <td class="text-m">
                                                    <div class="" style="color: #000000">
                                                        <? echo  $question_row['questionText']; ?><br>
                                                        <? if($question_row['questionImage']!=''){ ?>
                                                            <img src="<? echo $site['url'].$question_row['questionImage'] ?>"  style="max-width: 100%"  />
                                                        <? } ?>
                                                    </div>
                                                    <!--Mark for review-->
                                                    <label id="review_checkbox_container_<?=$questionId?>" class="text-s uk-flex uk-flex-middle m-top-none" style="color: blue; <?=$radio_value>0?"":"visibility:hidden"?>">
                                                        <input class="uk-checkbox" id="review_checkbox_<?=$questionId?>" type="checkbox" onchange="reviewMatrix('<?=$questionId?>', this.checked)" style="margin-right: 8px !important;">
                                                        Mark for review
                                                    </label>

                                                    <table class=" m-top-m uk-width-expand uk-text-small answer-container-<?=$questionId?>" style="border-collapse: collapse">
                                                        <tr>
                                                            <td class="uk-table-shrink" style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                                <input type="checkbox" value="1" edsId="<?= $edsId?>"
                                                                       class="uk-checkbox answer-checkbox-<?= $edsId?>"
                                                                       onchange="if(checkSection(this, <?= $questionId; ?>)){attemptMatrix('<?= $questionId; ?>', this); answer_by_student('<? echo $radioName ?>_1','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')}"
                                                                       name="<? echo $radioName ?>" id="<? echo $radioName ?>_1"  <? if( $radio_value==1){echo 'checked="checked"'; $attempt[$questionId] = true;} ?> />
                                                                1.
                                                            </td>
                                                            <td>
                                                                <? echo  $question_row['answerText1']; ?><br>
                                                                <? if($question_row['answerImage1']!=''){ ?>
                                                                    <img src="<? echo $site['url'].$question_row['answerImage1'] ?>"  style="height:100px;"  />
                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                        <tr >
                                                            <td style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                                <input  edsId="<?= $edsId?>" class="uk-checkbox answer-checkbox-<?= $edsId?>" type="checkbox" value="2"
                                                                        onchange="if(checkSection(this, <?= $questionId; ?>)){attemptMatrix('<?= $questionId; ?>', this); answer_by_student('<? echo $radioName ?>_2','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')}" name="<? echo $radioName ?>" id="<? echo $radioName ?>_2" <? if( $radio_value==2){echo 'checked="checked"';$attempt[$questionId] =true;} ?> />
                                                                2.
                                                            </td>
                                                            <td>
                                                                <? echo  $question_row['answerText2']; ?><br>

                                                                <? if($question_row['answerImage2']!=''){ ?>
                                                                    <img src="<? echo $site['url'].$question_row['answerImage2'] ?>"  style="height:100px;" />
                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                                <input  edsId="<?= $edsId?>" class="uk-checkbox answer-checkbox-<?= $edsId?>" type="checkbox" value="3"
                                                                        onchange="if(checkSection(this, <?= $questionId; ?>)){attemptMatrix('<?= $questionId; ?>', this);answer_by_student('<? echo $radioName ?>_3','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')}" name="<? echo $radioName ?>" id="<? echo $radioName ?>_3" <? if( $radio_value==3){echo 'checked="checked"';$attempt[$questionId] =true;} ?> />
                                                                3.
                                                            </td>
                                                            <td>
                                                                <? echo  $question_row['answerText3']; ?><br>

                                                                <? if($question_row['answerImage3']!=''){ ?>
                                                                    <img src="<? echo $site['url'].$question_row['answerImage3'] ?>"  style="height:100px;"   />
                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                                <input  edsId="<?= $edsId?>" class="uk-checkbox answer-checkbox-<?= $edsId?>" type="checkbox" value="4"
                                                                        onchange="if(checkSection(this, <?= $questionId; ?>)){attemptMatrix('<?= $questionId; ?>', this);answer_by_student('<? echo $radioName ?>_4','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')}" name="<? echo $radioName ?>" id="<? echo $radioName ?>_4"  <? if( $radio_value==4){echo 'checked="checked"';$attempt[$questionId] =true;} ?> />
                                                                4.
                                                            </td>
                                                            <td>
                                                                <? echo  $question_row['answerText4']; ?><br>

                                                                <? if($question_row['answerImage4']!=''){ ?>
                                                                    <img src="<? echo $site['url'].$question_row['answerImage4'] ?>" style="height:100px;" />
                                                                <? } ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                            <?
                        }
                    }
                    /*
                    foreach($question_rows as $question_row)
                    {

                        $questionId=$question_row['questionId'];

                        $radioName="ans_".$questionId;
                        $question_ids[]=$questionId;
                        $examdetailsId=$question_row["examdetailsId"];

                        $radio_value=0;
                        if(isset($answers_data->$questionId)){
                            $radio_value=(int)$answers_data->$questionId;
                        }


                        ?>
                        <div  id="question-no-<?=$questionId;?>" class="uk-position-relative uk-card uk-card-default uk-card-small uk-card-body uk-margin-small uk-card-outline">
                            <div style="font-size: 9px" class="uk-margin-remove uk-text-italic uk-position-absolute uk-position-top-right uk-background-muted">
                                <table>
                                    <tr>
                                        <td style="color: #1ea0c3">Marks:</td>
                                        <td><? echo  $question_row['marks']; ?></td>


                                        <?if($question_row['negetive_marks']>0){?>
                                            <td style="color: #1ea0c3">Nagative Marks:</td>
                                            <td><? echo  $question_row['negetive_marks']; ?></td>
                                        <?}?>

                                    </tr>
                                </table>

                            </div>

                            <div class="uk-position-absolute uk-position-top-left uk-background-secondary p-left-s p-right-s" style="color: white; border-bottom-right-radius: 5px"><? echo $question_row['viewOrder']; ?></div>
                            <table>
                                <tr>
                                    <td class="text-m">
                                        <div class="" style="color: #000000">
                                            <? echo  $question_row['questionText']; ?><br>
                                            <? if($question_row['questionImage']!=''){ ?>
                                                <img src="<? echo $site['url'].$question_row['questionImage'] ?>"  style="max-width: 100%"  />
                                            <? } ?>
                                        </div>
                                        <!--Mark for review-->
                                        <label id="review_checkbox_container_<?=$questionId?>" class="text-s uk-flex uk-flex-middle m-top-none" style="color: blue; <?=$radio_value>0?"":"visibility:hidden"?>">
                                            <input class="uk-checkbox" id="review_checkbox_<?=$questionId?>" type="checkbox" onchange="reviewMatrix('<?=$questionId?>', this.checked)" style="margin-right: 8px !important;">
                                            Mark for review
                                        </label>

                                        <table class=" m-top-m uk-width-expand uk-text-small answer-container-<?=$questionId?>" style="border-collapse: collapse">
                                            <tr>
                                                <td class="uk-table-shrink" style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                    <input type="checkbox" value="1"
                                                           class="uk-checkbox"
                                                           onchange="attemptMatrix('<?= $questionId; ?>', this)"
                                                           onclick="answer_by_student('<? echo $radioName ?>_1','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')"
                                                           name="<? echo $radioName ?>" id="<? echo $radioName ?>_1"  <? if( $radio_value==1){echo 'checked="checked"'; $attempt[$questionId] = true;} ?> />
                                                    1.
                                                </td>
                                                <td>
                                                    <? echo  $question_row['answerText1']; ?><br>
                                                    <? if($question_row['answerImage1']!=''){ ?>
                                                        <img src="<? echo $site['url'].$question_row['answerImage1'] ?>"  style="height:100px;"  />
                                                    <? } ?>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                    <input class="uk-checkbox" type="checkbox" value="2" onchange="attemptMatrix('<?= $questionId; ?>', this)" onclick="answer_by_student('<? echo $radioName ?>_2','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')" name="<? echo $radioName ?>" id="<? echo $radioName ?>_2" <? if( $radio_value==2){echo 'checked="checked"';$attempt[$questionId] =true;} ?> />
                                                    2.
                                                </td>
                                                <td>
                                                    <? echo  $question_row['answerText2']; ?><br>

                                                    <? if($question_row['answerImage2']!=''){ ?>
                                                        <img src="<? echo $site['url'].$question_row['answerImage2'] ?>"  style="height:100px;" />
                                                    <? } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                    <input class="uk-checkbox" type="checkbox" value="3" onchange="attemptMatrix('<?= $questionId; ?>', this)" onclick="answer_by_student('<? echo $radioName ?>_3','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')" name="<? echo $radioName ?>" id="<? echo $radioName ?>_3" <? if( $radio_value==3){echo 'checked="checked"';$attempt[$questionId] =true;} ?> />
                                                    3.
                                                </td>
                                                <td>
                                                    <? echo  $question_row['answerText3']; ?><br>

                                                    <? if($question_row['answerImage3']!=''){ ?>
                                                        <img src="<? echo $site['url'].$question_row['answerImage3'] ?>"  style="height:100px;"   />
                                                    <? } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top; white-space: nowrap" nowrap="nowrap">
                                                    <input class="uk-checkbox" type="checkbox" value="4" onchange="attemptMatrix('<?= $questionId; ?>', this)" onclick="answer_by_student('<? echo $radioName ?>_4','<? echo $questionId ?>','<? echo $examdetailsId ?>','<? echo $exam_group_id ?>','<? echo $examId ?>')" name="<? echo $radioName ?>" id="<? echo $radioName ?>_4"  <? if( $radio_value==4){echo 'checked="checked"';$attempt[$questionId] =true;} ?> />
                                                    4.
                                                </td>
                                                <td>
                                                    <? echo  $question_row['answerText4']; ?><br>

                                                    <? if($question_row['answerImage4']!=''){ ?>
                                                        <img src="<? echo $site['url'].$question_row['answerImage4'] ?>" style="height:100px;" />
                                                    <? } ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <? }
                    */
                    ?>

                <!-- submit paper button  666999-->
                <form action="" method="post" id="submit_form" class="uk-padding">
                    <input type="submit"
                           name="submit_paper_button"
                           value="Final Submit"
                           class="uk-button uk-button-danger"/>
                    <input type="hidden" name="submit_paper_conform" value="OK" />
                    <hr>
                    <ul class="uk-text-danger uk-text-small">
                        <li>By submitting you are finally submitting your answer sheet. </li>
                        <li>After submitting you can't change answers. </li>
                        <li>Do not submit your answer sheet if your exam is not complete. </li>
                        <li>Do not refresh this page</li>
                    </ul>
                </form>

                <!-- submit paper button end  666999-->

                <!------Exam matrix------->
                <div class="matrix-block">
                    <div class="uk-container">
                        <ul class="matrix-list">
                            <?
                            $m_count=0;
                            foreach ($question_ids as $matrix){
                                $m_count++;
                                ?>
                                <li onclick="gotoQuestion('<?=$matrix?>')" class="matrix-item matrix-no-<?=$matrix?>  <?=$os->val($attempt, $matrix)==true?"attempt":"" ?>"><?=$m_count?></li>
                            <? } ?>
                        </ul>
                    </div>

                    <div class="instructions">
                        <a style="color: blue">Review</a>
                        <a style="color: green">Attempt</a>
                        <a style="color: #dead1b">Unattempted</a>
                    </div>

                </div>
            </div>

            <div id="result_div" style="display: none">
                Thank you! Your exam is complete
            </div>


            <div  id="error_modal" uk-modal="esc-close:false; bg-close:false">
                <div class="uk-modal-dialog uk-modal-body uk-text-center">
                    <span class="uk-text-danger" uk-icon="icon: warning; ratio: 5"></span>
                    <h4 class="uk-margin-remove-bottom uk-margin-small-top">You're offline!</h4>
                    <p class="uk-margin-remove-top">Please check you internet connection.</p>
                    <a class="uk-button uk-button-small uk-button-primary" onclick="location.reload();">Refresh</a>
                </div>
            </div>

            <style>
                .answer-table p{
                    font-size: 13px !important;
                }
                .answer-table table td:nth-child(1){
                    padding-right: 6px;
                    color: indigo;
                }
                .answer-table p{
                    margin-top: 0px !important;
                    margin-bottom: 0px !important;
                    font-size: 13px !important;
                }
                .answer-table input[type=checkbox]{
                    margin-left: 0px !important;
                    margin-top: 5px !important;
                    margin-right: 0px !important;
                }
                #wt-page-header{
                    display: none;
                }
                #Exam_timer_div{
                    position: fixed;
                    top: 200px;
                    left: 0;
                    padding: 2px 2px 2px 0px;
                    color: #fff;
                    background-color: mediumseagreen;
                    border-radius: 0 3px 3px 0;
                }
                #clockdiv > div{
                    padding: 2px;
                }
                #clockdiv > div small{
                    line-height: var(--text-s);
                    width: 100%;
                    display: block;
                }

                .matrix-block{
                    width: 100%;
                    background-color: #fafafa;
                    border-bottom: 1px solid #e5e5e5;
                    z-index: 100;
                    padding-left: 2px;
                    padding-top: 4px;
                    padding-bottom: 2px;
                    position: fixed;
                    top: 64px;
                    left: 0;
                }
                .matrix-block .instructions{
                    display: grid;
                    grid-gap: 4px;
                    grid-auto-columns: min-content;
                    grid-template-columns: min-content min-content min-content;
                    font-size: 11px;
                    margin-top: 5px;
                }
                .matrix-block .instructions a {
                    position: relative;
                    padding-left: 15px;
                    margin-right: 10px;
                }
                .matrix-block .instructions a:before{
                    content: '';
                    height: 10px;
                    width: 10px;
                    border: 1px solid #2222;
                    position: absolute;
                    left: 0;
                    top: 50%;
                    transform: translateY(-50%);
                    border-radius: 100%;
                }
                .matrix-block .instructions a:nth-child(1):before{
                    background-color: blue;
                }
                .matrix-block .instructions a:nth-child(2):before{
                    background-color: green;
                }
                .matrix-block .instructions a:nth-child(3):before{
                    background-color: yellow;
                }
                @media  (min-width: 639px){
                    .matrix-block{
                        right: 0 !important;
                        left: inherit;
                        top: 50% !important;
                        transform: translateY(-50%);
                        width: 130px;
                        max-height: 350px;
                        overflow-y: auto;
                        border-left: 1px solid #e5e5e5;
                        border-top: 1px solid #e5e5e5;

                    }
                    .matrix-block .instructions{
                        grid-template-columns: 100%;
                        grid-template-rows: min-content min-content min-content;
                    }
                    .matrix-item{
                        font-size: 14px!important;
                        height: 25px !important;
                        width: 25px !important;
                    }

                }

                .matrix-list{
                    list-style: none;
                    display: flex;
                    flex-wrap: wrap;
                    padding: 0;
                    margin: 0;
                }
                .matrix-item{
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 9px;
                    height: 17px;
                    width: 17px;
                    padding: 2px;
                    margin-right: 1px;
                    margin-bottom: 1px;
                    background-color: #dead1b;
                    cursor: pointer;
                    color: white;
                    font-weight: bold;
                }
                .matrix-item:hover{
                    box-shadow: 1px 1px 0 1px rgba(0,0,0,0.2);
                }
                .matrix-item.attempt{
                    background-color: green;
                }
                .matrix-item.review{
                    background-color: blue !important;
                }
            </style>
            <script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"> </script>
            <script type="text/x-mathjax-config">
               MathJax.Hub.Config({
                  tex2jax: { inlineMath: [["$","$"],["\\(","\\)"]] },
                  "HTML-CSS": {
                    linebreaks: { automatic: true, width: "container" }
                  }
               });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
            <script>
                //declare container varieble
                let questionanswerdiv = document.querySelector("#Exam_paper_id");
                let result_div = document.querySelector("#result_div");
                let matrix_block = document.querySelector(".matrix-block");
                let Exam_timer = document.querySelector("#Exam_timer_div");

                //if get remaining time from socket
                window.SocketIO.on("remaining_time", (res)=>{
                    startTimer(res.remaining_time, ()=> {
                        questionanswerdiv.remove();
                        result_div.style.display = "block"
                    });
                });

                //if connect happend
                window.SocketIO.io.on("error", (error) => {
                    UIkit.modal("#error_modal").show();
                });
                window.SocketIO.io.on("reconnect_attempt", (attempt) => {
                    UIkit.modal("#error_modal").show();
                });
                window.SocketIO.io.on("reconnect_error", (error) => {
                    UIkit.modal("#error_modal").show();
                });
                window.SocketIO.io.on("reconnect", (attempt) => {
                    UIkit.modal("#error_modal").hide();
                });
                window.SocketIO.io.on("connect", (attempt) => {
                    UIkit.modal("#error_modal").hide();
                });

                setInterval(()=>{
                    if(navigator.onLine &&window.SocketIO.connected){
                        UIkit.modal("#error_modal").hide();
                    } else {
                        UIkit.modal("#error_modal").show();
                    }
                }, 2000);

                function attemptMatrix(no, ans_el){
                    let el = document.querySelector(".matrix-no-"+no);
                    let review_el = document.querySelector("#review_checkbox_container_"+no);
                    let answer_container = document.querySelector(".answer-container-"+no);

                    answer_container.querySelectorAll("input[type=checkbox]").forEach(inpt=>{
                        if(inpt!==ans_el){
                            inpt.checked = false;
                        }
                    })

                    let status = ans_el.checked;
                    if(status){
                        el.classList.add("attempt");
                        review_el.style.visibility = "visible";

                    } else {
                        el.classList.remove("attempt");
                        review_el.style.visibility = "hidden";
                        review_el.querySelector("input[type=checkbox]").checked=false
                        reviewMatrix(no, false);
                    }
                }
                function reviewMatrix(no, review){
                    let el = document.querySelector(".matrix-no-"+no);
                    let cookie_key= "question_review_status_for_<?=$exam_group_id."_".$studentId?>_"+no;
                    if(review){
                        el.classList.add("review");
                        localStorage.setItem(cookie_key,true);
                        document.querySelector("#review_checkbox_"+no).checked = true;
                    } else {
                        el.classList.remove("review");
                        localStorage.setItem(cookie_key,false);
                        document.querySelector("#review_checkbox_"+no).checked = false;
                    }
                }
                function gotoQuestion(no){
                    let el = document.querySelector("#question-no-"+no);
                    let elementPosition = el.getBoundingClientRect().top+window.scrollY;
                    let offsetPosition
                    if(document.body.offsetWidth<639) {
                        offsetPosition = elementPosition - matrix_block.offsetHeight;
                    } else {
                        offsetPosition = elementPosition;
                    }



                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            </script>
            <? foreach($question_ids as $no){?>
                <script>
                    let cookie_key_<?=$no?>= "question_review_status_for_<?=$exam_group_id."_".$studentId."_".$no?>";
                    let review_el_<?=$no?> = document.querySelector("#review_checkbox_container_<?=$no?>");

                    if(localStorage.getItem(cookie_key_<?=$no?>)==="true"){
                        reviewMatrix('<?=$no?>', true)
                    } else {
                        review_el_<?=$no?>.querySelector("input[type=checkbox]").checked=false
                    }
                </script>
            <? } ?>
            <script>
                function adjustGraphic(){
                    matrix_block.style.top = 0;//header.offsetHeight+"px";

                    if(document.body.offsetWidth<639){
                        Exam_timer.style.top = parseInt(/*header.offsetHeight+*/matrix_block.offsetHeight)+"px";
                        questionanswerdiv.style.marginTop = matrix_block.offsetHeight+"px";

                    } else {
                        Exam_timer.style.top = 0;//parseInt(header.offsetHeight)+"px";
                        questionanswerdiv.style.marginTop = "0px";
                    }

                }
                function answer_by_student(radio_id,questionId,examdetailsId,exam_group_id,exammId) // get record by table primery id
                {



                    let answer='';
                    let oo=os.getObj(radio_id);



                    if(oo.checked===true) {
                        answer=oo.value;
                    } else {
                        oo.checked = false;
                    }

                    window.SocketIO.emit("answer_by_student", {
                        examId: exammId,
                        exam_group_id: exam_group_id,
                        studentId: '<?=$os->userDetails['studentId']?>',
                        questionId: questionId,
                        examdetailsId: examdetailsId,
                        answer: answer,
                        historyId: <?=$historyId?>,

                    });
                }
                //==========section start=======//
                function checkSection(oo, questionId){
                    //=====Section program started=====/
                    let res = true;
                    if (oo.checked===true) {
                        let edsId = oo.getAttribute("edsId");
                        let section = document.getElementById("section_" + edsId);
                        let max_attempt = section.getAttribute("max-attempt");
                        const elms = document.querySelectorAll(".answer-checkbox-" + edsId);

                        let attempts = 0;
                        elms.forEach(elm=>{
                            if(elm.checked){
                                attempts++;
                            }
                        });
                        //checking if update

                        let answer_container = document.querySelector(".answer-container-"+questionId);
                        let ch_count = 0;
                        answer_container.querySelectorAll("input[type=checkbox]").forEach(input=>{
                            if (input.checked){
                                ch_count++;
                            }
                        });

                        if (attempts>max_attempt && ch_count===1){
                            res = false;
                        }
                        oo.checked = res;
                    }
                    //=====Section program started=====/
                    if(!res){
                        UIkit.notification("Maximum attempt reached", "danger");
                    }
                    return res;
                }
                //==========section end =======//
                document.querySelector("#submit_form").onsubmit = function (e){
                    e.preventDefault();
                    let form = this;
                    UIkit.modal.confirm("Are you sure? After submitting you can't change answers.").then(function() {
                        form.submit();
                    }, function () {
                        alert("Please revise twice before finally submit");
                    });
                }
                window.addEventListener("scroll", function (e){
                    adjustGraphic();
                })
                window.addEventListener("resize", e=>{
                    adjustGraphic();
                })
                window.addEventListener("load", e=>{
                    adjustGraphic();
                    startTimer(<?=$remaining_time ?>,function (){
                        //window.SocketIO.disconnect();
                        questionanswerdiv.remove();
                        result_div.style.display = "block"
                    });
                })
                window.onfocus =  function() {
                    window.SocketIO.emit("get_remaining_time", {
                        endtimestamp : <?= $endtimestamp*1000?>
                    });
                }
                window.addEventListener("click", function(event) {
                    window.SocketIO.emit("get_remaining_time", {
                        endtimestamp : <?= $endtimestamp*1000?>
                    });
                });
            </script>
            <?
        }
        /**
         * Post exam event
         */
        if($exam_status=="exam_over"){





            if($row_exam_group_history)
            {


                $question_rows_set=$question_rows;



                if($exam_time_over){


                    /* $question_set=$row_examdetails['question_set'];

                     if($question_set)
                     {
                         $question_rows_set=array();
                         $query_q_set="select * from question_paper_set where examdetailsId IN ($examdetailsIds) and    set_no='$question_set' order by view_order asc   ";
                         $query_q_set_rs=$os->mq($query_q_set);
                         while($q_set=$os->mfa( $query_q_set_rs))
                         {

                                 $question_rows_set[$q_set['question_id']]=$question_rows[$q_set['question_id']];
                                 $question_rows_set[$q_set['question_id']]['viewOrder']=$q_set['view_order'];


                         }



                     }*/



                    ?>
                    <br><? echo $examTitle ?>    Provisional OMR SHEET<br>
                    <small class="uk-text-danger">This is provisional Answer Sheet, it may vary with final Answer Sheet.</small>
                    <?
                    $os->render_answer_sheet($exam_group_id, $studentId, true);

                }
                else{
                    print "<p>To view OMR SHEET you have to wait till exam end.</p>";
                }


            }
            else
            {

                print "<p>Absent.</p>";
            }
        }



        ?>

        <script>
            let exam_interval_counter = null;
            function startTimer(duration, calback=null) {
                if(exam_interval_counter){
                    clearInterval(exam_interval_counter);
                }

                //duration  in sec
                var timer = duration, minutes, seconds;
                exam_interval_counter = setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    //display.textContent = minutes + ":" + seconds;

                    os.setHtml('time_minuite',minutes);
                    os.setHtml('time_second',seconds);

                    if(minutes<1 &&  seconds<2)
                    {
                        clearInterval(exam_interval_counter);
                        calback();
                    }
                    if (--timer < 0) {
                        timer = duration;
                    }
                }, 1000);
            }
        </script>
        <?php
    }
} ?>




