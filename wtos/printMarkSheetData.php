<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
include('templateClass.php');
$template_class=new templateClass();

$historyIds = $os->get('historyId');

if($historyIds!='')
{
    $historyIds_arr=explode(',',$historyIds);
    $historyIds_arr=array_filter($historyIds_arr);
}


$history_id_str=implode(',',$historyIds_arr);

$exam_id = $os->get('exam_id');



    $eId = $exam_id;
	
	
	 //$hId = $os->post('hId');
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Mark Sheet Print</title>
</head>

<body>
 



<div style="width:100%; padding: 15px; text-align:center;" id="printBtn"><input type="button" onClick="printPage()" value="Print" />
</div>
<script>
    function printPage(){
        document.getElementById("printBtn").style.display="none";
        window.print();
        document.getElementById("printBtn").style.display="block";
    }

</script>
<div class="admin_print_block">
<?	 
	 
	 
	foreach($historyIds_arr as $hId) 
	
	{
	 
   
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

            <div style="margin:50px auto; padding: 15px; border: 1px solid #000; text-align: center; display:none;">
                <p style="text-align: center; font-size: 13px; line-height: 18px">
                    <strong>Regd. Office:  </strong><br>
                    <strong>Central Office : </strong><br>
                    <strong>Email :   </strong>
                    <strong>Website : </strong>
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
  




}
?>
 </div>
 
</body>
</html>
<?











exit();


$query_in_studentId="SELECT h.studentId FROM `history` h where  h.historyId IN ($history_id_str)";



$query="SELECT * FROM `exam` where  examId='$exam_id'";
$rsResults=$os->mq($query);
$record_exam=$os->mfa( $rsResults);
$examTitle=$record_exam['examTitle'];
$asession=$record_exam['asession'];
$class=$record_exam['class'];

$query="SELECT rd.* , s.* FROM `resultsdetails` rd 
        LEFT JOIN student s on rd.studentId=s.studentId		
		where  rd.asession='$asession' and  rd.examTitle='$examTitle' and  rd.class='$class' and  rd.studentId IN ($query_in_studentId) ";


$arr=array();
$rsResults=$os->mq($query);
while($record=$os->mfa( $rsResults))
{
    $arr[$record['studentId']]['result'][$record['resultsdetailsId']]=$record;
    $arr[$record['studentId']]['__exam_info__']= $template_class->he_or_she($record["gender"])." secured the marks shown against each subject in examination ".$record['examTitle']." ".$record['asession'];

    $arr[$record['studentId']]['__barcode__']=$os->student_barcode_href($record['studentId']);
    $arr[$record['studentId']]['__Image__']=$site['url'].$record['image'];
    $arr[$record['studentId']]['__Name__']=$record['name'];
    $arr[$record['studentId']]['__roll__']=$record['roll_no'];
    $arr[$record['studentId']]['__class__']= $os->classList[$record['class']]." ".$record['asession'];
    $arr[$record['studentId']]['__DOB__']=$record['dob'];
    $arr[$record['studentId']]['__Father__']=$record['father_name'];
    $arr[$record['studentId']]['__sec__']=$record['section'];
    $arr[$record['studentId']]['__grade_block__']=grade_block_design([]);


}


