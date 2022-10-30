<?php

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/
session_start();
include('wtosConfigLocal.php');
global $site, $os;
include($site['root-wtos'] . 'wtosCommon.php');

$pluginName = '';
$ajaxFilePath = 'exam_setting_ajax.php';

$os->loadPluginConstant($pluginName);
$access_branches = $os->get_branches_by_access_name("Exam Settings");
$selected_branch_code = $os->getSession('selected_branch_code');

$branchCode = $selected_branch_code;
$access_name = "Exam Settings";
//access
$global_access = $os->get_global_access_by_name($access_name);
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



if ($os->get('get_subjects_by_class') == 'OK' && $os->post('get_subjects_by_class') == 'OK') {

    $asession = $os->post('asession');
    $classes = $os->post('classes');
    $subjects = $os->subjects_by_class($asession, $classes);

    echo '##--SUBJECT-BY-CLASS--##';
    if (is_array($subjects)) {
        foreach ($subjects as $key => $subject) {
?>
            <div class="checkbox_list">
                <input type="checkbox" name="subject_list[]" value="<?php echo $key; ?>" /> <?php echo $subject; ?>
            </div>
    <?php

        }
    }

    echo '##--SUBJECT-BY-CLASS--##';

    exit();
}

if ($os->get('manage_exam_setting') == 'OK' && $os->post('manage_exam_setting') == 'OK') {


    $asession = $os->post('asession');
    $classList_s = $os->post('classList_s');

    $andClass = $os->postAndQuery("classList_s", "e.class", "=");
    //branch_code
    $secondary_access = $os->get_secondary_access_by_branch_and_menu($os->post("branch_code_s"), "Exam Settings");
    if ($os->post("branch_code_s") == "") {
        $secondary_access = $global_access;
        $and_branch_code = "AND (e.branch_codes='" . $os->post("branch_code_s") . "')";
    } else {
        $and_branch_code = "AND (e.branch_codes LIKE'%" . $os->post("branch_code_s") . "%')";
    }

    if ($os->loggedUser()["adminType"] == "Super Admin") {
        $and_branch_code = "";
    }


    //
    $and_asession = $os->postAndQuery("asession", "e.asession", "=");

    /////
    /// Exam Fetch
    $exam_sql = "select
         *
         from exam e
         where 1=1 $andClass $and_branch_code $and_asession order by e.addedDate DESC";

    $exam_q = $os->mq($exam_sql);
    $classes = [];
    $all_exams = [];
    $examIds = [];
    while ($record = $os->mfa($exam_q)) {
        $classes[$record['class']][$record['examId']] = $record;
        $all_exams[$record['examId']] = $record;
        $examIds[] = $record['examId'];
    }
    if (sizeof($examIds) == 0) {
        echo '##--EXAM-SETTING-DATA--##';
        echo 'No Exam Found';
        echo '##--EXAM-SETTING-DATA--##';
        exit();
    }
    /*
     * Exam groups
     */
    $examIds = implode(",", $examIds);
    $exam_group_query = $os->mq("SELECT * FROM exam_group eg WHERE eg.examId IN($examIds) ORDER BY  eg.exam_start_datetime");
    while ($exam_group = $os->mfa($exam_group_query)) {
        $exam_group["subjects"] = [];
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



    echo '##--EXAM-SETTING-DATA--##';

    ?>
    <div>
        <a onclick="print_div('print_view')" id="print_button" class="uk-button uk-button-small uk-button-primary">Print</a>
        <div id="normal_view">
            <?php
            foreach ($all_exams as $eId => $exam) {
                if ($exam["branch_codes"] == "") {
                    $s_access = $global_access;
                } else {
                    $s_access = $secondary_access;
                }
                //secondary access
                $has_insert_edit_access = in_array("Modify", $s_access) || $os->userDetails["adminType"] == "Super Admin";
                $has_insert_view_access = in_array("View", $s_access) || $os->userDetails["adminType"] == "Super Admin";
                $has_insert_result_entry_access_access = in_array("Result Entry Access", $s_access) || $os->userDetails["adminType"] == "Super Admin";

            ?>

                <div style="background-color: #d4c5df" class="uk-margin  uk-border-rounded p-m uk-box-shadow-small">
                    <div class="p-s">
                        <h5 class="uk-margin-remove uk-text-bold uk-inline">
                            <?= $exam['examTitle'] ?> [<span class="uk-text-primary"><?= $exam["examId"] ?></span> / <?= $exam["branch_codes"] == "" ? "Global" : "Local" ?> ]
                        </h5>
                        <div class="uk-float-right uk-flex-middle uk-flex">
                            <?php if ($has_insert_edit_access) { ?>
                                <div class="uk-inline p-left-m p-right-m uk-flex uk-flex-middle">
                                    Publish

                                    <input type="checkbox" class="m-left-s" <?= $exam['publish_result'] == 'Yes' ? 'checked' : '' ?> value="Yes" id="publish_<?= $eId ?>" onchange="wtosInlineEdit('publish_<?= $eId ?>','exam','publish_result','examId','<?= $eId ?>','','','')">

                                </div>
                                /
                                <div class="uk-inline p-left-m p-right-m  uk-flex uk-flex-middle">
                                    Grade Card

                                    <input type="checkbox" class="m-left-s" <?= $exam['show_on_result'] == 'Yes' ? 'checked' : '' ?> value="Yes" id="show_on_result_<?= $eId ?>" onchange="wtosInlineEdit('show_on_result_<?= $eId ?>','exam','show_on_result','examId','<?= $eId ?>','','','')">


                                </div>


                                /

                                <a class=" p-left-m p-right-m" onclick="open_exam_form(<?= $eId ?>)">Edit</a>

                            <?php
                            } ?>

                            <?php if ($os->userDetails["adminType"] == "Super Admin") : ?>
                                /
                                <a class="uk-text-danger  p-left-m p-right-m" onclick="delete_exam(<?= $eId ?>)">Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="exam uk-margin-small">
                        <?php foreach ($exam['exam_groups'] as $exam_group_id => $exam_group) { ?>
                            <?php if ($exam_group["exam_group_type"] === "SIMPLE") {
                                foreach ($exam_group['subjects'] as $edId => $ed) {
                                    $subject = $subjects[$eId][array_search($ed['subjectId'], array_column($subjects[$eId], "subjectId"))];
                            ?><div class="uk-margin">
                                        <div class="uk-card p-bottom-m uk-card-default uk-card-small uk-border-rounded  exam_group uk-margin" style="background-color: white">
                                            <div class="uk-card-header">
                                                <div class="uk-inline">
                                                    <h5 class=" uk-text-bold uk-margin-remove ">
                                                        <?= $subject['subjectName'] ?>
                                                    </h5>
                                                    <?php
                                                    $start = strtotime(date_format(date_create($exam_group['exam_start_datetime']), "Y-m-d H:i:s"));
                                                    $end = strtotime(date_format(date_create($exam_group['exam_end_datetime']), "Y-m-d H:i:s"));
                                                    $duration = ($end - $start) / (60);
                                                    ?>
                                                </div>
                                            </div>

                                            <table class="uk-table uk-table-striped congested-table uk-margin-remove uk-table-hover uk-overflow-hidden">
                                                <thead>
                                                    <tr class="subject_table_class_tr">
                                                        <td style="padding-left: 20px;">Start</td>
                                                        <td>End</td>
                                                        <td>Duration</td>
                                                        <td>Written</td>
                                                        <?php if ($has_insert_edit_access) { ?><td></td><?php } ?>
                                                        <td>Viva</td>
                                                        <?php if ($has_insert_edit_access) { ?><td></td><?php } ?>
                                                        <td>Total </td>
                                                        <td class="uk-hidden">Publish</td>
                                                        <td>Verified</td>
                                                        <td style="padding-right: 20px"></td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_<?= $eId ?>_<?= $exam_group_id; ?>">
                                                    <tr>
                                                        <td style="padding-left: 20px;"><label class="uk-text-danger uk-text-bold"><?= $os->showDate($exam_group['exam_start_datetime'], "M d, Y, h:i a"); ?></label></td>
                                                        <td><label class="uk-text-danger uk-text-bold"><?= $os->showDate($exam_group['exam_end_datetime'], "M d, Y, h:i a"); ?></label></td>
                                                        <td><label class="uk-text-danger uk-text-bold"> <?= $duration; ?> </label>Minutes</td>
                                                        <td style="width: 40px">
                                                            <input <?= !$has_insert_edit_access ? "disabled" : "" ?> type="number" class="uk-input congested-form " style="width: 50px" id="written_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>" value="<?php echo $ed['written']; ?>" onchange="wtosInlineEdit('written_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>','examdetails','written','examdetailsId','<?= $edId ?>','','','')" />
                                                        </td>
                                                        <?php if ($has_insert_edit_access) { ?>
                                                            <td style="width: 40px">
                                                                <a class="uk-text-primary" uk-icon="icon:list;" onclick="view_written_section(<?= $ed['examdetailsId'] ?>)"></a>
                                                            </td>
                                                        <?php } ?>

                                                        <td style="width: 40px">
                                                            <input <?= !$has_insert_edit_access ? "disabled" : "" ?> type="number" class="uk-input congested-form " style="width: 50px" id="viva_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>" value="<?php echo $ed['viva']; ?>" onchange="wtosInlineEdit('viva_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>','examdetails','viva','examdetailsId','<?= $edId ?>','','','')" />
                                                        </td>

                                                        <?php if ($has_insert_edit_access) { ?>
                                                            <td style="width: 40px">
                                                                <a class="uk-margin-small-left uk-link uk-text-primary" uk-icon="icon:list;" onclick="view_viva_details(<?= $ed['examdetailsId'] ?>)"></a>
                                                            </td>
                                                        <?php } ?>
                                                        <td style="width: 50px">
                                                            <input readonly type="text" class="uk-input congested-form" value="<?php echo $ed['totalMarks']; ?>" />
                                                        </td>
                                                        <td class="uk-text-nowrap uk-table-shrink uk-hidden" nowrap="" style="padding-right: 20px">
                                                            <input type="checkbox" class="uk-checkbox" <?php if (!$has_insert_edit_access) { ?>disabled<?php
                                                                                                                                                    } ?> <?= $ed['publish_result'] == 1 ? 'checked' : '' ?> value="1" id="publish_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>" onchange="wtosInlineEdit('publish_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>','examdetails','publish_result','examdetailsId','<?= $edId ?>','','','')">
                                                        </td>
                                                        <?php if ($has_insert_result_entry_access_access && false) { ?>
                                                            <td>
                                                                <a onclick="WT_result_entry_access_listing(<?= $edId ?>)">Entry Access</a>
                                                            </td>
                                                        <?php
                                                        } ?>
                                                        <td>
                                                            <input <?= !$has_insert_edit_access ? "disabled" : "" ?> type="checkbox" class="m-left-s m-right-m" <?= $exam_group['question_verified'] == 'Yes' ? 'checked' : '' ?> value="Yes" id="question_verified_<?= $exam_group_id; ?>" onchange="if(confirm('Are you sure?')){wtosInlineEdit('question_verified_<?= $exam_group_id; ?>','exam_group','question_verified','exam_group_id','<?= $exam_group_id; ?>','','','')}else{if(this.checked){this.checked=false}else{this.checked=true}}">
                                                        </td>
                                                        <td class="uk-text-right uk-padding-small-right" style="padding-right: 20px; width: 150px">
                                                            <a class="uk-text-danger m-left-m" uk-icon="icon:trash;" onclick="delete_exam_group(<?= $exam_group_id; ?>)"></a></li>
                                                            <a class="uk-margin-small-left uk-link uk-text-primary" uk-icon="icon:pencil;" onclick="open_simple_examdetails_form(<?= $eId ?>, <?= $ed['examdetailsId'] ?>)"></a>
                                                            <?php if ($has_insert_result_entry_access_access && $exam_group["exam_mode"] == "Offline") { ?>
                                                                <a class="uk-margin-small-left uk-link uk-text-primary" uk-icon="icon:lock;" uk-tooltip="Result Entry Access" onclick="WT_result_entry_access_listing('<?= $edId ?>')"></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            <?php } else { ?>
                                <div class="uk-margin">
                                    <div class="uk-card p-bottom-m uk-card-default uk-card-small uk-border-rounded  exam_group uk-margin" style="background-color: white">
                                        <div class="uk-card-header">
                                            <div class="uk-inline">
                                                <h5 class=" uk-text-bold uk-margin-remove ">
                                                    <?= $exam_group['exam_group_name']; ?>
                                                </h5>
                                                <?php
                                                $start = strtotime(date_format(date_create($exam_group['exam_start_datetime']), "Y-m-d H:i:s"));
                                                $end = strtotime(date_format(date_create($exam_group['exam_end_datetime']), "Y-m-d H:i:s"));
                                                $duration = ($end - $start) / (60);
                                                ?>

                                                <div class="text-m">
                                                    Start : <label class="uk-text-danger uk-text-bold"><?= $os->showDate($exam_group['exam_start_datetime'], "M d, Y, h:i a"); ?></label><br>
                                                    End: &nbsp;&nbsp;<label class="uk-text-danger uk-text-bold"><?= $os->showDate($exam_group['exam_end_datetime'], "M d, Y, h:i a"); ?></label><br>
                                                    Duration: <label class="uk-text-danger uk-text-bold"> <?= $duration; ?> </label>Minutes
                                                </div>
                                            </div>


                                            <?php if ($has_insert_edit_access) { ?>


                                                <div class="uk-float-right">
                                                    Verified
                                                    <input type="checkbox" class="m-left-s m-right-m" <?= $exam_group['question_verified'] == 'Yes' ? 'checked' : '' ?> value="Yes" id="question_verified_<?= $exam_group_id; ?>" onchange="if(confirm('Are you sure?')){wtosInlineEdit('question_verified_<?= $exam_group_id; ?>','exam_group','question_verified','exam_group_id','<?= $exam_group_id; ?>','','','')}else{if(this.checked){this.checked=false}else{this.checked=true}}">

                                                    /
                                                    <a class="uk-text-primary m-left-m p-right-m" onclick="open_exam_group_form(<?= $eId ?>, <?= $exam_group_id ?>)">Edit</a></li>

                                                    <?php if ($os->userDetails["adminType"] == "Super Admin") : ?>
                                                        /
                                                        <a class="uk-text-danger m-left-m" onclick="delete_exam_group(<?= $exam_group_id; ?>)">Delete</a></li>
                                                    <?php endif; ?>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <table class="uk-table uk-table-striped congested-table uk-margin-remove uk-table-hover uk-overflow-hidden">
                                            <thead>
                                                <tr class="subject_table_class_tr">
                                                    <td style="padding-left: 20px"> Subject </td>
                                                    <td>Writt.</td>
                                                    <td>Viva</td>
                                                    <td></td>
                                                    <td>Total </td>
                                                    <td class="uk-hidden">Publish</td>
                                                    <td style="padding-right: 20px"></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_<?= $eId ?>_<?= $exam_group_id; ?>">
                                                <?php
                                                foreach ($exam_group['subjects'] as $edId => $ed) {
                                                ?>
                                                    <tr>
                                                        <td style="padding-left: 20px">
                                                            <select <?php if (!$has_insert_edit_access) { ?>disabled<?php
                                                                                                                } ?> class="uk-select congested-form" id="subject_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>" onchange="wtosInlineEdit('subject_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>','examdetails','subjectId','examdetailsId','<?= $edId ?>','','','')" name="subjectId">
                                                                <?php foreach ($subjects[$eId] as $subject) : ?>
                                                                    <option <?= $ed['subjectId'] == $subject['subjectId'] ? 'selected' : '' ?> value="<?= $subject['subjectId'] ?>">
                                                                        <?= $subject['subjectName'] ?>
                                                                        <?php if ($os->loggedUser()["adminType"] == "Super Admin" && false) { ?>
                                                                            [<?= $subject['asession'] ?> | <?= $subject['board'] ?>]
                                                                        <?php
                                                                        } ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <input <?php if (!$has_insert_edit_access) { ?>disabled<?php
                                                                                                                } ?> type="number" class="uk-input congested-form " style="width: 50px" id="written_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>" value="<?php echo $ed['written']; ?>" onchange="wtosInlineEdit('written_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>','examdetails','written','examdetailsId','<?= $edId ?>','','','')" />

                                                        </td>
                                                        <td nowrap="">
                                                            <input <?php if (!$has_insert_edit_access) { ?>disabled<?php
                                                                                                                } ?> type="number" class="uk-input congested-form " style="width: 50px" id="viva_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>" value="<?php echo $ed['viva']; ?>" onchange="wtosInlineEdit('viva_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>','examdetails','viva','examdetailsId','<?= $edId ?>','','','')" />
                                                        </td>
                                                        <td style="width: 40px">
                                                            <?php if ($has_insert_edit_access) { ?>
                                                                <a class="uk-margin-small-left uk-link uk-text-primary" uk-icon="icon:list;" onclick="view_viva_details(<?= $ed['examdetailsId'] ?>)"></a>
                                                            <?php
                                                            } ?>
                                                        </td>
                                                        <td style="width: 50px">
                                                            <input readonly type="text" class="uk-input congested-form" value="<?php echo $ed['totalMarks']; ?>" />
                                                        </td>
                                                        <td class="uk-text-nowrap uk-table-shrink uk-hidden" nowrap="" style="padding-right: 20px">
                                                            <input type="checkbox" class="uk-margin-small-right" <?php if (!$has_insert_edit_access) { ?>disabled<?php
                                                                                                                                                                } ?> <?= $ed['publish_result'] == 1 ? 'checked' : '' ?> value="1" id="publish_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>" onchange="wtosInlineEdit('publish_<?= $eId ?>_<?= $exam_group_id; ?>_<?= $edId ?>','examdetails','publish_result','examdetailsId','<?= $edId ?>','','','')">
                                                        </td>
                                                        <td class="uk-text-right uk-padding-small-right" style="padding-right: 20px; width: 150px">
                                                            <?php if ($os->userDetails["adminType"] == "Super Admin") { ?>
                                                                <a class="uk-text-danger" title="Delete" uk-icon="icon:trash;" onclick="removeRowAjaxFunction('examdetails','examdetailsId','<?php echo $ed['examdetailsId'] ?>','','','manage_exam_setting(\'search\');')  "></a>
                                                            <?php
                                                            } ?>
                                                            <a class="uk-margin-small-left uk-link uk-text-primary" uk-icon="icon:nut;" onclick="view_written_section(<?= $ed['examdetailsId'] ?>)"></a>
                                                            <?php if ($has_insert_result_entry_access_access && $exam_group["exam_mode"] == "Offline") { ?>
                                                                <a class="uk-margin-small-left uk-link uk-text-primary" uk-icon="icon:lock;" uk-tooltip="Result Entry Access" onclick="WT_result_entry_access_listing('<?= $edId ?>')"></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                            </tbody>
                                            <?php if ($has_insert_edit_access) { ?>
                                                <tfoot>
                                                    <tr id="examdetails_form_<?= $eId; ?>_<?= $exam_group_id; ?>" style="background-color: #f3f3f3">
                                                        <td style="padding-left: 20px">
                                                            <select class="uk-select congested-form " name="subjectId">
                                                                <option value="">--SUBJECT--</option>
                                                                <?php foreach ($subjects[$eId] as $subject) : ?>
                                                                    <option value="<?= $subject['subjectId'] ?>"><?= $subject['subjectName'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>
                                                        <td class="uk-table-shrink">
                                                            <input type="text" onchange="calculate_marks('.marks_<?= $eId ?>_<?= $exam_group_id; ?>','#total_marks_<?= $eId ?>_<?= $exam_group_id; ?>')" name="written_marks" class="uk-input congested-form marks_<?= $eId ?>_<?= $exam_group_id; ?>">
                                                        </td>
                                                        <td class="uk-table-shrink" nowrap="">

                                                            <input type="text" onchange="calculate_marks('.marks_<?= $eId ?>_<?= $exam_group_id; ?>','#total_marks_<?= $eId ?>_<?= $exam_group_id; ?>')" name="viva_marks" class="uk-input congested-form marks_<?= $eId ?>_<?= $exam_group_id; ?>">
                                                        </td>
                                                        <td>
                                                            <input class="uk-hidden" name="exam_group_id" value="<?= $exam_group_id; ?>">
                                                            <input class="uk-hidden" name="examId" value="<?= $eId; ?>">
                                                        </td>
                                                        <td class="uk-table-shrink">
                                                            <input value="" readonly class="congested-form uk-input" name="total_marks" id="total_marks_<?= $eId ?>_<?= $exam_group_id; ?>" />
                                                        </td>
                                                        <td class="uk-hidden"></td>
                                                        <td class="uk-hidden"></td>
                                                        <td class="uk-text-right uk-padding-small-right" style="padding-right: 20px">
                                                            <a class="uk-text-success" title="Insert" uk-icon="plus" onclick="save_examdetails('#examdetails_form_<?= $eId; ?>_<?= $exam_group_id; ?>')  "></a>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            <?php
                                            } ?>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="p-s uk-text-right">

                        <?php if ($has_insert_edit_access) { ?>
                            <a class="uk-button congested-form uk-button-primary uk-border-rounded" onclick="open_exam_group_form(<?= $eId ?>)">Add Group Subject</a>
                            <a class="uk-button congested-form uk-button-primary uk-border-rounded" onclick="open_simple_examdetails_form(<?= $eId ?>)">Add Subject</a>

                        <?php
                        } ?>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <!-----PRINT VIEW----->
        <div id="print_view" style="display: none;">
            <table class="exam-print-table">

                <?php foreach ($all_exams as $eId => $exam) { ?>

                    <tr class="exam-row">
                        <th colspan="5"><?= $exam['examTitle'] ?> (<?= $os->classList[$exam["class"]] ?>-<?= $exam["asession"] ?>)</td>
                    </tr>
                    <tr class="labels-row">
                        <th>Group</td>
                        <th>Subject</td>
                        <th>Exam Start</td>
                        <th>Exam End</td>
                        <th>Duration</td>
                    </tr>

                    <?php foreach ($exam['exam_groups'] as $exam_group_id => $exam_group) {
                        $start = strtotime(date_format(date_create($exam_group['exam_start_datetime']), "Y-m-d H:i:s"));
                        $end = strtotime(date_format(date_create($exam_group['exam_end_datetime']), "Y-m-d H:i:s"));
                        $duration = ($end - $start) / (60);
                        $show_group = $exam_group["exam_group_type"] != "SIMPLE";
                    ?>

                        <?php
                        $c = 0;
                        foreach ($exam_group['subjects'] as $edId => $ed) {
                            $c++;
                            $subject = $subjects[$eId][array_search($ed['subjectId'], array_column($subjects[$eId], "subjectId"))];
                        ?>
                            <tr class="examdetails-row">
                                <?php if ($c == 1) { ?>
                                    <td class="uk-table-shrink" nowrap rowspan="<?= count($exam_group['subjects']) ?>">
                                        <?php if ($show_group) { ?><?= $exam_group["exam_group_name"] ?> <?php } ?>
                                    </td>
                                <?php } ?>

                                <td><?= $subject["subjectName"] ?></td>

                                <?php if ($c == 1) { ?>
                                    <td class="uk-table-shrink" nowrap rowspan="<?= count($exam_group['subjects']) ?>"><?= $os->showDate($exam_group['exam_start_datetime'], "M d, Y, h:i A"); ?></td>
                                    <td class="uk-table-shrink" nowrap rowspan="<?= count($exam_group['subjects']) ?>"><?= $os->showDate($exam_group['exam_end_datetime'], "M d, Y, h:i A"); ?></td>
                                    <td class="uk-table-shrink" nowrap rowspan="<?= count($exam_group['subjects']) ?>"><?= $duration == 0 ? "" : $duration . " Minutes" ?></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tr>
                    <?php } ?>
                    <tr class="gap-row">
                        <td>----</td>
                    </tr>
                <?php } ?>
            </table>

            <style>
                @media print {
                    #print_button {
                        display: none
                    }
                }

                .exam-print-table {
                    border-collapse: collapse;
                    width: 100%;
                }

                .exam-print-table td,
                .exam-print-table th {
                    padding: 3px 5px;
                    text-align: left;
                    border: 1px solid #666;
                }


                .exam-row {
                    background-color: #666;
                    color: white;
                    font-size: 18px;
                    text-align: center;
                }

                .exam-row th {
                    text-align: center;
                }

                .labels-row {
                    background-color: #ccc;
                }

                .gap-row {}

                .gap-row td {
                    border: none;
                    color: transparent
                }
            </style>

        </div>

    </div>


<?php

    echo '##--EXAM-SETTING-DATA--##';

    exit();
}

if ($os->get('view_viva_details') == 'OK' && $os->post('view_viva_details') == 'OK') {
    $examdetailsId = $os->post('examdetailsId');
    $examdetails = $os->mfa($os->mq("SELECT * FROM examdetails WHERE examdetailsId='$examdetailsId'"));


    $viva_details = unserialize($examdetails['viva_fields']);
    $classes = 'uk-input uk-border-rounded congested-form';
?>
    <div class="uk-padding">
        <form id="sub_exam_viva_details_form">
            <h3>Exam Viva Marks Distribution</h3>
            <input type="hidden" name="examdetailsId" value="<?= $examdetailsId ?>">
            <input type="hidden" name="viva" id="viva_marks" value="<?= $examdetails['viva'] ?>">
            <ul id="sub_exam_viva_details" class="uk-list uk-list-striped">
                <?php
                foreach ($viva_details as $viva_key => $viva_detail) { ?>
                    <!--1st lavel-->
                    <li>
                        <div class="uk-grid uk-child-width-expand uk-grid-small" uk-grid>
                            <div>
                                <input class="<?= $classes ?>" placeholder="Title" name="exam_viva_details[<?= $viva_key ?>][title]" value="<?= $viva_detail['title'] ?>">
                            </div>
                            <div class="uk-width-auto">
                                <input class="<?= $classes ?> viva_parent_marks" id="viva_parent_mark_<?= $viva_key ?>" style="width:50px" placeholder="Marks" onchange="calculate_marks('.viva_parent_marks', '#viva_marks')" name="exam_viva_details[<?= $viva_key ?>][marks]" value="<?= $viva_detail['marks'] ?>">
                            </div>
                            <div class="uk-width-auto">
                                <a class="uk-text-danger" uk-icon="icon:trash; ratio:0.9" onclick="remove_exam_viva_details(this);
                                   calculate_marks('.viva_parent_marks','#viva_marks')"></a>
                            </div>
                        </div>
                        <ul id="sub_exam_viva_details_<?= $viva_key ?>" class="uk-list p-left-xl">
                            <?php
                            if (is_array($viva_detail['sub_head'])) {
                                $sub_details = $viva_detail['sub_head'];
                                foreach ($sub_details as $sub_key => $sub_detail) { ?>
                                    <li>
                                        <div class="uk-grid uk-child-width-expand uk-grid-small" uk-grid>
                                            <div class="uk-width-auto"></div>
                                            <div>
                                                <input class="<?= $classes ?>" placeholder="Title" name="exam_viva_details[<?= $viva_key ?>][sub_head][<?= $sub_key ?>][title]" value="<?= $sub_detail['title'] ?>">
                                            </div>
                                            <div class="uk-width-auto">
                                                <input class="<?= $classes ?> viva_child_mark_<?= $viva_key ?>" placeholder="Marks" style="width:50px" name="exam_viva_details[<?= $viva_key ?>][sub_head][<?= $sub_key ?>][marks]" onchange="calculate_marks('.viva_child_mark_<?= $viva_key ?>','#viva_parent_mark_<?= $viva_key ?>')" value="<?= $sub_detail['marks'] ?>">
                                            </div>
                                            <div class="uk-width-auto">
                                                <a class="uk-text-danger" uk-icon="icon:trash; ratio:0.9" onclick="remove_exam_viva_details(this); calculate_marks('.viva_child_mark_<?= $viva_key ?>','#viva_parent_mark_<?= $viva_key ?>')"></a>
                                            </div>
                                        </div>
                                    </li>
                                <?php
                                }
                                ?>
                            <?php
                            } ?>
                            <li>
                                <a onclick="insert_new_exam_viva_details(this, <?= $viva_key ?>)">Insert</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <li>
                    <a onclick="insert_new_exam_viva_details(this, null)">Insert</a>
                </li>
            </ul>
        </form>

        <button onclick="save_exam_viva_details(<?= $examdetailsId ?>)">Save</button>
    </div>
<?php
}

if ($os->get('save_exam_viva_details') == 'OK' && $os->post('save_exam_viva_details') == 'OK') {
    $details = $os->post('exam_viva_details');
    $viva = $os->post('viva');
    $examdetailsId = $os->post('examdetailsId');
    $details = serialize($details);


    $dataToSave = [];
    $dataToSave['viva_fields'] = $details;
    $dataToSave['viva'] = $viva;
    $os->save('examdetails', $dataToSave, 'examdetailsId', $examdetailsId);
}


if ($os->get('open_exam_form') == 'OK' && $os->post('open_exam_form') == 'OK') {
    $examId = $os->post("examId");
    $exam = $os->mfa($os->mq("SELECT examId, examTitle, asession, class, branch_codes, for_non_subscriber FROM exam WHERE examId='$examId'"));
    $examId = $os->val($exam, "examId") != "" ? $exam["examId"] : 0; ?>
    <form id="exam_form" action="<?= $ajaxFilePath ?>?save_exam=OK" method="post" enctype="multipart/form-data">
        <div>
            <h4>Create/Edit Exam Head</h4>
            <input class="uk-hidden" name="save_exam" value="OK">

            <input class="uk-hidden" type="number" name="examId" id="examId" value="<?= $examId ?>">

            <div class="uk-margin-small">
                <input required class="uk-input uk-border-rounded congested-form uk-text-bold" type="text" name="examTitle" id="examTitle" value="<?= $exam["examTitle"] ?>" />
            </div>

            <div class="uk-margin-small">
                <input class="uk-checkbox" type="checkbox" name="for_non_subscriber" id="for_non_subscriber" value="1" <?= $exam["for_non_subscriber"] == "1" ? "checked" : "" ?> />
                <label for="for_non_subscriber">Set as Free Exam (Show for all subscriber and nonsubscriber)</label>
            </div>


            <select name="asession">
                <?php $os->onlyOption($os->asession, $exam["asession"]); ?>
            </select>
            <div class="uk-margin-small">
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

            <?php
            $exam_branch_codes = json_decode($exam["branch_codes"]);
            $branches = $os->get_branches_by_access_name("Exam Settings");
            $has_global_entry_access = in_array("Modify", $global_access) || $os->userDetails["adminType"] == "Super Admin";
            ?>

            <?php if ($has_global_entry_access) { ?>
                <div>
                    <input type="checkbox" <?= $exam && $exam["branch_codes"] == "" ? "checked" : "" ?> onchange="toggle_branches(this.checked, '#exam_branch_codes')">
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

            <button class="uk-button uk-border-rounded congested-form uk-secondary-button" name="button" type="submit">Save</button>
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

    $branches_filter = explode(',', $os->val($exam_group, 'branch_codes'));
    //class list
    $classes_filter = get_exam_group_class($exam_group_id);


?>
    <form class="p-xl" id="exam_group_form">
        <h5 class="uk-margin-small">CREATE/EDIT EXAM</h5>
        <input class="uk-hidden" name="examId" value="<?= $examId ?>">
        <input class="uk-hidden" name="exam_group_id" value="<?= $exam_group_id ?>">

        <div>

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
            <div class="uk-margin">
                <h6 class="uk-hiedden">CLASS ACCESS</h6>
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



            <button onclick="save_exam_group('#exam_group_form')" type="button" class="uk-button uk-button-primary uk-border-rounded congested-form">
                Save Configuration</button>
        </div>
    </form>
<?php
}
if ($os->get('save_exam_group') == 'OK' && $os->post('save_exam_group') == 'OK') {
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
    print $os->query;
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
}


if ($os->get('save_examdetails') == 'OK' && $os->post('save_examdetails') == 'OK') {
    $examId = $os->post("examId");
    $exam_group_id = $os->post("exam_group_id");
    $subjectId = $os->post("subjectId");
    $written_marks = $os->post("written_marks");
    $viva_marks = $os->post("viva_marks");
    $total_marks = $os->post("total_marks");


    if ($subjectId == "") {
        print json_encode(array(
            "error" => true,
            "message" => "Please choose subject"
        ));
        exit();
    }


    $dataToSave = array(
        'examId' => $examId,
        'exam_group_id' => $exam_group_id,
        'subjectId' => $subjectId,
        'written' => $written_marks,
        'viva' => $viva_marks,
        'totalMarks' => $total_marks
    );

    $save = $os->save("examdetails", $dataToSave);

    if ($save) {
        print json_encode(array(
            "error" => false,
            "message" => "Successfully added new subject"
        ));
    }
}


/*********
 * Delete function
 */
if ($os->get("delete_exam") == "OK" && $os->post("delete_exam") == "OK") {
    $examId = $os->post("examId");
    $sql = "DELETE FROM exam WHERE examId='$examId';";
    $exam_group_id_query  = $os->mq("SELECT exam_group_id FROM exam_group WHERE examId='$examId'");
    $exam_group_ids = [];
    while ($exam_group = $os->mfa($exam_group_id_query)) {
        $exam_group_ids[] = $exam_group["exam_group_id"];
    }

    $exam_group_ids = implode($exam_group_ids, ",");

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




/*******
 * Entry access
 */
function get_exam_group_classes_by_examdetails($examdetailsId)
{
    global $os;
    $exam_group_classes_query = $os->mq("select egca.class, egca.asession 
        FROM exam_group_class_access egca
        INNER JOIN examdetails ed on egca.exam_group_id = ed.exam_group_id AND ed.examdetailsId='$examdetailsId'");
    $exam_group_classes = [];
    while ($exam_group_class = $os->mfa($exam_group_classes_query)) {
        $exam_group_classes[$exam_group_class["asession"]][$os->get_board_by_class($exam_group_class["class"])][$exam_group_class["class"]] = $os->classList[$exam_group_class["class"]];
    }

    return $exam_group_classes;
}
function get_teacher_by_branch_codes($branch_codes)
{
    global $os;
    $branch_codes = "'" . implode("','", $branch_codes) . "'";
    $query = $os->mq("SELECT a.name, a.adminId, a.branch_code FROM admin a 
        WHERE a.branch_code IN($branch_codes)");
    $teacher = [];
    while ($row = $os->mfa($query)) {
        $teacher[$row["branch_code"]][$row["adminId"]] = $row["name"];
    }
    return $teacher;
}
if ($os->get("WT_result_entry_access_listing") == "OK" && $os->post("WT_result_entry_access_listing") == "OK") {
    $examdetailsId = $os->post("edId");

    $exam = $os->mfa($os->mq("SELECT e.* FROM exam e INNER JOIN examdetails ed ON ed.examId=e.examId AND ed.examdetailsId='$examdetailsId'"));
    $exam_group = $os->mfa($os->mq("SELECT eg.* FROM exam_group eg INNER JOIN examdetails ed ON ed.exam_group_id=eg.exam_group_id AND ed.examdetailsId='$examdetailsId'"));

    if ($exam["branch_codes"] == "") {
        $branch_codes = $access_branches;
    } else {
        $branch_codes = json_decode($exam["branch_codes"]);
    }
    $exam_session_board_classes = get_exam_group_classes_by_examdetails($examdetailsId);
    $branch_teachers = get_teacher_by_branch_codes($branch_codes);

    $query = $os->mq("SELECT ra.* , t.name as teacher_name
        FROM resultentry_access ra 
        INNER JOIN admin t ON t.adminId=ra.teacherId
        WHERE ra.examdetailsId='$examdetailsId' ORDER BY ra.asession, ra.for_class");
    $branch_entry_accesses = [];
    $asession_spans = [];
    $class_spans = [];
    while ($row = $os->mfa($query)) {
        $branch_entry_accesses[$row['branch_code']][] = $row;
        @$asession_spans[$row['branch_code']][$row['asession']]++;
        @$class_spans[$row['branch_code']][$row['asession']][$row['for_class']]++;
    }



?>
    <div class="uk-grid uk-grid-small" uk-grid>
        <div class="uk-width-medium">
            <div class="p-m uk-border-rounded" style="background-color: #e5e5e5; border: 1px solid #ccc">
                <form id="result_entry_access_form" method="post" enctype="multipart/form-data" action="<?= $ajaxFilePath ?>?WT_save_result_entry_access=OK">
                    <input type="hidden" name="WT_save_result_entry_access" value="OK">
                    <input type="hidden" name="entry_access_edId" value="<?= $examdetailsId ?>">

                    <table class="congested-table">
                        <tr>
                            <td colspan="2">
                                <h4>Entry Form</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>Branch</td>
                            <td>
                                <select required class="uk-select congested-form" name="entry_access_branch" onblur="change_result_entry_teacher(this.value)">
                                    <?php foreach ($branch_codes as $branch_code) { ?>
                                        <option value="<?= $branch_code ?>"><?= $access_branches[$branch_code] ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </td>
                        </tr>


                        <tr class="<?= $exam_group["exam_group_type"] == "SIMPLE" ? "uk-hidden":""?>">
                            <td>Session</td>
                            <td>
                                <select required class="uk-select congested-form" name="entry_access_asession" onblur="change_result_entry_class(this.value)">
                                    <?php foreach ($exam_session_board_classes as $session => $board_class) { ?>
                                        <option value="<?= $session ?>"><?= $session ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="<?= $exam_group["exam_group_type"] == "SIMPLE" ? "uk-hidden":""?>">
                            <td>Class</td>
                            <td>
                                <?php
                                $board_class = count($exam_session_board_classes) > 0 ? $exam_session_board_classes[array_key_first($exam_session_board_classes)] : [];
                                ?>

                                <select required class="uk-select congested-form" name="entry_access_class">

                                    <?php foreach ($board_class as $board => $classes) { ?>
                                        <optgroup label="<?= $board; ?>">
                                            <?php foreach ($classes as $class => $classLabel) { ?>
                                                <option value="<?= $class ?>"><?= $classLabel ?></option>
                                            <?php } ?>

                                        </optgroup>

                                    <?php } ?>

                                </select>
                            </td>
                        </tr>


                        <tr>
                            <td>Teacher</td>
                            <td>
                                <select required class="uk-select congested-form select2" name="entry_access_teacher">
                                    <option value="">Teacher</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>
                                <select class="uk-select congested-form" name="entry_access_gender">
                                    <option value="">All</option>
                                    <?php $os->onlyOption($os->gender) ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Roll</td>
                            <td>
                                <input class="uk-input congested-form" name="entry_access_roll_from" placeholder="From" style="width: 50px">
                                <input class="uk-input congested-form" name="entry_access_roll_to" placeholder="To" style="width: 40px">

                            </td>
                        </tr>
                        <tr>
                            <td>Validity</td>
                            <td>
                                <div class="uk-inline">
                                    <input class="uk-input congested-form datepicker" name="entry_access_date_from_valid" placeholder="From" style="width: 80px">
                                </div>
                                <div class="uk-inline">
                                    <input class="uk-input congested-form datepicker" name="entry_access_date_to_valid" placeholder="To" style="width: 80px">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="bp3-button bp3-small bp3-intent-success">Save</button>
                            </td>
                        </tr>
                    </table>


                    <script>
                        var branch_teachers = <?= json_encode($branch_teachers) ?>;

                        function change_result_entry_teacher(branch_code) {
                            let teachers = branch_teachers[branch_code];
                            let ex = '';
                            for (const [adminId, name] of Object.entries(teachers)) {
                                ex += `<option value="${adminId}">${name}</option>`;
                            }
                            $("#result_entry_access_form select[name='entry_access_teacher']").html(ex);
                        }
                    </script>
                    <script>
                        var exam_session_board_classes = <?= json_encode($exam_session_board_classes) ?>;

                        function change_result_entry_class(session) {
                            let board_classes = exam_session_board_classes[session];
                            let ex = '';
                            for (const [board, classes] of Object.entries(board_classes)) {
                                ex += `<optgroup title='${board}'>`;
                                for (const [classs, class_name] of Object.entries(classes)) {
                                    ex += `<option value="${classs}">${class_name}</option>`;
                                }
                                ex += `</optgroup>`;
                            }
                            $("#result_entry_access_form select[name='entry_access_class']").html(ex);
                        }
                    </script>
                </form>
            </div>
        </div>
        <div class="uk-width-expand">
            <ul uk-accordion="multiple: true">

                <?php foreach ($branch_entry_accesses as $branch_code => $entry_accesses) : ?>
                    <li class="uk-open">
                        <a class="uk-accordion-title uk-margin-remove uk-light p-s" style="background-color: #e5e5e5" href="#"><?= $access_branches[$branch_code] ?></a>
                        <div class="uk-accordion-content uk-margin-remove">
                            <table border="1" class=" congested-table uk-width-1-1" style="border-collapse: collapse; border-color: #e5e5e5">
                                <thead>
                                    <tr>
                                        <th style="border-color: #e5e5e5">Session</th>
                                        <th style="border-color: #e5e5e5">Class</th>
                                        <th style="border-color: #e5e5e5">Teacher</th>
                                        <th style="border-color: #e5e5e5">Gender</th>
                                        <th style="border-color: #e5e5e5">Roll</th>
                                        <th style="border-color: #e5e5e5">Validity From</th>
                                        <th style="border-color: #e5e5e5">Validity To</th>
                                        <td style="border-color: #e5e5e5"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $asession_count = 0;
                                    $class_count = 0;
                                    foreach ($entry_accesses as $entry_access) :
                                        $asession_count++;
                                        $class_count++;
                                    ?>
                                        <tr>
                                            <?php if ($asession_count == 1) { ?>
                                                <td style="border-color: #e5e5e5" rowspan="<?= $asession_spans[$branch_code][$entry_access["asession"]] ?>"><?= $entry_access["asession"] ?></td>
                                            <?php
                                            } ?>
                                            <?php if ($class_count == 1) { ?>
                                                <td style="border-color: #e5e5e5" rowspan="<?= $class_spans[$branch_code][$entry_access["asession"]][$entry_access['for_class']] ?>"><?= $os->classList[$entry_access["for_class"]] ?></td>
                                            <?php
                                            } ?>
                                            <td style="border-color: #e5e5e5"><?= $entry_access["teacher_name"] ?></td>
                                            <td style="border-color: #e5e5e5"><?= $entry_access["gender"] ?></td>
                                            <td style="border-color: #e5e5e5">
                                                <?= $entry_access["roll_from"] ?> - <?= $entry_access["roll_to"] ?>
                                            </td>
                                            <td style="border-color: #e5e5e5">
                                                <?= $entry_access["date_from_valid"] ?>
                                            </td>
                                            <td style="border-color: #e5e5e5">
                                                <?= $entry_access["date_to_valid"] ?>
                                            </td>

                                            <td style="border-color: #e5e5e5">
                                                <span title="Delete This Record" style="cursor:pointer; color:#FF0000;" onclick="removeRowAjaxFunction('resultentry_access','resultentry_access_id','<?php echo $entry_access['resultentry_access_id']; ?>','','','WT_result_entry_access_listing(<?= $examdetailsId ?>)')">X</span>
                                            </td>
                                        </tr>
                                    <?php
                                        if ($asession_spans[$branch_code][$entry_access["asession"]] == $asession_count) {
                                            $asession_count = 0;
                                        }
                                        if ($class_spans[$branch_code][$entry_access["asession"]][$entry_access['for_class']] == $class_count) {
                                            $class_count = 0;
                                        }
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script>
        $("#result_entry_access_form").ajaxForm((data) => {
            WT_result_entry_access_listing(<?= $examdetailsId ?>)
        });
    </script>
<?php
    exit();
}
if ($os->get("WT_save_result_entry_access") == "OK" && $os->post("WT_save_result_entry_access") == "OK") {

    $branch_code = $os->post('entry_access_branch');
    $edId = $os->post('entry_access_edId');
    $asession = $os->post("entry_access_asession");
    $for_class = $os->post('entry_access_class');
    $roll_from = $os->post('entry_access_roll_from');
    $roll_to = $os->post('entry_access_roll_to');
    $gender = $os->post('entry_access_gender');
    $date_from = $os->post('entry_access_date_from_valid');
    $date_to = $os->post('entry_access_date_to_valid');
    $teacher = $os->post('entry_access_teacher');

    $dataToSave = array();


    $dataToSave['for_class'] = $for_class;
    $dataToSave['asession'] = $asession;
    $dataToSave['teacherId'] = $teacher;
    $dataToSave['examdetailsId'] = $edId;

    $dataToSave['branch_code'] = $branch_code;
    $dataToSave['roll_from'] = $roll_from;
    $dataToSave['roll_to'] = $roll_to;
    $dataToSave['gender'] = $gender;
    $dataToSave['date_from_valid'] = $date_from;
    $dataToSave['date_to_valid'] = $date_to;

    $dataToSave['addedDate'] = $os->now();
    $dataToSave['addedBy'] = $os->userDetails["adminId"];
    $dataToSave['modifyBy'] = '0';
    $dataToSave['modifyDate'] = $os->now();


    $duplicate_query = "select * from resultentry_access where  examdetailsId='$edId' and  teacherId='$teacher' and asession='$asession' AND for_class='$for_class'";
    $resultentry_access_id = $os->isRecordExist($duplicate_query, 'resultentry_access_id');

    $qResult = $os->save('resultentry_access', $dataToSave, 'resultentry_access_id', $resultentry_access_id);
}

/********
 * Tree Listing
 */
if ($os->get('question_verification_listing') == 'OK' && $os->post('question_verification_listing') == 'OK') {

    $all_branch_list = $os->get_branches_by_access_name("Exam Summery");

    $asession = $os->post('asession');
    $classList_s = $os->post('classList_s');
    $from_date_s = $os->post('from_date_s');
    $to_date_s = $os->post('to_date_s');

    $and_dates_s = "AND TIMESTAMP(eg.exam_start_datetime)>=TIMESTAMP('$from_date_s')";
    if ($to_date_s != "") {
        $and_dates_s .= "AND TIMESTAMP(eg.exam_start_datetime)<=TIMESTAMP('$to_date_s')";
    }


    $andClass = $os->postAndQuery("classList_s", "e.class", "=");
    //branch_code
    $secondary_access = $os->get_secondary_access_by_branch_and_menu($os->post("branch_code_s"), "Exam Settings");
    if ($os->post("branch_code_s") == "") {
        $secondary_access = $global_access;
        $and_branch_code = "AND (e.branch_codes='" . $os->post("branch_code_s") . "')";
    } else {
        $and_branch_code = "AND (e.branch_codes LIKE'%" . $os->post("branch_code_s") . "%')";
    }
    if ($os->post("branch_code_s") == "all") {
        $and_branch_code = "";
    }
    //
    $and_asession = $os->postAndQuery("asession", "e.asession", "=");

        /*
     * Exam groups
     */;
    $all_exams = [];
    $exam_group_query = $os->mq("SELECT 
       DATE(eg.exam_start_datetime) as start_date, 
       eg.*, e.*,
       TIME(exam_start_datetime) AS start_time, 
       TIME(exam_end_datetime) AS end_time
    FROM exam_group eg INNER JOIN exam e ON e.examId=eg.examId WHERE 1=1 $andClass $and_branch_code $and_asession $and_dates_s order by eg.exam_start_datetime asc ");
    while ($exam_group = $os->mfa($exam_group_query)) {

        $all_exams[$exam_group['start_date']][$exam_group['exam_group_id']] = $exam_group;
    }

    print $os->query;


    echo '##--EXAM-SETTING-DATA--##';


?>
    <div>
        <?php
        foreach ($all_exams as $start_date => $exam_groups) {
        ?>
            <div>
                <h3 style="background-color: #0A246A; color: white; padding: 5px 10px" uk-sticky="offset: 100"><?= $start_date ?></h3>

                <?php foreach ($exam_groups as $eg_id => $exam_group) { ?>

                    <div class="uk-position-relative uk-card uk-card-default uk-margin uk-card-small uk-card-body">
                        <h3><?= $exam_group["exam_group_name"] ?></h3>
                        <div>
                            Exam : <span style="color: darkblue"><?= @$exam_group["examTitle"] ?></span>
                        </div>
                        <div>
                            Class :
                            <span style="color: darkblue">
                                <?= @$os->classList[$exam_group["class"]] ?>-<?= @$exam_group["asession"] ?>
                            </span>
                        </div>

                        <div>
                            Date :<span style="color: darkblue"><?= $start_date ?></span>
                        </div>

                        <div>
                            Time :
                            <span style="color: darkblue"><?= date('h:i:s a', strtotime($exam_group["exam_start_datetime"])); ?></span>
                            -
                            <span style="color: darkblue"><?= date('h:i:s a', strtotime($exam_group["exam_end_datetime"])); ?></span>

                            (
                            <?php
                            $diff = abs(strtotime($exam_group["exam_end_datetime"]) - strtotime($exam_group["exam_start_datetime"]));
                            $hour = floor($diff / 3600);
                            $min = floor(($diff - (3600 * $hour)) / 60);
                            $sec = $diff - (3600 * $hour) - (60 * $min);
                            ?>

                            <?= $hour > 0 ? $hour . "hrs" : '' ?>
                            <?= $min > 0 ? $min . "min" : '' ?>
                            <?= $sec > 0 ? $sec . "sec" : '' ?>
                            )
                        </div>
                        <?php if ($exam_group["branch_codes"] != "") { ?>
                            <div>
                                Branches : <br><?php
                                                $e_b = @json_decode($exam_group["branch_codes"]);
                                                foreach ($e_b as $b) {
                                                ?>
                                    <span style="color: darkblue; font-size: 10px"><?= $all_branch_list[$b]; ?></span><br>
                                <?php
                                                }
                                                $exam_group["branch_codes"]
                                ?>
                            </div>
                        <?php
                        } ?>
                        <div class="uk-position-absolute" style="top: -5px; left: -5px">
                            <?php
                            $date2 = date_create($exam_group["exam_start_datetime"]);
                            $date1 = date_create(date('Y-m-d H:i:s'));
                            $diff = date_diff($date1, $date2);
                            $days = $diff->format("%R%a");
                            $time = $diff->format("%h:%i:%s");
                            $class = "uk-label-warning";
                            $text = $days . " days left";
                            if ($days > 3) {
                                $class = "uk-label-success";
                            }
                            if ($days == 0) {
                                $class = "uk-label-danger";
                                $text = $time . " left";
                            }
                            if ($days < 0) {
                                $class = "uk-label-success";
                                $text = "Completed " . str_replace("-", "", $days) . " days ago";
                            }
                            ?>
                            <label class='uk-label uk-text-normal <?= $class ?>'><?= $text ?></label>

                        </div>
                        <?php if ($os->loggedUser()["adminType"] == "Super Admin") { ?>
                            <label for="question_verified_<?= $eg_id; ?>" class="uk-float-right">
                                <input type="checkbox" <?= $exam_group['question_verified'] == 'Yes' ? 'checked' : '' ?> value="Yes" id="question_verified_<?= $eg_id; ?>" onchange="if(confirm('Are you sure?')){wtosInlineEdit('question_verified_<?= $eg_id; ?>','exam_group','question_verified','exam_group_id','<?= $eg_id; ?>','','','')}else{if(this.checked){this.checked=false}else{this.checked=true}}">
                                Verify
                            </label>

                        <?php } else { ?>
                            <?= $exam_group['question_verified'] == 'Yes' ? '<span style="color: green">Verified</span>' : '<span style="color: red">Not Verified</span>' ?>
                        <?php
                        } ?>
                    </div>

                <?php
                } ?>
            </div>
        <?php
        }
        ?>
    </div>
<?php

    echo '##--EXAM-SETTING-DATA--##';

    exit();
}

//=============WRITTEN GROUPS===========//
if ($os->get('view_written_section') == 'OK' && $os->post('view_viva_details') == 'OK') {
    $examdetailsId = $os->post('examdetailsId');
    $examdetails_sections = $os->mq("SELECT * FROM examdetails_section WHERE examdetailsId='$examdetailsId'");
?>
    <div class="uk-card uk-card-default uk-card-small">
        <div class="uk-card-header">
            <h4>Written Sections</h4>
        </div>

        <div class="uk-card-body">
            <input type="hidden" name="examdetailsId" value="<?= $examdetailsId ?>">
            <input type="hidden" name="viva" id="viva_marks" value="<?= $examdetails['viva'] ?>">
            <table class="uk-table uk-table-small uk-table-divider uk-table-justify uk-margin-remove">
                <thead>
                    <tr>
                        <td>Section Name</td>
                        <td class="uk-table-shrink uk-text-nowrap">Max Attempt</td>
                    </tr>
                </thead>
                <tbody id="written_sections">
                    <?php while ($examdetails_section = $os->mfa($examdetails_sections)) { ?>
                        <tr id="written_section-<?= $examdetails_section["examdetails_section_id"] ?>">
                            <td>
                                <label>
                                    <input type="text" class="uk-input congested-form" value="<?= $examdetails_section["name"] ?>" id="examdetails_section_name_<?= $examdetails_section["examdetails_section_id"] ?>" onchange="wtosInlineEdit('examdetails_section_name_<?= $examdetails_section["examdetails_section_id"] ?>','examdetails_section','name','examdetails_section_id','<?= $examdetails_section["examdetails_section_id"] ?>','','','')">
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input type="number" class="uk-input congested-form" value="<?= $examdetails_section["max_attempt"] ?>" id="examdetails_section_max_attempt_<?= $examdetails_section["examdetails_section_id"] ?>" onchange="wtosInlineEdit('examdetails_section_max_attempt_<?= $examdetails_section["examdetails_section_id"] ?>','examdetails_section','max_attempt','examdetails_section_id','<?= $examdetails_section["examdetails_section_id"] ?>','','','')">
                                </label>
                            </td>
                            <td style="width: 40px">
                                <a class="uk-text-danger" onclick="delete_examdetails_section(<?= $examdetails_section["examdetails_section_id"] ?>)">
                                    <span uk-icon="trash"></span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <label>
                                <input type="text" id="written_section_name" class="uk-input congested-form">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="number" id="written_section_max_attempt" class="uk-input congested-form">
                            </label>
                        </td>
                        <td style="width: 40px">
                            <a class="uk-text-success" onclick="add_edit_written_section(
                            <?= $examdetailsId ?>,
                                    $('#written_section_name').val(),
                                    $('#written_section_max_attempt').val())">
                                <span uk-icon="plus"></span>
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
<?php
}


if ($os->get("add_edit_written_section") == "OK" && $os->post("add_edit_written_section") == "OK") {
    $examdetailsId = $os->post("examdetailsId");
    $name = $os->post("name");
    $max_attempt = $os->post("max_attempt");
    $examdetails_section_id = $os->post("examdetails_section_id");
    $dataToSave = [];
    $dataToSave["name"] = $name;
    $dataToSave["examdetailsId"] = $examdetailsId;
    $dataToSave["max_attempt"] = $max_attempt;

    $last_id = $os->save("examdetails_section", $dataToSave, "examdetails_section_id", $examdetails_section_id);

    $htm = '<tr>
                    <td>
                        <label>
                            <input type="text" class="uk-input congested-form" value="' . $name . '">
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="number" class="uk-input congested-form"  value="' . $max_attempt . '">
                        </label>
                    </td>
                    <td style="width: 40px">
                        <a class="uk-text-danger" onclick="$(this).closest(\'tr\').remove()">
                            <span uk-icon="trash"></span>
                        </a>
                    </td>
                </tr>';

    print $htm;
    exit();
}
if ($os->get("delete_examdetails_section") == "OK" && $os->post("delete_examdetails_section") == "OK") {
    $examdetails_section_id = $os->post("examdetails_section_id");
    if ($os->mq("DELETE FROM examdetails_section WHERE examdetails_section_id='$examdetails_section_id'")) {
        print "OK";
    } else {
        print "ERROR";
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
    $os->save("examdetails", $examdetails_to_save, "exam_group_id", $os->val($examdetails, "examdetailsId"));
    echo "Subject added successfully";
    exit();
}
