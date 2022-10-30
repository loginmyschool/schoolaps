<?
include('../wtosConfig.php');
include('os.php');
$os->userDetails =$os->session($os->loginKey,'logedUser');
$studentId = $os->userDetails['studentId'];
$os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
?><?

if($os->get('WT_eclassListing')=='OK'){
    $where='';
    $showPerPage= $os->post('showPerPage');
    $andteacher_id=  $os->postAndQuery('teacher_id_s','teacher_id','=');
    $andclass_id=  $os->postAndQuery('class_id_s','class_id','=');
    $andsubject_id=  $os->postAndQuery('subject_id_s','subject_id','=');
    $andtitle=  $os->postAndQuery('title_s','title','%');
    $andsearch_keys=  $os->postAndQuery('search_keys_s','search_keys','%');
    $anddescription=  $os->postAndQuery('description_s','description','%');
    $andvideo_file_1=  $os->postAndQuery('video_file_1_s','video_file_1','%');
    $andvideo_link_1=  $os->postAndQuery('video_link_1_s','video_link_1','%');

    $f_dated_s= $os->post('f_dated_s'); $t_dated_s= $os->post('t_dated_s');
    $anddated= $os->DateQ('dated',$f_dated_s,$t_dated_s,$sTime='00:00:00',$eTime='59:59:59');
    $andis_meeting=  $os->postAndQuery('is_meeting_s','is_meeting','%');
    $andmeeting_id=  $os->postAndQuery('meeting_id_s','meeting_id','%');
    $andmeeting_password=  $os->postAndQuery('meeting_password_s','meeting_password','%');
    $andmeeting_link=  $os->postAndQuery('meeting_link_s','meeting_link','%');
    $andmeeting_title=  $os->postAndQuery('meeting_title_s','meeting_title','%');
    $andmeeting_time=  $os->postAndQuery('meeting_time_s','meeting_time','%');
    $andactive_status=  $os->postAndQuery('active_status_s','active_status','%');
    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( teacher_id like '%$searchKey%' Or class_id like '%$searchKey%' Or subject_id like '%$searchKey%' Or title like '%$searchKey%' Or search_keys like '%$searchKey%' Or description like '%$searchKey%' Or video_file_1 like '%$searchKey%' Or video_link_1 like '%$searchKey%' Or is_meeting like '%$searchKey%' Or meeting_id like '%$searchKey%' Or meeting_password like '%$searchKey%' Or meeting_link like '%$searchKey%' Or meeting_title like '%$searchKey%' Or meeting_time like '%$searchKey%' Or active_status like '%$searchKey%' )";

    }
    $listingQuery="  select *, DATE(dated) as dated, TIME(dated) as timed from eclass where eclass_id>0   $where   $andteacher_id  $andclass_id  $andsubject_id  $andtitle  $andsearch_keys  $anddescription  $andvideo_file_1  $andvideo_link_1  $anddated  $andis_meeting  $andmeeting_id  $andmeeting_password  $andmeeting_link  $andmeeting_title  $andmeeting_time  $andactive_status     order by dated desc";
    $resource=$os->pagingQuery($listingQuery,10000000,false,true);
    $rsRecords=$resource['resource'];

    $timeline = [];
    while($record = $os->mfa($rsRecords)){
        $timeline[$record['dated']][]= $record;
    }



    ?>
    <div class="listingRecords">
        <div class="pagingLinkCss uk-hidden">Total:<? echo $os->val($resource,'totalRec'); ?>  &nbsp;&nbsp; <? //echo// $resource['links']; ?>   </div>

        <? foreach ($timeline as $date=>$dated_record){?>
            <p class="uk-text-large uk-text-primary"><?=$date ?></p>

            <div class="uk-grid uk-grid-small uk-child-width-1-3@m uk-child-width-1-2@s " uk-grid>
                <?foreach ($dated_record as $record){?>
                    <div>
                        <div class="uk-card uk-card-default uk-card-small">
                            <div class="uk-card-header">
                                <h5><?php echo $record['title']?></h5>
                            </div>
                            <div class="uk-card-body">

                                <table class="uk-text-small" style="border-collapse: collapse">
                                    <tr>
                                        <td>Subject</td>
                                        <td class="p-left-l" style="color: #0A246A">
                                            <? echo $os->rowByField('subjectName','subject','subjectId',
                                                $record['subject_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Timed</td>
                                        <td class="p-left-l" style="color: #0A246A">
                                            <?=$record['timed'] ?></td>
                                    </tr>

                                </table>

                                <a class="uk-link uk-text-small"
                                   href="<?=$site['url']?>e-class/<?= base64_encode($record['eclass_id']);?>">
                                    Show Details
                                </a>

                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
        <?}?>
    </div>

    <?php
    exit();}
if($os->get('WT_uploadHomeworks')=='OK' && $os->post('WT_uploadHomeworks')=='OK'){
    $image=$os->UploadPhoto('file',$site['root'].'wtos-images');
    $eclass_id=$os->post('eclass_id');
    $studentId = $os->userDetails['studentId'];

    $dataToSave['file']='wtos-images/'.$image;
    $dataToSave['eclass_id'] = $eclass_id;
    $dataToSave['studentId'] = $studentId;
    $duplicate_row = $os->mfa($os->mq("SELECT homework_file_id FROM  homework_file WHERE eclass_id='$eclass_id' AND studentId='$studentId'"));
    $homework_file_id = $os->val($duplicate_row, 'homework_file_id')>0?$os->val($duplicate_row, 'homework_file_id'):0;
    $save_query =  $os->save('homework_file',$dataToSave, 'homework_file_id', $homework_file_id);
    $select_query = $os->mfa($os->mq("SELECT * FROM homework_file WHERE homework_file_id='$save_query'"));
    ?>
    <a target="_blank" href="<?=$site['url'].$select_query['file']?>">Show your uploaded answer file</a>
    <?
    exit();
}
//create assesment
if($os->get('WT_create_daily_assesment')=='OK' && $os->post('WT_create_daily_assesment')=='OK'){
    $eclass_id = $os->post('eclass_id');
    $level = $os->post('level');
    $dataToSave = [];
    $dataToSave['eclass_id']=$eclass_id;
    $dataToSave['studentId']=$studentId;
    $dataToSave['level']=$level;
    $lastId = $os->save('self_assesment', $dataToSave);


    //fetch eclass
    $eclass_details = $os->mfa($os->mq("SELECT * FROM eclass WHERE eclass_id='$eclass_id'"));
    $subject_id = $eclass_details['subject_id'];
    //save random question
    $question_select = $os->mq("SELECT questionId FROM question_bank WHERE subjectId='$subject_id' ORDER BY RAND() LIMIT 0,10");

    $question_maker_arr = [];

    while($question = $os->mfa($question_select)){
        $question_bank_id = $question['questionId'];
        $question_query = "('$question_bank_id','$lastId','')";
        $question_maker_arr[] = $question_query;
    }

    $vals_ = implode(',',$question_maker_arr);
    $sql_ = "INSERT INTO self_assesment_question (question_bank_id, self_assesment_id, answerSelected) VALUES $vals_";
    $os->mq($sql_);
}
//create assesment
if($os->get('WT_fetch_daily_assesment')=='OK' && $os->post('WT_fetch_daily_assesment')=='OK'){
    $eclass_id = $os->post('eclass_id');
    $self_assesment_query = $os->mq("SELECT * FROM self_assesment WHERE  studentId='$studentId' AND eclass_id='$eclass_id'");

    ?>
    <table class="uk-text-small uk-table uk-table-small uk-table-divider">
        <tr>
            <td>Date</td>
            <td class="uk-table-shrink">Level</td>
        </tr>
        <?while ($self_assesment  = $os->mfa($self_assesment_query)){?>
            <tr>
                <td><?=$self_assesment['dated']?></td>
                <td><?=$self_assesment['level']?></td>
                <td class="uk-table-shrink">
                    <a href="<?=$site['url']?>e-class/<?= base64_encode($eclass_id);?>/<?=base64_encode
                    ($self_assesment['self_assesment_id'])?>">View</a>
                </td>
            </tr>
        <?}?>
    </table>
    <div>
        <div class="uk-inline">
            <label>Lavel</label>
            <div class="uk-inline">
                <select name="level" id="self_assesment_level" class="uk-select uk-form-small uk-border-rounded
                    p-right-l">
                    <option value=""> </option>
                    <? $os->onlyOption($os->question_level_arr,'');	?>
                </select>
            </div>
        </div>
        <a class="uk-button uk-button-small secondory-background secondory-background-hover uk-border-rounded"
           onclick="createAssessment()">
            Create Assessment
        </a>
    </div>
    <?
}
//answer by student
if($os->get('answer_by_student')=='OK' && $os->post('answer_by_student')=='OK' ){

    $question_bank_id = $os->post("question_bank_id");
    $answer = $os->post("answer");
    $self_assesment_id = $os->post("self_assesment_id");

    $query = $os->mq("UPDATE self_assesment_question SET answerSelected='$answer' WHERE question_bank_id='$question_bank_id' AND self_assesment_id='$self_assesment_id'");

}
?>


