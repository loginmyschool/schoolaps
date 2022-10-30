<?

include('wtosConfigLocal.php');

global $os, $site;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include($site['root-wtos'].'wtosCommon.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pluginName='';
$os->loadPluginConstant($pluginName);
$admin_access = $os->branch_access();
$admin_type = $os->loggedUser()["adminType"];
function sanitize_key($key){
    $key = str_replace([" ","-","~",",",".", "/"],"", $key);
    return "KEY_".$key;
}
$branches = $os->get_branches();
if($os->get("WT_fetch_list")=="OK" && $os->post("WT_fetch_list")=="OK"){
    $eg_id = $os->post("exam_group_id");

    $and_branches_code_IN = $admin_type=="Super Admin"?"":"AND h.branch_code ".$admin_access["branches_code_IN"];
    $eg = $os->mfa($os->mq("SELECT eg.*, e.asession, e.class FROM exam_group eg 
        INNER JOIN exam e ON e.examId=eg.examId
        WHERE exam_group_id='$eg_id'"));

    //return datetime
    $exam_end_datetime = strtotime($eg['exam_end_datetime']);

    echo "##EXAM_OVER##";
    if($exam_end_datetime<time()){
        print "Yes";
    } else {
        print "No";
    }
    echo "##EXAM_OVER##";

    //

    $asession_class = $os->mfa($os->mq("SELECT GROUP_CONCAT(CONCAT('\'',egca.asession,'_',egca.class, '\'')) asession_class FROM exam_group_class_access egca WHERE exam_group_id='$eg_id'"))["asession_class"];

    $eg_h_q = $os->mq("SELECT 
       s.name,
       s.mobile_student,
       s.registerNo,
       h.studentId,
       h.historyId, 
       h.branch_code, 
       h.class, 
       egh.exam_group_history_id,
       egh.exam_start_time, 
       egh.submit_paper, 
       egh.submit_time,
       egh.exam_mode
    FROM history h  
        LEFT JOIN exam_group_history egh ON (h.historyId= egh.historyId AND egh.exam_group_id='$eg_id')
        INNER JOIN student s ON s.studentId=h.studentId
    WHERE CONCAT(h.asession,'_',h.class) IN($asession_class)  AND h.class!='80'  GROUP BY h.historyId ORDER BY egh.exam_group_history_id DESC");

    $os->setSession($os->query, "online_exam_attendance_query");

    $exam_group_histories = [];
    $exam_all = [];
    $counter = [];
    while ($egh = $os->mfa($eg_h_q)){

        $exam_group_histories[$egh["branch_code"]][$egh["class"]][$egh["historyId"]]= $egh;
        $exam_group_histories[$egh["branch_code"]]["All"][$egh["historyId"]]= $egh;

        if($egh["exam_group_history_id"]!="") {
            $counter[$egh["branch_code"]][$egh["class"]]["attended"] = isset($counter[$egh["branch_code"]][$egh["class"]]["attended"])?$counter[$egh["branch_code"]][$egh["class"]]["attended"]+1:1;
            $counter[$egh["branch_code"]]["All"]["attended"] = isset($counter[$egh["branch_code"]]["All"]["attended"])?$counter[$egh["branch_code"]]["All"]["attended"]+1:1;
            $counter["All"]["All"]["attended"] = isset($counter["All"]["All"]["attended"])?$counter["All"]["All"]["attended"]+1:1;
            $counter["All"][$egh["class"]]["attended"] = isset($counter["All"][$egh["class"]]["attended"])?$counter["All"][$egh["class"]]["attended"]+1:1;
        } else if($egh["exam_group_history_id"]=="") {
            $counter[$egh["branch_code"]][$egh["class"]]["absent"] = isset($counter[$egh["branch_code"]][$egh["class"]]["absent"])?$counter[$egh["branch_code"]][$egh["class"]]["absent"]+1:1;
            $counter[$egh["branch_code"]]["All"]["absent"] = isset($counter[$egh["branch_code"]]["All"]["absent"])?$counter[$egh["branch_code"]]["All"]["absent"]+1:1;
            $counter["All"]["All"]["absent"] = isset($counter["All"]["All"]["absent"])?$counter["All"]["All"]["absent"]+1:1;
            $counter["All"][$egh["class"]]["absent"] = isset($counter["All"][$egh["class"]]["absent"])?$counter["All"][$egh["class"]]["absent"]+1:1;
        }
        //for all
        $exam_all[$egh["class"]][$egh["historyId"]]= $egh;
        $exam_all["All"][$egh["historyId"]]= $egh;
    }
    ksort($exam_group_histories);
    $exam_group_histories = array_reverse($exam_group_histories);
    $exam_group_histories["All"] = $exam_all;
    $exam_group_histories = array_reverse($exam_group_histories);



    echo "##LIST_OF_DATA##";
    ?>
    <div class="uk-padding-small">
        <div class="uk-grid uk-grid-small" uk-grid>
            <div class="uk-width-auto">
                <div class="uk-card  uk-card-default">

                    <ul class="uk-list">
                        <?
                        $branch_link_class = "uk-background-primary uk-light";
                        foreach ($exam_group_histories as $branch_code=>$class_history){
                            if ($branch_code==""){
                                continue;
                            }
                            ?>
                            <li class="uk-parent branch_link pointable p-s p-right-l uk-margin-remove <?=$branch_link_class;?>"
                                onclick="change_branch('<?=sanitize_key($branch_code)?>')"
                                id="branch_link_<?=sanitize_key($branch_code)?>">
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td class="p-left-l">
                                            <?
                                            if($branch_code==""){
                                                print "";
                                            } else {
                                                if(isset($branches[$branch_code]['branch_name'])) {
                                                    print $branches[$branch_code]['branch_name'];
                                                }
                                            }
                                            ?><br>
                                            <small style="color: darkblue; font-size: 10px">[<?=$branch_code?>]</small>
                                        </td>
                                        <td class="uk-table-shrink uk-text-nowrap p-right-l p-left-l">

                                                (
                                                <span class="uk-text-success"><?= isset($counter[$branch_code]['All']["attended"])?$counter[$branch_code]['All']["attended"]:0; ?></span>
                                                |
                                                <span class="uk-text-danger"><?= isset($counter[$branch_code]['All']["absent"])?$counter[$branch_code]['All']["absent"]:0; ?></span>
                                                )
                                                <a href="report_online_exam_group_attendance_ajax.php?WT_download_pdf=OK&branch_code=<?=$branch_code?>&class=All&eg_id=<?=$eg_id?>"
                                                   uk-icon="file-text"></a>


                                        </td>
                                    </tr>
                                </table>
                            </li>
                            <hr class="uk-margin-remove">
                            <?
                            $branch_link_class = "";
                        }
                        ?>
                    </ul>

                </div>
            </div>
            <div class="uk-width-expand" id="branch_container">
                <?
                $branch_wrapper_class = "";
                foreach ($exam_group_histories as $branch_code=>$class_history){
                    if ($branch_code==""){
                        continue;
                    }
                    ?>
                    <div id="<?= sanitize_key($branch_code)?>" class="branch_wrapper <?= $branch_wrapper_class; ?>">
                        <?
                        ksort($class_history);

                        ?>
                        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                            <?
                            if(sizeof($class_history)==2){
                                unset($class_history["All"]);
                            }
                            foreach ($class_history as $class=>$histories){
                                ?>
                                <li class="uk-border-rounded">
                                    <a class="uk-text-bolder">
                                        <?=$class!="All"?$os->classList[$class]:$class;?>
                                        (<label class="uk-text-success uk-text-bolder">
                                            <span class="uk-text-success"><?= isset($counter[$branch_code][$class]["attended"])?$counter[$branch_code]['All']["attended"]:0; ?></span>
                                            |
                                            <span class="uk-text-danger"><?= isset($counter[$branch_code][$class]["absent"])?$counter[$branch_code]['All']["absent"]:0; ?></span>


                                        </label><span onclick="window.location.href='report_online_exam_group_attendance_ajax.php?WT_download_pdf=OK&branch_code=<?=$branch_code?>&class=<?=$class?>&eg_id=<?=$eg_id?>';"
                                                      uk-icon="file-text"></span>)
                                    </a>
                                </li>
                                <?
                            }?>
                        </ul>
                        <ul class="uk-switcher uk-margin">
                            <? foreach ($class_history as $class=>$histories){?>
                                <li>
                                    <div class="uk-card uk-card-default uk-margin class_wrapper">
                                        <table class="uk-table uk-table-small uk-table-striped">
                                            <thead>
                                            <tr>
                                                <th class="uk-table-shrink">#</th>
                                                <th class="uk-hidden"></th>
                                                <th>Reg. No.</th>
                                                <th>Name</th>
                                                <th>Branch</th>
                                                <th>Class</th>
                                                <th>Started</th>
                                                <th>Submitted</th>
                                                <th>Mobile</th>
                                                <th>Mode</th>
                                            </tr>
                                            </thead>
                                            <?
                                            $c=0;
                                            foreach ($histories as $hId=>$history){
                                                $c++;
                                                $back_color = $history['exam_group_history_id']>0?'':'#ff000030';
                                                ?>
                                                <tr style="background-color: <?=$back_color;?>">
                                                    <td class="uk-table-shrink"><?=$c;?></td>
                                                    <td class="uk-hidden" style="width: 40px">
                                                        <a uk-icon="menu"></a>
                                                    </td>
                                                    <td><?=$history["registerNo"];?></td>
                                                    <td><?=$history["name"];?></td>
                                                    <td><?=$history["branch_code"];?></td>
                                                    <td><?=$os->classList[$history["class"]];?></td>
                                                    <td><?=$history["exam_start_time"];?></td>
                                                    <td><?=$history["submit_time"];?></td>
                                                    <td><?=$history["mobile_student"];?></td>
                                                    <td><?=$history["exam_mode"];?></td>
                                                </tr>

                                            <?}?>
                                        </table>
                                    </div>
                                </li>
                            <?} ?>
                        </ul>
                    </div>
                    <?
                    $branch_wrapper_class = "uk-hidden";
                }
                ?>
            </div>
        </div>
    </div>
    <?
    echo "##LIST_OF_DATA##";
}

if($os->get("WT_update_results")=="OK" && $os->post("WT_update_results")=="OK"){
    $eg_id = $os->post("exam_group_id");
    $eg_h_q = $os->mq("SELECT 
       h.studentId,
       h.historyId, 
       h.branch_code, 
       h.class, 
       egh.exam_start_time, 
       egh.submit_paper, 
       egh.submit_time
    FROM exam_group_history egh
        INNER JOIN history h ON h.historyId= egh.historyId
        WHERE exam_group_id='$eg_id' 
    ");

    ///update marks
    $edIds = $os->mfa($os->mq("SELECT GROUP_CONCAT(examdetailsId) as ids FROM examdetails WHERE exam_group_id='$eg_id'"));
    $edIds = explode(",",$edIds["ids"]);

    //examdetails
    $eds_q = $os->mq("SELECT * FROM examdetails WHERE examdetailsId IN(".implode(",",$edIds).")");
    $eds = [];
    while($ed= $os->mfa($eds_q)){
        $eds[$ed["examdetailsId"]] = $ed;
    }
    //questions
    $q_q = $os->mq("SELECT * FROM question WHERE examdetailsId IN(".implode(",",$edIds).") ORDER BY ViewOrder ASC");
    while($q = $os->mfa($q_q)){
        $eds[$q['examdetailsId']]["questions"][$q["questionId"]] = $q;
    }

    $students = [];
    $keys_for_rd = [];
    while($student = $os->mfa($eg_h_q)) {
        $students[$student["historyId"]] = $student;


        foreach (array_keys($eds) as $edId) {
            $keys_for_rd[] = $edId."_".$student["historyId"];
        }
    }
    $keys_for_rd = implode("','",$keys_for_rd);
    $rds_details = [];
    $rds_query = $os->mq("SELECT *  FROM resultsdetails WHERE CONCAT(examdetailsId,'_',historyId) IN ('$keys_for_rd')");
    while($rds = $os->mfa($rds_query)){
        $rds_details[$rds["examdetailsId"]][$rds["historyId"]] = $rds;
    }



    foreach ($students as $hId=>$student){
        foreach ($eds as $edId=>$ed) {
            //calculations
            $writtenMarks = 0;
            $negative_attempt = 0;
            $positive_attempt = 0;
            $negative_marks = 0;
            $positive_marks = 0;


            $answers = (array)json_decode(file_get_contents(ANSWERS_PATH."/".$student["studentId"].".json"));
            /****/
            foreach ($ed["questions"] as $question){
                if(isset($answers[$question["questionId"]])){
                    if ($question["correctAnswer"] == $answers[$question["questionId"]]||
                        $question["correctAnswer_2"] == $answers[$question["questionId"]]||
                        $question["correctAnswer_3"] == $answers[$question["questionId"]]||
                        $question["correctAnswer_4"] == $answers[$question["questionId"]]||
                        $question["wrong_question"] == 1) {
                        $positive_attempt++;
                        $positive_marks += (int)$question["marks"];
                        $writtenMarks += (int)$question["marks"];
                    } else {
                        $negative_attempt++;
                        $negative_marks += $question["negetive_marks"];
                        $writtenMarks -= $question["negetive_marks"];
                    }
                }
                else if ($question["wrong_question"] == 1)
                {
                    $positive_attempt++;
                    $positive_marks += (int)$question["marks"];
                    $writtenMarks += (int)$question["marks"];
                }
            }


            $hId = $student["historyId"];
            $data_to_save = array(
                'examId'=>$ed["examId"],
                'historyId' => $hId,
                'examdetailsId' => $edId,
                'writtenMarks'=>$writtenMarks,
                'totalMarks'=>$writtenMarks,
                'percentage'=>round(($writtenMarks/(float)$ed["totalMarks"])*100,2),
                'negative_attempt'=>$negative_attempt,
                'positive_attempt'=>$positive_attempt,
                'negative_marks'=>$negative_marks,
                'positive_marks'=>$positive_marks
            );

            $rdId = 0;
            $rd = isset($rds_details[$edId][$hId])?$rds_details[$edId][$hId]:false;
            if ($rd) {

                $rdId = $rd['resultsdetailsId'];
                $data_to_save["totalMarks"] = ((float)$data_to_save["writtenMarks"]+(float)$rd["viva"]);
                $data_to_save["percentage"] = round(($data_to_save["totalMarks"]/$ed["totalMarks"])*100,2);


            }

            $lastId = $os->save("resultsdetails", $data_to_save, "resultsdetailsId", $rdId);

        }
    }
    /////////////////////////
}


if($os->get("WT_download_pdf")=="OK"){

    $branch_code = $os->get("branch_code");
    $class = $os->get("class");
    $eg_id = $os->get("eg_id");
    $cmd = $os->getSession("online_exam_attendance_query");


    ///
    $eg = $os->mfa($os->mq("SELECT eg.*, e.asession, e.class, e.examTitle FROM exam_group eg 
        INNER JOIN exam e ON e.examId=eg.examId
        WHERE exam_group_id='$eg_id'"));
    $description = "EXAM: ".$eg["exam_group_name"]."-".$eg["examTitle"].", BRANCH: $branch_code";
    ///

    $and = "AND h.class!='80' ";
    if($branch_code!="All"&&$branch_code!=""){
        $and.="AND h.branch_code='$branch_code' ";


    }

    if($class!="All"&&$class!=""){
        $and.="AND h.class='$class' ";

        $description.= (", CLASS:". ($os->classList[$class])." only");
    }

    $cmd = str_replace("AND h.class!='80'", "$and", $cmd);
    $query = $os->mq($cmd);

    $spreadsheet = new Spreadsheet();
    $spreadsheet->getProperties()
        ->setCreator($os->userDetails["name"])
        ->setLastModifiedBy($os->userDetails["name"])
        //->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Online Exam Attendance");
        //->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        //->setKeywords("office 2007 openxml php")
        //->setCategory("Test result file");
    $sheet = $spreadsheet->getActiveSheet();
    //
    $row = 0;
    //page heading
    $row++;
    $sheet->mergeCells($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row));
    $sheet->getStyle($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row))
        ->getFont()
        ->setSize(13);
    $sheet->getStyle($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row))
        ->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue($os->get_cell_name(1,$row),'Online Exam Attendance');


    //page meta
    $row++;
    $sheet->mergeCells($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row));
    $sheet->getStyle($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row))
        ->getFont()
        ->setSize(9);
    $sheet->getStyle($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row))
        ->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue($os->get_cell_name(1,$row),$description);

    //Column header
    $row++;
    $sheet->setCellValue($os->get_cell_name(1,$row),'SL. NO.');
    $sheet->setCellValue($os->get_cell_name(2,$row),'REGN.');
    $sheet->setCellValue($os->get_cell_name(3,$row),'Name');
    $sheet->setCellValue($os->get_cell_name(4,$row), 'BRANCH');
    $sheet->setCellValue($os->get_cell_name(5,$row), 'CLASS');
    $sheet->setCellValue($os->get_cell_name(6,$row), 'STARTED');
    $sheet->setCellValue($os->get_cell_name(7,$row), 'SUBMITTED');
    $sheet->setCellValue($os->get_cell_name(8,$row), 'MOBILE');
    //add header style
    $sheet->getStyle($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row))
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()
        ->setARGB('e5e5e5');

    try {
        $sheet->getStyle($os->get_cell_name(1, $row) . ':' . $os->get_cell_name(8, $row))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
        _d($e);
    }


    $c=0;
    while($history = $os->mfa($query)){
        $c++;
        $row++;
        $back_color = $history['exam_group_history_id']>0?'':'#ff000030';
        $sheet->setCellValue($os->get_cell_name(1,$row),$c);
        $sheet->setCellValue($os->get_cell_name(2,$row),$history["registerNo"]);
        $sheet->setCellValue($os->get_cell_name(3,$row),$history["name"]);
        $sheet->setCellValue($os->get_cell_name(4,$row),$history["branch_code"]);
        $sheet->setCellValue($os->get_cell_name(5,$row),$os->classList[$history["class"]]);
        $sheet->setCellValue($os->get_cell_name(6,$row),$history["exam_start_time"]);
        $sheet->setCellValue($os->get_cell_name(7,$row),$history["submit_time"]);
        $sheet->setCellValue($os->get_cell_name(8,$row),$history["mobile_student"]);



        try {
            $sheet->getStyle($os->get_cell_name(1, $row) . ':' . $os->get_cell_name(8, $row))
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            _d($e);
        }


        if($history["exam_group_history_id"]<=0 || $history["exam_group_history_id"]==""){
            $sheet->getStyle($os->get_cell_name(1,$row).':'.$os->get_cell_name(8,$row))
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('ffc9c9');
        }
    }

    $sheet->getColumnDimension($os->get_leter_by_number(1))->setAutoSize(true);
    $sheet->getColumnDimension($os->get_leter_by_number(2))->setAutoSize(true);
    $sheet->getColumnDimension($os->get_leter_by_number(3))->setAutoSize(true);
    $sheet->getColumnDimension($os->get_leter_by_number(4))->setAutoSize(true);
    $sheet->getColumnDimension($os->get_leter_by_number(5))->setAutoSize(true);
    $sheet->getColumnDimension($os->get_leter_by_number(6))->setAutoSize(true);
    $sheet->getColumnDimension($os->get_leter_by_number(7))->setAutoSize(true);
    $sheet->getColumnDimension($os->get_leter_by_number(8))->setAutoSize(true);


    $sheet->getStyle($os->get_cell_name(1,1).':'.$os->get_cell_name(8,$row))
        ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->getStyle($os->get_cell_name(1,1).':'.$os->get_cell_name(8,$row))
        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->getStyle($os->get_cell_name(1,1).':'.$os->get_cell_name(8,$row))
        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $sheet->getStyle($os->get_cell_name(1,1).':'.$os->get_cell_name(8,$row))
        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


    $writer = new Xlsx($spreadsheet);

    $file = sanitize_key($eg["exam_group_name"]."_".$eg["examTitle"]."_".$branch_code."_".$class).".xlsx";
    $writer->save(CACHE_PATH.'/excel/'.$file);

    $file_url = $site['url'].'cache/excel/'.$file;
    header("Location:$file_url");
    flush();
    exit();
}


