<?php

include('wtosConfigLocal.php');
set_time_limit (0);
include($site['root-wtos'].'wtosCommon.php');

$listingQuery = $os->getSession('download_student_result_report_excel');

if($listingQuery==''){exit();}
$data = $os->mq($listingQuery);
$count=1;

$total_student=0;
$attended_student=0;
$fields =array();

$os->startOB();

?>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <tr style="background-color:#C0C0C0">
            <td>SL</td>
            <td>Name</td>
            <td>Reg. No</td>
            <td>Branch</td>
            <td>Class</td>
            <td>Exam Title</td>
            <td>Subject</td>
        </tr>

        <?


        while($record = $os->mfa($data))
        {

            $total_student=$total_student +1 ;
            if($record['examTitle']!='')
            {

                $attended_student=$attended_student +1 ;
            }
            $examTitle = $record['examTitle'].' '.$os->classList[$record['class']];
			  
            ?>



            <tr <? if($record['examTitle']==''){echo 'style="background-color:#FFC4C4"';} ?>  >
                <td> <? echo  $count ; ?></td>
                <td><? echo  $record['name'] ; ?></td>
                <td><? echo  $record['registerNo'] ; ?></td>
                <td><? echo  $record['branch'] ; ?></td>
                <td><? echo  $os->classList[$record['class']];?></td>
                <td><? echo  $record['examTitle'] ; ?></td>
                <td><? echo  $record['subjectName'] ; ?></td>
            </tr>

            <?


            $count++;

        }
        ?>
    </table>
    <style>
        table tr td{
            padding: 2px 5px;
        }
    </style>
<?

$absent=$total_student - $attended_student;

$data=$os->getOB();
$os->startOB();
?>
    <table style="font-size: 30px; margin-bottom: 15px; border-collapse: collapse" border="1" >
        <tr>
            <td colspan="2">
                <?=$examTitle;?>
            </td>
        </tr>
        <tr>
            <td>Total </td>
            <td><? echo $total_student; ?></td>
        </tr>
        <tr>
            <td> Attended </td>
            <td style="color: green"><? echo $attended_student; ?></td>
        </tr>
        <tr>
            <td>Absent </td>
            <td style="color: red"><? echo $absent; ?></td>
        </tr>
    </table>


<?

$data_head=$os->getOB();
$data=$data_head.$data;
$fileName='download_student_result_report.html';
$fp = fopen($fileName, 'w');
fwrite($fp,$data,9999999999);

$fileName_html=$site['url-wtos'].$fileName;

$filepdf='download_student_result_report.pdf';
$filepdf_url=$site['root-wtos'].$filepdf;

exec("wkhtmltopdf   $fileName_html  $filepdf_url");

//echo $data;
 


header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename='.$filepdf);
header('Pragma: no-cache');
readfile($filepdf_url);
