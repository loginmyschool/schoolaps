<?
/*
   # wtos version : 1.1
   # page called by ajax script in school_settingDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


$Blue_Yellow = serialize(array(
    "color-primary" => "#1072ED",
    "color-primary-dark"=>"#0035A1",
    "color-text-primary"=>"#ffffff",
    "color-secondory"=>"#FAD570",
    "color-secondory-dark"=>"#F4A26B",
    "color-text-secondory"=>"#ffffff"
));
$BlueGrey_Yellow = serialize(array(
    "color-primary" => "#173E4F",
    "color-primary-dark"=>"#1B262C",
    "color-text-primary"=>"#ffffff",
    "color-secondory"=>"#CA8029",
    "color-secondory-dark"=>"#A66201",
    "color-text-secondory"=>"#ffffff"
));
$theme_data=array(
        ""=>"Default",
    $Blue_Yellow =>'Blue, Cyan',
    $BlueGrey_Yellow =>'Blue Grey, Yellow',
);





?><?

if($os->get('WT_school_settingListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');




    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="
";

    }

    $listingQuery="  select * from school_setting where school_setting_id>0   $where      order by school_setting_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>

    <div class="uk-hidden">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>
    <table class="uk-table uk-table-justify congested-table uk-margin-auto uk-width-auto">
        <?php
        $serial=$os->val($resource,'serial');
        while($record=$os->mfa( $rsRecords)){
            ?>
            <tr>
                <td colspan="2" class="uk-text-center">
                    <img src="<?php  echo $site['url'].$record['logoimage']; ?>"  style="height: 100px; width: 100px" />
                </td>
            </tr>

            <tr>
                <td>School Name</td>
                <td class="color-primary"><?php echo $record['school_name']?> </td>
            </tr>
            <tr>
                <td>Tagline</td>
                <td class="color-primary"><?php echo $record['tagline']?> </td>
            </tr>
            <tr>
                <td>Address</td>
                <td class="color-primary"><?php echo $record['address']?> </td>
            </tr>
            <tr>
                <td>Contact</td>
                <td class="color-primary"><?php echo $record['contact']?> </td>
            </tr>
            <tr>
                <td>Email</td>
                <td class="color-primary"><?php echo $record['email']?> </td>
            </tr>
            <tr>
                <td>School Code</td>
                <td class="color-primary"><?php echo $record['schoolCode']?> </td>
            </tr>

             <tr>
                <td>Theme</td>
                <td class="color-primary">
				<? $os->editSelect($theme_data,$record['theme_data'],'school_setting','theme_data','school_setting_id',$record['school_setting_id'], $inputNameID='editSelect',$extraParams='class="editSelect" ',array()); ?> </td>
            </tr>


		    <tr>
                <td>
                    <? if($os->access('wtView')){ ?>
                        <a href="javascript:void(0)"
                           class="uk-button uk-secondary-button congested-form uk-border-rounded"
                           onclick="WT_school_settingGetById('<? echo $record['school_setting_id'];?>')" >Edit</a>
                    <? } ?>
                </td>
            </tr>


        <? } ?>
    </table>


    <?php
    exit();

}






if($os->get('WT_school_settingEditAndSave')=='OK')
{
    $school_setting_id=$os->post('school_setting_id');



    $dataToSave['school_name']=addslashes($os->post('school_name'));
    $dataToSave['address']=addslashes($os->post('address'));
    $dataToSave['contact']=addslashes($os->post('contact'));
    $dataToSave['email']=addslashes($os->post('email'));
    $dataToSave['schoolCode']=addslashes($os->post('schoolCode'));
    $dataToSave['tagline']=addslashes($os->post('tagline'));
    $logoimage=$os->UploadPhoto('logoimage',$site['root'].'wtos-images');
    if($logoimage!=''){
        $dataToSave['logoimage']='wtos-images/'.$logoimage;}




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($school_setting_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('school_setting',$dataToSave,'school_setting_id',$school_setting_id);///    allowed char '\*#@/"~$^.,()|+_-=:��

    if($qResult)
    {
        if($school_setting_id>0 ){ $mgs= " Data updated Successfully";}
        if($school_setting_id<1 ){ $mgs= " Data Added Successfully"; $school_setting_id=  $qResult;}

        $mgs=$school_setting_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}
if($os->get('WT_school_settingGetById')=='OK')
{
    $school_setting_id=$os->post('school_setting_id');

    if($school_setting_id>0)
    {
        $wheres=" where school_setting_id='$school_setting_id'";
    }
    $dataQuery=" select * from school_setting  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['school_name']=$record['school_name'];
    $record['address']=$record['address'];
    $record['contact']=$record['contact'];
    $record['email']=$record['email'];
    $record['schoolCode']=$record['schoolCode'];
    $record['tagline']=$record['tagline'];
    if($record['logoimage']!=''){
        $record['logoimage']=$site['url'].$record['logoimage'];}



    echo  json_encode($record);

    exit();

}
if($os->get('WT_school_settingDeleteRowById')=='OK')
{

    $school_setting_id=$os->post('school_setting_id');
    if($school_setting_id>0){
        $updateQuery="delete from school_setting where school_setting_id='$school_setting_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

