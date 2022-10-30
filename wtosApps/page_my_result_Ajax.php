<?
session_start();
include('../wtosConfig.php');
include('os.php');
global $os, $site;
use mikehaertl\wkhtmlto\Pdf;
//
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
                h.branch_code as branch 

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

//

$os->userDetails =$os->session($os->loginKey,'logedUser');
$studentId = $os->userDetails['studentId'];
$os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');


if($os->get('WT_fetch_answer_sheet')=='OK' && $os->post('WT_fetch_answer_sheet')=='OK'){
    $exam_group_id = $os->post('exam_group_id');

    $os->render_answer_sheet($exam_group_id, $studentId);

    exit();
}

if($os->get("WT_render_grade_card")=='OK'){

    $eId = $os->get('examId');
    $hId = $os->get('hId');
    $exam = $os->mfa($os->mq("SELECT * FROM exam e WHERE e.examId='$eId'"));
    $history = $os->mfa($os->mq("SELECT * FROM history h INNER JOIN student s ON s.studentId=h.studentId  WHERE h.historyId='$hId'"));
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
    $file_name = str_replace(".",'','grade_card_'.$os->userDetails['name'].'('.$exam['examTitle'].')');
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
        <title>Grade Card-<?=$os->userDetails['name']?>[ <?= $exam['examTitle']?>]</title>
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
                            <?=$os->userDetails['name']?>
                        </td>
                    </tr>
                </table>
                <table style="margin: 5px auto">
                    <tr>
                        <th style="white-space: nowrap; width: 350px; text-align: left">Mother's Name/ Father's Name/
                            Guardian's
                            Name:</th>
                        <td><?=$os->userDetails['father_name'] ?></td>
                    </tr>
                </table>
                <table style="margin: 5px auto">
                    <tr>
                        <th style="width: 100px; text-align: left">Date of Birth :</th>
                        <td><?=$os->showDate($os->userDetails['dob'])?></td>
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

            <div style="margin:50px auto; padding: 15px; border: 1px solid #000; text-align: center; display:none">
                <p style="text-align: center; font-size: 13px; line-height: 18px">
                    <strong>Regd. Office: </strong><br>
                    <strong>Central Office :  </strong><br>
                    <strong>Email :   </strong>
                    <strong>Website :   </strong>
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

 echo $con ; exit();


    $path = realpath($site['root'].'cache/pdf');
    $http_pdf = $site['url'].'cache/pdf/'.$file_name.'.pdf';
    // You can pass a filename, a HTML string, an URL or an options array to the constructor


    $pdf = new Pdf(array(
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

if($os->get('print_rank_card'=='OK')){
    $eId = base64_decode($os->get('eId'));
    $hId = $os->get('hId');
    $sId = $os->userDetails['studentId'];
    $class = $os->get('class');
	
 
    $ranks_all = get_exam_rank($sId, [$eId]);

    //
    $history = $os->mfa($os->mq("SELECT * FROM history h WHERE h.historyId='$hId'"));
    $student = array_merge($history,$os->userDetails);

    //exam
    $exam = $os->mfa($os->mq("SELECT * FROM exam WHERE examId='$eId'"));
    //results
    $results = [];
    $results_q = $os->mq("SELECT 
       rd.*,
       sub.subjectName,
       ed.subjectId
    FROM examdetails ed
    INNER JOIN subject sub ON(sub.subjectId=ed.subjectId)
    INNER JOIN resultsdetails rd ON(rd.examdetailsId = ed.examdetailsId)
    WHERE rd.historyId='".$student['historyId']."' AND rd.examId='$eId'");

    //max marks
    $max_marks = get_exam_max([$eId]);

    $con = '';
    ob_start();
    ?>
    <html lang="en-gb">
    <head>
        <style>
            *{
                box-sizing: border-box;
                font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif;
                font-size: 13px;
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

            }
            .page{
                min-height: 100%;
                padding: 25px 35px;
                border: 1px solid green;
            }
            table{
                border-collapse: collapse;
                width: 100%;
            }
            table tbody tr td, table thead tr th{
                padding: 2px 3px;
            }
            table thead {
                background-color: #eeeeee;
            }
            table.main tbody tr td, table.main thead tr th{
                border: 1px solid #333;
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
    </head>
    <body>
    <div class="page">


        <h1 style="font-size: 20px; text-align: center">Rank Card</h1>

        <div style="margin:30px auto; padding: 15px; border: 1px solid #000;">

            <table style="margin: 5px auto">
                <tr>
                    <th style="width: 80px; text-align: left">Name :</th>
                    <td>
                        <?=$os->userDetails['name']?>
                    </td>
                </tr>
            </table>
            <table style="margin: 5px auto; display: none">
                <tr>
                    <th style="white-space: nowrap; width: 350px; text-align: left">Mother's Name/ Father's Name/
                        Guardian's
                        Name:</th>
                    <td><?=$os->userDetails['father_name'] ?></td>
                </tr>
            </table>
            <table style="margin: 5px auto">
                <tr>
                    <th style="width: 100px; text-align: left; display: none">Date of Birth :</th>
                    <td style="display: none"><?=$os->showDate($os->userDetails['dob'])?></td>
                    <th style="width: 80px; text-align: left">Class : </th>
                    <td><?=str_replace("CBSE","",$os->classList[$history['class']]) ?></td>
                    <!--th style="width: 80px; text-align: left">Section :</th><td><?=$history['section']
                    ?></td-->
                </tr>
            </table>
            <table style="margin: 5px auto">
                <tr>
                    <th style="width: 80px; text-align: left; display: none">Roll No. :</th><td
                            style="display: none"><?=$history['roll_no']
                        ?></td>
                    <th style="width: 80px; text-align: left">Regn. No. : </th><td><?=$history['registrationNo'] ?></td>
                </tr>
            </table>

        </div>
        <h1 style="font-size: 24px; text-align: center"><?= $exam['examTitle']?></h1>
        <table border="1" class="main">
            <thead>
            <tr>
                <th style="text-align: left">Subject Name</th>
                <th>Total Attempt</th>
                <th>Wrong Attempt</th>
                <th>Right Attempt</th>
                <th>Highest Marks</th>
                <th>Marks Obtained</th>
                <th>Total Marks Obtained</th>
                <th>Branch Rank</th>
                <th>All Branch Rank</th>
            </tr>
            </thead>
            <tbody>
            <?
            $results = [];
            $results["totalMarksObtain"] = 0;
            while ($result = $os->mfa($results_q)){
                $results['subjects'][] = $result;
                $results["totalMarksObtain"] += $result['totalMarks'];

            }?>
            <?
            $c=0;
            foreach ($results['subjects'] as $result){$c++;?>
                <tr>
                    <td><?=$result['subjectName']?></td>
                    <td style="text-align: center"><?=$result['negative_attempt']+$result['positive_attempt']?></td>
                    <td style="text-align: center"><?=$result['negative_attempt']?></td>
                    <td style="text-align: center"><?=$result['positive_attempt']?></td>
                    <td style="text-align: center"><?=$max_marks[$eId][$result['subjectId']]?></td>
                    <td style="text-align: center"><?=$result['totalMarks']?></td>

                    <?if($c==1){?>
                        <td rowspan="<?= sizeof($results['subjects'])?>"
                            style="text-align: center"><?= $results['totalMarksObtain'];?></td>
                        <td rowspan="<?= sizeof($results['subjects'])?>"
                            style="text-align: center"><?= $ranks_all['ranks']['branch'][$eId]?></td>
                        <td rowspan="<?= sizeof($results['subjects'])?>"
                            style="text-align: center"><?= $ranks_all['ranks']['overall'][$eId]?></td>
                    <?}?>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    </body>
    </html>
    <?

    $con = ob_get_contents();
    ob_end_clean();


    print $con; exit();

    // You can pass a filename, a HTML string, an URL or an options array to the constructor
    $path = realpath($site['root'].'cache/pdf');
    $file_name = str_replace(".",'','grade_card_'.$os->userDetails['name'].'('.$exam['examTitle'].')');
    $file_name = str_replace("-",'_', $file_name);
    $file_name = str_replace(" ",'-', $file_name);
    $file_name = strtolower($file_name);

    $pdf = new Pdf(array(
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
?>


