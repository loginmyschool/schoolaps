<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/

include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');
$logged_teacherId=1; //todolists
$pluginName='';
$os->loadPluginConstant($pluginName);
//teacher access
$logged_teacherId = $os->loggedUser()['adminId'];
$exam_accesses = [];
if($os->userDetails['adminType']!='Super Admin'){
    $access_query  = $os->mq("SELECT 
       ra.examdetailsId, 
       e.examTitle,
       ed.examId, 
       sub.subjectName,
       egca.class, egca.asession  FROM resultentry_access ra
    INNER JOIN examdetails ed ON ed.examdetailsId = ra.examdetailsId
    INNER JOIN subject sub ON ed.subjectId=sub.subjectId       
    INNER JOIN exam e ON e.examId=ed.examId
    INNER JOIN exam_group_class_access egca ON (egca.exam_group_id=ed.exam_group_id AND egca.class=ra.for_class)
    WHERE ra.teacherId='$logged_teacherId'");
    while($exam_access = $os->mfa($access_query)){
        $exam_accesses[$exam_access['examId']][$exam_access['examdetailsId']] = $exam_access;
    }
}
$branchCode = $os->getSession($key1='selected_branch_code');
$andBranchCode = "";
if($branchCode!=="ALL" & $branchCode!=="") {
    $andBranchCode = "AND branchCode IN ('$branchCode' ,'', 'ALL')";
}

if($os->get('WT_result_entry_listing')=='OK' && $os->post('WT_result_entry_listing')=='OK'){
    $examdetailsId = $os->post('examdetails_s');
    $examId = $os->post('exam_s');
    $class_s = $os->post('class_s');
    $asession_s = $os->post('asession_s');
    $section_s = $os->post('section_s');
    $gender_s = $os->post('gender_s');
    $order_by = $os->post("order_by_s");

    $andRollBetween = "";
    $andSection = $os->postAndQuery("section_s", "h.section","=");
    $andGender = $os->postAndQuery("gender_s", "s.gender",'=');

    $e = $os->mfa($os->mq("SELECT * FROM exam WHERE examId='$examId'"));
    $ed = $os->mfa($os->mq("SELECT ed.*, eg.exam_mode FROM examdetails ed 
        INNER JOIN exam_group eg ON eg.exam_group_id=ed.exam_group_id
        WHERE examdetailsId='$examdetailsId'"));

    $subjectId = $ed['subjectId'];
    $all_subjects = $os->get_subjects_by_class($e["class"], $asession_s);



  $qq="SELECT 
       h.roll_no,
       h.section,
       h.historyId,
       h.elective_subject_ids,
       s.studentId,
       s.name,
       s.registerNo, 
       rd.writtenMarks, 
       rd.viva, 
       IF(rd.resultsdetailsId>0,rd.resultsdetailsId,0) resultsdetailsId FROM history h 
        INNER JOIN student s ON(s.studentId=h.studentId)
        LEFT JOIN resultsdetails rd ON (rd.historyId = h.historyId AND rd.examdetailsId='$examdetailsId')
        LEFT JOIN resultentry_access raccess ON(
            raccess.examdetailsId='$examdetailsId' AND 
            raccess.teacherId='$logged_teacherId' AND 
            raccess.branch_code='$branchCode' AND 
            (raccess.section=h.section OR raccess.section='') AND 
            (raccess.gender=s.gender OR raccess.gender='') AND
            DATE(raccess.date_to_valid)>=DATE(NOW()) AND DATE(raccess.date_from_valid)<=DATE(NOW())) 
        WHERE 
              h.class='$class_s' 
          AND h.asession='$asession_s' 
          AND h.branch_code='$branchCode'
          $andRollBetween $andSection $andGender
          AND raccess.resultentry_access_id>0
        GROUP BY h.studentId ORDER BY $order_by
     ";
	  
     $result_details_query = $os->mq( $qq) ;

    //print $os->query;
    //
    $serial = 0;
	 
	 $s = $os->mfa($os->mq("SELECT * FROM subject WHERE subjectId='$subjectId'"));
	// subjectName
	  
    ?>
	 
	<div style="text-align:center; padding-top:10px;">
	<h3> <? echo $e['examTitle']; ?></h3>
	<div style="font-size:18px">  <? echo $s['subjectName']; ?></div>
	<div style="font-size:16px"> <? echo $os->classList[$e['class']]; ?> - <? echo $e['asession']; ?></div>
	<? if($ed['written']>0){ ?>
	<!--<div style="font-size:12px"> Written   <? echo $ed['written']; ?></div>-->
	<? } ?>
	<? if($ed['viva']>0){ ?>
	<!--<div style="font-size:12px"> Viva   <? echo $ed['viva']; ?></div>-->
	<? } ?>
	
	 
	 <div style="font-size:12px">Full Marks - <? echo $full_marks=$ed['written']+$ed['viva']; ?></div> 
	 
	 
	</div>
	 

    <table class="uk-table uk-table-striped " style="background-color: white"> <!--uk-table-small-->
        <thead>
            <tr>

                <th style="font-size:14px;">Name </th>
				 <th class="uk-table-shrink" nowrap="" style="font-size:14px;">Roll</th>
                <? if($ed['viva']>0){?>
                    <th class="uk-table-shrink" nowrap="" style="font-size:14px;">Viva</th>
                <?}?>
                <? if($ed['written']>0){?>
                    <th class="uk-table-shrink" nowrap="" style="font-size:14px;">Writt.</th>
                <?}?>
        </thead>
        <tbody>
        <?
        while($rd = $os->mfa($result_details_query)){
            $el = $rd['elective_subject_ids'];
            $_subjects = $os->get_subjects_with_elective($all_subjects,explode(',',$el));
            if(in_array($subjectId, $_subjects)){
            $serial++;
            ?>
            <tr rdid="<?=$rd['resultsdetailsId']?>"
                edid="<?=$examdetailsId?>"
                sid="<?=$rd['studentId']?>"
                hid="<?=$rd['historyId']?>">

                <td>
                 <b>   <?=$rd['name']?> </b>
                    <p class="text-s">Reg. No.: <i style="color: #0A246A"><?=$rd['registerNo']?></i></p>
                </td>
				 <td><?=$rd['section']?> <?=$rd['section']!=""?"/":""?> <?=$rd['roll_no']?></td>


                <? if($ed['viva']>0){?>
                    <td>
                        <input  class="uk-input congested-form uk-border-rounded"
                                type="number"
                                max="<?=$ed['viva']?>"
                                <?=$ed['viva_fields']!=""?'readonly':""?>
                                id="viva_<?=$examdetailsId?>_<?=$rd['historyId']?>"
                                style="width: 50px"
                                value="<?=$rd['viva']?>"
                                onchange="save_marks(this, 'viva')"
                                onfocusin="<?if($ed['viva_fields']!=""){?>
                                        edit_viva_mark(
                                            <?=$examdetailsId?>,
                                            <?=$rd['historyId']?>
                                        )
                                <?}?>" >
                    </td>
                <?} ?>
                <? if($ed['written']>0){?>
                    <td>
                        <input style="letter-spacing:1px;" <?if($ed['exam_mode']=='Online'){?>readonly<?}?>
                               onchange="save_marks(this, 'written')"
                               type="text"
                               max="<?=$ed['written']?>"
                               style="width: 50px"
                               class="uk-input congested-form uk-border-rounded"
                               value="<?=$rd['writtenMarks']?>">
                    </td>
                <?}?>
            </tr>
            <?
            }
        }
        ?>
        </tbody>
    </table>
    <?
    exit();
}
//selectbox query
if($os->get('get_exam_by_class')=='OK' && $os->post('get_exam_by_class')=='OK')
{
    $class_s = $os->post('class_s');
    $asession_s = $os->post('asession_s');

    $sql = "SELECT * FROM exam WHERE exam.class='$class_s' AND asession='$asession_s' AND branchCode IN('$branchCode', 'ALL','')";
    $query = $os->mq($sql);
    ?>
    <option value="">--SELECT EXAM--</option>
    <?
    while ($item = $os->mfa($query)){
        if(key_exists($item['examId'],$exam_accesses)){
            ?>
            <option value="<?=$item['examId']?>"><?=$item['examTitle']?></option>
            <?
        }
    }

    exit();

}
if($os->get('get_subjects_by_exam')=='OK' && $os->post('get_subjects_by_exam')=='OK')
{
    $examId = $os->post('exam_s');

    $sql = "SELECT ed.examdetailsId, s.subjectName, s.subjectId FROM examdetails ed 
        INNER JOIN subject s ON(ed.subjectId=s.subjectId)
        WHERE ed.examId='$examId'  ";

    _d($sql);
    $query = $os->mq($sql);
    ?>
    <option value="">--SELECT SUBJECT--</option>
    <?
    while ($item = $os->mfa($query)){
        if(key_exists($item['subjectId'],$exam_accesses[$examId])){
            ?>
            <option value="<?=$item['examdetailsId']?>"><?=$item['subjectName']?></option>
            <?
        }
    }

    exit();

}
///
if($os->get('edit_viva_details')=='OK' && $os->post('edit_viva_details')=='OK'){
    $examdetailsId = $os->post('examdetailsId');
    $historyId = $os->post('historyId');
    $ed = $os->mfa($os->mq("SELECT * FROM examdetails ed INNER JOIN subject s ON(ed.subjectId=s.subjectId) WHERE ed.examdetailsId='$examdetailsId'"));
    $rd = $os->mfa($os->mq("SELECT * FROM resultsdetails WHERE examdetailsId='$examdetailsId' AND historyId='$historyId'"));
    $s = $os->mfa($os->mq("SELECT * FROM history h
        INNER JOIN student s ON(h.studentId=s.studentId)
        WHERE h.historyId='$historyId'"));

    $viva_details = @unserialize($ed['viva_fields']);
    $viva_marks = @unserialize($rd['viva_fields_marks']);
    $classes = 'uk-input uk-border-rounded congested-form';
    ?>
    <div class="uk-padding">
        <form id="sub_exam_viva_marks_form" onsubmit="save_viva_marks">
            <h3>Viva/Internal Marks Entry</h3>
            <input type="hidden" name="examdetailsId" value="<?=$examdetailsId?>">
            <input type="hidden" name="historyId" value="<?=$historyId?>">
            <table class="uk-table congested-table uk-table-striped">
                <thead>
                <tr>
                    <td>Title</td>
                    <td>Marks</td>
                    <td class="uk-table-shrink">F.M</td>
                </tr>
                </thead>
                <?
                $fm = 0;
                foreach ($viva_details as $viva_key => $viva_detail){
                    $fm+=$viva_detail['marks'];
                    ?>
                    <!--1st lavel-->
                    <tr>
                        <td class="uk-text-bold">
                            <input type="hidden"
                                   name="exam_viva_details[<?=$viva_key?>][title]"
                                   value="<?=$viva_detail['title']?>">
                            <?=$viva_detail['title']?>
                        </td>
                        <td class="uk-table-shrink">
                            <?if(is_array($viva_detail['sub_head'])){?>
                                <input class="uk-text-bold uk-text-success mark_input text-m"
                                       type="text"
                                       readonly
                                       style="width:50px; border: none;padding: 0; background-color: transparent;
                                       outline: none"
                                       name="exam_viva_details[<?=$viva_key?>][marks]"
                                       id="mark_input_<?=$viva_key?>"
                                       value="<?=$viva_marks[$viva_key]['marks']?>"
                                       max="<?=$viva_detail['marks']?>"
                                       onchange="calculate_marks('.mark_input', '#viva_marks');">
                            <?} else {?>
                                <input class="<?=$classes?> uk-text-bold uk-text-success mark_input"
                                       type="number"
                                       style="width:50px"
                                       placeholder="Marks"
                                       name="exam_viva_details[<?=$viva_key?>][marks]"
                                       id="mark_input_<?=$viva_key?>"
                                       value="<?=$viva_marks[$viva_key]['marks']?>"
                                       max="<?=$viva_detail['marks']?>"
                                       onchange="calculate_marks('.mark_input', '#viva_marks');">

                            <? }?>
                        </td>
                        <td>
                            <?=$viva_detail['marks']?>
                        </td>
                    </tr>
                    <?
                    if(is_array($viva_detail['sub_head'])){
                        $sub_details = $viva_detail['sub_head'];
                        ?>

                        <?foreach ($sub_details as $sub_key=>$sub_detail){?>
                            <tr>
                                <td style="padding-left: 25px!important;">
                                    <input type="hidden"
                                           name="exam_viva_details[<?=$viva_key?>][sub_head][<?=$sub_key?>][title]"
                                           value="<?=$sub_detail['title']?>">
                                    <?=$sub_detail['title']?>
                                </td>
                                <td>
                                    <input class="<?=$classes?> mark_input_child_<?=$viva_key?>"
                                           type="number"
                                           placeholder="Marks"
                                           style="width:50px"
                                           onchange="calculate_marks('.mark_input_child_<?=$viva_key?>', '#mark_input_<?=$viva_key?>')"
                                           name="exam_viva_details[<?=$viva_key?>][sub_head][<?=$sub_key?>][marks]"
                                           max="<?=$sub_detail['marks']?>"
                                           value="<?=$viva_marks[$viva_key]['sub_head'][$sub_key]['marks']?>">
                                </td>
                                <td>
                                    <?=$sub_detail['marks']?>
                                </td>
                            </tr>
                        <?} ?>
                    <?}?>
                <?} ?>
                <tr>
                    <td class="text-l uk-text-bold">Total</td>
                    <td class="text-l uk-table-shrink">
                        <input style="border: none; outline: none; width: 50px; padding: 0" readonly
                               type="text" id="viva_marks"
                               name="viva"
                               class="text-l uk-text-bold"
                               value="<?=$rd['viva']?>">
                    </td>
                    <td class="text-l uk-text-bold uk-table-shrink"><?=$fm?></td>
                </tr>
            </table>
            <button type="submit"
                    onclick="calculate_marks('#viva_marks', '#viva_<?=$examdetailsId?>_<?=$historyId?>')"
                    class="uk-button congested-form uk-secondary-button uk-border-rounded">Save</button>
        </form>
    </div>
    <?
    exit();
}
if($os->get('save_exam_marks_details')=='OK' && $os->post('save_exam_marks_details')=='OK') {
    $details = $os->post('exam_viva_details');
    $examdetailsId = $os->post('examdetailsId');
    //$studentId = $os->post('studentId');
    $historyId = $os->post('historyId');
    $viva = $os->post('viva');
    $details = serialize($details);

    $ed = $os->mfa($os->mq("SELECT * FROM examdetails ed INNER JOIN subject s ON(ed.subjectId=s.subjectId) WHERE ed.examdetailsId='$examdetailsId'"));
    $s = $os->mfa($os->mq("SELECT * FROM history h
        INNER JOIN student s ON(h.studentId=s.studentId)
        WHERE h.historyId='$historyId'"));

    $rd = $os->mfa($os->mq("SELECT DISTINCT * FROM resultsdetails 
            WHERE examdetailsId='$examdetailsId' AND historyId='$historyId'"));
    $rdId = isset($rd['resultsdetailsId'])?$rd['resultsdetailsId']:0;

    $dataToSave = [];
    $dataToSave['viva_fields_marks'] = $details;
    $dataToSave['examdetailsId'] = $examdetailsId;
    $dataToSave['viva'] = $viva;
    $dataToSave['examId'] = $ed['examId'];
    $dataToSave['historyId'] = $s['historyId'];
    $id = $os->save('resultsdetails', $dataToSave,'resultsdetailsId', $rdId);

    print $id;
}

//save marks
if($os->get('save_marks')=='OK' && $os->post('save_marks')=='OK') {
    $examdetailsId = $os->post('edid');
    $historyId = $os->post('hid');
    $type = $os->post('type');
    $marks = $os->post('marks');


    $ed = $os->mfa($os->mq("SELECT * FROM examdetails ed INNER JOIN subject s ON(ed.subjectId=s.subjectId) WHERE ed.examdetailsId='$examdetailsId'"));
    $s = $os->mfa($os->mq("SELECT * FROM history h
        INNER JOIN student s ON(h.studentId=s.studentId)
        WHERE h.historyId='$historyId'"));

    $rd = $os->mfa($os->mq("SELECT DISTINCT * FROM resultsdetails 
            WHERE examdetailsId='$examdetailsId' AND historyId='$historyId'"));
    $rdId = isset($rd['resultsdetailsId'])?$rd['resultsdetailsId']:0;
    ///
    $eId = $ed['examId'];

    ///SAVE RESULT DETAILS
    $dataToSave = [];
    switch ($type){
        case 'viva':
            $dataToSave['viva'] = $marks;
            $dataToSave['totalMarks'] = $marks+($rd['writtenMarks']?$rd['writtenMarks']:0);
            break;
        case 'written':
            $dataToSave['writtenMarks'] = $marks;
            $dataToSave['totalMarks'] = $marks+($rd['viva']?$rd['viva']:0);
            break;
    }

    $dataToSave["percentage"] = ($dataToSave["totalMarks"]/$ed["totalMarks"])*100;

    $dataToSave['examdetailsId'] = $examdetailsId;
    $dataToSave['examId'] = $ed['examId'];
    $dataToSave['historyId'] = $historyId;
    $id = $os->save('resultsdetails',$dataToSave,'resultsdetailsId',$rdId);
    print $id;
}





