<?
include('wtosConfigLocal.php');
global $site, $os;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

$access_name = "Overall Result Report";
$branch_codes = $os->get_branches_by_access_name($access_name);
$branch_codes["all"] = "Total";



?><?
$os->showPerPage=100000;
function sortPercentage($a, $b){
    return $a['percentage'] < $b['percentage'];
}
function createIndex($key){
    return str_replace(" ", "-", strtolower($key));
}
function get_exam_rank($student_id, $examIds=[], $branch = ''){
    global $os;
    if(is_array($examIds)){
        $examIds = implode(",", $examIds);
    }
    $subjects=[];
    $examQuery = $os->mq("SELECT 
                ed.*,
                su.Elective as elective
            FROM examdetails ed 
            INNER JOIN subject su ON(su.subjectId= ed.subjectId)
            WHERE ed.examId IN($examIds)");

    while($exam = $os->mfa($examQuery)){
        $subjects[$exam['examId']][$exam['subjectId']] = $exam;
    }
    //result details
    $resultsQ = $os->mq("SELECT 
                rd.historyId,
                h.studentId,
                rd.examId,
                sub.subjectId,
                h.asession,
                h.class,
                rd.writtenMarks ,
                rd.viva ,
                h.elective_subject_ids,
                s.name,
                h.branch_code as branch, 
                s.registerNo

            FROM resultsdetails rd 
            INNER JOIN history h on (rd.historyId = h.historyId)
            INNER JOIN student s ON(h.studentId=s.studentId)
            INNER JOIN examdetails ed ON ed.examdetailsId = rd.examdetailsId
            INNER JOIN subject sub ON sub.subjectId=ed.subjectId
            WHERE rd.examId IN($examIds) AND rd.historyId>0");

    $h_subjects = [];
    $results = [];
    while ($rd = $os->mfa($resultsQ)){

        if($rd['class']==80){
            continue;
        }
        //get subjects
        if(!isset($h_subjects[$rd['examId']][$rd['historyId']])){
            $els_subjects = explode(",",$rd['elective_subject_ids']);
            $h_subjects[$rd['examId']][$rd['historyId']] =
                $os->get_subjects_with_elective($subjects[$rd['examId']], $els_subjects);
            foreach ($subjects[$rd['examId']] as $sub){
                if(in_array($sub['subjectId'], $h_subjects[$rd['examId']][$rd['historyId']])){
                    //totalmarks
                    if(isset($results[$rd['examId']][$rd['historyId']]['total'])){
                        $results[$rd['examId']][$rd['historyId']]['total'] += ($sub['written']+$sub['viva']);
                    } else{
                        $results[$rd['examId']][$rd['historyId']]['total'] = ($sub['written']+$sub['viva']);
                    }
                }
            }
        }


        $results[$rd['examId']][$rd['historyId']]['studentId'] =  $rd['studentId'];
        $results[$rd['examId']][$rd['historyId']]['name'] = $rd['name'];
        $results[$rd['examId']][$rd['historyId']]['class'] = $rd['class'];
        $results[$rd['examId']][$rd['historyId']]['branch'] =  $rd['branch'];
        $results[$rd['examId']][$rd['historyId']]['registerNo'] =  $rd['registerNo'];

        if(in_array($rd['subjectId'], $h_subjects[$rd['examId']][$rd['historyId']])) {

            //overall
            if (isset($results[$rd['examId']][$rd['historyId']]['obtain'])) {
                $results[$rd['examId']][$rd['historyId']]['obtain'] += ($rd['writtenMarks'] + $rd['viva']);
            } else {
                $results[$rd['examId']][$rd['historyId']]['obtain'] = ($rd['writtenMarks'] + $rd['viva']);
            }

            $results[$rd['examId']][$rd['historyId']]['percentage'] =
                ($results[$rd['examId']][$rd['historyId']]['obtain'] / $results[$rd['examId']][$rd['historyId']]['total']) * 100;


        }
    }
    ///
    $counter = [];
    $b_counter=[];
    $rank = [];
    $branch_rank = [];
    $branch_results = [];
    foreach ($results as $eid=>$rrr){
        usort($results[$eid], function ($item1, $item2) {
            return $item2['name'] <=> $item1['name'];
        });
        usort($results[$eid], function ($item1, $item2) {
            return $item2['percentage'] <=> $item1['percentage'];
        });
        //
        foreach ($results[$eid] as $row){
            $counter[$eid] = !isset($counter[$eid])?1:$counter[$eid]+1;
            $b_counter[$eid][$row['branch']] = !isset($b_counter[$eid][$row['branch']])?1:$b_counter[$eid][$row['branch']]+1;
            if($row['studentId']==$student_id){
                $rank[$eid] = $counter[$eid];
                $branch_rank[$eid]= $b_counter[$eid][$row['branch']];
            }

            $branch_results[$eid][$row['branch']][] = $row;
        }
    }

    //history

    $res = [];
    $res['ranks']['overall'] = $rank;
    $res['ranks']['branch']  = $branch_rank;
    $res['details']['overall'] = $results;
    $res['details']['branch']  = $branch_results;


    return $res;
}
function _fetch_rank($arr, $studentId){

    $rank=0;
    foreach ($arr as $profile){
        $rank++;
        if($profile['studentId']==$studentId){
            return $rank;
        }
    }
    return false;
}


if($os->get("get_asession_by_branch_code")=="OK" && $os->post("get_asession_by_branch_code")=="OK" ){
    $branch_code_s=$os->post('branch_code_s');
    $branch_code_s = $branch_code_s==""?"e.branch_codes=''":"e.branch_codes LIKE '%$branch_code_s%'";
    $query = $os->mq("SELECT  DISTINCT e.asession FROM exam e 
        WHERE $branch_code_s");

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
    $branch_code_s = $branch_code_s==""?"e.branch_codes=''":"e.branch_codes LIKE '%$branch_code_s%'";
    $exams_q = $os->mq("SELECT  DISTINCT e.class FROM exam e 
        WHERE $branch_code_s AND e.asession='$asession_s'");

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
    $and_branch_s = $branch_code_s==""?"AND e.branch_codes = ''":"AND e.branch_codes LIKE '%$branch_code_s%'";
    $exams_q = $os->mq("SELECT e.* FROM exam e 
        WHERE  e.class='$class_s' AND e.asession='$asession_s' $and_branch_s GROUP BY e.examId") ;
    print $os->query;
    ?>
    <option value=""></option>
    <?
    while($exam = $os->mfa($exams_q))
    {
        ?>
        <option  name="" value="<?= $exam['examId']; ?>" /> <?= $exam['examTitle'] ?><?= $branch_code_s==""?"(Global)":""?></option>
        <?
    }
    exit();

}
if($os->get('WT_resultsdetailsListing')=='OK'&&$os->post('resultDetailsListingVal')=='OKS'){
    $where='';
    $showPerPage        = $os->post('showPerPage');
    //variable
    $classId = $os->post('class_s');
    $asession = $os->post("asession");
    //result_details
    $and_examId_rd      = $os->postAndQuery('examId_s','rd.examId','=');
    //$and_class_rd       = $os->postAndQuery('class_s','rd.class','=');
    //$and_asession_rd    = $os->postAndQuery('asession','rd.asession','=');
    //student details
    $and_branch_s       = $os->postAndQuery('branch_s','st.branch','=');
    //class id
    //$and_class_h        = $os->postAndQuery('class_s','h.class','=');
    $and_examId_ed      = $os->postAndQuery('examId_s','ed.examId','=');
    //and registerNo_s
    $and_registerNo_st = $os->postAndQuery('registerNo_s','st.registerNo','=');
    //and registerNo_s
    $and_gender_st = $os->postAndQuery('gender_s','st.gender','=');


    //subjects
    $subjects = $os->get_subjects_by_class( $classId, $asession);
    $examdetails = [];
    $examId =0;
    $fullMark = 0;
    $examdetails_query = $os->mq("SELECT ed.totalMarks,  ed.examId, ed.subjectId, sb.subjectName
        FROM examdetails AS ed
        LEFT JOIN subject sb ON(sb.subjectId=ed.subjectId)
        WHERE ed.examId='".$os->post('examId_s')."'");
    while($ed = $os->mfa($examdetails_query)){
        $examId = $ed['examId'];
        $examdetails[] = $ed;
        $fullMark+=$ed['totalMarks'];
    }




    $counter = array('all'=>0);
    ///////////
    $listingQuery="SELECT
       rd.historyId,
       rd.resultsdetailsId,
       rd.writtenMarks,
       rd.viva,
       rd.totalMarks,
       rd.percentage,
       ed.subjectId,
       st.name,
       st.registerNo,
       st.gender,
       h.branch_code,
       h.class,
       h.elective_subject_ids,
       h.studentId,
       h.historyId
    FROM resultsdetails AS  rd
    INNER JOIN examdetails ed ON ed.examdetailsId=rd.examdetailsId
    INNER JOIN history h ON(h.historyId=rd.historyId)
    INNER JOIN student AS st ON(st.studentId=h.studentId)
    
    WHERE h.studentId>0 $and_examId_rd  $and_registerNo_st $and_gender_st AND h.class!='80' ";



    $os->setSession($listingQuery, 'download_student_result_overall_report_excel');
    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    //data query
    $branches = [];
    $branches['all'] = "All";
    $result_details=[];
    while($record = $os->mfa( $rsRecords)){

        if (!key_exists($record['branch_code'], $branch_codes)){
            continue;
        }
        $branch_index = createIndex($record['branch_code']);
        $branches[$branch_index]=$record["branch_code"];
        $branch_r = $record["branch_code"];

        $branch_sql_arr['all'] = $listingQuery;
        $branch_sql_arr[$branch_index] = str_replace("h.studentId>0"," h.studentId>0 AND h.branch_code = '$branch_r' ",
            $listingQuery);



        $elective = str_replace(" ","",$record['elective_subject_ids']);
        $elective = explode(",",$elective);
        //subjects
        $subjects_all = $os->get_subjects_with_elective($subjects, $elective);
        //
        $historyId = $record['historyId'];
        //
        $record['totalMarks'] = $record['writtenMarks']+$record['viva'];



        //Save for all
        if(!isset($result_details['all'][$historyId])){
            $counter["all"] = $counter["all"]+1;
            $result_details['all'][$historyId]['totalMarks'] = 0;
            $result_details['all'][$historyId]['paper'] = 0;

        }

        $result_details['all'][$historyId]['name']= $record['name'];
        $result_details['all'][$historyId]['gender']= $record['gender'];
        $result_details['all'][$historyId]['subjects']= $subjects_all;
        $result_details['all'][$historyId]['studentId']= $record['studentId'];
        $result_details['all'][$historyId]['registerNo']= $record['registerNo'];
        $result_details['all'][$historyId]['branch']= $record['branch_code'];
        $result_details['all'][$historyId]['totalMarks'] += $record['totalMarks'];
        $result_details['all'][$historyId]['paper'] += 1;
        $result_details['all'][$historyId]['marks'][$record['subjectId']] = array(
            'subjectId'=> $record['subjectId'],
            'resultsdetailsId'=> $record['resultsdetailsId'],
            'subjectName'=> @$record['subjectName'],
            'totalMarks'=> $record['totalMarks'],
            'percentage'=> $record['percentage'],
        );
        $result_details['all'][$historyId]['percentage'] = ($result_details['all'][$historyId]['totalMarks']/$fullMark)*100;

        //save for branch
        if(!isset($result_details[$branch_index][$historyId])){
            $counter[$branch_index]= $counter[$branch_index]>=0?$counter[$branch_index]+1:0;
            $result_details[$branch_index][$historyId]['totalMarks'] = 0;
            $result_details[$branch_index][$historyId]['paper'] = 0;
        }

        $result_details[$branch_index][$historyId]['name']= $record['name'];
        $result_details[$branch_index][$historyId]['gender']= $record['gender'];
        $result_details[$branch_index][$historyId]['subjects']= $subjects_all;
        $result_details[$branch_index][$historyId]['studentId']= $record['studentId'];
        $result_details[$branch_index][$historyId]['historyId']= $record['historyId'];
        $result_details[$branch_index][$historyId]['registerNo']= $record['registerNo'];
        $result_details[$branch_index][$historyId]['branch']= $record['branch_code'];
        $result_details[$branch_index][$historyId]['totalMarks'] += $record['totalMarks'];
        $result_details[$branch_index][$historyId]['paper'] += 1;
        $result_details[$branch_index][$historyId]['marks'][$record['subjectId']] = array(
            'subjectId'=> $record['subjectId'],
            'resultsdetailsId'=> $record['resultsdetailsId'],
            'subjectName'=> @$record['subjectName'],
            'totalMarks'=> $record['totalMarks'],
            'percentage'=> $record['percentage'],
        );
        $result_details[$branch_index][$historyId]['percentage'] =  ($result_details[$branch_index][$historyId]['totalMarks']/$fullMark) *100;
    };
    //data sorting
    asort($result_details);
    asort($branches);


    if(sizeof($branches)<=2){
        unset($branches["all"]);
    }


    ?>
    <div class="uk-padding-small">
        <div class="uk-grid uk-grid-small" uk-grid>

            <div class="uk-width-auto">
                <table class="uk-table uk-table-divider uk-table-striped uk-table-hover congested-table  background-color-white">
                    <thead>
                    <tr>
                        <td>Branch</td>
                        <td>Total</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody id="branches_list">
                    <?
                    $index = -1;
                    $class="branch_active";
                    foreach ($branches as $branch=>$branch_name) {
                        if (!key_exists($branch, $branch_codes) and $branch!=="all"){
                            continue;
                        }
                        $index++;
                        $branch_index = createIndex($branch);
                        $sql_encoded = rawurlencode(addslashes($branch_sql_arr[$branch_index]));
                        ?>
                        <tr onClick="switchBranch(<?=$index?>)" class="pointable <?=$class;?>">
                            <td><font color="red">[<?=$branch?>]</font> - <?= $branch_codes[$branch]; ?></td>
                            <td><?= $counter[$branch_index]; ?></td>
                            <td>
                                <a href="report_student_result_overall_ajax.php?download_student_result_overall_report_excel=OK&examId=<?=$examId?>&comm=<?= $sql_encoded ?>"
                                   target="_blank" uk-icon="icon: file-text"></a>
                            </td>
                        </tr>
                        <?
                        $class="";

                    } ?>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-expand" id="branch_datas">

                <?
                $style="";
                foreach ($branches as $branch=>$branch_name) {
                    if (!key_exists($branch, $branch_codes) and $branch!=="all"){
                        continue;
                    }
                    $branch_index = createIndex($branch);
                    usort($result_details[$branch_index], 'sortPercentage');
                    ?>
                    <table class="uk-table uk-table-small uk-table-striped
                        uk-table-divider
                        background-color-white
                        uk-width-expand uk-margin-remove"
                           style="<?=$style?>">
                        <thead>
                        <tr>
                            <th class="uk-table-shrink">#</th>
                            <th>Reg No</th>
                            <th>Name</th>
                            <th>gender</th>
                            <th>Branch</th>
                            <th>Marks</th>
                            <th class="uk-text-right">Total</th>
                            <th class="uk-text-right">%</th>
                        </tr>
                        </thead>
                        <?php
                        $serial = 0;
                        foreach($result_details[$branch_index] as $sId=>$record){
                            $serial++;
                            $fullMark=0;
                            $obtain = 0;
                            $percentage = 0;
                            $status = 'OK';
                            //subject wise calculation
                            $subject_wise_mark = '';
                            foreach ($examdetails as $ed){
                                if(in_array($ed['subjectId'], $record['subjects'])) {
                                    $mark = $record['marks'][$ed['subjectId']];
                                    $subjectName = $ed['subjectName'];
                                    $subjectMark = $mark['totalMarks'] != '' ? $mark['totalMarks'] : 0;
                                    $subjectColor = 'black';
                                    $rdId = $mark['resultsdetailsId'];

                                    if (!isset($mark['resultsdetailsId'])) {
                                        $status = 'I';
                                        $subjectMark = 'AB';
                                        $subjectColor = 'red';
                                    }

                                    $subject_wise_mark .= "<div>$subjectName<span style='float: right; color:$subjectColor'>$subjectMark</span></div>";

                                    $obtain += $subjectMark;
                                    $fullMark += $ed['totalMarks'];
                                }
                                //for incomplete
                            }


                            $percentage = number_format((float)($obtain/$fullMark)*100, 2, '.', '');;
                            //rowColor
                            $rowColor='';
                            if($status=='I'){
                                $rowColor = 'background-color:#ff000030';
                                $percentage='INCOMPLETE';
                                $obtain = '--';
                            }
                            $markColor = 'color:red';
                            if($percentage>0){
                                $percentage = $percentage."%";
                            }
                            if($percentage>49) {
                                $markColor = 'color:orange';
                            }
                            if($percentage>69) {
                                $markColor = 'color:green';
                            }
                            ?>
                            <tr class="tag-<?=$record['branch']?>" style="<?=$rowColor?>">
                                <td><?php echo $serial; ?></td>
                                <td class="uk-table-shrink"><?php echo $record['registerNo']?> </td>
                                <td><? echo $record['name']; ?> </td>
                                <td><? echo $record['gender']; ?> </td>
                                <td><? echo $record['branch'];?></td>

                                <td nowrap="" class="uk-text-small uk-text-nowrap"><?=$subject_wise_mark?></td>
                                <td class="uk-text-right uk-text-bold" style="<?=$markColor?>"><?= $obtain; ?></td>
                                <td class="uk-text-right uk-text-bold" style="<?=$markColor?>"><?= $percentage;?></td>
                                <td class="uk-table-shrink" style="width: 40px">
                                    <form target="_blank"
                                          method="post"
                                          class="uk-hidde"
                                          action="report_student_result_overall_ajax.php?download_student_result_overall_report_card=OK">
                                        <input type="hidden" name="eId" value="<?= $os->post('examId_s')?>">
                                        <input type="hidden" name="hId" value="<?= $record['historyId']?>">
                                        <button uk-icon="icon:download"></button>
                                    </form>
                                </td>
                            </tr>
                            <?

                        }?>

                    </table>
                    <?

                    $style="display:none";
                } ?>


            </div>
        </div>
    </div>


    <?php exit(); } ?>

<?


if($os->get('download_student_result_overall_report_excel')=='OK'){
    $examId=$os->get('examId');
    $ranks = get_exam_rank(0, [$examId])['details'];


    //
    $exam = $os->mfa($os->mq("SELECT * FROM exam WHERE examId='$examId'"));
    //exam details
    $examdetails = [];
    $fullMark = 0;
    $examTitle ='';
    $examdetails_query = $os->mq("SELECT ed.totalMarks,  ed.examId, ed.subjectId, ed.examdetailsId, sb.subjectName
        FROM examdetails AS ed
        LEFT JOIN subject sb ON(sb.subjectId=ed.subjectId)
        WHERE ed.examId='$examId'");
    while($ed = $os->mfa($examdetails_query)){
        $examId = $ed['examId'];
        $examdetails[] = $ed;
        $fullMark+=$ed['totalMarks'];
    }


    $cmd = stripslashes(rawurldecode($os->get('comm')));
    $cmd_q = $os->mq($cmd);

    //branch
    $start = "AND h.branch_code='";
    $end = "' GROUP";

    $pattern = sprintf(
        '/%s(.+?)%s/ims',
        preg_quote($start, '/'), preg_quote($end, '/')
    );

    $brancht = '';
    if (preg_match($pattern, $cmd, $matches)) {
        list(, $match) = $matches;
        $brancht = $match;
    }
    //exit();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    //add header
    $sheet->setCellValue($os->get_cell_name(1,1),'SL. NO.');
    $sheet->setCellValue($os->get_cell_name(2,1),'REGN.');
    $sheet->setCellValue($os->get_cell_name(3,1),'Name');
    $sheet->setCellValue($os->get_cell_name(4,1), 'SEX');
    $sheet->setCellValue($os->get_cell_name(5,1), 'CLASS');
    $sheet->setCellValue($os->get_cell_name(6,1), 'BRANCH CODE');
    $sheet->setCellValue($os->get_cell_name(7,1), 'BRANCH NAME');

    $head_cell_count = 8;
    foreach ($examdetails as $ed){
        $sheet->setCellValue($os->get_cell_name($head_cell_count,1), $ed['subjectName']);
        $head_cell_count++;
    }

    $sheet->setCellValue($os->get_cell_name($head_cell_count,1), 'TOTAL');
    $head_cell_count++;
    $sheet->setCellValue($os->get_cell_name($head_cell_count,1),'ABR');
    $head_cell_count++;
    $sheet->setCellValue($os->get_cell_name($head_cell_count,1),'BR');
    ///////
    //Details
    $records = [];
    while ($record = $os->mfa($cmd_q)) {
        $studentId = $record['studentId'];
        if(!isset($records[$studentId])){
            $records[$studentId]['totalMarks'] = 0;
            $records[$studentId]['paper'] = 0;

        }

        $records[$studentId]['name']= $record['name'];

        $records[$studentId]['abr']= _fetch_rank($ranks['overall'][$examId], $studentId);
        $records[$studentId]['br'] = _fetch_rank($ranks['branch'][$examId][$record['branch_code']], $studentId);


        $records[$studentId]['registerNo']= $record['registerNo'];
        $records[$studentId]['branch']= $record['branch_code'];
        $records[$studentId]['gender']= $record['gender'];
        $records[$studentId]['class']= $record['class'];
        $records[$studentId]['totalMarks'] += $record['totalMarks'];
        $records[$studentId]['paper'] += 1;

        $records[$studentId]['marks'][$record['subjectId']] = array(
            'subjectId' => $record['subjectId'],
            'resultsdetailsId' => $record['resultsdetailsId'],
            'subjectName' => $record['subjectName'],
            'totalMarks' => $record['totalMarks'],
            'percentage' => $record['percentage'],
        );

        $records[$studentId]['percentage'] = ($records[$studentId]['totalMarks']/$fullMark)*100;
    }


    usort($records, 'sortPercentage');
    $serial=0;
    foreach($records as $record){


        $serial++;
        $fullMark=0;
        $obtain = 0;
        $percentage = 0;
        $status = 'OK';
        //subject wise calculation
        $subject_wise_mark = [];
        foreach ($examdetails as $ed){
            $mark = $record['marks'][$ed['subjectId']];
            $subjectName = $ed['subjectName'];
            $subjectMark = $mark['totalMarks']!=""?$mark['totalMarks']:0;

            if(!isset($record['marks'][$ed['subjectId']]['resultsdetailsId'])){
                $status = 'I';
                $subjectMark='AB';
                $subjectColor = 'red';
            }
            $subject_wise_mark[$ed['subjectId']] = $subjectMark;
            $obtain+=$subjectMark;
            $fullMark+=$ed['totalMarks'];
            //for incomplete
        }
        ///////////////////
        $sheet->setCellValue($os->get_cell_name(1,$serial+1),$serial);
        $sheet->setCellValue($os->get_cell_name(2,$serial+1),$record['registerNo']);
        $sheet->setCellValue($os->get_cell_name(3,$serial+1),$record['name']);
        $sheet->setCellValue($os->get_cell_name(4,$serial+1), $record['gender']);
        $sheet->setCellValue($os->get_cell_name(5,$serial+1), $os->classList[$record['class']]);
        $sheet->setCellValue($os->get_cell_name(6,$serial+1), $record['branch']);
        $sheet->setCellValue($os->get_cell_name(7,$serial+1), @$branch_codes[$record['branch']]);

        $head_cell_count = 8;
        foreach ($examdetails as $ed){
            $sheet->setCellValue($os->get_cell_name($head_cell_count,$serial+1), $subject_wise_mark[$ed['subjectId']]);
            $head_cell_count++;
        }


        $sheet->setCellValue($os->get_cell_name($head_cell_count,$serial+1), $obtain);
        $head_cell_count++;
        $sheet->setCellValue($os->get_cell_name($head_cell_count,$serial+1),$record['abr']);
        $head_cell_count++;
        $sheet->setCellValue($os->get_cell_name($head_cell_count,$serial+1),$record['br']);
        /////////////////

    }

    $file_name = $exam["examTitle"].".xlsx";
    $writer = new Xlsx($spreadsheet);
    try {
        $writer->save(CACHE_PATH . '/excel/' . $file_name);
    } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
    }

    $file_url = $site['url'].'cache/excel/'.$file_name;
    header("Location:$file_url");
    flush();
    exit();
}
//view progress report
if($os->get('download_student_result_overall_report_card')=='OK'){

    $eId = $os->post('eId');
    $hId = $os->post('hId');
    $exam = $os->mfa($os->mq("SELECT * FROM exam e WHERE e.examId='$eId'"));
    $history = $os->mfa($os->mq("SELECT * FROM history h INNER JOIN student s ON s.studentId=h.studentId WHERE h.historyId='$hId'"));
    $exam["elective_subject_ids"] = $history["elective_subject_ids"];
    $branch_code=  $history['branch_code'];
    $rd_query = $os->mq("SELECT * FROM resultsdetails rd  WHERE rd.examId='$eId' AND rd.historyId='$hId'");
    $ed_query = $os->mq("SELECT * FROM examdetails ed
        INNER JOIN subject s ON(s.subjectId=ed.subjectId)
        WHERE ed.examId='$eId'");
    $grade_setting = $os->get_grade_settings_by_class($exam['class'], $exam['asession']);
    $subjects = $os->get_subjects_by_class($exam['class'], $exam['asession']);
    $branch = $os->mfa($os->mq("SELECT DISTINCT b.* FROM branch b WHERE branch_code='$branch_code'"));

    //signature
    $incharge = $os->get_sigentory_authority("grade_card",$branch_code,$history["class"],$history["gender"]);
    $signature = @$site['url'].$incharge['signature'];


    //
    $file_name = str_replace(".",'','grade_card_'.$history['name'].'('.$exam['examTitle'].')');
    $file_name = str_replace("-",'_', $file_name);
    $file_name = str_replace(" ",'-', $file_name);
    $file_name = strtolower($file_name);
    $con = "";
    ob_start();
    ?>
    <html lang="en-gb">
    <head>

        <style>
            *{
                box-sizing: border-box;
                font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif;
            }
            p{
                font-size: 13px;
            }
            html{
                margin: 0;
                padding: 0;
                background-color: #feffdc;
            }
            body{
                margin: 0;
                padding: 0;
                background-color: #feffdc;
                background-image: url('<?=$site['url']?>wtos-images/<?=$os->get_watermark_by_unit_group($branch['group_unit'])?>');

            }
            .page{
                min-height: 100%;
                padding: 25px 35px;
                border: 1px solid green;
            }
            @media print {
                *{
                    color-adjust: exact;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact
                }
                html, body {
                    border: 1px solid white;
                    page-break-after: avoid;
                    page-break-before: avoid;
                }
                .page_breaker {page-break-after: always;}

            }
            @page {
                size: A4;
            }
        </style>
        <title>Grade Card-<?=$history['name']?>[ <?= $exam['examTitle']?>]</title>
    </head>
    <body>


    <div style="max-width: 1000px; margin: auto;);">
        <div class="page">
            <center>
                <img src="<?=$os->validate_image_url($site['url']."wtos-images/".$os->get_logo_by_unit_group($branch['group_unit']))?>"

                     width="160px"
                     style="margin-top: 100px">
                <h1 colspan="2" style="font-size: 38px; margin-top: 60px; text-align: center; margin-bottom: 0px">
                    <?=$branch['branch_name']?>
                </h1>
                <div style=" margin: auto">
                    <p style="margin-bottom: 22px; center; font-size: 20px;">
                        (A Unit of <?=$os->group_unit_list[$branch['group_unit']]?>)
                    </p>


                    <p colspan="2" style="text-align: center; font-size: 13px">
                        Vill: <?=$branch['address']?>,
                        P.O: <?=$branch['PO']?>,
                        Dist: <?=$branch['dist']?><br>
                        Pin : <?=$branch['pin_code']?>, <?=$branch['state']?>,
                        <br>
                        Email : <?=$branch['email']?>
                    </p>
                </div>
            </center>


            <div style="width: 280px; font-size: 24px;
            font-weight: bold; margin: 50px auto ; text-align: center;
            padding: 5px; border:2px solid #000">
                PROGRESS REPORT
            </div>

            <p style="font-size: 20px;font-weight: bold; margin: 0px auto 40px; text-align: center;">SESSION:
                2020-21</p>
            <? if($os->get_board_by_class($history['class'])=="CBSE"){?>
                <div style="margin:50px auto; padding: 15px; border: 1px solid #000; text-align: center;">
                    <strong>A NOTE TO PARENTS</strong>
                    <p style="text-align: justify; font-size: 13px; line-height: 22px">
                        This is on par with the latest guidelines of CBSE . An eight point grading scale is used to
                        indicate the overall performance of a learner in scholastic areas. A three point grading system is used to indicate the performance on the co-curricular section.
                    </p>
                </div>
            <? } ?>

            <div style="margin:30px auto; padding: 15px; border: 1px solid #000; text-align: center">
                <table style="margin: 5px auto">
                    <tr>
                        <th style="width: 80px; text-align: left">Name :</th>
                        <td>
                            <?=$history['name']?>
                        </td>
                    </tr>
                </table>
                <table style="margin: 5px auto">
                    <tr>
                        <th style="white-space: nowrap; width: 350px; text-align: left">Mother's Name/ Father's Name/
                            Guardian's
                            Name:</th>
                        <td><?=$history['father_name'] ?></td>
                    </tr>
                </table>
                <table style="margin: 5px auto">
                    <tr>
                        <th style="width: 100px; text-align: left">Date of Birth :</th>
                        <td><?=$os->showDate($history['dob'])?></td>
                        <th style="width: 80px; text-align: left">Class : </th>
                        <td><?=str_replace("CBSE","",$os->classList[$history['class']]) ?></td>
                        <!--th style="width: 80px; text-align: left">Section :</th><td><?=$history['section']
                        ?></td-->
                    </tr>
                </table>
                <table style="margin: 5px auto">
                    <tr>
                        <th style="width: 80px; text-align: left">Roll No. :</th><td><?=$history['roll_no'] ?></td>
                        <th style="width: 80px; text-align: left">Reg No. : </th><td><?=$history['registrationNo'] ?></td>
                    </tr>
                </table>

            </div>

            <div style="margin:50px auto; padding: 15px; border: 1px solid #000; text-align: center;">
                <p style="text-align: center; font-size: 13px; line-height: 18px">
                    <strong>Regd. Office: Khalatpur, Udaynaryanpur, Dihibhursut, Howrah-712408(W.B.)</strong><br>
                    <strong>Central Office : 53B Eiliot Road, Kolkata - 700016</strong><br>
                    <strong>Email : alameenmissiontrust@gmail.com </strong>
                    <strong>Website : www.alameenmission.org </strong>
                </p>
            </div>
        </div>
        <div class="page_breaker"></div>
        <div class="page">
            <div>
                <div style=" font-size: 24px;
                            font-weight: bold; margin: 30px auto 20px; text-align: center;">
                    <?=$exam['examTitle']?>
                </div>
                <?
                ///
                print $os->render_grade_card($exam, $ed_query, $rd_query, $grade_setting, $subjects);
                ?>
            </div>



            <div class="" style="margin-top: 60px">
                <table style="width: 230px" border="1">
                    <tr>
                        <th colspan="2">Percentage</th>
                        <th rowspan="2">Grade</th>
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                    </tr>


                    <?
                    $grade_setting = array_reverse($grade_setting);
                    foreach ($grade_setting as $grade):
                        ?>
                        <tr style="text-align: center">
                            <td><?=$grade['min']?></td>
                            <td><?=$grade['max']?></td>
                            <td><?=$grade['grade']?></td>
                        </tr>
                    <?endforeach;?>
                </table>

            </div>
            <div class="" style="margin-top: 150px">
                <table>
                    <tr>
                        <th style="width: 50%">
                            <img height="70px"
                                 src="<?=$site['url']?>wtos-images/secretory_sig.png">
                        </th>
                        <?if($incharge){?>
                        <th style="width: 50%">
                            <img height="70px"
                                 src="<?=$os->validate_image_url($signature)?>">
                        </th>
                        <?}?>
                    </tr>
                    <tr>
                        <th>
                            <div style="width: 230px; border-top: 1px dotted #000; margin: 5px auto; "></div>
                            General Secretary, <br><?=$branch['group_unit']?>
                        </th>
                        <?if($incharge){?>
                            <th>
                                <div style="width: 230px; border-top: 1px dotted #000; margin: 5px auto; "></div>
                                <?=$incharge['adminType']?>, <br><?=$branch['branch_name']?>
                            </th>
                        <?}?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?
    $con = ob_get_contents();
    ob_end_clean();

    $con = str_replace("#000", '#333', $con);
echo  $con;
exit();


    $path = realpath($site['root'].'cache/pdf');
    $http_pdf = $site['url'].'cache/pdf/'.$file_name.'.pdf';
    // You can pass a filename, a HTML string, an URL or an options array to the constructor


    $pdf = new mikehaertl\wkhtmlto\Pdf(array(
        'binary' => WKHTMLTOPDF_BIN,
    ));
    $pdf->addPage($con);
    if (!$pdf->saveAs($path.'/'.$file_name.'.pdf')) {
        $error = $pdf->getError();
        // ... handle error here
        print $error;
        exit();

    }

    header("Content-Disposition: attachment; filename=".$file_name.".pdf");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Description: File Transfer");
    header("Content-Length: " . filesize($path.'/'.$file_name.'.pdf'));
    flush(); // this doesn't really matter.
    $fp = fopen($path.'/'.$file_name.'.pdf', "r");
    while (!feof($fp))
    {
        echo fread($fp, 65536);
        flush(); // this is essential for large downloads
    }
    fclose($fp);
    unlink($path.'/'.$file_name.'.pdf');
    exit();
}
