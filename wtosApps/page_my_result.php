<?php
global $os,$site,$session_selected,$bridge,$pageVar;
$ajaxFilePath= $site['url'].'wtosApps/page_my_result_Ajax.php';
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

//_d($_SERVER);
if($_SERVER['REMOTE_ADDR']!='45.251.116.226')
{
    //echo '<pre>';
    //print  "Under construction";
   // exit();

}

if(! $os->isLogin() )
{

    header("Location: ".$site['url']."login");
    exit();

}
else
{
    $studentId=$os->userDetails['studentId'];
    $name=$os->userDetails['name'];
    $branch=$os->userDetails['branch'];
    //
    function get_grade_settings($session_classes){
        global $os;
        $keys = [];
        foreach ($session_classes as $session => $classes){
            foreach ($classes as $class){
                $keys[] = $os->get_board_by_class($class)."_".$session;
            }
        }
        $keys = "'".implode("','",$keys)."'";
        $grades_q = $os->mq("SELECT 
            from_percent as min, 
            to_percent as max,
            grade, asession, board
        FROM grade_setting  WHERE CONCAT(board,'_',asession) IN($keys)");
        $grades=[];
        while ($grade = $os->mfa($grades_q)){
            $grades[$grade["asession"]][$grade["board"]][] = $grade;
        }
        return $grades;

    }
    function get_electives(){
        global $os;
        $sId = $os->loggedUser()["studentId"];
        $query = $os->mq("SELECT class, elective_subject_ids FROM history WHERE studentId='$sId'");
        $subjects = [];
        while ($sub = $os->mfa($query)){
            $subjects[$sub["class"]] = explode(",", $sub["elective_subject_ids"]);
        }
        return $subjects;
    }
    function get_all_subjects($session_classes = []){
        global $os;
        $keys = [];
        foreach ($session_classes as $session => $classes){
            foreach ($classes as $class){
                $keys[] = $class;
            }
        }
        $keys = "'".implode("','",$keys)."'";
        $subs = $os->mq("SELECT sub.* FROM subject sub WHERE CONCAT(sub.classId) IN($keys)");

        $subjects = [];
        $electives = get_electives();
        while ($sub = $os->mfa($subs)){
            $elective = isset($electives[$sub['classId']])?$electives[$sub['classId']]:[];
            if($sub['Elective']==1){
                if(in_array($sub['subjectId'],$elective)){
                    $subjects[$sub['classId']][] = $sub['subjectId'];
                }
            } else {
                $subjects[$sub['classId']][] = $sub['subjectId'];
            }
        }
        return $subjects;
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
                s.branch

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
    function get_exam_max($examIds=[], $branch=''){
        global $os;
        if(is_array($examIds)){
            $examIds = implode(",", $examIds);
        }
        $query = $os->mq("SELECT
          
            rd.examId,
            ed.subjectId,
            MAX(IF(rd.writtenMarks>0,rd.writtenMarks,0)+IF(rd.viva>0,rd.viva,0)) as highest
            FROM resultsdetails rd 
            INNER JOIN examdetails ed ON ed.examdetailsId=rd.examdetailsId
            INNER JOIN history h ON h.historyId=rd.historyId
            WHERE rd.examId IN($examIds) AND h.class!='80'
            GROUP BY rd.examId, ed.subjectId");
        $result = [];
        while ($res = $os->mfa($query)){
            $result[$res['examId']][$res['subjectId']] = $res['highest'];
        }
        return $result;
    }


    /*****
     * results details
     */
    $exams = [];
    $exam_ids  = [];
    $session_classes = [];
    $rds_query = $os->mq("SELECT 
            e.class, e.asession,
       
            rd.historyId,
            rd.writtenMarks, 
            rd.viva as vivaMarks, 
            rd.totalMarks, 
            rd.examdetailsId,
            rd.examId,
            rd.negative_marks,
            rd.positive_marks,  
            rd.negative_attempt,
            rd.positive_attempt,
            rd.percentage,
       
            ed.subjectId
       
        FROM resultsdetails rd 
        INNER JOIN history h ON (h.historyId=rd.historyId AND h.studentId='$studentId')
        INNER JOIN examdetails ed ON ed.examdetailsId=rd.examdetailsId
        INNER JOIN exam e ON (ed.examId=e.examId AND e.publish_result='Yes')
        ORDER BY rd.examdetailsId DESC
        ");
    while($rd = $os->mfa($rds_query)){
        $exams[$rd['asession']][$rd['class']][$rd['examId']]['subjects'][$rd['subjectId']] = $rd;
        $exams[$rd['asession']][$rd['class']][$rd['examId']]['historyId']  =  $rd["historyId"];
        //Calculations

        if(!isset($exams[$rd['asession']][$rd['class']][$rd['examId']]["totalMarks"])){
            $exams[$rd['asession']][$rd['class']][$rd['examId']]['totalMarks'] = 0;
            $exams[$rd['asession']][$rd['class']][$rd['examId']]['negative_attempt'] = 0;
            $exams[$rd['asession']][$rd['class']][$rd['examId']]['positive_attempt'] = 0;
            $exams[$rd['asession']][$rd['class']][$rd['examId']]['totalObtain'] = 0;
        }

        $exams[$rd['asession']][$rd['class']][$rd['examId']]['negative_attempt'] =
            $exams[$rd['asession']][$rd['class']][$rd['examId']]['negative_attempt'] +$rd["negative_attempt"];
        $exams[$rd['asession']][$rd['class']][$rd['examId']]['positive_attempt'] =
            $exams[$rd['asession']][$rd['class']][$rd['examId']]['positive_attempt'] +$rd["positive_attempt"];
        $exams[$rd['asession']][$rd['class']][$rd['examId']]['totalObtain'] =
            $exams[$rd['asession']][$rd['class']][$rd['examId']]['totalObtain'] +$rd["totalMarks"];


        //Generate key
        $session_classes[$rd['asession']][$rd['class']]= $rd['class'];
        $exam_ids[$rd['examId']]=$rd['examId'];
    }

    $subjects = get_all_subjects($session_classes);

    //examdetailsquery
    $ed_q = $os->mq("SELECT ed.written,
            e.asession, 
            e.class,
            e.examId,
            e.show_on_result,
       
            ed.viva,
            ed.totalMarks as total,
            ed.subjectId,
            
            sub.subjectId,
            sub.subjectName,
            
            eg.exam_mode,
            eg.exam_group_id,
            e.examTitle, 
            e.asession, 
            e.class 
        FROM examdetails ed
        INNER JOIN exam_group eg ON eg.exam_group_id=ed.exam_group_id   
        INNER JOIN exam e ON (e.examId=ed.examId AND e.publish_result='Yes')
        INNER JOIN subject sub ON sub.subjectId=ed.subjectId
        WHERE ed.examId IN('".implode("','", $exam_ids)."')
        ");
    while ($ed= $os->mfa($ed_q)){
        if(isset($exams[$ed['asession']][$ed['class']][$ed['examId']]['subjects'][$ed["subjectId"]])){
            $ed = array_merge($exams[$ed['asession']][$ed['class']][$ed['examId']]['subjects'][$ed["subjectId"]], $ed);
        }
        $exams[$ed['asession']][$ed['class']][$ed['examId']]['subjects'][$ed["subjectId"]] = $ed;


        if(!in_array($ed["subjectId"], $subjects[$ed['class']])){
            unset($exams[$ed['asession']][$ed['class']][$ed['examId']]['subjects'][$ed["subjectId"]] );

            continue;
        }



        $exams[$ed['asession']][$ed['class']][$ed['examId']]["examTitle"] = $ed['examTitle'];
        $exams[$ed['asession']][$ed['class']][$ed['examId']]["show_on_result"] = $ed['show_on_result'];
        $exams[$ed['asession']][$ed['class']][$ed['examId']]["examType"] = $ed['exam_mode'];
        $exams[$ed['asession']][$ed['class']][$ed['examId']]["class"] = $ed['class'];

        $exams[$ed['asession']][$ed['class']][$ed['examId']]['totalMarks'] =
            $exams[$ed['asession']][$ed['class']][$ed['examId']]['totalMarks'] + $ed["total"];
    }


    /**************
     * Main Part
     */
    $grade_settings = get_grade_settings($session_classes);
    $exam_ranks = get_exam_rank($studentId, $exam_ids, $branch);
    $exam_highest = get_exam_max($exam_ids, $branch);


    foreach($exams as  $session=>$classes_settings){
        //session level
        foreach ($classes_settings as $class=>$exams){

            ?>
            <h3 class="uk-text-bolder"><?=$os->classList[$class]?> [<?= $session?>] </h3>

            <div class="uk-grid uk-child-width-1-3@m uk-child-width-1-2@s" uk-grid>
                <?
                foreach ($exams as  $examId=>$exam){
                    $grade_setting = $grade_settings[$session][$os->get_board_by_class($class)];
                    $overall_rank_div_id='overall_rank_div_id'.$examId;
                    $branch_rank_div_id='branch_rank_div_id'.$examId;
                    $statistics_div_id='statistics_div_id'.$examId;
                    $statistics_details_div_id='statistics_details_div_id'.$examId;
                    $merit_list_100_div_id='merit_list_100_div_id'.$examId;
                    $answer_sheet_div_id='answer_sheet_div_id'.$examId;

                    ?>
                    <div>
                        <div class="uk-card uk-card-default uk-card-small uk-card-outline">
                            <div class="uk-card-body">
                                <h4 class="uk-margin-remove" style="color: black">
                                    <strong><?=$exam['examTitle']?></strong>
                                </h4>

                                <table class="uk-table  uk-table-tiny uk-width-expand text-m">
                                    <tbody>
                                    <tr>
                                        <td>Full Marks</td>
                                        <td class="uk-table-shrink"><? echo $exam['totalMarks']  ?></td>
                                    </tr>
                                    <?if($exam['examType']=="Online"):?>
                                        <tr>
                                            <td>Total Attempt</td>
                                            <td class="uk-table-shrink"><? echo $exam['negative_attempt']+$exam['positive_attempt']?></td>
                                        </tr>
                                        <tr>
                                            <td>Positive Attempt</td>
                                            <td class="uk-table-shrink uk-text-success"><? echo $exam['positive_attempt']  ?></td>
                                        </tr>
                                        <tr>
                                            <td>Negative Attempt</td>
                                            <td class="uk-table-shrink uk-text-danger"><? echo $exam['negative_attempt']  ?></td>
                                        </tr>
                                    <?endif;?>
                                    <tr>
                                        <td>Marks Obtained</td>
                                        <td><? echo $exam['totalObtain']  ?></td>
                                    </tr>
                                    <tr>
                                        <td>Percentage </td>
                                        <td>
                                            <?
                                            $exam_percentage = round(($exam['totalObtain']/$exam['totalMarks'])*100,2);
                                            echo $exam_percentage;
                                            ?>%
                                        </td>
                                    </tr>
                                    <?if($os->calculate_grade($exam_percentage, $grade_setting)!=="--"){;?>
                                        <tr>
                                            <td>Overall Grade </td>
                                            <td><?= $os->calculate_grade($exam_percentage, $grade_setting) ?></td>
                                        </tr>
                                    <? }?>
                                    <tr>
                                        <td>All Branch Rank </td>
                                        <td><span style="cursor:pointer; color:#0000FF; font-weight:bold;"
                                                  onclick="//UIkit.modal('#<?=$overall_rank_div_id?>').show()">
                                            <? echo $exam_ranks['ranks']['overall'][$examId]  ?>
                                        </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Branch Rank </td>
                                        <td>
                                        <span style="cursor:pointer;color:#0000FF; font-weight:bold;"
                                              onclick="//UIkit.modal('#<?=$branch_rank_div_id?>').show()">
                                            <? echo $exam_ranks['ranks']['branch'][$examId]  ?>
                                        </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>


                                <?if(in_array($os->get_board_by_class($exam['class']),$os->special_boards)){;?>
                                    <div class="for_special">

                                        <a class="uk-button uk-button-secondary uk-button-small "
                                           onclick="UIkit.modal('#<?=$statistics_details_div_id?>').show()">
                                            View Details
                                        </a>

                                        <a class="uk-button uk-button-secondary uk-button-small "
                                           onclick="UIkit.modal('#<?=$merit_list_100_div_id?>').show()">
                                            Merit List
                                        </a>

                                        <a class="uk-button uk-button-primary uk-button-small "
                                           target="_blank"
                                           href="<?= $ajaxFilePath?>?print_rank_card=OK&eId=<?=base64_encode($examId)?>&hId=<?=$exam['historyId']?>">
                                            Rank Card
                                        </a>
                                    </div>
                                    <!-- pop up start  -->
                                    <div id="<?=$statistics_details_div_id;?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">
                                            <table class="uk-table uk-table-tiny uk-table-responsive uk-table-striped text-s">
                                                <thead>
                                                <tr >
                                                    <td>Subject</td>
                                                    <td>Full Marks</td>
                                                    <td>Highest Marks</td>
                                                    <?if($exam['examType']=="Online"):?>
                                                        <td>Attempt</td>
                                                    <?endif;?>
                                                    <td>Obtained</td>
                                                    <td>%</td>
                                                    <td>Grade</td>
                                                    <td></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?

                                                foreach($exam['subjects'] as $subjectId=>$subject) {

                                                    $sub_percentage =
                                                        isset($subject['percentage'])?$subject['percentage']:'--';
                                                    $sub_grade = isset($subject['percentage'])?$os->calculate_grade
                                                    ($subject['percentage'],$grade_setting) :'--';
                                                    ?>
                                                    <tr >
                                                        <td title="Subject"><?=$subject['subjectName'];?></td>
                                                        <td title="Full Marks"><?=$subject['total'];?></td>
                                                        <td title="Highest Marks"><?=$exam_highest[$examId][$subjectId]?></td>
                                                        <?if($exam['examType']=="Online"):?>
                                                            <td title="Attempt">
                                                                <span class="uk-text-success"><?= $subject['positive_attempt']; ?></span><br>
                                                                <span class="uk-text-danger"><?= $subject['negative_attempt']; ?></span>
                                                            </td>
                                                        <? endif;?>
                                                        <td title="obtain"><?=isset($subject['totalMarks'])?$subject['totalMarks']:'--';?></td>
                                                        <td title="Percentage"><?= round($sub_percentage,2)?></td>
                                                        <td title="Grade"><?= $sub_grade?></td>
                                                        <td>
                                                            <?if($exam['examType']=="Online"):?>
                                                                <a onclick="viewAnswerSheet('<?=$subject['exam_group_id']?>')">
                                                                    OMR
                                                                </a>
                                                            <?endif;?>
                                                        </td>
                                                    </tr>
                                                    <?
                                                } ?>
                                                </tbody>
                                            </table>
                                            <table class="uk-table uk-hidden uk-table-small uk-table-tiny uk-table-striped uk-table-hover text-m">
                                                <tr >
                                                    <td>Subject</td>
                                                    <td>Total Attempt</td>
                                                    <td>(+)Attempt</td>
                                                    <td>(-)Attempt</td>
                                                    <td>Obtained</td>
                                                </tr>
                                                <?


                                                foreach($exam['subjects'] as $subjectId=>$subject) {
                                                    $group_wise_stat = @unserialize($subject['groupwise_stat']);

                                                    foreach($group_wise_stat as $group=>$stat){
                                                        ?>
                                                        <tr >
                                                            <td><?=$group?></td>
                                                            <td><?=$stat['negative_attempt']+$stat['positive_attempt'];?></td>
                                                            <td><?=$stat['positive_attempt'];?></td>
                                                            <td><?=$stat['negative_attempt'];?></td>
                                                            <td><?=$stat['obtain'];?></td>
                                                        </tr>
                                                        <?
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="5">
                                                            <a onclick="viewAnswerSheet('<?=$subject['examdetailsId']?>')">
                                                                View Answer Sheet</a>
                                                        </td>
                                                    </tr>
                                                    <?

                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="<?=$merit_list_100_div_id;?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">

                                            <h4>Top 100 Merit List</h4>
                                            <?

                                            ?>

                                            <table class="uk-table uk-table-tiny uk-table-striped uk-table-hover
                                        text-s">
                                                <tr>
                                                    <th class="text-s">Rank</th>
                                                    <th class="text-s">Name</th>
                                                    <th class="text-s">Obtained</th>
                                                    <th class="text-s">%</th>
                                                </tr>
                                                <?
                                                $k=0;
                                                foreach($exam_ranks['details']['overall'][$examId] as   $rows) {
                                                    $k++;
                                                    ?>
                                                    <tr <? if($studentId==$rows['studentId']){ ?> style="background-color:#FF9595" <? } ?>>
                                                        <td> <? echo $k; ?> </td>
                                                        <td>
                                                            <span class="text-m"><? echo $rows['name']; ?></span><br>
                                                            <div class="text-xs">
                                                            <span>Class: <i class="uk-text-primary"><? echo $os->classList[$rows['class']]; ?></i></span>
                                                            <span>Branch <i class="uk-text-primary"><? echo $rows['branch']; ?></i></span><br>
                                                            </div>
                                                        </td>
                                                        <td><? echo $rows['obtain']; ?></td>
                                                        <td> <? echo round( $rows['percentage'],2); ?></td>
                                                    </tr>

                                                    <? if ($k==100){break;}
                                                } ?>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- pop up end -->
                                <?  // }                                 else                             {  /// temporary open for all

                                    ?>
                                    <div class="for_non_special" style="margin-top:10px;">
                                       <!-- <a class="uk-button uk-button-primary uk-button-small "
                                           onclick="UIkit.modal('#<?=$statistics_div_id?>').show()">
                                            View Details
                                        </a>-->
                                        <form class="uk-inline <?=$exam['show_on_result']=="Yes"?"":"uk-hidden"?>"
                                              action="<?=$ajaxFilePath?>?WT_render_grade_card=OK&examId=<?=$examId?>&hId=<?=$exam["historyId"]?>"
                                              method="post"
                                              target="_blank">
                                            <button type="submit"
                                                    class="uk-button uk-button-secondary uk-button-small ">
                                                <span uk-icon="download"></span> Grade Card
                                            </button>
                                        </form>
                                    </div>
                                    <div id="<?=$overall_rank_div_id;?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">
                                            <table class="uk-table uk-table-small uk-table-striped uk-table-hover">
                                                <?
                                                $k=0;
                                                foreach($exam_ranks['details']['overall'][$exam['examId']] as   $rows) {
                                                    $k++;
                                                    ?>
                                                    <tr <? if($studentId==$rows['studentId']){ ?> style="background-color:#FF9595" <? } ?>>
                                                        <td><? echo $k; ?> </td>
                                                        <td><? echo $rows['name']; ?></td>
                                                        <td><? echo round( $rows['percentage'],2); ?> %</td>
                                                    </tr>
                                                <? } ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="<?=$branch_rank_div_id;?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">

                                            <table class="uk-table uk-table-small uk-table-striped uk-table-hover">

                                                <?
                                                $k=0;
                                                foreach($exam_ranks['details']['branch'][$exam['examId']][$branch] as
                                                        $rows)
                                                {

                                                    $k++;
                                                    ?> <tr  <? if($studentId==$rows['studentId']){ ?> style="background-color:#FF9595" <? } ?> >
                                                    <td> <? echo $k; ?> </td>
                                                    <td><? echo $rows['name']; ?></td>
                                                    <td> <? echo round( $rows['percentage'],2); ?> % </td>
                                                </tr> <?

                                                } ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="<?=$statistics_div_id;?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">

                                            <table class="uk-table uk-table-tiny uk-table-responsive uk-table-striped text-s">
                                                <thead>
                                                <tr >
                                                    <td>Subject</td>
                                                    <td>Full Marks</td>
                                                    <td>Highest Marks</td>
                                                    <?if($exam['examType']=="Online"):?>
                                                        <td>Attempt</td>
                                                    <?endif;?>
                                                    <td>Obtained</td>
                                                    <td>%</td>
                                                    <td>Grade</td>
                                                    <td></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?

                                                foreach($exam['subjects'] as $subjectId=>$subject) {

                                                    $sub_percentage =
                                                        isset($subject['percentage'])?$subject['percentage']:'--';
                                                    $sub_grade = isset($subject['percentage'])?$os->calculate_grade
                                                    ($subject['percentage'],$grade_setting) :'--';
                                                    ?>
                                                    <tr >
                                                        <td title="Subject"><?=$subject['subjectName'];?></td>
                                                        <td title="Full Marks"><?=$subject['total'];?></td>
                                                        <td title="Highest Marks"><?=$exam_highest[$examId][$subjectId]?></td>
                                                        <?if($exam['examType']=="Online"):?>
                                                            <td title="Attempt">
                                                                <span class="uk-text-success"><?= $subject['positive_attempt']; ?></span><br>
                                                                <span class="uk-text-danger"><?= $subject['negative_attempt']; ?></span>
                                                            </td>
                                                        <? endif;?>
                                                        <td title="obtain"><?=isset($subject['totalMarks'])?$subject['totalMarks']:'--';?></td>
                                                        <td title="Percentage"><?= round($sub_percentage,2)?></td>
                                                        <td title="Grade"><?= $sub_grade?></td>
                                                        <td>
                                                            <?if($exam['examType']=="Online"):?>
                                                                <a onclick="viewAnswerSheet('<?=$subject['exam_group_id']?>')">
                                                                    OMR
                                                                </a>
                                                            <?endif;?>
                                                        </td>
                                                    </tr>
                                                    <?
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
            <?

        }
    }



}
?>

<!---
-Global Modal
---->
<div id="answer_sheet_div" uk-modal class="uk-modal-full">
    <div class="uk-modal-dialog uk-modal-body" id="answer_sheet_div_container">
    </div>
</div>
<script type="text/javascript" id="MathJax-script" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
</script>
<script>
    function viewAnswerSheet(exam_group_id){
        UIkit.modal('#answer_sheet_div').show();
        document.querySelector('#answer_sheet_div_container').innerHTML='';
        var formdata = new FormData();

        formdata.append('exam_group_id',exam_group_id);
        formdata.append('WT_fetch_answer_sheet','OK');

        var url='<? echo $ajaxFilePath ?>?WT_fetch_answer_sheet=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please Wait..';
        os.setAjaxFunc('viewAnswerSheetResult',url,formdata);
    }

    function viewAnswerSheetResult(data){
        document.querySelector("#answer_sheet_div_container").innerHTML = data;
        setTimeout(()=>{
            if(typeof MathJax !== 'undefined') {MathJax.typesetPromise()}
        }, 200);
    }
</script>

<style>
    @media print
    {
        html *
        {
            display: none !important;
        }
    }
</style>


