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

$themes =
    [
        [
            "color-primary"=> "#51C0AC",
            "color-primary-dark"=> "#409B8A",
            "color-text-primary"=> "#ffffff",
            "color-secondory"=> "#945BD7",
            "color-secondory-dark"=> "#8650BE",
            "color-text-secondory"=>"#ffffff",
        ], [
            "color-primary"=> "#111D5E",
            "color-primary-dark"=> "#061149",
            "color-text-primary"=> "#ffffff",
            "color-secondory"=> "#EEBB4D",
            "color-secondory-dark"=> "#C19323",
            "color-text-secondory"=>"#ffffff",
        ], [
            "color-primary"=> "#1D4D47",
            "color-primary-dark"=> "10332e",
            "color-text-primary"=> "#ffffff",
            "color-secondory"=> "#E73A5C",
            "color-secondory-dark"=> "c12240",
            "color-text-secondory"=>"#ffffff",
        ]

    ];

$theme_data=[];
$theme_data[serialize($themes[0])] = "Green, Purple";
$theme_data[serialize($themes[1])] = "Blue , Yellow";
$theme_data[serialize($themes[2])] = "Green , Pink";
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

