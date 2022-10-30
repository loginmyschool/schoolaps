<?
/*

   # wtos version : 1.1

   # page called by ajax script in feesDataView.php

   #

*/


include('wtosConfigLocal.php');

include($site['root-wtos'].'wtosCommon.php');

$pluginName='';

$os->loadPluginConstant($pluginName);

if($os->get('manage_global_setting')=='OK' && $os->post('manage_global_setting')=='OK')
{



    $asession=$os->post('asession');

    $session_start_date=$os->post('session_start_date');
	$session_end_date=$os->post('session_end_date');
    $payment_due_date=$os->post('payment_due_date');
    $per_day_fine=$os->post('per_day_fine');

    $classList=$os->post('classList');
    $button=$os->post('button');

$asession_s=$os->post('asession_s');




    if( $classList!='' && $session_start_date!='' && $session_end_date!='' && $asession!='' && $button=='save' )
    {



        $classListA=array_filter(explode(',',$classList));



        foreach($classListA as $class_val)
        {


            $dataToSave=array();
            $dataToSave['class_id']=$class_val;

            $dataToSave['session_start_date']=$os->saveDate($session_start_date);
			$dataToSave['session_end_date']=$os->saveDate($session_end_date);
            $dataToSave['payment_due_date']=$payment_due_date;
            $dataToSave['per_day_fine']=$per_day_fine;

            $dataToSave['asession']=$asession;
            $dataToSave['addedDate']=$os->now();
            $dataToSave['addedBy']=$os->userDetails['adminId'];


            $global_session_setting_id=$os->isRecordExist("select * from global_session_setting where class_id!='' and class_id='$class_val'  and  asession='$asession'",'global_session_setting_id');

            $qResult=$os->save('global_session_setting',$dataToSave,'global_session_setting_id',$global_session_setting_id);///    allowed char '\*#@/"~$^.,()|+_-=:��




        }


    }


    $classList_s=$os->post('classList_s');

    $andClass='';
    if($classList_s!='')
    {
        $andClass=" and class_id='$classList_s'";

    }
	
	$andasession='';
    if($asession_s!='')
    {
        $andasession=" and asession='$asession_s'";

    }



    $config_array=array();
     $sel="select * from global_session_setting where class_id!=''   $andClass $andasession order by class_id asc ";
    $resset=$os->mq($sel);





    echo '##--GLOBAL-SETTING-DATA--##';


    //_d($config_array);
    ?>
    <table class="uk-table uk-table-striped congested-table background-color-white">
        <tr>
		 <td>Class</td>
		  <td>session</td>
		 
            <td>Session Start</td>
			<td>Session End</td>
            <td>Due Day</td>
            <td>Per day fine</td>
			<td>Delete</td>
        </tr>


    <?
    while($record=$os->mfa($resset))
    {




         

        ?>
        <tr>    <td>  <? echo $os->classList[$record['class_id']];?></td>
		<td>  <? echo $record['asession'];?></td> 
            <td><?= $os->showDate($record['session_start_date']);?></td>
			 <td><?= $os->showDate($record['session_end_date']);?></td>
            <td><?= $record['payment_due_date']?></td>
            <td><?= $record['per_day_fine']?></td>
			<td> <input type="button" value="Delete" onclick="global_settingDeleteRowById(<? echo $record['global_session_setting_id']; ?>)"  /> </td>
        </tr>

        <?
    }
    ?>
    </table>




    <? 
    echo '##--GLOBAL-SETTING-DATA--##';

    exit();
}




if($os->get('global_settingDeleteRowById')=='OK')
{ 

$global_session_setting_id=$os->post('global_session_setting_id');
 if($global_session_setting_id>0)
 {
			 $updateQuery="delete from global_session_setting where global_session_setting_id='$global_session_setting_id'";
			 $os->mq($updateQuery);
			 echo 'Record Deleted Successfully';
 }
 exit();
}
 

 


