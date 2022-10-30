<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$autoloader_path = realpath($site['root'].'/vendor/autoload.php');
//composer
include($autoloader_path);
use mikehaertl\wkhtmlto\Pdf;
$pluginName='';

$os->loadPluginConstant($pluginName);
$os->question_level_arr=array('1'=>'1','2'=>'2','3'=>'3');
$os->question_type_arr=array('MCQ'=>'MCQ','DESC'=>'DESC');
$os->question_base_arr=array('Informative'=>'Informative','Math'=>'Math');
$os->correctAnswer_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4' );
ob_start();
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />

    </head>
    <body style="line-height:16px; font-size:11px;">
    <?

    $examdetailsId=$os->get('examdetailsId');


    $queation_count=array();
    $query_q_count=" select   count(*) cc, examdetailsId from question where examdetailsId='$examdetailsId' ";
    $query_q_countrs=$os->mq($query_q_count);
    $row=$os->mfa($query_q_countrs);
    $queation_count=$row['cc'];

    $query_q_count="select    ed.written,ed.viva,  s.subjectName,  e.examTitle ,  e.asession ,  e.class from examdetails ed 
		 INNER JOIN subject  s ON  ed.subjectId=s.subjectId	
		 INNER JOIN exam  e ON  e.examId=ed.examId	
		
		 where ed.examdetailsId='$examdetailsId' ";
    $query_q_countrs=$os->mq($query_q_count);
    $row_exam=$os->mfa($query_q_countrs);


    ?>
    <div style="color:#9F9F9F"  >
        Exam: <span style="color:#0000FF">  <? echo $row_exam['examTitle']; ?>  </span>
        Exam: <span style="color:#0000FF">  <? echo $row_exam['class']; ?>  </span>
        Year : <span style="color:#0000FF">  <? echo $row_exam['asession']; ?>  </span>   <br>
        Subject :  <span style="color:#0000FF"> <? echo $row_exam['subjectName']; ?>  </span>
        Written : <span style="color:#0000FF">  <? echo $row_exam['written']; ?> </span>
        Viva : <span style="color:#0000FF">  <? echo $row_exam['viva']; ?> </span>
    </div>
    <div  style="text-align:left; color:#999999; margin-right:10px;">




        No Of Question <b style="color:#FF0066;"> <? echo $queation_count; ?> </b></div>
    <div id="question_list_form" class="uk-grid" uk-grid>


        <div>

            <div>
                <?
                //$q_set_q=" Select * from  question  where examdetailsId='$examdetailsId' ORDER BY viewOrder ASC";
                $q_set_q=" Select q.*  
			from  question q, examdetails ed  
			where q.examdetailsId='$examdetailsId' and ed.examdetailsId='$examdetailsId'   and ed.examdetailsId=q.examdetailsId 
			ORDER BY viewOrder ASC";
                $q_set_q_rs=$os->mq($q_set_q);
                $serial=0;
                while($question_row=$os->mfa( $q_set_q_rs))

                {
                    $serial++;
                    ?>
                    <div class="uk-card uk-card-default uk-border-rounded uk-margin" style="margin-top:15px; border:1px solid #000000">
                        <div style="font-size:9px; text-align:right;">
                            Marks: <span class="color-primary uk-margin-right "><? echo  $question_row['marks']; ?></span>
                            Negative marks: <span class="color-primary uk-margin-right "><? echo  $question_row['negetive_marks']; ?></span>

                            Serial No  <span   class="color-primary uk-margin-right "><? echo  $question_row['viewOrder']; ?></span>
                            Correct Answer   <span   class="color-primary uk-margin-right "><? echo  $question_row['correctAnswer']; ?></span>
                            <!-- Type: <span class="color-primary uk-margin-right "><? echo  $question_row['type']; ?></span>-->
                        </div>

                        <div style=" background-color:#FFFFDD; border: 0px solid #CCCCCC; padding:2px; margin:0px; font-weight:bold;" >

						    <span title="ED: <? echo $examdetailsId ?>  Q:<? echo  $question_row['questionId']; ?>"
                                  class="text-m">
                                <span style="color:#CC00CC; font-weight:bold; font-size:11px;"><? echo  $question_row['viewOrder']; ?>.  </span>
                                <?= $os->render_all_mml($question_row['questionText']); ?>
                            </span>
                            <? if($question_row['questionImage']!=''){ ?>
                                <img src="<? echo $site['url'].$question_row['questionImage'] ?>"  style="height:100px" />
                            <? } ?>

                        </div>



                        <div class="uk-border-rounded" style="<?= $question_row['correctAnswer']==1?"background-color:rgba(0,255,0,0.3);font-weight:bold":""?>">
                            <table class="uk-table congested-table">
                                <tr>
                                    <td class="uk-table-shrink">1</td>
                                    <td><?= $os->render_all_mml( $question_row['answerText1']); ?>
                                        <? if($question_row['answerImage1']!=''){ ?>
                                            <img src="<? echo $site['url'].$question_row['answerImage1'] ?>"  style="height:100px" />
                                        <? } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="uk-border-rounded" style="<?= $question_row['correctAnswer']==2?"background-color:rgba(0,255,0,0.3);font-weight:bold":""?>">
                            <table class="uk-table congested-table">
                                <tr>
                                    <td class="uk-table-shrink">2</td>
                                    <td>
                                        <?= $os->render_all_mml(  $question_row['answerText2']); ?><br />
                                        <? if($question_row['answerImage2']!=''){ ?>
                                            <img src="<? echo $site['url'].$question_row['answerImage2'] ?>"  style="height:100px" />
                                        <? } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="uk-border-rounded" style="<?= $question_row['correctAnswer']==3?"background-color:rgba(0,255,0,0.3);font-weight:bold":""?>">
                            <table class="uk-table congested-table">
                                <tr>
                                    <td class="uk-table-shrink">3</td>
                                    <td>
                                        <?= $os->render_all_mml($question_row['answerText3']) ?><br />
                                        <? if($question_row['answerImage3']!=''){ ?>
                                            <img src="<? echo $site['url'].$question_row['answerImage3'] ?>"  style="height:100px" />
                                        <? } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="uk-border-rounded" style="<?= $question_row['correctAnswer']==4?"background-color:rgba(0,255,0,0.3);font-weight:bold":""?>">
                            <table class="uk-table congested-table">
                                <tr>
                                    <td class="uk-table-shrink"  >4</td>
                                    <td>
                                        <?= $os->render_all_mml($question_row['answerText4'])?><br />
                                        <? if($question_row['answerImage4']!=''){ ?>
                                            <img src="<? echo $site['url'].$question_row['answerImage4'] ?>"  style="height:100px;" />
                                        <? } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <? if($question_row['answer_hints']!='' || $question_row['answer_hints_image']!='' ) {?>

                            <div class="uk-border-rounded"  >
                                <div style="color:#009900; "> ANSWER HINTS </div>
                                <table class="uk-table congested-table">
                                    <tr>
                                        <td class="uk-table-shrink"> </td>
                                        <td>
                                            <? echo  $question_row['answer_hints']; ?><br />
                                            <? if($question_row['answer_hints_image']!=''){ ?>
                                                <img src="<? echo $site['url'].$question_row['answer_hints_image'] ?>"  style="height:100px" />
                                            <? } ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        <? } ?>

                    </div>
                <? } ?>

            </div>
        </div>
    </div>

    <?php


    ?>
    <style>
        .uk-table td{ padding:0px 0px 0px 20px; margin:0px;}
        .uk-padding-small {
            padding: 2px;
        }
        .uk-table {

            margin-bottom: 3px;
        }
        * + .uk-margin {
            margin-top: 5px !important;
        }
        .uk-margin {
            margin-bottom: 5px;
        }
    </style>
    </body>
    </html>
<?
$data = ob_get_contents();
ob_end_clean();

echo $data; exit();
$file_name=	$examdetailsId."_question_paper";
$path = realpath($site['root'].'cache/pdf');
$http_pdf = $site['url'].'cache/pdf/'.$file_name.'.pdf';
// You can pass a filename, a HTML string, an URL or an options array to the constructor
$pdf = new Pdf(array(
    'binary' => WKHTMLTOPDF_BIN,
));
$pdf->addPage($data);
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
    echo fread($fp, 6553666);
    flush(); // this is essential for large downloads
}
fclose($fp);
exit();
