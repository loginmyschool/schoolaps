<?php

/*

# wtos version : 1.1

# page called by ajax script in feesDataView.php

#

 */
session_start();
include '../wtosConfigLocal.php';
global $site, $os;
include $site['root-wtos'] . 'wtosCommon.php';

$pluginName = '';
$ajaxFilePath = 'ajax.php';
$os->loadPluginConstant($pluginName);

//access
$_access_name = "Exam Settings";
$_selected_branch_code = $os->getSession('selected_branch_code');

$_branch_access = $os->get_branches_by_access_name($_access_name);
$_global_access = $os->get_global_access_by_name($_access_name);

/*
 * Functions
 */

function get_exam_group_class($exam_group_id)
{
    global $os, $site;
    $query = $os->mq("SELECT * FROM exam_group_class_access WHERE exam_group_id='$exam_group_id'");
    $classes = [];
    while ($class = $os->mfa($query)) {
        $classes[$class['asession']][] = $class['class'];
    }
    return $classes;
}

//get exams
if ($os->post("get_exams") == "OK" && $os->get("get_exams") == "OK") {
    $branch_code_s = $os->post("branch_code_s");
    $asession_s = $os->post("asession_s");
    $class_s = $os->post("class_s");

    $_secondary_access = $os->get_secondary_access_by_branch_and_menu($os->post("branch_code_s"), $_access_name);

    //and brach code
    $and_branch_code = "";
    if ($branch_code_s == "") {
        $_secondary_access = $_global_access;
        $and_branch_code = "AND (e.branch_codes='" . $os->post("branch_code_s") . "')";
    } else {
        $and_branch_code = "AND (e.branch_codes LIKE'%" . $os->post("branch_code_s") . "%')";
    }

    if ($os->loggedUser()["adminType"] == "Super Admin") {
        $and_branch_code = "";
    }

    //and asession
    $and_asession = $os->postAndQuery("asession", "e.asession", "=");

    //and class
    $and_class = $os->postAndQuery("class_s", "e.class", "=");

    //Exams
    $exam_sql = "select
         *
         from exam e
         where 1=1 $and_class $and_branch_code $and_asession order by e.addedDate DESC";

    $exam_q = $os->mq($exam_sql);
    $classes = [];
    $all_exams = [];
    $examIds = [];
    while ($record = $os->mfa($exam_q)) {
        $record["exam_groups"] = [];
        $classes[$record['class']][$record['examId']] = $record;
        $all_exams[$record['examId']] = $record;
        $examIds[] = $record['examId'];
    }
    if (sizeof($examIds) == 0) {
        echo "No Exams found";
        exit();
    }
    /*
     * Exam groups
     */
    $examIds = implode(",", $examIds);
    $exam_group_query = $os->mq("SELECT * FROM exam_group eg WHERE eg.examId IN($examIds) ORDER BY  eg.exam_start_datetime");
    while ($exam_group = $os->mfa($exam_group_query)) {
        $exam_group["subjects"] = [];
        //duration calculation
        $exam_start_datetime = strtotime(date_format(date_create($exam_group['exam_start_datetime']), "Y-m-d H:i:s"));
        $exam_end_datetime = strtotime(date_format(date_create($exam_group['exam_end_datetime']), "Y-m-d H:i:s"));
        $exam_group["exam_duration"] = ($exam_end_datetime - $exam_start_datetime) / (60);
        $all_exams[$exam_group['examId']]['exam_groups'][$exam_group['exam_group_id']] = $exam_group;
    }
    /*
     * Exam Details
     */
    $examdetails_query = $os->mq("SELECT
            ed.*, sub.subjectName
        FROM examdetails ed
        INNER JOIN subject sub ON(sub.subjectId=ed.subjectId)
        WHERE examId IN($examIds)");
    while ($rec = $os->mfa($examdetails_query)) {
        $all_exams[$rec['examId']]['exam_groups'][$rec['exam_group_id']]['subjects'][$rec['examdetailsId']] = $rec;
    }
    /**
     * Subjects
     */

    $subjects_query = $os->mq("SELECT sub.*, e.examId FROM subject sub
        INNER JOIN exam e ON(sub.classId=e.class AND e.examId IN($examIds))");
    $subjects = [];
    while ($subject = $os->mfa($subjects_query)) {
        $subjects[$subject['examId']][] = $subject;
    }

    ?>

        <?php foreach ($all_exams as $examId => $exam) {
            $total_marks = 0;
            //secondary access
            $s_access = $exam["branch_codes"] == ""?$_global_access:$_secondary_access;
            $has_insert_edit_access = in_array("Modify", $s_access) || $os->userDetails["adminType"] == "Super Admin";
            $has_insert_view_access = in_array("View", $s_access) || $os->userDetails["adminType"] == "Super Admin";
            $has_insert_result_entry_access_access = in_array("Result Entry Access", $s_access) || $os->userDetails["adminType"] == "Super Admin";

            ?>
            <div class="uk-card uk-card-default uk-border-rounded uk-card-small uk-overflow-hidden uk-margin">
                <div class="uk-card-header uk-margin-remove p-top-m p-bottom-m uk-flex" style="background-color: #a0cfed">
                    <h4 class="uk-flex-1"><?=$exam["examTitle"];?></h4>

                    <div class="uk-text-nowrap uk-flex">
                    <?php if ($has_insert_edit_access) { ?>
                                <div class="uk-inline p-left-m p-right-m uk-flex uk-flex-middle">
                                    Publish

                                    <input type="checkbox" class="m-left-s uk-checkbox" <?= $exam['publish_result'] == 'Yes' ? 'checked' : '' ?> value="Yes" id="publish_<?= $examId ?>" onchange="wtosInlineEdit('publish_<?= $examId ?>','exam','publish_result','examId','<?= $examId ?>','','','')">

                                </div>
                                /
                                <div class="uk-inline p-left-m p-right-m  uk-flex uk-flex-middle">
                                    Grade Card

                                    <input type="checkbox" class="m-left-s uk-checkbox" <?= $exam['show_on_result'] == 'Yes' ? 'checked' : '' ?> value="Yes" id="show_on_result_<?= $examId ?>" onchange="wtosInlineEdit('show_on_result_<?= $examId ?>','exam','show_on_result','examId','<?= $examId ?>','','','')">


                                </div>


                                /

                                <a class=" p-left-m p-right-m" onclick="open_exam_form(<?= $examId ?>)">Edit</a>

                            <?php
                            } ?>

                            <?php if ($os->userDetails["adminType"] == "Super Admin") : ?>
                                /
                                <a class="uk-text-danger  p-left-m p-right-m" onclick="delete_exam(<?= $examId ?>)">Delete</a>
                            <?php endif; ?>
                    </div>
                </div>
           
                <table class="uk-table uk-table-small  exam-table uk-margin-remove">
                
                    <tr class="heading-row">
                        <td style="padding-left: 20px;" colspan="2">Subject</td>
                        <td>Written</td>
                        <td>Viva</td>
                        <td>Total</td>
                        <td>Start</td>
                        <td>End</td>
                        <td>Duration</td>
                        <td>Mode</td>
                        <td>Verified</td>
                        <td></td>
                    </tr>
            
                    <!-----EXAM GROUP LOOP START HERE--->
                    <?php foreach ($exam["exam_groups"] as $exam_group_id => $exam_group) {?>
                        <rowgroup>
                        <!-----EXAM DETAILS LOOP START HERE--->
                        <?php 
                        $count = 0;
                        foreach ($exam_group["subjects"] as $examdetailsId => $examdetails) {
                            $count ++;
                            $subject = $subject = $subjects[$examId][array_search($examdetails['subjectId'], array_column($subjects[$examId], "subjectId"))];
                            $total_marks+=$examdetails["totalMarks"];
                            $bgColor = $exam_group["exam_group_type"] == "SIMPLE"?"transparent":"#ffff0030";
                            ?>
                            <tr class="subject-row" style="background-color:<?= $bgColor?>">
                                <?php if($count == 1){?>
                                    <?php if($exam_group["exam_group_type"] != "SIMPLE"){ ?>
                                        <td rowspan="<?= count($exam_group["subjects"])?>" class="uk-table-shrink" style="padding-left: 20px;">
                                            <?= $exam_group["exam_group_name"]?>
                                        </td>
                                    <?php } ?>
                                <?php }?>
                                <td colspan="<?= $exam_group["exam_group_type"] == "SIMPLE"?"2":"1"?>" style="<?= $exam_group["exam_group_type"] == "SIMPLE"?"padding-left:20px":""?>">
                                    <?= $subject["subjectName"]?>
                                </td>
                                <td class="uk-table-shrink uk-text-nowrap uk-text-right"><?= $examdetails["written"]?></td>
                                <td class="uk-table-shrink uk-text-nowrap uk-text-right"><?= $examdetails["viva"]?></td>
                                <td class="uk-table-shrink uk-text-nowrap uk-text-right"><?= $examdetails["totalMarks"]?></td>
                                <?php if($count == 1){?>
                                    <td class="uk-table-shrink uk-text-nowrap" rowspan="<?= count($exam_group["subjects"])?>"> <?= $os->showDate($exam_group["exam_start_datetime"], "d/m/Y h:i A") ?></td>
                                    <td class="uk-table-shrink uk-text-nowrap" rowspan="<?= count($exam_group["subjects"])?>"> <?= $os->showDate($exam_group["exam_end_datetime"], "d/m/Y h:i A") ?></td>
                                    <td class="uk-table-shrink uk-text-nowrap" rowspan="<?= count($exam_group["subjects"])?>"> <?= $exam_group["exam_duration"]  >0 ?$exam_group["exam_duration"]."Min":""; ?></td>
                                    <td class="uk-table-shrink uk-text-nowrap" rowspan="<?= count($exam_group["subjects"])?>"> <?= $exam_group["exam_mode"] ?></td>
                                    <td class="uk-table-shrink uk-text-nowrap" rowspan="<?= count($exam_group["subjects"])?>">
                                        <input type="checkbox"
                                            value="Yes"
                                            class="uk-checkbox"
                                            id="question_verified_<?= $exam_group_id; ?>" 
                                            <?= !$has_insert_edit_access ? "disabled" : "" ?> 
                                            <?= $exam_group['question_verified'] == 'Yes' ? 'checked' : '' ?> 
                                            onchange="if(confirm('Are you sure?')){wtosInlineEdit('question_verified_<?= $exam_group_id; ?>','exam_group','question_verified','exam_group_id','<?= $exam_group_id; ?>','','','')}else{if(this.checked){this.checked=false}else{this.checked=true}}"> 
                                    </td>
                                    <td class="uk-table-shrink uk-text-nowrap  border-none border-right-none" rowspan="<?= count($exam_group["subjects"])?>">
                                    <?php
                                        $edit_func = $exam_group["exam_group_type"] === "SIMPLE"?"open_simple_examdetails_form($examId, $examdetailsId)":"open_exam_group_form('$examId',  '$exam_group_id')"
                                    ?>
                                        <a onclick="<?= $edit_func?>">Edit</a>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <!-----EXAM DETAILS LOOP START HERE--->
                        </rowgroup>
                    <?php }?>
                    <!-----EXAM GROUP LOOP END HERE--->
                    <tr>
                        <td colspan="4"></td>
                        <td><strong><?= $total_marks; ?></strong></td>
                        <td colspan="5"></td>
                    </tr>
                </table>
                <div class="uk-card-footer uk-margin-remove p-top-m p-bottom-m uk-text-right">
                    <button class="uk-button uk-button-secondary congested-form" onclick="open_exam_group_form(<?=$examId?>)">Add Group Subject</button>
                    <button class="uk-button uk-button-secondary congested-form" onclick="open_simple_examdetails_form(<?=$examId?>)">Add Subject</button>
                </div>
            </div>
        <?php }?>
        <style>
        .exam-table tr td{
            padding: 7px 6px;
            vertical-align: middle
        }
        .exam-table .heading-row{
            background-color: #fafafa;
            border-bottom: 1px solid #e5e5e5;
        }
        .exam-table .heading-row td{
            font-weight: bold;
        }
        .exam-table .subject-row{
            border-bottom: 1px solid #e5e5e5;
        }
        .exam-table .subject-row td{
            padding: 3px 6px;
        }
        .exam-table td{
            border-right: 1px solid #e5e5e5;
        }
        
        </style>
    <?php

}
//exam form

if ($os->get('open_exam_form') == 'OK' && $os->post('open_exam_form') == 'OK') {
    $examId = $os->post("examId");
    $exam = $os->mfa($os->mq("SELECT examId, examTitle, asession, class, branch_codes, for_non_subscriber FROM exam WHERE examId='$examId'"));
    $examId = $os->val($exam, "examId") != "" ? $exam["examId"] : 0; ?>
    <form id="exam_form" action="<?= $ajaxFilePath ?>?save_exam=OK" method="post" enctype="multipart/form-data">
        <div class="uk-card uk-card-small uk-card-default">
            <div class="uk-card-header p-top-m p-bottom-m uk-background-muted">
            <h4><?= $examId> 0?"Edit":"Add"?> Exam</h4>
            </div>
            <div class="uk-card-body">
                <input class="uk-hidden" name="save_exam" value="OK">

                <input class="uk-hidden" type="number" name="examId" id="examId" value="<?= $examId ?>">

                <div class="uk-margin-small">
                    <input required class="uk-input uk-border-rounded congested-form uk-text-bold" type="text" name="examTitle" id="examTitle" value="<?= $exam["examTitle"] ?>" />
                </div>

                <div class="uk-margin-small uk-hidden">
                    <input class="uk-checkbox" type="checkbox" name="for_non_subscriber" id="for_non_subscriber" value="1" <?= $exam["for_non_subscriber"] == "1" ? "checked" : "" ?> />
                    <label for="for_non_subscriber">Set as Free Exam (Show for all subscriber and nonsubscriber)</label>
                </div>


              
                <div class="uk-margin-small">
                    <div uk-grid>
                        <div>
                            Session
                            <select name="asession"  class="uk-select uk-border-rounded congested-form">
                                <?php $os->onlyOption($os->asession, $exam["asession"]); ?>
                            </select>
                        </div>
                        <div>
                        Class
                            <select name="class" id="class" class="uk-select uk-border-rounded congested-form">
                                <option></option>
                                <?php foreach ($os->board as $board) : ?>
                                    <optgroup label="<?= $board ?>">
                                        <?php foreach ($os->board_class[$board] as $class) : ?>
                                            <option value="<?= $class ?>" <?= $exam["class"] == $class ? "selected" : '' ?>>
                                                <?= $os->classList[$class] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                   
                </div>

                <?php
                $exam_branch_codes = json_decode($exam["branch_codes"]) ?? [];
                $branches = $os->get_branches_by_access_name("Exam Settings");
                $has_global_entry_access = in_array("Modify", $_global_access) || $os->userDetails["adminType"] == "Super Admin";
                ?>

                <?php if ($has_global_entry_access) { ?>
                    <div>
                        <input type="checkbox" 
                            <?= $exam && $exam["branch_codes"] == "" ? "checked" : "" ?> 
                            onchange="this.checked?$('#exam_branch_codes').hide():$('#exam_branch_codes').show()" class="uk-checkbox">
                        For All Branches
                    </div>
                <?php } ?>
                <div id="exam_branch_codes" class="border-xxs uk-border-rounded uk-overflow-hidden" style="border-color: #ddd; <?= $exam && $exam["branch_codes"] == "" ? "display:none" : "" ?>">
                    <p class="uk-background-muted p-m p-top-s p-bottom-s" style="border-bottom: 1px solid #ddd">BRANCH ACCESS</p>


                    <div class="uk-height-small uk-overflow-auto p-m">

                        <?php

                        foreach ($branches as $branch_code => $branch_name) {
                        ?>
                            <div>
                                <label>
                                    <input type="checkbox" class="uk-checkbox branch_codes" name="branch_codes[]" value="<?= $branch_code ?>" <?= in_array($branch_code, $exam_branch_codes) ? "checked" : "" ?> <?= sizeof($branches) == 1 ? "checked onclick='return false;'" : "" ?>>
                                    <?= $branch_name ?>
                                </label>
                            </div>
                        <?php } ?>
                        <style>
                            input[type="checkbox"][readonly] {
                                pointer-events: none;
                            }
                        </style>
                    </div>
                </div>
            </div>
            <div class="uk-card-footer">
                <button class="uk-button uk-border-rounded congested-form uk-secondary-button" name="button" type="submit">Save</button>
            </div>
        </div>
    </form>

<?php
}
if ($os->get('save_exam') == 'OK' && $os->post('save_exam') == 'OK') {
    $examId = $os->post("examId");
    $examTitle = $os->post("examTitle");
    $for_non_subscriber = $os->post("for_non_subscriber") > 0 ? 1 : 0;
    $asession = $os->post("asession");
    $class = $os->post("class");
    $branch_codes = @json_encode($os->post("branch_codes"));
    if ($branch_codes == "null") {
        $branch_codes = "";
    }
    $dataToSave = array(
        'examId' => $examId,
        'asession' => $asession,
        'examTitle' => $examTitle,
        'branch_codes' => $branch_codes,
        'class' => $class,
        'for_non_subscriber' => $for_non_subscriber
    );
    if ($examId == 0) {
        $dataToSave["addedBy"] = $os->userDetails["adminId"];
        $dataToSave["addedDate"] = "NOW()";
    } else {
        $dataToSave["modifyBy"] = $os->userDetails["adminId"];
        $dataToSave["modifyDate"] = "NOW()";
    }

    $examId = $os->save("exam", $dataToSave, 'examId', $examId);
    if ($examId) {
        print $examId;
    } else {
        print 0;
    }
}


///Open Exam Group form
if ($os->get('open_exam_group_form') == 'OK' && $os->post('open_exam_group_form') == 'OK') {
    $examId = $os->post("examId");
    $exam_group_id = $os->post("exam_group_id");
    $access_branches = $os->get_branches_by_access_name('Exam Settings', $os->loggedUser()['access']);


    $exam = $os->mfa($os->mq("SELECT * FROM exam WHERE examId='$examId'"));
    $exam_group = $os->mfa($os->mq("SELECT * FROM exam_group WHERE exam_group_id='$exam_group_id'"));
    $examdetailses = [];
    if($exam_group){
        $examdetails_query = $os->mq("SELECT * FROM examdetails WHERE exam_group_id = '{$exam_group["exam_group_id"]}'");
        while($examdetails = $os->mfa($examdetails_query)){
            $examdetailses[] = $examdetails; 
        }
    }
    $branches_filter = explode(',', $os->val($exam_group, 'branch_codes'));
    //class list
    $classes_filter = get_exam_group_class($exam_group_id);

     /**
     * Subjects
     */

    $subjects_query = $os->mq("SELECT sub.*, e.examId FROM subject sub
        INNER JOIN exam e ON(sub.classId=e.class AND e.examId = $examId)");
    $subjects = [];
    while ($subject = $os->mfa($subjects_query)) {
        $subjects[$subject["subjectId"]] = $subject;
    }

    ?>
    <div class="uk-card uk-card-small uk-card-default">
        <div class="uk-card-header uk-background-muted p-top-m p-bottom-m">
        <h5 class="uk-margin-remove">CREATE/EDIT EXAM</h5>
        <button class="uk-modal-close-default" type="button" uk-close></button>
        </div>
        <form id="exam_group_form" onsubmit="save_exam_group(event)">
            <input class="uk-hidden" name="examId" value="<?= $examId ?>">
            <input class="uk-hidden" name="exam_group_id" value="<?= $exam_group_id ?>">
  
            <div class="p-xl">
                        <div class="uk-margin">
                            <input name="exam_group_name" value="<?= $os->val($exam_group, 'exam_group_name'); ?>" type="text" class="uk-input uk-border-rounded uk-form-small uk-text-large">
                        </div>

                        <div class="uk-grid uk-child-width-expand uk-grid-small" uk-grid>
                            <div>
                                <label>Exam start datetime</label>
                                <input name="exam_start_datetime" value="<?= $os->val($exam_group, 'exam_start_datetime'); ?>" class="uk-input uk-border-rounded congested-form datetimepicker" />
                            </div>
                            <div>
                                <label>Exam end datetime</label>
                                <input name="exam_end_datetime" value="<?= $os->val($exam_group, 'exam_end_datetime'); ?>" class="uk-input uk-border-rounded congested-form datetimepicker" />
                            </div>
                            <div>
                                <label>Exam Mode</label>
                                <select name="exam_mode" class="uk-select congested-form uk-border-rounded">
                                    <option <?= $os->val($exam_group, 'exam_mode') == '' ? 'selected' : ''; ?> value="">---</option>
                                    <option <?= $os->val($exam_group, 'exam_mode') == 'Online' ? 'selected' : ''; ?>>Online</option>
                                    <option <?= $os->val($exam_group, 'exam_mode') == 'Offline' ? 'selected' : ''; ?>>Offline</option>
                                </select>
                            </div>
                        </div>

                        <!--Subjects starts here --->
                        <div class="uk-margin">
                            <h6>SUBJECTS</h6>
                            <div class="border-xxs uk-border-rounded uk-overflow-hidden" style="border-color: #ddd">
                                <table class="uk-table congested-table uk-table-divider uk-table-bordered  uk-margin-remove">
                                    <tr class="uk-background-muted">
                                        <td>#</td>
                                        <td>Subject</td>
                                        <td>Written</td>
                                        <td>Viva</td>
                                    </tr>
                                   <?php for($index = 0; $index < count($subjects); $index++){
                                    $examdetails = @$examdetailses[$index];
                                    $bgColor = $examdetails? "background-color: #00ff0040":""
                                    ?>
                                    <tr style="<?= $bgColor?>">
                                 
                                            <td class="uk-table-shrink">
                                                <?= $index +1?>
                                                <?php if($examdetails){?>
                                                    <input type="hidden" name="subjects[<?= $index ?>][examdetailsId]" value="<?= $os->val($examdetails, "examdetailsId")?>"/>
                                                <?php }?>
                                            </td>
                                            <td>
                                                <select class="base-input" name="subjects[<?= $index ?>][subjectId]">
                                                    <option></option>
                                                    <?php foreach ($subjects as $subject) : ?>
                                                        <option value="<?= $subject['subjectId'] ?>" <?= $os->val($examdetails, "subjectId") === $subject['subjectId'] ? "selected":"" ?>>
                                                            <?= $subject['subjectName'] ?>              
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td class="uk-table-shrink" style="width: 60px;">
                                                <input type="number" class="base-input" name="subjects[<?= $index ?>][written]" value="<?= $os->val($examdetails, "written")?>"/>
                                            </td>
                                            <td class="uk-table-shrink" style="width: 60px;">
                                                <input type="number" class="base-input" name="subjects[<?= $index ?>][viva]" value="<?= $os->val($examdetails, "viva")?>"/>
                                            </td>
                                    
                                    </tr>
                                    <?php } ?>
                                  
                                </table>
                            </div>
                        </div>

                        <!--Class Access Starts here --->
                        <div class="uk-margin">
                            <h6>CLASS ACCESS</h6>
                            <div class="border-xxs uk-border-rounded uk-overflow-hidden" style="border-color: #ddd">
                                <div class="uk-background-muted">
                                    <ul uk-tab uk-switcher="connect: #class_switcher">
                                        <?php foreach ($os->asession as $asession) : ?>
                                            <li><a href="#"><?= $asession ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <ul class="uk-switcher uk-margin" id="class_switcher">
                                    <?php foreach ($os->asession as $asession) :
                                        $classes_f = @(array)$os->val($classes_filter, $asession);
                                    ?>
                                        <li>
                                            <div class="uk-height-small uk-overflow-auto p-left-m p-right-m" style="border-color: #ddd">
                                                <div class="uk-grid uk-grid-small uk-child-width-1-3@s" uk-grid>
                                                    <?php foreach ($os->board_class as $board => $classes) { ?>
                                                        <div>
                                                            <p class="uk-text-bold"><?= $board ?></p>
                                                            <?php foreach ($classes as $class) :
                                                                $checked = $exam["asession"] == $asession && $exam["class"] == $class;
                                                            ?>
                                                                <div>
                                                                    <label>
                                                                        <input type="checkbox" class="uk-checkbox" name="exam_group_classes[<?= $asession ?>][]" <?= in_array($class, $classes_f) ? 'checked' : '' ?> <?= $checked ? "checked onclick='return false;'" : '' ?> value="<?= $class ?>" />
                                                                        <?= $os->classList[$class]; ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
            
            <div class="uk-card-footer uk-text-right p-top-m p-bottom-m uk-background-muted">
                <?php if($exam_group_id > 0){?>
                <button type="button" class="uk-button uk-button-danger uk-border-rounded congested-form" onclick="delete_exam_group(<?= $exam_group_id?>)"> Delete</button>
                <?php } ?>
                <button type="submit" class="uk-button uk-button-primary uk-border-rounded congested-form"> Save</button>
            </div>
            
        </form>
    </div>
<?php
}
//save exam group
if ($os->get('save_exam_group') == 'OK' && $os->post('save_exam_group') == 'OK') {
    try{
        $os->mq("START TRANSACTION;");
        $examId = $os->post("examId");
        $exam_group_id = $os->post("exam_group_id");

        $exam_group_name = $os->post("exam_group_name");
        $exam_start_datetime = $os->post("exam_start_datetime");
        $exam_end_datetime = $os->post("exam_end_datetime");
        $exam_mode = $os->post("exam_mode");

        $dataToSave = array(
            'examId' => $examId,
            'exam_group_name' => $exam_group_name,
            'exam_start_datetime' => $exam_start_datetime,
            'exam_end_datetime' => $exam_end_datetime,
            'exam_mode' => $exam_mode,
            "exam_group_type" => "ADVANCE"
        );

        $exam_group_id = $os->save("exam_group", $dataToSave, 'exam_group_id', $exam_group_id);

        //class list
        $d = $os->mq("DELETE FROM exam_group_class_access WHERE exam_group_id='$exam_group_id'");
        $paases_exam_group_classes = $os->post("exam_group_classes");
        foreach ($paases_exam_group_classes as $session => $classes) {
            foreach ($classes as $class) {
                $dataToSave = array(
                    "asession" => $session,
                    "class" => $class,
                    "exam_group_id" => $exam_group_id
                );

                $os->save("exam_group_class_access", $dataToSave);
            }
        }
        //examdetailses
        foreach($os->post("subjects") as $subject){
            $examdetailsId = @$subject["examdetailsId"]??"";
            if($examdetailsId !="" && $subject["subjectId"] = ""){
                $os->mq("DELETE FROM examdetails WHERE examdetailsId=$examdetailsId");
                continue;
            }
            if($subject["subjectId"] == "" || $subject["written"] == ""){
                continue;
            }
            unset($subject["examdetailsId"]);
            $subject["viva"] = $subject["viva"] > 0? $subject["viva"]: 0;
            $subject["totalMarks"] = $subject["viva"]+$subject["written"];
            $subject["exam_group_id"] = $exam_group_id;
            $subject["examId"] = $examId;

            $save = $os->save("examdetails", $subject,"examdetailsId", $examdetailsId);
            echo $os->query;
        }
        $os->mq("COMMIT");
        print("Successful");
    } catch(Exception $ex){
        print("Something went wrong while saving data");
        $os->mq("ROLLBACK");
    }
    exit();
}


//=============FOR DELETE EXAM FUNCTION ONLY=============//

if ($os->get("delete_exam") == "OK" && $os->post("delete_exam") == "OK") {
    $examId = $os->post("examId");
    $sql = "DELETE FROM exam WHERE examId='$examId';";
    $exam_group_id_query  = $os->mq("SELECT exam_group_id FROM exam_group WHERE examId='$examId'");
    $exam_group_ids = [];
    while ($exam_group = $os->mfa($exam_group_id_query)) {
        $exam_group_ids[] = $exam_group["exam_group_id"];
    }

    $exam_group_ids = implode(",",$exam_group_ids);

    $sql .= "DELETE FROM exam_group WHERE exam_group_id IN($exam_group_ids);";
    $sql .= "DELETE FROM examdetails WHERE exam_group_id IN($exam_group_ids);";

    $res = $os->mq($sql);
    if ($res) {
        print "Successfully deleted";
    }
}
if ($os->get("delete_exam_group") == "OK" && $os->post("delete_exam_group") == "OK") {
    $exam_group_id = $os->post("exam_group_id");
    $sql = "DELETE FROM exam_group WHERE exam_group_id IN($exam_group_id);";
    $sql .= "DELETE FROM exam_group_class_access WHERE exam_group_id IN($exam_group_id);";
    $sql .= "DELETE FROM examdetails WHERE exam_group_id IN($exam_group_id);";

    $res = $os->mq($sql);
    if ($res) {
        print "Successfully deleted";
    }
}

if ($os->get("delete_examdetails") == "OK" && $os->post("delete_examdetails") == "OK") {
    $examdetailsId = $os->post("examdetailsId");
    $sql = "DELETE FROM examdetails WHERE examdetailsId IN($examdetailsId);";
    $res = $os->mq($sql);
    if ($res) {
        print "Successfully deleted";
    }
}


//=============FOR SIMPLE EXAM FUNCTION ONLY=============//
if ($os->get('simple_examdetails_form') == "OK" && $os->post('simple_examdetails_form') == "OK") {
    $examId = $os->post("examId");
    $examdetailsId = $os->post("examdetailsId") ?? "";

    $exam = $os->mfa($os->mq("SELECT * FROM exam WHERE examId='$examId'"));
    $examdetails = null;
    $exam_group = null;
    if ($examdetailsId != "" && $examdetailsId != null) {
        $examdetails = $os->mfa($os->mq("SELECT * FROM examdetails WHERE examdetailsId='$examdetailsId'"));
        $exam_group = $os->mfa($os->mq("SELECT * FROM exam_group WHERE exam_group_id='{$examdetails["exam_group_id"]}'"));
    }

    /**
     * Subjects
     */

    $subjects_query = $os->mq("SELECT sub.* FROM subject sub WHERE sub.classId='{$exam["class"]}'");
    $subjects = [];
    while ($subject = $os->mfa($subjects_query)) {
        $subjects[] = $subject;
    }


?>
    <div class="uk-card uk-card-default uk-card-small">
        <div class="uk-card-header uk-background-muted">
            <h4><?= $examdetailsId ? "Edit" : "Add" ?> Subject</h4>
            <a class="uk-modal-close-default" uk-close></a>
        </div>

        <div class="uk-card-body">
            <form onsubmit="save_simple_examdetails_form(event); return false;">
                <input type="hidden" name="examId" value="<?= $examId ?>" />
                <input type="hidden" name="examdetailsId" value="<?= $examdetailsId ?>" />

                <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                    <div class="uk-width-1-1">
                        <label>Subject</label>
                        <select name="examdetails[subjectId]" required="required" class="uk-select uk-form-small">
                            <option value="">--SUBJECT--</option>
                            <?php foreach ($subjects as $subject) { ?>
                                <option value="<?= $subject['subjectId'] ?>" <?= $os->val($examdetails, 'subjectId') == $subject['subjectId'] ? 'selected' : ''; ?>>
                                    <?= $subject['subjectName'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label>Written Marks</label>
                        <input name="examdetails[written]" type="number" required="required" class="uk-input uk-form-small" value="<?= $os->val($examdetails, 'written') ?>" />
                    </div>
                    <div>
                        <label>Viva Marks</label>
                        <input name="examdetails[viva]" type="number" required="required" class="uk-input uk-form-small" value="<?= $os->val($examdetails, 'viva') ?>" />
                    </div>
                </div>

                <div class="uk-child-width-1-3 uk-grid-small" uk-grid>
                    <div>
                        <label>Exam start datetime</label>
                        <input name="exam_group[exam_start_datetime]" required="required" class="uk-input uk-form-small datetimepicker" value="<?= $os->val($exam_group, 'exam_start_datetime') ?>" />
                    </div>
                    <div>
                        <label>Exam end datetime</label>
                        <input name="exam_group[exam_end_datetime]" required="required" class="uk-input uk-form-small datetimepicker" value="<?= $os->val($exam_group, 'exam_end_datetime') ?>" />
                    </div>
                    <div>
                        <label>Exam Mode</label>
                        <select name="exam_group[exam_mode]" required="required" class="uk-select congested-form uk-border-rounded">
                            <option <?= $os->val($exam_group, 'exam_mode') == '' ? 'selected' : ''; ?> value="">---</option>
                            <option <?= $os->val($exam_group, 'exam_mode') == 'Online' ? 'selected' : ''; ?>>Online</option>
                            <option <?= $os->val($exam_group, 'exam_mode') == 'Offline' ? 'selected' : ''; ?>>Offline</option>
                        </select>
                    </div>
                </div>

                <button class="uk-button uk-button-primary congested-form uk-margin">Save</button>
            </form>
        </div>
    </div>
<?php
    exit();
}

if ($os->get('save_simple_examdetails_form') == "OK" && $os->post('save_simple_examdetails_form') == "OK") {
    $examId = $os->post("examId");
    $examdetailsId = $os->post("examdetailsId");

    $exam = $os->mfa($os->mq("SELECT * FROM exam WHERE examId='$examId'"));
    $examdetails = null;

    if ($examdetailsId != "" && $examdetailsId != null) {
        $examdetails = $os->mfa($os->mq("SELECT * FROM examdetails WHERE examdetailsId='$examdetailsId'"));
    }



    $examdetails_to_save = $os->post("examdetails");
    $exam_group_to_save = $os->post("exam_group");

    $subject = $os->mfa($os->mq("SELECT * FROM subject WHERE subjectId='{$examdetails_to_save["subjectId"]}'"));

    //save exam group
    $exam_group_to_save["examId"] = $examId;
    $exam_group_to_save["exam_group_name"] = $subject["subjectName"];
    $exam_group_to_save["exam_group_type"] = "SIMPLE";
    $exam_group_res = $os->save("exam_group", $exam_group_to_save, "exam_group_id", $os->val($examdetails, "exam_group_id"));
    $exam_group_id = $examdetails ? $os->val($examdetails, "exam_group_id") : $exam_group_res;

    //add class class access
    $exam_group_class_access_to_save = [
        "exam_group_id" => $exam_group_id,
        "asession" => $exam["asession"],
        "class" => $exam["class"]
    ];
    $os->mq("DELETE FROM exam_group_class_access WHERE exam_group_id='$exam_group_id'");
    $os->save("exam_group_class_access", $exam_group_class_access_to_save);


    //save examdetails
    $examdetails_to_save["totalMarks"] = $examdetails_to_save["written"] + $examdetails_to_save["viva"];
    $examdetails_to_save["examId"] = $examId;
    $examdetails_to_save["exam_group_id"] = $exam_group_id;
	
	 
	
    $os->save("examdetails", $examdetails_to_save, "examdetailsId", $os->val($examdetails, "examdetailsId"));
	
	//echo $os->query;
    echo "Subject added successfully";
    exit();
}

