<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);
?><?
$os->showPerPage=5000;
if($os->get('WT_resultsdetailsListing')=='OK'&&$os->post('resultDetailsListingVal')=='OKS'){
    $where='';
    $showPerPage        = $os->post('showPerPage');
    //result_details
    $and_examId_rd      = $os->postAndQuery('examId_s','rd.examId','=');
    $and_class_rd       = $os->postAndQuery('class_s','rd.class','=');
    $and_asession_rd    = $os->postAndQuery('asession','rd.asession','=');
    $and_subject_rd     = $os->postAndQuery('subject_s','rd.subjectId','=');

    //student details
    $and_branch_s       = $os->postAndQuery('branch_s','st.branch','=');

    //class id
    $and_class_h        = $os->postAndQuery('class_s','h.class','=');


    /*$listingQuery="select
                        rd.*,st.name,st.registerNo,st.branch
                        from resultsdetails as rd
                        inner join student as st on rd.studentId=st.studentId
                         where rd.resultsdetailsId>0  $andexamId  $andclass  $andAsession $andsubject_s  $andbranc_s  order by rd.studentId asc";
                        */

    $columns = "
       rd.examTitle,
       rd.subjectName,
       rd.totalMarks, 
       rd.percentage, 
       rd.class, 
       st.name,
       st.registerNo,
       st.branch";

    $listingQuery="select 
	   $columns
	from  history  as  h
	INNER JOIN student as st on(st.studentId=h.studentId)
    LEFT JOIN resultsdetails as rd on (rd.studentId=h.studentId   $and_examId_rd  $and_class_rd  $and_asession_rd $and_subject_rd) 
    WHERE 1=1 $and_class_h $and_branch_s   GROUP BY  st.registerNo order by st.branch asc , st.registerNo asc";



    $os->setSession($listingQuery, 'download_student_result_report_excel');
    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];

    $total_student=0;
    $attended_student=0;




    ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div class="listingRecords">
                    <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
                    <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
                        <tr class="borderTitle" >
                            <td>#</td>
                            <td><b>Name</b></td>
                            <td><b>Reg No</b></td>
                            <td><b>Branch</b></td>
                            <td><b>Class</b></td>
                            <td><b>Exam</b></td>
                            <td><b>Subject</b></td>
                            <!--<td ><b>Total Marks</b></td>
                            <td ><b>Percentage</b></td> -->
                        </tr>
                        <?php
                        $serial=$os->val($resource,'serial');
                        while($record=$os->mfa( $rsRecords)){
                            $serial++;
                            $total_student=$total_student +1 ;
                            if($record['examTitle']!='')
                            {

                                $attended_student=$attended_student +1 ;
                            }




                            ?>
                            <tr class="trListing">
                                <td><?php echo $serial; ?></td>
                                <td><? echo $record['name']; ?> </td>
                                <td><?php echo $record['registerNo']?> </td>
                                <td><? echo $record['branch']; ?></td>
                                <td> <? if(isset($os->classList[$record['class']])){ echo  $os->classList[$record['class']]; } ?></td>
                                <td><? echo $record['examTitle'];?></td>
                                <td>  <? echo $record['subjectName']; ?></td>
                                <!--<td><?php echo $record['totalMarks']?> </td>
								<td><?php echo $record['percentage']?> </td>-->
                            </tr>
                        <?}?>

                    </table>
                </div> </td>
            <td valign="top">


                <?
                /********
                 * Pi chart Query
                 */


                $pichartSQL="select 
	                FLOOR(UNIX_TIMESTAMP(rd.startTime)/(5 * 60)) AS timekey, COUNT(*) as students
                    from  resultsdetails as rd
                    LEFT JOIN student as st on (rd.studentId=st.studentId   ) 
                    WHERE 1=1  $and_branch_s  $and_examId_rd  $and_class_rd  $and_asession_rd $and_subject_rd GROUP BY  timekey";
                $pichartQuery = $os->mq($pichartSQL);
                ?>
                <div class="xpeed-chart" style="display: flex; flex-direction: row; align-items: flex-end;
                padding-bottom: 80px">
                    <?
                    while ($pichartItem = $os->mfa($pichartQuery)){
                        $time = $pichartItem['timekey']*300;
                        $height = $pichartItem["students"]/7;
                        ?>

                        <div style="position: relative">
                            <div uk-tooltip="<?= $pichartItem["students"];?>" style="height: <?=$height?>px; width:
                                    25px;
                                    background-color: green"></div>
                            <span
                                    style="position: absolute; top: 100%; left: 0; transform: translateX(0)
                                    translateY(25px) rotateZ(45deg);
                                    font-size: 11px; color: red;
                            white-space: nowrap">
                                <?= date("h:i:s A", $time); ?>
                            </span>
                        </div>
                        <?
                    }
                    ?>
                </div>

                <h1> Total = <? echo $total_student ?></h1>
                <h1> Appeared  = <? echo $attended_student ?></h1>
                <h1> Absent   = <? echo $k=$total_student - $attended_student  ?></h1>

            </td>
        </tr>
    </table>




    <?php exit(); } ?>