//__result_block__
function result_block_design($data)
{
    global $os, $site;





    $os->startOB();?>
    <!-- -->

    <table>
        <thead>
        <tr>
            <th>SL NO.</th>
            <th>Subject</th>
            <th>Total</th>
            <th>Written</th>
            <th>Viva</th>
            <th>Practical</th>
            <th>Total Obtain</th>
            <th>%</th>
            <th>Grade </th>
        </tr>
        </thead>
        <tbody>
        <?

        $marks_total_obtain=0;
        $fm_total = 0;
        $cc=0;
        foreach($data as $result_row){

            $cc++;

            $result_row['totalMarks']= $result_row['writtenMarks'] + $result_row['viva'] +$result_row['practical'];
            $marks=100;
            $percent=0;
            $percentage_total_obtain=0;
            if($result_row['totalMarks']>0)
            {
                $percent =$result_row['totalMarks']/$marks * 100;
                $percent = (int)$percent;
            }
            $marks_total_obtain +=$result_row['totalMarks'];
            $fm_total +=$marks;
            ?>
            <tr>
                <td style="width: 20px"><?= $cc;?></td>
                <td><? echo $result_row['subjectName'];  ?>   </td>
                <td><? echo $marks;  ?>   </td>
                <td><? echo $result_row['writtenMarks'];  ?>   </td>
                <td><? echo $result_row['viva'];  ?>   </td>
                <td><? echo $result_row['practical'];  ?>   </td>
                <td><? echo $result_row['totalMarks'];  ?>   </td>
                <td><? echo $percent  ?>%  </td>
                <td><? echo $result_row['grade'];  ?> </td>
            </tr>
        <? } ?>

        <tr>
            <td colspan="6" style="border-bottom: transparent; border-left: transparent"></td>
            <td style="font-weight: bold"><?=$marks_total_obtain;?></td>
            <td style="font-weight: bold"><?=($marks_total_obtain/$fm_total)*100;?>%</td>
            <td style="font-weight: bold"><? echo $result_row['overall_grade'];  ?></td>
        </tr>
        </tbody>
    </table>

    <?
    $result_block_design= $os->getOB();
    return  $result_block_design;
}
function grade_block_design($data){
    global $os, $site;

    $os->startOB();?>
    <!-- -->
    <table>
        <thead>
        <tr>
            <th>Marks Scale</th>
            <th>Grade</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>90 - 100</td>
            <td>AA</td>
            <td>Outstanding</td>
        </tr>
        <tr>
            <td>80 - 89</td>
            <td>A+</td>
            <td>Excelent</td>
        </tr>
        <tr>
            <td>60 - 79</td>
            <td>A</td>
            <td>Very Good</td>
        </tr>
        <tr>
            <td>45 - 59</td>
            <td>B+</td>
            <td>Good</td>
        </tr>
        <tr>
            <td>35 - 44</td>
            <td>B</td>
            <td>Satisfactory</td>
        </tr>
        <tr>
            <td>25 - 34</td>
            <td>C</td>
            <td>Marginal</td>
        </tr>
        <tr>
            <td>Below 25</td>
            <td>D</td>
            <td>Disqualified</td>
        </tr>

        </tbody>
    </table>
    <?
    $grade_block_design= $os->getOB();
    return  $grade_block_design;
}
 global $template_class;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Mark Sheet Print</title>
</head>

<body>
<div style="width:100%; padding: 15px; text-align:center;" id="printBtn"><input type="button" onClick="printPage()" value="Print" />
</div>
<div class="admin_print_block">
    <?

    foreach($arr as $examData)
    {


        $resultData['__result_block__']=result_block_design($examData['result']);
        $resultData['__exam_info__']= $examData['__exam_info__'] ;


        $resultData['__barcode__']=$examData['__barcode__'];
        $resultData['__Image__']= $examData['__Image__'];
        $resultData['__Name__']=$examData['__Name__'];
        $resultData['__roll__']=$examData['__roll__'];
        $resultData['__class__']=$examData['__class__'];
        $resultData['__DOB__']=$examData['__DOB__'];$examData['__sec__'];
        $resultData['__Father__']=$examData['__Father__'];
        $resultData['__sec__']=$examData['__sec__'];
        $resultData['__note_block__']= '' ;
        $resultData['__grade_block__']= $examData['__grade_block__'] ;



        ?>
        <div style="padding:5px;  break-after: page;" >
        <? echo  $template_class->render_marksheet($resultData,$template='');  ?>
        </div>
    <? }
    ?>
    <div style="clear:both;"></div>

</div>
<script>
    function printPage(){
        document.getElementById("printBtn").style.display="none";
        window.print();
        document.getElementById("printBtn").style.display="block";
    }

</script>

</body>
</html>
