<?
/*
   # wtos version : 1.1
   # page called by ajax script in eclassDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
// $os->loadPluginConstant($pluginName);


?><?

if($os->get('WT_eclassListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andasession=  $os->postAndQuery('asession_s','asession','%');
    $andclass=  $os->postAndQuery('class_s','class','%');
    $andtitle=  $os->postAndQuery('title_s','title','%');
    $andsearch_keys=  $os->postAndQuery('search_keys_s','search_keys','%');
    $anddescription=  $os->postAndQuery('description_s','description','%');
    $andactive_status=  $os->postAndQuery('active_status_s','active_status','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( asession like '%$searchKey%' Or class like '%$searchKey%' Or title like '%$searchKey%' Or search_keys like '%$searchKey%' Or description like '%$searchKey%' Or active_status like '%$searchKey%' )";

    }

    $listingQuery="  select * from eclass where eclass_id>0   $where   $andasession  $andclass  $andtitle  $andsearch_keys  $anddescription  $andactive_status     order by eclass_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>
    <div class="listingRecords">
        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table  border="0" cellspacing="0" cellpadding="0" class="noBorder"  >
            <tr class="borderTitle" >

                <td >#</td>
                <td >Action </td>



                <td ><b>Teacher</b></td>
                <td ><b>Session</b></td>
                <td ><b>Class</b></td>
                <td ><b>Subject</b></td>
                <td ><b>chapter</b></td>
                <td ><b>topic</b></td>
                <td ><b>Title</b></td>
                <td ><b>Kewords</b></td>
                <td ><b>Description</b></td>
                <td ><b>Image</b></td>
                <td ><b>Video</b></td>
                <td ><b>Video Link</b></td>
                <td ><b>Date</b></td>
                <td ><b>Is Meeting</b></td>
                <td ><b>Meeting ID</b></td>
                <td ><b>Meeting Password</b></td>
                <td ><b>Meeting Link</b></td>
                <td ><b>Meeting Title</b></td>
                <td ><b>Meeting Time</b></td>
                <td ><b>Study Materials</b></td>
                <td ><b>Home Work</b></td>
                <td ><b>Status</b></td>



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
                            <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_eclassGetById('<? echo $record['eclass_id'];?>')" >Edit</a></span>  <? } ?>  </td>

                    <td> <? if(isset($os->yesNo[$record['adminId']])){ echo  $os->yesNo[$record['adminId']]; } ?></td>
                    <td> <? if(isset($os->yesNo[$record['asession']])){ echo  $os->yesNo[$record['asession']]; } ?></td>
                    <td> <? if(isset($os->yesNo[$record['class']])){ echo  $os->yesNo[$record['class']]; } ?></td>
                    <td> <? if(isset($os->yesNo[$record['subject_id']])){ echo  $os->yesNo[$record['subject_id']]; } ?></td>
                    <td> <? if(isset($os->yesNo[$record['chapter']])){ echo  $os->yesNo[$record['chapter']]; } ?></td>
                    <td> <? if(isset($os->yesNo[$record['topic']])){ echo  $os->yesNo[$record['topic']]; } ?></td>
                    <td><?php echo $record['title']?> </td>
                    <td><?php echo $record['search_keys']?> </td>
                    <td><?php echo $record['description']?> </td>
                    <td><img src="<?php  echo $site['url'].$record['description_image']; ?>"  height="70" width="70" /></td>
                    <td><img src="<?php  echo $site['url'].$record['video_file']; ?>"  height="70" width="70" /></td>
                    <td><?php echo $record['video_link']?> </td>
                    <td><?php echo $os->showDate($record['dated']);?> </td>
                    <td><?php echo $record['is_meeting']?> </td>
                    <td><?php echo $record['meeting_id']?> </td>
                    <td><?php echo $record['meeting_password']?> </td>
                    <td><?php echo $record['meeting_link']?> </td>
                    <td><?php echo $record['meeting_title']?> </td>
                    <td><?php echo $record['meeting_time']?> </td>
                    <td><img src="<?php  echo $site['url'].$record['study_materials']; ?>"  height="70" width="70" /></td>
                    <td><img src="<?php  echo $site['url'].$record['homework']; ?>"  height="70" width="70" /></td>
                    <td> <? if(isset($os->yesNo[$record['active_status']])){ echo  $os->yesNo[$record['active_status']]; } ?></td>


                </tr>
                <?


            } ?>





        </table>



    </div>

    <br />



    <?php
    exit();

}






if($os->get('WT_eclassEditAndSave')=='OK')
{
    $eclass_id=$os->post('eclass_id');



    $dataToSave['adminId']=addslashes($os->post('adminId'));
    $dataToSave['asession']=addslashes($os->post('asession'));
    $dataToSave['class']=addslashes($os->post('class'));
    $dataToSave['subject_id']=addslashes($os->post('subject_id'));
    $dataToSave['chapter']=addslashes($os->post('chapter'));
    $dataToSave['topic']=addslashes($os->post('topic'));
    $dataToSave['title']=addslashes($os->post('title'));
    $dataToSave['search_keys']=addslashes($os->post('search_keys'));
    $dataToSave['description']=addslashes($os->post('description'));
    $description_image=$os->UploadPhoto('description_image',$site['root'].'wtos-images');
    if($description_image!=''){
        $dataToSave['description_image']='wtos-images/'.$description_image;}
    $video_file=$os->UploadPhoto('video_file',$site['root'].'wtos-images');
    if($video_file!=''){
        $dataToSave['video_file']='wtos-images/'.$video_file;}
    $dataToSave['video_link']=addslashes($os->post('video_link'));
    $dataToSave['dated']=$os->saveDate($os->post('dated'));
    $dataToSave['is_meeting']=addslashes($os->post('is_meeting'));
    $dataToSave['meeting_id']=addslashes($os->post('meeting_id'));
    $dataToSave['meeting_password']=addslashes($os->post('meeting_password'));
    $dataToSave['meeting_link']=addslashes($os->post('meeting_link'));
    $dataToSave['meeting_title']=addslashes($os->post('meeting_title'));
    $dataToSave['meeting_time']=addslashes($os->post('meeting_time'));
    $study_materials=$os->UploadPhoto('study_materials',$site['root'].'wtos-images');
    if($study_materials!=''){
        $dataToSave['study_materials']='wtos-images/'.$study_materials;}
    $homework=$os->UploadPhoto('homework',$site['root'].'wtos-images');
    if($homework!=''){
        $dataToSave['homework']='wtos-images/'.$homework;}
    $dataToSave['active_status']=addslashes($os->post('active_status'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($eclass_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('eclass',$dataToSave,'eclass_id',$eclass_id);///    allowed char '\*#@/"~$^.,()|+_-=:
    if($qResult)
    {
        if($eclass_id>0 ){ $mgs= " Data updated Successfully";}
        if($eclass_id<1 ){ $mgs= " Data Added Successfully"; $eclass_id=  $qResult;}

        $mgs=$eclass_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_eclassGetById')=='OK')
{
    $eclass_id=$os->post('eclass_id');

    if($eclass_id>0)
    {
        $wheres=" where eclass_id='$eclass_id'";
    }
    $dataQuery=" select * from eclass  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['adminId']=$record['adminId'];
    $record['asession']=$record['asession'];
    $record['class']=$record['class'];
    $record['subject_id']=$record['subject_id'];
    $record['chapter']=$record['chapter'];
    $record['topic']=$record['topic'];
    $record['title']=$record['title'];
    $record['search_keys']=$record['search_keys'];
    $record['description']=$record['description'];
    if($record['description_image']!=''){
        $record['description_image']=$site['url'].$record['description_image'];}
    if($record['video_file']!=''){
        $record['video_file']=$site['url'].$record['video_file'];}
    $record['video_link']=$record['video_link'];
    $record['dated']=$os->showDate($record['dated']);
    $record['is_meeting']=$record['is_meeting'];
    $record['meeting_id']=$record['meeting_id'];
    $record['meeting_password']=$record['meeting_password'];
    $record['meeting_link']=$record['meeting_link'];
    $record['meeting_title']=$record['meeting_title'];
    $record['meeting_time']=$record['meeting_time'];
    if($record['study_materials']!=''){
        $record['study_materials']=$site['url'].$record['study_materials'];}
    if($record['homework']!=''){
        $record['homework']=$site['url'].$record['homework'];}
    $record['active_status']=$record['active_status'];



    echo  json_encode($record);

    exit();

}


if($os->get('WT_eclassDeleteRowById')=='OK')
{

    $eclass_id=$os->post('eclass_id');
    if($eclass_id>0){
        $updateQuery="delete from eclass where eclass_id='$eclass_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}
