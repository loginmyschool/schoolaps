<?
error_reporting(E_ALL);
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'wtosCommon.php');
//composer
require_once __DIR__.'/../vendor/autoload.php';
$pluginName='';
$os->loadPluginConstant($pluginName);
$os->showPerPage=10000;
$access_name = "Student Result Report";
$branch_codes_all = $os->get_branches_by_access_name($access_name);

if($os->get('WT_resultsdetailsListing')=='OK' && $os->post('resultDetailsListingVal')=='OKS'){

    $where='';
    $showPerPage        = $os->post('showPerPage');
    //result_details
    $and_subject_rd     = $os->postAndQuery('subject_s','rd.subjectId','=');
    //student details
    $and_branch_s       = $os->postAndQuery('branch_s','st.branch','=');
    $and_registerNo_s   = $os->postAndQuery('registerNo_s','st.registerNo','%');
    //class id
    $and_asession_h     = $os->postAndQuery('asession','h.asession','=');
    $and_examId_ed = $os->postAndQuery('examId_s','ed.examId','=');

    //registration Number'

    $subjectId  = $os->post('subject_s');

    $branch_codes = $os->get_branches_by_access_name('Student Result details', $os->loggedUser()['access']);
    $branch_codes = "'".implode("', '", $branch_codes)."'";


    $and_branch_s = $os->loggedUser()["adminType"]=="Super Admin"?"":"AND branch_code IN($branch_codes)";

    if($os->loggedUser()['adminType']=='Super Admin'){
        $and_branch_s = '';
    }

    $examdetails = $os->mfa($os->mq("SELECT 
            ed.*, 
            e.examTitle, 
            eg.exam_mode,
            sub.subjectName,
            ed.subjectId,
            (SELECT GROUP_CONCAT(concat('\'',egca.asession,'_',egca.class, '\'')) FROM exam_group_class_access egca WHERE egca.exam_group_id=eg.exam_group_id) AS asession_classes
        FROM examdetails ed
            INNER JOIN exam e ON(e.examId=ed.examId AND e.asession='".$os->post('asession')."')
            INNER JOIN subject sub ON(sub.subjectId=ed.subjectId)
            INNER JOIN exam_group eg ON(eg.exam_group_id= ed.exam_group_id)
            WHERE ed.examId='".$os->post('examId_s')."' 
            AND ed.subjectId='".$os->post('subject_s')."'
            "));


    if(!$examdetails){
        print "No Data Found";
        exit();
    }

    $exam_type = $examdetails['exam_mode'];
    $examTitle = $examdetails['examTitle'];
    $examdetailsId = $examdetails['examdetailsId'];
    $totalMarks = $examdetails['totalMarks'];
    $vivaMarks = $examdetails['viva'];
    $writtenMarks = $examdetails['written'];
    $subjectName = $examdetails['subjectName'];
    $subjectId= $examdetails['subjectId'];
    $asession_classes = $examdetails['asession_classes'];
    ///////////
    $listingQuery="select 
       h.studentId,
       h.historyId,
       h.class,
       st.name,
       st.registerNo,
       h.branch_code,
       h.asession
    FROM  history  as  h
	INNER JOIN student as st on(st.studentId=h.studentId)
    WHERE h.studentId>0 AND CONCAT(h.asession,'_',h.class) IN($asession_classes) AND h.class!='80' $and_branch_s $and_registerNo_s" ;

    $os->setSession($listingQuery, 'download_student_result_report_excel');
    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    $total_student=0;
    $attended_student=0;
    $branch_records = [];
    $history_branch_codes  = [];
    while($record = $os->mfa( $rsRecords)){
        $record["attend"] = 0;
        $hId = $record['historyId'];
        $branch_code = createIndex($record['branch_code']);
        $history_branch_codes[$hId] = $record['branch_code'];

        //branch_wise
        if(!isset($branch_records[$branch_code]['attended'])){
            $branch_records[$branch_code]['attended'] = 0;
            $branch_records[$branch_code]['written_attended'] = 0;
            $branch_records[$branch_code]['viva_attended'] = null;
            $branch_records[$branch_code]['total'] = 0;
        }
        $branch_records[$branch_code]['total']++;
        //overall
        if(!isset($branch_records['ALL']['attended'])){
            $branch_records['ALL']['attended'] = 0;
            $branch_records['ALL']['written_attended'] = 0;
            $branch_records['ALL']['viva_attended'] = null;
            $branch_records['ALL']['total'] = 0;
        }
        $branch_records['ALL']['total']++;


        //update marks
        $branch_records[$branch_code]['students'][$hId] = $record;
        $branch_records['ALL']['students'][$hId] = $record;

        $total_student++;
    }
    ///////

    $result_details = [];

    $result_sql = "SELECT
       rd.resultsdetailsId,
       rd.writtenMarks,
       rd.totalMarks,
       rd.viva,
       rd.historyId,
       rd.negative_attempt,
       rd.positive_attempt,
       rd.negative_attempt+rd.positive_attempt as attempt,
       rd.negative_marks,
       rd.positive_marks,
       IF(rd.writtenMarks='' OR rd.resultsdetailsId<=0,0,1) AS attend
    
    FROM resultsdetails rd
    WHERE rd.examdetailsId='$examdetailsId'
    ORDER BY rd.writtenMarks DESC";

    $result_query = $os->mq($result_sql);
    while ($rd_row = $os->mfa($result_query)){
        $hId = $rd_row['historyId'];
        $branch_code = createIndex($history_branch_codes[$hId]);


        if(!isset($branch_records[$branch_code]['students'][$hId])){
            continue;
        }
        $rec = array_merge($branch_records[$branch_code]['students'][$hId], $rd_row);
        $rec['percentage'] = round(($rec['totalMarks']/$totalMarks)*100,2);

        $branch_records[$branch_code]['students'][$hId] = $rec;
        $branch_records['ALL']['students'][$hId] = $rec;

        $branch_records[$branch_code]['attended']++;
        $branch_records['ALL']['attended']++;


        if($rec['writtenMarks']!=''){
            $branch_records[$branch_code]['written_attended']++;
            $branch_records['ALL']['written_attended']++;
        }

        if($vivaMarks>0 && $rec['viva']!=''){
            $branch_records[$branch_code]['viva_attended']++;
            $branch_records['ALL']['viva_attended']++;
        }
    }
    ksort($branch_records);
    ?>
    <div class="uk-padding-small">
        <div class="uk-grid uk-grid-small " uk-grid>

            <div class="uk-width-auto">
                <table class="uk-table uk-table-divider uk-table-striped uk-table-hover congested-table  background-color-white">
                    <thead>
                    <tr>
                        <td>#</td>
                       <td>Branch</td>
                       <td>Total</td>
                       <td>Attended</td>
                       <td>Absent</td>
                    </tr>
                    </thead>
                    <tbody id="branches_list">
                    <?
                    $index = -1;
                    $class="branch_active";
                    foreach ($branch_records as $branch_name => $branch) {
                        $index++;
                        $branch_index = createIndex($branch);

                        ?>
                        <tr onclick="switchBranch(<?=$index?>)" class="pointable <?=$class;?>">
                            <td><?=$index+1?></td>
                            <td><font color="red"> [<?=$branch_name?>]</font> - <?= $branch_codes_all[$branch_name]; ?></td>
                            <td><?= $branch['total']?></td>
                            <td class="uk-text-success"><?= $branch["attended"] ?></td>
                            <td class="uk-text-danger"><?= $branch["total"] - $branch["attended"] ?></td>
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
                foreach ($branch_records as $branch=>$branch_details) {
                    $records = $branch_details['students'];
                    usort($records, function($a, $b) {
                        return $a['name'] <=> $b['name'];
                    });
                    usort($records, function($a, $b) {
                        return $b['attend'] <=> $a['attend'];
                    });
                    usort($records, function($a, $b) {
                        return $b['percentage'] <=> $a['percentage'];
                    });



                    $histories = [];
                    foreach($records as $record){
                        $histories["All"][] = $record;
                        $histories[$record["class"]][] = $record;
                    }
                    if(sizeof($histories)<3){
                        unset($histories["All"]);
                    }
                    ?>
                    <div style="<?= $style?>">
                        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                            <? foreach ($histories as $class=>$records){?>
                                <li>
                                    <a>
                                        <?=$class!="All"?$os->classList[$class]:$class;?> (<label class="uk-text-success uk-text-bolder"><?= sizeof($records)?></label>)
                                    </a>
                                </li>
                            <? } ?>
                        </ul>
                        <ul class="uk-switcher uk-margin">
                            <? foreach ($histories as $class=>$records){?>
                            <li>
                                <table class="uk-table congested-table uk-table-striped uk-table-divider background-color-white uk-width-expand uk-margin-remove">
                                    <thead>
                                    <tr>
                                        <th class="uk-table-shrink">#</th>
                                        <th class="uk-table-shrink"><b>Action</b></th>
                                        <th>Name</th>
                                        <th class="uk-text-nowrap">Reg No</th>
                                        <th>Branch</th>
                                        <th>Class</th>
                                        <th class="uk-hidden">Exam</th>
                                        <th class="uk-hidden">Subject</th>
                                        <? if($exam_type=="Online"):?>
                                            <th class="uk-text-success" nowrap="">(+) Attempt</th>
                                            <th class="uk-text-danger" nowrap="">(-) Attempt</th>
                                            <th>Attempt</th>

                                            <th class="uk-text-success" nowrap="">(+) Marks</th>
                                            <th class="uk-text-danger" nowrap="">(-) Marks</th>
                                        <?endif;?>
                                        <th class="">Writt.</th>
                                        <? if($vivaMarks>0){?>
                                            <th class="">Viva</th>
                                        <? } ?>
                                        <th class="">Obtain</th>

                                        <th class="uk-text-right">%</th>
                                    </tr>
                                    </thead>
                                    <tbody class="filter-<?=$record['branch_code']?>">
                                    <?php
                                    $serial = 0;
                                    foreach($records as $record){

                                        $serial++; ?>
                                        <tr class="tag-<?=$record['branch_code']."-".$record["class"]?>"
                                            style="<?=$os->val($record,'attend')==0?'background-color:rgba(255,0,0,0.3)':''?>">
                                            <td><?php echo $serial; ?></td>
                                            <td>
                                                <? if($exam_type=="Online" && false){?>
                                                    <a onclick="resultDetailsView(<?=$record['resultsdetailsId']?>)">
                                                        <i class="las la-file-alt"></i>
                                                    </a>
                                                <?}?>

                                                <a onclick="viewStatistics(
                                                    <?=$record['historyId']?>,
                                                    <?=$subjectId;?>)">
                                                    <i class="las la-chart-bar"></i>
                                                </a>
                                            </td>
                                            <td><?= $record['name']; ?> </td>
                                            <td><?= $record['registerNo']?> </td>
                                            <td><?= $record['branch_code']; ?></td>
                                            <td><?= isset($os->classList[$record['class']])?$os->classList[$record['class']]:'';?></td>
                                            <td class="uk-hidden"><?= $examTitle?></td>
                                            <td class="uk-hidden"><?= $subjectName; ?></td>

                                            <? if($exam_type=="Online"):?>
                                                <td class="uk-text-success"><?= $record['positive_attempt']; ?></td>
                                                <td class="uk-text-danger"> <?= $record['negative_attempt']; ?></td>
                                                <td><?= $record['attempt']; ?></td>

                                                <td class="uk-text-bold uk-text-success"><?= $record['positive_marks'];?></td>
                                                <td class="uk-text-bold uk-text-danger"><?= $record['negative_marks'];?></td>
                                            <? endif; ?>

                                            <td class="uk-text-bold"><?= $record['writtenMarks'];?></td>
                                            <? if($vivaMarks>0){?>
                                                <th class=""><?= $record['viva'];?></th>
                                            <? } ?>
                                            <th class=""><?= $record['totalMarks'];?></th>
                                            <td class="uk-text-right uk-text-bold"><?= $record['percentage'];?>% </td>

                                        </tr>
                                        <?

                                    }?>
                                    </tbody>
                                </table>
                            </li>
                            <?}?>
                        </ul>


                    </div>
                    <? $style="display:none";
                } ?>



            </div>
        </div>
    </div>
    <?php exit(); } ?>
<?

function createIndex($key){
    return str_replace(" ", "-", strtolower($key));
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
    $exams_q = $os->mq("SELECT e.* FROM exam e 
        WHERE  e.class='$class_s' AND e.asession='$asession_s' AND (e.branch_codes LIKE '%$branch_code_s%' OR e.branch_codes='') GROUP BY e.examId") ;
    ?>
    <option value=""></option>
    <?
    while($exam = $os->mfa($exams_q))
    {
        ?>
        <option  name="" value="<?= $exam['examId']; ?>" /> <?= $exam['examTitle'] ?>  </option>
        <?
    }
    exit();

}



if($os->get('WT_resultdetailsView')=='OK' && $os->post('WT_resultdetailsView')=='OK'){

    $resultsdetailsId = $os->post("resultsdetailsId");
    $result_details = $os->mfa($os->mq("SELECT * FROM resultsdetails WHERE resultsdetailsId=$resultsdetailsId"));

    $examdetailsId= $result_details['examdetailsId'];
    $studentId = $result_details['studentId'];

    $questionquery = $os->mq("SELECT 
       q.questionId, 
       q.marks,
       q.negetive_marks,
       q.questionText, 
       q.answerText1,
       q.answerText2,
       q.answerText3,
       q.answerText4,
       q.questionImage,
       q.answerImage1,
       q.answerImage2,
       q.answerImage3,
       q.answerImage4,
       q.correctAnswer,
       qa.questionanswaredId,
       qa.answerSelected
    

        FROM question q
        LEFT JOIN questionanswared qa ON(qa.questionId=q.questionId AND qa.studentId=$studentId)
        WHERE q.examdetailsId=$examdetailsId
        ORDER BY viewOrder");
    $questiondetails = [];
    $full_mark = 0;
    $obtain_mark = 0;

    while($question = $os->mfa($questionquery)){
        $full_mark+=$question["marks"];
        if($question["correctAnswer"]==$question["answerSelected"]){
            $obtain_mark +=  $question["marks"];
        } elseif($question["questionanswaredId"]!=""){
            $obtain_mark -=  $question["negetive_marks"];
        }
        $questiondetails[]= $question;
    }
    $obtain_percentage = number_format((float)(($obtain_mark/$full_mark)*100), 2, '.', '');;
    ?>
    <table class="text-l">
        <tr>
            <td>Full Marks</td>
            <td><?=$full_mark?></td>
        </tr>
        <tr>
            <td>Obtain</td>
            <td><?=$obtain_mark;?></td>
        </tr>
        <tr>
            <td>Percentage</td>
            <td><?=$obtain_percentage;?></td>
        </tr>
    </table>

    <h3 class="m-top-xl">Answers</h3>
    <table  style="border-collapse: collapse">
        <?
        $count = 0;
        $success_color = "background-color:rgba(0,255,0,0.3)";
        foreach ($questiondetails as $question){
            $wrong_select = $question['answerSelected']!=$question['correctAnswer']?$question['answerSelected']:0;
            $correct_select = $question['answerSelected']==$question['correctAnswer']?$question['answerSelected']:0;
            $correct_ans = $question['correctAnswer'];
            $count++;
            ?>
            <tr>
                <td class="p-bottom-m text-l" style="vertical-align: top; padding-right: 10px"><?=$count;?></td>
                <td class="p-bottom-m">
                    <span class="text-l"><? echo $question["questionText"]; ?></span>
                    <table class="uk-margin-small">
                        <tr
                                style="<?=$correct_ans==1?'color:blue;':''?> <?=$wrong_select==1?'color:red;':''?> <?=
                        $correct_select ==1?'color:green;':''?>">
                            <td class="p-bottom-m p-right-m" style="color: blue">1.</td>
                            <td class="p-bottom-m">
                                <? echo $question["answerText1"]; ?>
                                <? if($question['answerImage1']!=''){ ?>
                                    <img src="<? echo $site['url'].$question['answerImage1'] ?>"
                                         style="height:100px;" />
                                <? } ?>
                            </td>
                        </tr>

                        <tr
                                style="<?=$correct_ans==2?'color:blue;':''?> <?=$wrong_select==2?'color:red;':''?> <?=
                        $correct_select ==2?'color:green;':''?>">
                            <td class="p-bottom-m p-right-m" style="color: blue">2.</td>
                            <td class="p-bottom-m">
                                <? echo $question["answerText2"]; ?>
                                <? if($question['answerImage2']!=''){ ?>
                                    <img src="<? echo $site['url'].$question['answerImage2'] ?>"  style="height:100px;" />
                                <? } ?>
                            </td>
                        </tr>

                        <tr
                                style="<?=$correct_ans==3?'color:blue;':''?> <?=$wrong_select==3?'color:red;':''?> <?=
                        $correct_select ==3?'color:green;':''?>">
                            <td class="p-bottom-m p-right-m" style="color: blue">3.</td>
                            <td class="p-bottom-m">
                                <? echo $question["answerText3"]; ?>
                                <? if($question['answerImage3']!=''){ ?>
                                    <img src="<? echo $site['url'].$question['answerImage3'] ?>"
                                         style="height:100px;" />
                                <? } ?>
                            </td>
                        </tr>

                        <tr
                                style="<?=$correct_ans==4?'color:blue;':''?> <?=$wrong_select==4?'color:red;':''?> <?=
                        $correct_select ==4?'color:green;':''?>">
                            <td class="p-bottom-m p-right-m" style="color: blue">4.</td>
                            <td class="p-bottom-m">
                                <? echo $question["answerText4"]; ?>
                                <? if($question['answerImage4']!=''){ ?>
                                    <img src="<? echo $site['url'].$question['answerImage4'] ?>"
                                         style="height:100px;" />
                                <? } ?>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <?
        }
        ?>
    </table>

    <?
}
if($os->get('WT_statistics_view')=='OK' && $os->post('WT_statistics_view')=='OK'){
    $hId = $os->post("hId");
    $subjectId = $os->post('subjectId');


    $attempts = [
        "labels"=>  [],
        "datasets"=> [
            [
                'type'=> 'line',
                'label'=> 'Total Attempt(%)',
                'borderColor'=> 'rgb(0,0,255)',
                'borderWidth'=> 2,
                'fill'=> 'origin',
                'lineTension'=> 0,
                'data'=> []
            ],
            [
                'type'=> 'bar',
                'label'=> 'Negative Attempt(%)',
                'backgroundColor'=> 'red',
                'borderColor'=> 'white',
                'borderWidth'=> 2,
                'data'=> []
            ],
            [
                'type'=> 'bar',
                'label'=> 'Positive Attempt(%)',
                'backgroundColor'=> 'green',
                'data'=> []
            ]
        ]
    ];
    $marks = [
        "labels"=>  [],
        "datasets"=> [
            [
                'type'=> 'line',
                'label'=> 'Obtain(%)',
                'borderColor'=> 'rgb(0,0,255)',
                'borderWidth'=> 2,
                'fill'=> 'origin',
                'lineTension'=> 0,
                'data'=> []
            ],
            [
                'type'=> 'bar',
                'label'=> 'Negative(%)',
                'backgroundColor'=> 'red',
                'borderColor'=> 'white',
                'borderWidth'=> 2,
                'data'=> []
            ],
            [
                'type'=> 'bar',
                'label'=> 'Positive(%)',
                'backgroundColor'=> 'green',
                'data'=> []
            ]
        ]
    ];


    print $subjectId;
    $results = $os->mq("SELECT 
       e.examTitle,
       ed.*,
       ed.written,
       (SELECT COUNT(*) FROM question q WHERE q.examdetailsId=ed.examdetailsId) as total_questions,
       rd.negative_attempt,
       rd.positive_attempt,
       rd.negative_marks,
       rd.positive_marks,
       rd.writtenMarks,
       (rd.negative_attempt+rd.positive_attempt) as total_attempt
    FROM examdetails ed 
    INNER JOIN resultsdetails rd ON rd.examdetailsId=ed.examdetailsId
    INNER JOIN exam e ON e.examId=ed.examId
    WHERE  rd.historyId='$hId' AND ed.subjectId='$subjectId'");
    while ($result = $os->mfa($results)){
        //Attempt
        $total_attempt = ($result['total_attempt']/$result['total_questions'])*100;
        $negative_attempt = ($result['negative_attempt']/$result['total_questions'])*100;
        $positive_attempt = ($result['positive_attempt']/$result['total_questions'])*100;
        $attempts['labels'][]=$result['examTitle'];
        $attempts['datasets'][0]['data'][] = round($total_attempt,2);
        $attempts['datasets'][1]['data'][] = -round($negative_attempt,2);
        $attempts['datasets'][2]['data'][] = round($positive_attempt,2);

        //Marks
        $obtain = ($result['writtenMarks']/$result['written'])*100;
        $negative_marks = ($result['negative_marks']/$result['written'])*100;
        $positive_marks = ($result['positive_marks']/$result['written'])*100;
        $marks['labels'][]=$result['examTitle'];
        $marks['datasets'][0]['data'][] = round($obtain,2);
        $marks['datasets'][1]['data'][] = -round($negative_marks,2);
        $marks['datasets'][2]['data'][] = round($positive_marks,2);
    }

    $report["attempts"] = $attempts;
    $report["marks"] = $marks;


    echo '##--chart_data--##';
    print json_encode($report);
    echo '##--chart_data--##';
    echo '##--data_container--##';
    ?>
    <div class="uk-container">
        <h3 class="uk-margin uk-text-center">Exam Statistics</h3>
        <canvas id="student_overall_attempts_stat"></canvas>
        <canvas id="student_overall_marks_stat"></canvas>
    </div>
    <?
    echo '##--data_container--##';


}
?>

