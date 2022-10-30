<?
/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/

include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);
$access_name = "Result Entry Access";
function fetch_subjects_by_exam($examId)
{
    global $os;
    $examsdetails_q = $os->mq("SELECT examdetails.*, subject.subjectName FROM examdetails 
        INNER JOIN subject ON (subject.subjectId = examdetails.subjectId)
        WHERE examId='$examId'");

    ?>
    <option value=""></option>
    <?
    while($examdetails = $os->mfa($examsdetails_q))
    {
        ?>
        <option  name="" value="<?= $examdetails['examdetailsId']; ?>" /> <?= $examdetails['subjectName'] ?>  </option>
        <?
    }
}
function fetch_teachers_by_branch_code($branch_code)
{
    global $os;
    $teacher_query = $os->mq("SELECT * FROM admin as a where adminId>0 and a.adminType!='Super Admin' AND a.branch_code='$branch_code' ORDER BY a.name ASC");

    ?>

    <option> </option>
    <? while($teacher = $os->mfa($teacher_query)) {?>
    <option   name="" value="<?= $teacher['adminId']; ?>" /> <?= $teacher['name']; ?>  </option>
<?} ?>
    s
    <?
}


if($os->get("get_asession_by_branch_code")=="OK" && $os->post("get_asession_by_branch_code")=="OK" ){
    $branch_code_s=$os->post('branch_code_s');
    $query = $os->mq("SELECT  egca.asession FROM exam_group_class_access egca
        INNER JOIN exam_group eg on egca.exam_group_id = eg.exam_group_id
        INNER JOIN exam e ON e.examId=eg.examId AND (e.branch_codes LIKE '%$branch_code_s%' OR e.branch_codes='')
        GROUP BY egca.asession
    ");

    ?><option value="">--</option><?
    while($asession = $os->mfa($query)) {
        ?>
        <option><?=$asession["asession"]?></option>
        <?
    }
    exit();
}

if($os->get("get_class_by_session")=="OK" && $os->post("get_class_by_session")=="OK" ){
    $branch_code_s=$os->post('branch_code_s');
    $asession_s=$os->post('asession_s');
    $exams_q = $os->mq("SELECT  egca.class FROM exam_group_class_access egca
        INNER JOIN exam_group eg on egca.exam_group_id = eg.exam_group_id
        INNER JOIN exam e ON e.examId=eg.examId AND (e.branch_codes LIKE '%$branch_code_s%' OR e.branch_codes='')
        WHERE egca.asession='$asession_s'
    ");
    $board_class = [];
    while($class = $os->mfa($exams_q))
    {
        $board_class[$os->get_board_by_class($class["class"])][$class["class"]] = $os->classList[$class["class"]];
    }

    ?>
    <option value="">--</option>
    <?
    foreach ($board_class as $board=>$classes){
        ?>
        <optgroup label="<?=$board?>">
            <? foreach ($classes as $class=>$class_name){?>
                <option value="<?=$class?>"><?=$class_name?></option>
            <?} ?>
        </optgroup>
        <?
    }

    exit();
}

if($os->get('get_exam_by_class')=='OK' && $os->post('get_exam_by_class')=='OK')
{

    $branch_code_s = $os->post("branch_code_s");
    $asession_s=$os->post('asession_s');
    $class_s=$os->post('class_s');
    $exams_q = $os->mq("SELECT e.* FROM exam e 
        INNER JOIN exam_group eg ON e.examId=eg.examId
        INNER JOIN exam_group_class_access egca ON (egca.exam_group_id=eg.exam_group_id AND egca.asession='$asession_s')
        WHERE  egca.class='$class_s' AND (e.branch_codes LIKE '%$branch_code_s%' OR e.branch_codes='') GROUP BY e.examId") ;
    ?>
    <option value=""></option>
    <?
    while($exam = $os->mfa($exams_q))
    {
        ?>
        <option  name="" value="<?= $exam['examId']; ?>" /> <?= $exam['examTitle'] ?><?=$exam["branch_codes"]==""?"(Global)":""?>  </option>
        <?
    }
    exit();

}


if($os->get('manage_exam_setting')=='OK' && $os->post('manage_exam_setting')=='OK')
{


    $branch_code_s = $os->post("branch_code_s");
    $asession_s=$os->post('asession_s');
    $class_s=$os->post('class_s');
    $exam_s=$os->post('exam_s');

    $button=$os->post('button');

    $examdetailsId=$os->post('examdetailsId');
    $roll_from=$os->post('roll_from');
    $roll_to=$os->post('roll_to');
    $gender=$os->post('gender');
    $date_from=$os->post('date_from');
    $date_to=$os->post('date_to');
    $teacherId=$os->post('teacherId');
    $section=$os->post('section');




    if($teacherId!='' && $asession_s!='' && $examdetailsId!='' && $button=='save' )
    {


        $dataToSave=array();


        $dataToSave['for_class'] = $class_s;
        $dataToSave['asession'] = $asession_s;
        $dataToSave['teacherId']=$teacherId;
        $dataToSave['examdetailsId']=$examdetailsId;

        $dataToSave['branch_code']=$branch_code_s;
        $dataToSave['roll_from']=$roll_from;
        $dataToSave['roll_to']=$roll_to;
        $dataToSave['gender']=$gender;
        $dataToSave['date_from_valid']=$date_from;
        $dataToSave['date_to_valid']=$date_to;
        $dataToSave['section']=$section;

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails["adminId"];
        $dataToSave['modifyBy']='0';
        $dataToSave['modifyDate']=$os->now();
        $duplicate_query="select * from resultentry_access where  examdetailsId='$examdetailsId' and  teacherId='$teacherId' and asession='$asession' AND for_class='$for_class'";
        $resultentry_access_id=$os->isRecordExist($duplicate_query,'resultentry_access_id');

        $qResult=$os->save('resultentry_access',$dataToSave,'resultentry_access_id',$resultentry_access_id);

    }


    $andClass = $os->postAndQuery("class_s","ra.for_class","=");
    $andaSession = $os->postAndQuery("asession_s","ra.asession","=");

    $config_array=array();

    $sel="select ra.*,
       e.examId, e.examTitle, 
       a.name as teacherName,
       sub.subjectId,sub.subjectName from resultentry_access  ra
           INNER JOIN examdetails ed ON ed.examdetailsId=ra.examdetailsId
        INNER JOIN exam e ON(e.examId=ed.examId) AND e.examId='$exam_s'
        INNER JOIN admin a ON(ra.teacherId=a.adminId)  
        INNER JOIN subject sub ON(sub.subjectId=ed.subjectId)
        where ra.branch_code='$branch_code_s' $andClass  $andaSession   order by ra.resultentry_access_id desc ";

    $resset=$os->mq($sel);
    $datas=array();
    $data2 = [];
    while($record=$os->mfa($resset))
    {
        $key = $record['examId'];
        $datas[$key]['rec'][$record['subjectId']]['subjectName'] = $record['subjectName'];
        $datas[$key]['rec'][$record['subjectId']]['subjectId'] = $record['subjectId'];
        $datas[$key]['rec'][$record['subjectId']]["teachers"][] = $record;
        $datas[$key]['examTitle'] =$record['examTitle'];
        $datas[$key]['asession'] =$record['asession'];
        $datas[$key]['className'] = $os->classList[$record['for_class']];
        $datas[$key]['subjectName'] = $record['subjectName'];
        $datas[$key]['teacherName'] = $record['teacherName'];
        $datas[$key]['gender'] = $record['gender'];



    }
    echo '##--EXAM-SETTING-DATA--##';

    //

    ?>
    <div class="uk-grid uk-grid-small" uk-grid>
        <div class="uk-width-medium">
            <div class="uk-card uk-card-default p-l">
                <h4>Assign Teacher</h4>
                <table class="uk-table congested-table uk-table-justify">
                    <tr>
                        <td>Subject</td>
                        <td colspan="3">
                            <select class="uk-select congested-form" id="examdetailsId">
                                <? fetch_subjects_by_exam($exam_s);?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Teacher</td>
                        <td colspan="3">
                            <select class="uk-select congested-form select2" id="teacherId">
                                <? fetch_teachers_by_branch_code($branch_code_s);?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Section</td>
                        <td colspan="3">
                            <select class="uk-select congested-form" id="section">
                                <option></option>
                                <? $os->onlyOption($os->section)?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Roll</td>
                        <td>
                            <input type="number" min="1" class="uk-input congested-form" id="roll_from"/>
                        </td>
                        <td>
                            <input type="number" min="2" class="uk-input congested-form" id="roll_to"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Validity</td>
                        <td>
                            <input class="uk-input congested-form datepicker" id="date_from" placeholder="from"/>
                        </td>
                        <td>
                            <input class="uk-input congested-form datepicker" id="date_to" placeholder="to"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Student Gender</td>
                        <td colspan="2">
                            <select class="uk-select congested-form" id="gender">
                                <option value="">All</option>
                                <?=$os->onlyOption($os->gender)?>
                            </select>
                        </td>
                    </tr>

                </table>
                <button class="uk-button congested-form uk-button-primary" onclick="manage_exam_setting('save')">Assign Now</button>
            </div>
        </div>
        <div class="uk-width-expand">
            <? foreach($datas as $settingData) {?>
                <div class="uk-margin background-color-white">
                    <div class="background-color-light-blue p-s p-left-m p-right-m text-l">
                        <span  class="exam_subject_head_span" style="color: green">
                            <? echo $settingData['examTitle']  ?>
                        </span>
                        |
                        <?= $settingData['asession'] ?> - <? echo $settingData['className'] ?>
                    </div>


                    <ul class="uk-margin-remove-top uk-margin-remove-bottom" uk-tab>
                        <? foreach($settingData['rec'] as $records ) {

                            ?>
                            <li><a><? echo $records['subjectName']; ?></a></li>
                        <? } ?>
                    </ul>

                    <ul class="uk-switcher uk-margin-remove-top uk-margin-remove-bottom">
                        <? foreach($settingData['rec'] as $record ) {

                            ?>
                            <li>
                                <table class="uk-table congested-table uk-table-striped">
                                    <tr>
                                        <td>Teacher</td>
                                        <td>Section</td>
                                        <td>Gender</td>
                                        <td>Roll From </td>
                                        <td>Roll To</td>
                                        <td>From</td>
                                        <td>To</td>
                                        <td> </td>
                                    </tr>


                                    <?foreach ($record["teachers"]  as $teacher){?>
                                        <tr>

                                            <td><? echo $teacher['teacherName']; ?></td>
                                            <td><? echo $teacher['section']; ?></td>
                                            <td><? echo $teacher['gender']; ?></td>
                                            <td><? echo $teacher['roll_from']; ?> </td>
                                            <td><? echo $teacher['roll_to']; ?></td>
                                            <td><? echo $os->showDate($teacher['date_from_valid']); ?></td>
                                            <td><? echo $os->showDate($teacher['date_to_valid']); ?></td>
                                            <td><span title="Delete This Record" style="cursor:pointer; color:#FF0000;"
                                                      onclick="removeRowAjaxFunction('resultentry_access','resultentry_access_id','<? echo $teacher['resultentry_access_id']; ?>','','','manage_exam_setting()')">X</span> </td>
                                        </tr>
                                    <?}?>



                                </table>
                            </li>
                        <?  } ?>


                    </ul>

                </div>
            <?} ?>
        </div>
    </div>


    <?
    echo '##--EXAM-SETTING-DATA--##';

    exit();
}



