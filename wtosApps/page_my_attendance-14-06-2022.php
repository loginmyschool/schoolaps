<?php
global $os,$site,$session_selected;


if(! $os->isLogin() )
{

    ?>
    <a href="<? echo $site['url']; ?>login"> Click Here To Login Please.</a>
    <?


}else{

    $studentId=$os->userDetails['studentId'];
    $name=$os->userDetails['name'];
    echo $name;
    ?>
    <?

    // $class=5;
    $asession=$session_selected;

    $class=$os->rowByField($getfld='class',$tables='history',$fld='studentId',$fldVal=$studentId,$where=" and asession=$session_selected ",$orderby='');



    //  $query="select  YEAR(dated) y, MONTH(dated) m, DATE_FORMAT(dated, '%d') d from attendance where  studentId='$studentId' and absent_present='P' group by YEAR(dated), MONTH(dated), DATE_FORMAT(dated, '%d')  ";

    //	 $query="select distinct DATE_FORMAT(dated, '%d') d, YEAR(dated) y, MONTH(dated) m ,count(*) c from attendance where class='$class' and absent_present='P' group by y,m,d";
    $query="select distinct DATE_FORMAT(dated, '%d') d, YEAR(dated) y, MONTH(dated) m ,count(*) c from attendance where  absent_present='P' group by y,m,d";
    $query_rs=$os->mq($query);

    $data_grid_total=array();

    while($data_att=$os->mfa($query_rs))
    {


        $y=$data_att['y'];
        $m=$data_att['m'];

        if(isset($data_grid_total[$y][$m]))
        {
            $data_grid_total[$y][$m]=$data_grid_total[$y][$m]+1;
        }else
        {

            $data_grid_total[$y][$m]=1;
        }


    }




    $query="select distinct DATE_FORMAT(dated, '%d') d, YEAR(dated) y, MONTH(dated) m ,count(*) c from attendance where studentId='$studentId' and absent_present='P' group by y,m,d";
    $query_rs=$os->mq($query);

    $data_grid_student=array();

    while($data_att=$os->mfa($query_rs))
    {
        $y=$data_att['y'];
        $m=$data_att['m'];



        if(isset($data_grid_student[$y][$m]))
        {
            $data_grid_student[$y][$m]=$data_grid_student[$y][$m]+1;
        }else
        {

            $data_grid_student[$y][$m]=1;
        }



    }


    $SubjectList=array();

    // $SubjectList= $os->getSubjectList($asession,$class);



    if(count($data_grid_student)>0){

        ?>

        <table class="noBorder "   title="attendance table">


            <? foreach($data_grid_student as $year=>$months)
            { ?>

                <tr class="trListing">
                    <td colspan="10" style="background-color:#006595; color:#FFFFFF;"> <b> Attendance   <? echo $os->classList[$class]; ?> <? echo $year ?>  </b> </td>
                </tr>
                <tr class="borderTitle">
                    <td>Month</td>
                    <td>Total   Class </td>
                    <td>Attended</td>
                    <td>%</td>
                </tr>

                <? foreach($months as $month=>$count)
            {

                $total_class=$data_grid_total[$year][$month];
                $percent=0;

                if($total_class>0)
                {

                    $percent=$count/$total_class *100;
                    $percent=(int) $percent;
                }


                ?>

                <tr class="trListing">
                    <td > <? echo  $os->feesMonth[(int)$month] ?> </td>
                    <td > <? echo $total_class ?> </td>
                    <td > <? echo $count ?></td>
                    <td > <? echo $percent ?> %  </td>
                </tr>


            <? } ?>





            <? } ?>






        </table>
        <?
    }else{

        echo 'Attendance not entered for this session.';
    } ?>













<? } ?>
<style>
    .noBorder td{ padding:3px; border: 1px solid #F4F4F4;}
</style>

