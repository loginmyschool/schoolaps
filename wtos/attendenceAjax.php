<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

//////student data section

if($os->get('studentListing')=='OK'&& $os->post('searchStudent')=='OK' )
{
    $andAsession=  $os->postAndQuery('asession_s','asession','=');
    $andClass=  $os->postAndQuery('classList_s','class','=');
    $andSection=  $os->postAndQuery('section_s','section','=');
    $studentQuery="select * from history  where historyId>0    $andAsession $andClass $andSection and historyStatus='Active' order by roll_no";
    $resource=$os->pagingQuery($studentQuery,'300',false,true);
    $student=$resource['resource'];


    $f_Date_s= $os->showdate($os->post('attendenceDate')); $t_Date_s= $os->showdate($os->post('attendenceDate'));
    $andDate=$os->DateQ('dated',$f_Date_s,$t_Date_s,$sTime='00:00:00',$eTime='23:59:59');
    $andSubjectId=  $os->postAndQuery('subjectId_s','subjectId','=');





    $presentStudent=array();

    $dateAndSubject=$andSubjectId  . $andDate." and absent_present='P'";
    $attendenceData= $os->getIdsDataFromQuery($student->queryString,'historyId','attendance','historyId',$fields='',$returnArray=true,$relation='121',$otherCondition=$dateAndSubject);
    if(is_array($attendenceData))
    {
        foreach($attendenceData as $attdata)
        {
            // $key=$attdata['historyId'].'_'.$attdata['subjectId'].'_'.$os->showDate($attdata['dated']);
            $presentStudent[$attdata['historyId']]=$attdata['historyId'];

        }


    }




    $studentInfo= $os->getIdsDataFromQuery($student->queryString,'studentId','student','studentId',$fields='studentId,name',$returnArray=true,$relation='121',$otherCondition='');


//$c= $os->getIdsDataFromQuery($rsRecords->queryString,'rbcontactId','rbcontact','rbcontactId',$fields='',$returnArray=true,$relation='121',$otherCondition='');

    ?>

    <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

    <table  class="uk-table uk-table-striped uk-table-small background-color-white" >
        <thead>
        <tr>
            <th class="uk-table-shrink"></th>
            <th class="uk-text-nowrap uk-table-shrink p-left-s p-right-s">Roll</th>
            <th class="p-left-m">Name</th>
            <th class="uk-hidden">Class</th>

        </tr>
        </thead>


        <?php


        $serial=0;
        while($studentData=$os->mfa($student))
        {
            $name=$studentInfo[$studentData['studentId']]['name'];

            $checked='';

            $which_class=$os->classList[$studentData['class']];

            if(in_array($studentData['historyId'],$presentStudent))
            {
                $checked='checked="checked"';
            }

            $serial++;?>
            <tr class="trListing" >
                <td> <input class="uk-checkbox" <? echo $checked ?>  type="checkbox" id="checkbox_attendance_<? echo $studentData['historyId'] ?>" onclick="attendenceSet('<? echo $studentData['historyId'] ?>','<? echo $studentData['studentId'] ?>')"   /> </td>
                <td class="uk-hidden"><? echo $which_class ?> </td>
                <td class="p-left-s p-right-s"><? echo $studentData['roll_no'] ?> </td>
                <td class="p-left-m"> <? echo $name ?> </td>
            </tr>


        <? } ?>









    </table>
    </div>

    <br />


    <?
    exit();
}

////////end student data section



////student attendence section

if($os->get('attendence')=='OK'&& $os->post('updateAttendence')=='OK' )
{
    $presentState='A';


    $subjectId=$os->post('subjectId');
    $absent_present=$os->post('attendenceVal');
    $studentId=$os->post('studentId');
    $historyId=$os->post('historyId');
    $dated=$os->saveDate($os->post('attendenceDate'));

    $asession=$os->post('asession');
    $class=$os->post('classList');
    $section=$os->post('section');



    if($subjectId!='' && $absent_present!='' && $studentId!='' && $historyId!='' && $dated!='' && $asession!='' && $class!='' && $section!='')
    {
        $attendanceId="";

        $dataToSave['absent_present']=$absent_present;
        $dataToSave['studentId']=$studentId;
        $dataToSave['historyId']=$historyId;
        $dataToSave['dated']=$dated;
        $dataToSave['addedDate']=$os->now();
        $dataToSave['asession']=$asession;
        $dataToSave['class']=$class;
        $dataToSave['section']=$section;
        $dataToSave['subjectId']=$subjectId;

        $rollNoQuery="select roll_no from history where  studentId='$studentId'";
        $rollNoMq=$os->mq($rollNoQuery);
        $rollNoData=$os->mfa($rollNoMq);
        $dataToSave['roll_no']=$rollNoData['roll_no'];
        $dataToSave['adminId']=$os->userDetails['adminId'];


        $f_Date_s= $os->showdate($dataToSave['dated']); $t_Date_s= $os->showdate($dataToSave['dated']);
        $andDate=$os->DateQ('dated',$f_Date_s,$t_Date_s,$sTime='00:00:00',$eTime='23:59:59');
        $attendenceIdQuery="select attendanceId from attendance where  studentId='$studentId' and  historyId='$historyId' and subjectId='$subjectId' $andDate";
        $attendenceIdMq=$os->mq($attendenceIdQuery);
        $attendenceData=$os->mfa($attendenceIdMq);
        if(isset($attendenceData['attendanceId']))
        {
            $attendanceId=$attendenceData['attendanceId'];
        }
        $qResult=$os->save('attendance',$dataToSave,'attendanceId',$attendanceId);


        $attendenceIdQuery="select absent_present from attendance where  studentId='$studentId' and  historyId='$historyId' and subjectId='$subjectId' $andDate";
        $attendenceIdMq=$os->mq($attendenceIdQuery);
        $attendenceData=$os->mfa($attendenceIdMq);
        if(isset($attendenceData['absent_present']))
        {
            $presentState=$attendenceData['absent_present'];
        }







    }

    $arr['presentState']=$presentState;
    $arr['historyId']=$historyId;



    echo json_encode($arr);
    exit();

}


////end student attendence section

?>


