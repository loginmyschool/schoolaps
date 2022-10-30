<?php
include "_partials/wt_header.php";
include "_partials/wt_precontent.php";

global $os,$site,$session_selected,$bridge,$pageVar;
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$exam_started='';
$activate_cache=true;

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
    exit();
}

?>
<script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script>
    let socket = io("<?=$site["socket_io_url"]?>",{
        path: "/io",
    });
</script>
<?


$studentId=$os->userDetails['studentId'];

if($activate_cache==false){
    $os->unsetSession('student_data',$studentId); //  session cache history data  // cooment out to activate cache
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
}else
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


// student elective subjects

?> Welcome <? echo $name ?><?

$exam_id_segment  = $os->val($pageVar['segment'], 2);
/**
 * Exam Details page
 */


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
				SELECT e.examTitle,e.publish_result , group_concat(ed.examdetailsId) examdetailsIds 
				FROM exam_group eg  
				INNER JOIN  exam e ON( e.examId =eg.examId)			
				INNER JOIN  examdetails ed ON( ed.exam_group_id =eg.exam_group_id and ed.exam_group_id='$exam_group_id')			
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
			where q.examdetailsId IN ($examdetailsIds) ORDER BY  q.viewOrder asc";


    $q_set_q_rs=$os->mq($q_set_q);
    while($row_question=$os->mfa( $q_set_q_rs))
    {
        $question_rows[$row_question['questionId']]=$row_question;

    }






    $os->setSession($question_rows,$key1='question_rows',$exam_group_id);
}








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

    // get answer from file
    $answers_file=$studentId.'.json';
    $answers_file_path=ANSWERS_PATH.'/'.$answers_file;
    $answers_data = @json_decode( file_get_contents($answers_file_path));

    ?>
        <div style="position: fixed; top:0; left: 0; height: 100%; width: 100%; display: flex; flex-direction: column;"
             class="uk-background-muted">


            <div id="examApp" style="flex: 1; display: flex; flex-direction: column; height: 100%">
            </div>
        </div>

    <?
    $questions = [];
    foreach ($question_rows as $question_row){
        $questionId = $question_row["questionId"];
        $question_row["selected"] = @$answers_data->$questionId;
        $question_row["review"] = false;
        $questions[$question_row["questionId"]] = $question_row;
    }

    ?>
    <script>
        const questions_ob = <?= json_encode($questions)?>;
        const remaining_time = <?=$remaining_time?>;
        const endtime = <?= $endtimestamp?>;
        const examId = <?= $examId;?>;
        const exam_group_id = <?= $exam_group_id;?>;
        const studentId = <?= $studentId;?>;
        const historyId = <?= $historyId;?>;
    </script>
    <script  type="text/babel" src="<?= $site["themePath"]?>components/Exam.js"></script>



    <div id="error_modal" uk-modal="esc-close:false; bg-close:false">
        <div class="uk-modal-dialog uk-modal-body uk-text-center">
            <span class="uk-text-danger" uk-icon="icon: warning; ratio: 5"></span>
            <h4 class="uk-margin-remove-bottom uk-margin-small-top">You're offline!</h4>
            <p class="uk-margin-remove-top">Please check you internet connection.</p>
            <a class="uk-button uk-button-small uk-button-primary" onclick="location.reload();">Refresh</a>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"> </script>
    <script type="text/x-mathjax-config">
               MathJax.Hub.Config({
                  tex2jax: { inlineMath: [["$","$"],["\\(","\\)"]] },
                  "HTML-CSS": {
                    linebreaks: { automatic: true, width: "container" }
                  }
               });
            </script>

    <script>

        //if connect happend
        socket.io.on("error", (error) => {
            //UIkit.modal("#error_modal").show();
        });
        socket.io.on("reconnect_attempt", (attempt) => {
            //UIkit.modal("#error_modal").show();
        });
        socket.io.on("reconnect_error", (error) => {
            //UIkit.modal("#error_modal").show();
        });
        socket.io.on("reconnect", (attempt) => {
            UIkit.modal("#error_modal").hide();
        });
        socket.io.on("connect", (attempt) => {
            UIkit.modal("#error_modal").hide();
        });

        setInterval(()=>{
            if(navigator.onLine &&socket.connected){
                UIkit.modal("#error_modal").hide();
            } else {
                //UIkit.modal("#error_modal").show();
            }
        }, 2000);


    </script>
    <script>

        document.querySelector("#submit_form").onsubmit = function (e){
            e.preventDefault();
            let form = this;
            UIkit.modal.confirm("Are you sure? After submitting you can't change answers.").then(function() {
                form.submit();
            }, function () {
                alert("Please revise twice before finally submit");
            });
        }
        window.onfocus =  function() {
            socket.emit("get_remaining_time", {
                endtimestamp : <?= $endtimestamp*1000?>
            });
        }
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
        if($exam_time_over){?>
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


<? include "_partials/wt_postcontent.php";?>
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
<? include "_partials/wt_footer.php"; ?>





