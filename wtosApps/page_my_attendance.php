<?php
global $os,$site,$session_selected;
$ajaxFilePath= $site['url'].'wtosApps/'.'page_my_attendance_ajax.php';

if(! $os->isLogin() ){
    ?>
    <a href="<? echo $site['url']; ?>login"> Click Here To Login Please.</a>
    <?
}else{
    $studentId=$os->userDetails['studentId'];
    $name=$os->userDetails['name'];
    echo $name;
    ?>
    <?
    $asession=$session_selected;
    $class=$os->rowByField($getfld='class',$tables='history',$fld='studentId',$fldVal=$studentId,$where=" and asession=$session_selected ",$orderby='');
    // $query="select distinct DATE_FORMAT(dated, '%d') d, YEAR(dated) y, MONTH(dated) m ,count(*) c from attendance where  absent_present='P' and asession='$asession' and class='$class' group by y,m,d";
    $query="select distinct DATE_FORMAT(dated, '%d') d, YEAR(dated) y, MONTH(dated) m ,count(*) c from attendance where  absent_present='P' and asession='$asession'  group by y,m,d";

    $query_rs=$os->mq($query);
    $data_grid_total=array();
    while($data_att=$os->mfa($query_rs)){
        $y=$data_att['y'];
        $m=$data_att['m'];
        if(isset($data_grid_total[$y][$m])){
            $data_grid_total[$y][$m]=$data_grid_total[$y][$m]+1;
        }else{
            $data_grid_total[$y][$m]=1;
        }
    }

    // $query_s="select distinct DATE_FORMAT(dated, '%d') d, YEAR(dated) y, MONTH(dated) m ,count(*) c from attendance where studentId='$studentId' and absent_present='P'  and asession='$asession' and class='$class' group by y,m,d";
    $query_s="select distinct DATE_FORMAT(dated, '%d') d, YEAR(dated) y, MONTH(dated) m ,count(*) c from attendance where studentId='$studentId' and absent_present='P'  and asession='$asession' group by y,m,d";

    $query_mq=$os->mq($query_s);
    $data_grid_student=array();
    while($data_att=$os->mfa($query_mq)){
        $y=$data_att['y'];
        $m=$data_att['m'];
        if(isset($data_grid_student[$y][$m])){
            $data_grid_student[$y][$m]=$data_grid_student[$y][$m]+1;
        }else{
            $data_grid_student[$y][$m]=1;
        }
    }
    $SubjectList=array();
    if(count($data_grid_student)>0){?>
        <table class="uk-table uk-table-divider"   title="attendance table">
            <? foreach($data_grid_total as $year=>$months){ ?>
                <tr class="trListing">
                    <td colspan="10" style="background-color:#006595; color:#FFFFFF;"> <b> Attendance   <? echo $os->classList[$class]; ?> <? echo $year ?>  </b> </td>
                </tr>
                <tr class="borderTitle">
                    <td><b>Month</td>
                    <td><b>Total   Class</b></td>
                    <td><b>Attended</b></td>
                    <td><b>%</b></td>
                    <td><b>View Attendance</b></td>
                </tr>
                <?
                $sum_total_class_all_month=0;$sum_present_class_all_month=0;
                foreach($months as $month=>$count){
                    $total_class_per_month=$data_grid_total[$year][$month];
                    $sum_total_class_all_month=$sum_total_class_all_month+$total_class_per_month;
                    $present_on_perticular_month=$data_grid_student[$year][$month]??0;
                    $sum_present_class_all_month=$sum_present_class_all_month+$present_on_perticular_month;
                    $percent=0;
                    if($total_class_per_month>0){
                        $percent=$present_on_perticular_month/$total_class_per_month *100;
                        $percent=(int) $percent;
                    }
                    ?>

                    <tr class="trListing">
                        <td > <? echo  $os->feesMonth[(int)$month] ?> </td>
                        <td > <? echo $total_class_per_month ?> </td>
                        <td > <? echo $present_on_perticular_month ?></td>
                        <td > <? echo $percent ?> %  </td>
                        <td> 
                            <!-- <span  class="actionLink" ><a href="javascript:void(0)"  onclick="attendanceDetails('<? echo $studentId;?>','<? echo $asession;?>','<? echo $class;?>','<? echo $month;?>','<? echo $year;?>')" >View Details</a></span> -->
                            <span uk-tooltip="title:View Details; delay: 100">
                             <a href="javascript:void(0)"   onclick="attendanceDetails('<? echo $studentId;?>','<? echo $asession;?>','<? echo $class;?>','<? echo $month;?>','<? echo $year;?>')" uk-icon="icon:file-text"></a></span>
                         </td>
                     </tr>


                 <? } ?>

                 <tr class="trListing">
                    <td > Total : </td>
                    <td > <? echo $sum_total_class_all_month ?> </td>
                    <td > <? echo $sum_present_class_all_month ?></td>
                    <td > <? echo (int)($sum_present_class_all_month/$sum_total_class_all_month *100) ?> %  </td>
                    <td></td>
                </tr>
            <? } ?>
        </table>

        <?
    }else{

        echo 'Attendance not entered for this session.';
    } ?>
<? } ?>

<div id="attendance_details_modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-card uk-card-default uk-card-small">

            <div class="uk-card-header">
                <h5>Attendance Details</h5>
            </div>
            <div  id="WT_attendanceDetailsDiv">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function attendanceDetails(studentId,asession,classVal,monthVal,yearVal){
        var formdata = new FormData();
        formdata.append('studentId',studentId);
        formdata.append('class',classVal);
        formdata.append('asession',asession);
        formdata.append('month',monthVal);
        formdata.append('year',yearVal);
        var url='<? echo $ajaxFilePath ?>?WT_attendanceDetailsListing=OK&';
        os.animateMe.html='<div class="loadText">&nbsp;Please wait. Working...</div>';
        os.setHtml('WT_attendanceDetailsDiv','');         
        os.setAjaxHtml('WT_attendanceDetailsDiv',url,formdata);
        UIkit.modal('#attendance_details_modal').show();        
    }
</script>
<style>
    .noBorder td{ padding:3px; border: 1px solid #F4F4F4;}
</style>

