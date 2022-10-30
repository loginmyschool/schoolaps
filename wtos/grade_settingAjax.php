<?
/*
   # wtos version : 1.1
   # page called by ajax script in grade_settingDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_grade_settingListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andgrade_setting_id=  $os->postAndQuery('grade_setting_id_s','grade_setting_id','%');
    $andasession=  $os->postAndQuery('asession_s','asession','%');
    $andfrom_percent=  $os->postAndQuery('from_percent_s','from_percent','%');
    $andto_percent=  $os->postAndQuery('to_percent_s','to_percent','%');
    $andgrade=  $os->postAndQuery('grade_s','grade','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( grade_setting_id like '%$searchKey%' Or asession like '%$searchKey%' Or from_percent like '%$searchKey%' Or to_percent like '%$searchKey%' Or grade like '%$searchKey%' )";

    }

    $listingQuery="  select * from grade_setting where grade_setting_id>0   $where   $andgrade_setting_id  $andasession  $andfrom_percent  $andto_percent  $andgrade     order by grade_setting_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>
    <div class="listingRecords">
        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
            <tr class="borderTitle" >

                <td >#</td>
                <td >Action </td>


                <td ><b>Board</b></td>
                <td ><b>Session</b></td>
                <td ><b>From Percent</b></td>
                <td ><b>To Percent</b></td>
                <td ><b>Grade</b></td>



            </tr>



            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;




                ?>
                <tr class="trListing">
                    <td><?php echo $serial; ?>     </td>
                    <td>
                        <? if($os->access('wtView')){ ?>
                            <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_grade_settingGetById('<? echo $record['grade_setting_id'];?>')" >Edit</a></span>  <? } ?>  </td>

                    <td><?php echo $record['board']?> </td>
                    <td>  <? echo
                        $os->rowByField('title','accademicsession','idKey',$record['asession']); ?></td>
                    <td><?php echo $record['from_percent']?> </td>
                    <td><?php echo $record['to_percent']?> </td>
                    <td><?php echo $record['grade']?> </td>


                </tr>
                <?


            } ?>





        </table>



    </div>

    <br />



    <?php
    exit();

}

if($os->get('WT_grade_settingEditAndSave')=='OK')
{
    $grade_setting_id=$os->post('grade_setting_id');



    $dataToSave['asession']=addslashes($os->post('asession'));
    $dataToSave['board']=addslashes($os->post('board'));
    $dataToSave['from_percent']=addslashes($os->post('from_percent'));
    $dataToSave['to_percent']=addslashes($os->post('to_percent'));
    $dataToSave['grade']=addslashes($os->post('grade'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($grade_setting_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('grade_setting',$dataToSave,'grade_setting_id',$grade_setting_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($grade_setting_id>0 ){ $mgs= " Data updated Successfully";}
        if($grade_setting_id<1 ){ $mgs= " Data Added Successfully"; $grade_setting_id=  $qResult;}

        $mgs=$grade_setting_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_grade_settingGetById')=='OK')
{
    $grade_setting_id=$os->post('grade_setting_id');

    if($grade_setting_id>0)
    {
        $wheres=" where grade_setting_id='$grade_setting_id'";
    }
    $dataQuery=" select * from grade_setting  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['asession']=$record['asession'];
    $record['board']=$record['board'];
    $record['from_percent']=$record['from_percent'];
    $record['to_percent']=$record['to_percent'];
    $record['grade']=$record['grade'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_grade_settingDeleteRowById')=='OK')
{

    $grade_setting_id=$os->post('grade_setting_id');
    if($grade_setting_id>0){
        $updateQuery="delete from grade_setting where grade_setting_id='$grade_setting_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

