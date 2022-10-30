<?

/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/
ini_set("memory_limit", "-1");
set_time_limit(0);
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');
$logged_teacherId=1; //todolists
$pluginName='';
$os->loadPluginConstant($pluginName);

if($os->get("get_asession_by_branch_code")=="OK" && $os->post("get_asession_by_branch_code")=="OK" ){
    $branch_code_s=$os->post('branch_code_s');
    $branch_code_s = "(e.branch_codes LIKE '%$branch_code_s%' OR e.branch_codes='')";
    $query = $os->mq("SELECT  DISTINCT egca.asession FROM exam_group_class_access egca 
        INNER JOIN exam_group eg on egca.exam_group_id = eg.exam_group_id AND eg.question_verified='Yes'
        INNER JOIN exam e on eg.examId = e.examId 
        WHERE $branch_code_s AND e.publish_result!='Yes'");

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
    $branch_code_s = "(e.branch_codes LIKE '%$branch_code_s%' OR e.branch_codes='')";
    $exams_q = $os->mq("SELECT  DISTINCT egca.class FROM exam_group_class_access egca 
        INNER JOIN exam_group eg on egca.exam_group_id = eg.exam_group_id AND eg.question_verified='Yes'
        INNER JOIN exam e on eg.examId = e.examId
        WHERE $branch_code_s AND egca.asession='$asession_s' AND e.publish_result!='Yes'");

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
    $branch_code_s=$os->post('branch_code_s');
    $asession_s=$os->post('asession_s');
    $branch_code_s = "(e.branch_codes LIKE '%$branch_code_s%' OR e.branch_codes='')";
    $class_s=$os->post('class_s');
    $exams_q = $os->mq("SELECT  e.examId, e.examTitle, IF(e.branch_codes='','GLOBAL', 'LOCAL') as type FROM exam_group_class_access egca 
        INNER JOIN exam_group eg on egca.exam_group_id = eg.exam_group_id AND eg.question_verified='Yes'
        INNER JOIN exam e on eg.examId = e.examId
        WHERE $branch_code_s AND egca.asession='$asession_s' AND egca.class='$class_s' AND e.publish_result!='Yes'  GROUP BY e.examId") ;
    ?>
    <option value=""></option>
    <?
    while($exam = $os->mfa($exams_q))
    {
        ?>
        <option value="<?= $exam['examId']; ?>"> <?= $exam['examTitle'] ?> [<?=$exam["type"]?>]  </option>
        <?
    }
    exit();

}

if($os->get('get_exam_group_by_exam')=='OK' && $os->post('get_exam_group_by_exam')=='OK')
{

    $exam_s=$os->post('exam_s');
    $exams_group_q = $os->mq("SELECT eg.* FROM exam_group eg 
        WHERE  eg.examId='$exam_s' AND eg.question_verified='Yes'") ;
    ?>
    <option value=""></option>
    <?
    while($exam_group = $os->mfa($exams_group_q))
    {
        ?>
        <option  name="" value="<?= $exam_group['exam_group_id']; ?>"> <?= $exam_group['exam_group_name'] ?>  </option>
        <?
    }
    exit();

}



if($os->get('WT_result_entry_listing')=='OK' && $os->post('WT_result_entry_listing')=='OK') {
    $branch_code_s = $os->post("branch_code_s");
    $examId = $os->post('exam_s');
    $exam_group_s = $os->post('exam_group_s');
    $class_s = $os->post('class_s');
    $asession_s = $os->post('asession_s');
    $registerNo_s = $os->post("registerNo_s");
    $order_by = $os->post("order_by_s");

    $andregisterNo_s = $os->postAndQuery("registerNo_s", "h.registrationNo", "=");

    $histories = $os->mq("SELECT h.*,s.*, egh.question_set, egh.exam_mode FROM history h 
        INNER JOIN student s on h.studentId = s.studentId
        LEFT JOIN exam_group_history egh on h.historyId = egh.historyId AND egh.exam_group_id='$exam_group_s'
        WHERE h.class='$class_s' AND h.asession='$asession_s' AND h.branch_code='$branch_code_s' $andregisterNo_s");
    //
    if ($os->loggedUser()["adminType"] == "Super Admin") {

        //print  $os->query;
    }
    $serial = 0;
    ?>

        <? if ($os->loggedUser()["adminType"] == "Super Admin"):?>
    <form target="_blank" method="post" enctype="multipart/form-data" action="<?= $site["url-wtos"]?>answer_entry_ajax.php?xlsx_import=OK">
        <input type="number" value="<?=$exam_group_s?>" name="exam_group_id">
        <input type="file"  name="xlsx" required>
        <button type="submit" name="xlsx_import" value="OK">XLSX IMPORT</button>
    </form>
    <?endif;?>

    <table class="uk-table uk-table-striped uk-table-small" style="background-color: white">
        <thead>
        <tr>
            <th>Name </th>
            <th class="uk-table-shrink" nowrap="">Roll</th>
            <th class="uk-table-shrink">sheet</th>
            <th class="uk-table-shrink" nowrap="">Entry</th>
        </tr>
        </thead>
        <tbody>
        <?
        while($history = $os->mfa($histories)){

            if ($history["exam_mode"]=="Online"){
                continue;
            }
            $serial++;
            ?>
            <tr sid="<?=$history['studentId']?>"
                hid="<?=$history['historyId']?>">

                <td>
                    <?=$history['name']?>
                    <p class="text-s">Reg. No.: <i style="color: #0A246A"><?=$history['registerNo']?></i></p>
                </td>
                <td><?=$history['roll_no']?></td>

                <td>
                    <select id="question_set_<?=$history["historyId"]?>"
                            onchange="save_question_set(this.value, '<?=$history["historyId"]?>', '<?= $exam_group_s?>')">
                        <option></option>
                        <option <?=$history["question_set"]==1?"selected":""?> value="1">A</option>
                        <option <?=$history["question_set"]==2?"selected":""?> value="2">B</option>
                        <option <?=$history["question_set"]==3?"selected":""?> value="3">C</option>
                        <option <?=$history["question_set"]==4?"selected":""?> value="4">D</option>
                    </select>
                </td>
                <td>
                    <a
                            onclick="open_omr_sheet(<?=$history["historyId"]?>, <?=$history["studentId"]?>, <?=$exam_group_s?>, os.getVal('question_set_<?=$history["historyId"]?>'))">Sheet</a>
                </td>

            </tr>
            <?

        }
        ?>
        </tbody>
    </table>
    <?
    exit();
}

//OMR SHEET
if($os->post("open_omr_sheet")=="OK" && $os->get("open_omr_sheet")){
    $historyId = $os->post("hId");
    $studentId = $os->post("sId");
    $exam_group_id = $os->post("egId");
    $set = $os->post("set");

    //
    $student = $os->mfa($os->mq("SELECT * FROM history h INNER JOIN student s on h.studentId = s.studentId WHERE h.historyId='$historyId'"));


    $examdetailses = $os->mfa($os->mq("SELECT GROUP_CONCAT('\'',examdetailsId,'\'') as eds FROM examdetails WHERE exam_group_id='$exam_group_id'"))["eds"];
    $questions = $os->mq("SELECT q.*, qps.view_order, ed.examId FROM question q 
        INNER JOIN examdetails ed ON ed.examdetailsId=q.examdetailsId 
        INNER JOIN question_paper_set qps on q.questionId = qps.question_id AND qps.set_no='$set'
    WHERE ed.examdetailsId IN ($examdetailses) ORDER BY qps.view_order ASC");

    if(!file_exists(ANSWERS_PATH."/".$studentId.".json")){
        file_put_contents(ANSWERS_PATH."/".$studentId.".json","{}");
    }
    $answers = (array)@json_decode(file_get_contents(ANSWERS_PATH."/".$studentId.".json"));
    ?>
    <button class="uk-modal-close-default" type="button" uk-close></button>
    <div class="uk-card uk-card-small uk-card-default">
        <div class="uk-card-header">
            <h4>Answer sheet of <?=$student["name"]?></h4>
        </div>
        <ul class="uk-subnav uk-subnav-pill uk-margin-remove uk-background-muted uk-hidden">
            <li class="<?=$set=="1"?"uk-active":""?>"><a onclick="open_omr_sheet(<?=$historyId?>, <?=$studentId?>, <?=$exam_group_id?>, set='1')">SET A</a></li>
            <li class="<?=$set=="2"?"uk-active":""?>"><a onclick="open_omr_sheet(<?=$historyId?>, <?=$studentId?>, <?=$exam_group_id?>, set='2')">SET B</a></li>
            <li class="<?=$set=="3"?"uk-active":""?>"><a onclick="open_omr_sheet(<?=$historyId?>, <?=$studentId?>, <?=$exam_group_id?>, set='3')">SET C</a></li>
            <li class="<?=$set=="4"?"uk-active":""?>"><a onclick="open_omr_sheet(<?=$historyId?>, <?=$studentId?>, <?=$exam_group_id?>, set='4')">SET D</a></li>
        </ul>
        <div class="uk-card-body uk-overflow-auto" style="height: calc(100vh - 250px)">
            <table class="uk-width-1-1 uk-margin">
                <?
                $count=0;
                $checker = [];
                while($question = $os->mfa($questions)){$count++;
                    $answer = @$answers[$question["questionId"]];
                    ?>
                    <tr id="answer_container_<?=$count?>">
                        <td valign="top"
                            class="p-bottom-l p-right-l uk-table-shrink uk-text-bold text-m"
                            style="color: #0A246A"><?=$question["view_order"]?>.</td>
                        <td valign="top" class="p-bottom-l uk-text-bold text-m" style="color: #000">
                            <?=$question['questionText']?>
                            <table class="m-top-l m-bottom-m text-s answer-container-<?=$question["questionId"]?>"
                                   style="color: #333; font-weight: normal;  border-collapse: collapse">
                                <?
                                $check = false;
                                for($xxx=1;$xxx<=4;$xxx++){
                                    $radioName="ans_".$question["questionId"]."_".$xxx;
                                    if($answer==$xxx){$check=true;};
                                    ?>
                                    <tr style="">
                                        <td>
                                            <input
                                                <?=$answer==$xxx?"checked":""?>
                                                    type="checkbox" name="" value="<?=$xxx?>"
                                                    onchange="attempt(<?=$question["questionId"]?>, this)"
                                                    onclick="answer_by_student('<?=$studentId?>','<?=$historyId?>','<?= $radioName ?>','<?= $question["questionId"] ?>','<?= $question["examdetailsId"] ?>','<?= $exam_group_id ?>','<?= $question["examId"] ?>', '<?=$count?>')"
                                                    id="<?=$radioName ?>">
                                        </td>
                                        <td class="p-right-m p-left-m"><?=$xxx?>.</td>
                                        <td >
                                            <?=$question['answerText'.$xxx]?>
                                            <? if($question['answerImage'.$xxx]){?>
                                                <img src="<?=$site['url'].$question['answerImage'.$xxx]?>">
                                            <? } ?>
                                        </td>
                                    </tr>
                                <?}
                                $checker[$count] = $check;
                                ?>
                            </table>
                        </td>
                    </tr>
                    <?
                }
                ?>
            </table>
        </div>
        <div style="font-size: 0" id="matrix_container">
            <?$x=1; while ($x<=$count){?>
                <a class="matrix-checkbox" href="#answer_container_<?=$x?>" id="matrix_content_<?=$x?>">

                    <input <?= $checker[$x]?"checked":""?> type="checkbox"
                                                           content="<?=$x?>"
                                                           disabled>
                    <div><?=$x?></div>

                </a>
                <?$x++;}?>
        </div>
    </div>
    <style>
        .matrix-checkbox{
            position: relative;
            display: inline-block;
        }
        .matrix-checkbox input{

            position: relative;
            height: 20px;
            width: 20px;
        }
        .matrix-checkbox input+div{
            position: absolute;
            top: 0;
            left: 0;
            background-color: #dead1b;
            color: #fff;
            height: 20px;
            width: 20px;
            font-size: 10px;
            border: 1px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .matrix-checkbox input+div:hover{
            opacity: 0.9;
        }
        .matrix-checkbox input:checked+div{
            background-color: #0A246A;
        }
    </style>
    <?

}

//save question sheet
if($os->post("save_question_sheet")=="OK" &&$os->get("save_question_sheet")=="OK"){
    $sheet = $os->post("sheet");
    $hId = $os->post("hId");
    $eg_id = $os->post("eg_id");

    $exam_group_history_id = @$os->mfa($os->mq("SELECT * FROM exam_group_history egh WHERE exam_group_id='$eg_id' AND historyId='$hId'"))["exam_group_history_id"];

    $datatosave = array(
        "exam_group_id"=>$eg_id,
        "historyId"=>$hId,
        "question_set"=>$sheet,
        "exam_mode"=>'Offline'
    );
    $os->save("exam_group_history", $datatosave, "exam_group_history_id", $exam_group_history_id);
    print "Successfully saved data";
}



//xlsx import
if($os->post("xlsx_import")=="OK"&&$os->get("xlsx_import")=="OK"){

    $exam_group_id = $os->post("exam_group_id");
    $file = $_FILES["xlsx"]["tmp_name"];
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = [];

    $reg_cell = 3;
    $test_center_cell = 247;
    $set_no_cell = 4;
    $barcode_cell = 2;
    $ans_cell = [5, 244];

    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        $count = 0;
        $qno = 0;
        foreach ($cellIterator as $cell) {
            $count++;
            if ($count==$reg_cell){
                $cells["reg_no"] = (string)$cell->getValue();

            }
            /*
            if ($count==$test_center_cell){
                $cells["test_center"] = (string)$cell->getValue();
            }
            */
            if ($count==$set_no_cell){
                $set='';
                switch ($cell->getValue()){
                    case "A":
                        $set=1;
                        break;
                    case "B":
                        $set=2;
                        break;
                    case "C":
                        $set=3;
                        break;
                    case "D":
                        $set=4;
                        break;
                }
                $cells["set_no"] = $set;
            }
            if ($count>=$ans_cell[0] && $count<=$ans_cell[1]){
                $qno++;
                $cells["answers"][$qno] = (string)$cell->getValue();

            }

            if ($count==$barcode_cell){
                $cells["barcode"] = (string)$cell->getValue();
            }

        }
        $rows[] = $cells;
    }




    $students=[];
    $students_q = $os->mq("SELECT h.registrationNo, h.studentId, h.historyId FROM history h WHERE concat(h.asession,'_',h.class) IN(SELECT CONCAT(egca.asession,'_',egca.class) FROM exam_group_class_access egca WHERE egca.exam_group_id='$exam_group_id' )");
    while ($student = $os->mfa($students_q)){
        $students[$student["registrationNo"]] = $student;
    }

    //
    $question_sets = [];
    $questions_q = $os->mq("SELECT qps.set_no, qps.question_id, qps.view_order FROM question_paper_set qps WHERE qps.examdetailsId IN (SELECT ed.examdetailsId FROM examdetails ed WHERE ed.exam_group_id='$exam_group_id') ORDER BY qps.view_order ASC");
    while ($q = $os->mfa($questions_q)){
        $question_sets[$q["set_no"]][$q["view_order"]] = $q["question_id"];
    }
    //
    $c=0;
    $invaliddata = [];
    foreach($rows as $row){
        if($row["reg_no"][1]!=0){
            $row["reg_no"] = ltrim($row["reg_no"],'N');
        }
        $row["reg_no"] = ltrim($row["reg_no"],'0');

        $reg_no = str_replace("N0", "N", $row["reg_no"]);
        $row["reg_no"] = isset($students[$reg_no])?$reg_no:str_replace("N0", "", $row["reg_no"]);
        $reg_no = $row["reg_no"];

        if (!isset($students[$reg_no])){
            unset($row["answers"]);
            $invaliddata[] = $row;
            continue;
        }
        $sId  = $students[$reg_no]["studentId"];
        $hId  = $students[$reg_no]["historyId"];
        $answerfile = ANSWERS_PATH."/".$sId.".json";
        if(!file_exists($answerfile)){
            file_put_contents($answerfile, "{}");
        }
        if (!isset($question_sets[$row["set_no"]])){
            unset($row["answers"]);
            $invaliddata[] = $row;
            continue;
        }

        $answers = @json_decode(file_get_contents($answerfile));



        $questions = $question_sets[$row["set_no"]];
        foreach ($row["answers"] as $key => $ans){
            $qId = @$questions[$key];
            if ($qId<=0 || $qId=='' || $ans==""){continue;}
            $answers->$qId = $ans;
        }

        //save answer sheet
        $exam_group_history_id = @$os->mfa($os->mq("SELECT * FROM exam_group_history egh WHERE exam_group_id='$exam_group_id' AND historyId='$hId'"))["exam_group_history_id"];

        $datatosave = array(
            "exam_group_id"=>$exam_group_id,
            "historyId"=>$hId,
            "question_set"=>$row["set_no"],
            "exam_mode"=>'Offline'
        );
        $answers = @json_encode($answers);
        $os->save("exam_group_history", $datatosave, "exam_group_history_id", $exam_group_history_id);
        file_put_contents($answerfile, $answers);

    }


    _d($invaliddata);
    exit();
}




if ($os->get("remove_omr")=="OK") {
    $eg_id = $os->get("eg_id");
    if ($eg_id == "") {
        die("Please enter id");
    }
    //
    $edIdsIn = $os->mfa($os->mq("SELECT GROUP_CONCAT(examdetailsId) AS ids FROM examdetails WHERE exam_group_id='$eg_id'"))["ids"];
    $os->mq("DELETE FROM resultsdetails WHERE examdetailsId IN($edIdsIn)");
    //
    $students = [];
    $students_q = $os->mq("SELECT h.*, egh.exam_group_history_id  FROM exam_group_history egh 
        INNER JOIN history h ON h.historyId=egh.historyId WHERE exam_mode='Offline' AND exam_group_id='$eg_id'");
    while($student =$os->mfa($students_q)){
        $students[$student["studentId"]] = $student["studentId"].".json";
        $os->mq("DELETE  FROM exam_group_history WHERE exam_group_history_id='".$student["exam_group_history_id"]."'");
    }

    $files = $students;
    $questions = [];
    $questions_q = $os->mq("SELECT q.* FROM question q WHERE q.examdetailsId IN(SELECT ed.examdetailsId FROM examdetails ed WHERE  ed.exam_group_id='$eg_id')");
    while($question = $os->mfa($questions_q)){
        $questions[$question["questionId"]] = $question;
    };
    foreach ($files as $sId=>$file){
        $filename = ANSWERS_PATH."/".$file;

        $answers = json_decode(file_get_contents($filename));
        $has = false;
        foreach ($questions as $questionId=>$question){
            if(isset($answers->$questionId)){
                unset($answers->$questionId);
                $has=true;
            }
        }

        if ($has){
            $answers = json_encode($answers);
            file_put_contents($filename, $answers);
            chmod($filename, 0777);
            print $sId."<br>";
        }


    }


    exit();
}

