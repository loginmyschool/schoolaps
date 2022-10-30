<?
/*
   # wtos version : 1.1
   # page called by ajax script in global_templateDataView.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);

include('templateClass.php');
$template_class=new templateClass();
$template_class-> template_ajax_php();

//default template settings
$os->defaultTemplateSettings = array(
    "font-size" => [
            "",
        "1pt",
        "2pt",
        "3pt",
        "4pt",
        "5pt",
        "6pt",
        "7pt",
        "9pt",
        "11pt",
        "12pt",
        "14pt",
        "16pt",
        "18pt",
        "20pt",
        "24pt",
        "26pt",
        "28pt",
        "30pt"
    ],
    "font-style"=> [
        "",
        "normal",
        "italic",
        "oblique"
    ],
    "font-family"=>[
        "",
        "Georgia, serif",
        "Palatino Linotype, Book Antiqua, Palatino, serif",
        "Times New Roman, Times, serif",
        "Arial, Helvetica, sans-serif",
        "Arial Black, Gadget, sans-serif",
        "Comic Sans MS, cursive, sans-serif",
        "Impact, Charcoal, sans-serif",
        "Lucida Sans Unicode, Lucida Grande, sans-serif",
        "Tahoma, Geneva, sans-serif",
        "Courier New, Courier, monospace",
        "Lucida Console, Monaco, monospace"

    ],
    "font-weight"=>[
        "",
        "100",
        "200",
        "300",
        "400",
        "500",
        "600",
        "700",
        "800",
        "900"
    ],
    "border-width" => [
        "",
        "0pt",
        "1pt",
        "2pt",
        "3pt",
        "4pt",
        "5pt",
        "6pt",
        "7pt",
        "8pt",
        "9pt",
        "11pt",
        "12pt",
        "14pt",
        "16pt",
        "18pt",
        "20pt",
        "24pt",
        "26pt",
        "28pt",
        "30pt"
    ],
    "border-radius" => [
        "",
        "0pt",
        "1pt",
        "2pt",
        "3pt",
        "4pt",
        "5pt",
        "6pt",
        "7pt",
        "8pt",
        "9pt",
        "11pt",
        "12pt",
        "14pt",
        "16pt",
        "18pt",
        "20pt",
        "24pt",
        "26pt",
        "28pt",
        "30pt"
    ],
    "border-style" => [
        "",
        "solid",
        "double",
        "dotted",
        "dashed",
        "groove",
        "ridge",
        "inset",
        "outset",
    ],
    "text-align"   =>["","left","center", "right", "justify"]
)

?><?

if($os->get('WT_global_templateListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andname=  $os->postAndQuery('name_s','name','%');
    $andactive_status=  $os->postAndQuery('active_status_s','active_status','%');
    $andtype=  $os->postAndQuery('type_s','type','%');
    $andtemplate_page=  $os->postAndQuery('template_page_s','template_page','%');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( name like '%$searchKey%' Or active_status like '%$searchKey%' Or type like '%$searchKey%' Or template_page like '%$searchKey%' )";

    }

    $listingQuery="  select * from global_template where global_template_id>0   $where   $andname  $andactive_status  $andtype  $andtemplate_page     order by global_template_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>

        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>   </div>

        <table class="uk-table uk-table-small uk-table-striped background-color-white">
            <tr class="borderTitle" >

                <td >#</td>
                <td >Action </td>
                <td ><b>Id</b></td>
                <td ><b>Name</b></td>
                <td ><b>Active Status</b></td>
                <td ><b>Type</b></td>
                <td ><b>Template Page</b></td>
                <td ><b>Background Image</b></td>



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
                            <a class="uk-button uk-border-rounded uk-secondary-button congested-form" href="javascript:void(0)"  onclick="WT_global_templateGetById('<? echo $record['global_template_id'];?>')" >Edit</a>
                        <? } ?>
                        <a class="uk-button uk-border-rounded uk-button-primary congested-form" href="javascript:void(0)"  onclick="WT_modify_global_template_preview('<? echo $record['global_template_id'];?>','')" >Setting</a>


                    </td>

                    <td><?php echo $record['global_template_id']?> </td>
                    <td><?php echo $record['name']?> </td>
                    <td> <? if(isset($os->global_template_status[$record['active_status']])){ echo  $os->global_template_status[$record['active_status']]; } ?></td>
                    <td> <? if(isset($os->global_template_type[$record['type']])){ echo  $os->global_template_type[$record['type']]; } ?></td>
                    <td><?php echo $record['template_page']?> </td>
                    <td><img src="<?php  echo $site['url'].$record['backgroundImage']; ?>"  height="70" width="70" /></td>


                </tr>
                <?


            } ?>





        </table>




    <?php
    exit();

}

if($os->get('WT_global_templateEditAndSave')=='OK')
{
    $global_template_id=$os->post('global_template_id');



    $dataToSave['name']=addslashes($os->post('name'));
    $dataToSave['active_status']=addslashes($os->post('active_status'));
    $dataToSave['type']=addslashes($os->post('type'));
    $dataToSave['template_page']=addslashes($os->post('template_page'));
    $dataToSave['template_content']=addslashes($template_class->get_template_file_str($dataToSave['template_page'],$dataToSave['type']));



    $backgroundImage=$os->UploadPhoto('backgroundImage',$site['root'].'wtos-images');
    if($backgroundImage!=''){
        $dataToSave['backgroundImage']='wtos-images/'.$backgroundImage;}




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($global_template_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('global_template',$dataToSave,'global_template_id',$global_template_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($global_template_id>0 ){ $mgs= " Data updated Successfully";}
        if($global_template_id<1 ){ $mgs= " Data Added Successfully"; $global_template_id=  $qResult;}

        $mgs=$global_template_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_global_templateGetById')=='OK')
{
    $global_template_id=$os->post('global_template_id');

    if($global_template_id>0)
    {
        $wheres=" where global_template_id='$global_template_id'";
    }
    $dataQuery=" select * from global_template  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['name']=$record['name'];
    $record['active_status']=$record['active_status'];
    $record['type']=$record['type'];
    $record['template_page']=$record['template_page'];
    if($record['backgroundImage']!=''){
        $record['backgroundImage']=$site['url'].$record['backgroundImage'];}



    echo  json_encode($record);

    exit();

}

if($os->get('WT_global_templateDeleteRowById')=='OK')
{

    $global_template_id=$os->post('global_template_id');
    if($global_template_id>0){
        $updateQuery="delete from global_template where global_template_id='$global_template_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}
/////----------------------------------- 5556 ---------------------------------///

if($os->get('WT_modify_global_template_preview')=='OK' && $os->post('WT_modify_global_template_preview'))
{

    $global_template_id=$os->post('global_template_id');

    $global_template=$os->rowByField('','global_template','global_template_id',$global_template_id);
    echo '##--templateSetting_DIV--##';


    //add renderer
    ?>
    <div class="uk-grid uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1">

            <div class="uk-height-1-1 uk-overflow-auto uk-flex uk-flex-center">
                <div>
                    <? echo $template_class->render_design($global_template, array()); ?>
                </div>
            </div>

        </div>
        <div class="uk-width-auto uk-height-1-1">
            <div class="uk-height-1-1 uk-overflow-auto uk-padding-small">
                <? generateSettingsForm($global_template); ?>
            </div>
        </div>
    </div>
    <?
    echo '##--templateSetting_DIV--##';

    exit();
}

if($os->get('saveGlobalTemplateSettings')=='OK' && $os->post('saveGlobalTemplateSettings')) {
    $global_template_id = $os->post("global_template_id");
    $style_overrides = $os->post("style_overrides");

    $dataToSave = array(
        "style_override" => $style_overrides
    );
    $qResult=$os->save('global_template',$dataToSave,'global_template_id',$global_template_id);
    if($qResult){
        echo $qResult;
    } else {
        echo "Ops! Something went wrong";
    }
    exit();
}
function generateSettingsForm($global_template){


    global  $os, $site;

    $global_template_id = $global_template["global_template_id"];
    $template = $global_template["template_content"];
    $style_override = (array)json_decode($global_template["style_override"]);


    $ov = explode("@OVERRIDE@",$template);

    if(isset($ov[1])){
        $source = $ov[1];
        $parameters = (array)json_decode($source, true);
        ?>
        <div id="global_template_settings_forms" class="">
            <?php
            foreach($parameters as $parameter){
                $attribute = $parameter["attribute"];
                $default_style = isset($style_override[$attribute])?$style_override[$attribute]:[];

                ?>
                <form class="uk-margin" name='<?= $attribute?>'>
                    <div class="uk-card uk-card-small uk-card-default  ">
                        <div class="uk-card-header">
                            <h3><?= $parameter["title"]?></h3>
                        </div>

                        <div class="uk-card-body">
                            <table>
                                <?
                                foreach ($parameter["style"] as $style) {
                                    $title = ucwords(str_replace("-"," ", $style));
                                    $default_value = isset($default_style->$style)?$default_style->$style:"";
                                    //font-size;
                                    if(isset($os->defaultTemplateSettings[$style])){
                                        ?>
                                        <tr>
                                            <td class="uk-text-nowrap">
                                                <? echo $title;?>
                                            </td>
                                            <td class="p-left-l">
                                                <select class="uk-select uk-border-rounded congested-form uk-width-small" name="<? echo $style;?>" onchange="saveGlobalTemplateSettings('<? echo $global_template_id;?>', serializeGlobalTemplateSetting())">
                                                    <?
                                                    foreach (($os->defaultTemplateSettings[$style]) as $option){

                                                        ?>
                                                        <option <? echo $option==$default_value?"Selected":""; ?> value="<? echo $option;?>" style="<? echo $style;?>: <? echo $option;?>"> <?echo $option;?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    else if($style=="color"||$style=="background-color"||$style=="border-color")
                                    {?>
                                        <tr>
                                            <td>
                                                <label><? echo $title;?></label>
                                            </td>
                                            <td class="p-left-l">
                                                <input class="uk-input uk-border-rounded congested-form uk-width-small" type="color" onchange="saveGlobalTemplateSettings('<? echo $global_template_id;?>', serializeGlobalTemplateSetting())" name="<? echo $style;?>" value="<? echo $default_value;?>"/>
                                            </td>
                                        </tr>

                                        <?
                                    }
                                    else
                                    {?>
                                        <tr>
                                            <td>
                                                <label><? echo $title;?></label>
                                            </td>
                                            <td class="p-left-l">
                                                <input class="uk-input uk-border-rounded congested-form uk-width-small" onchange="saveGlobalTemplateSettings('<? echo $global_template_id;?>', serializeGlobalTemplateSetting())" type="text" name="<? echo $style?>" value="<? echo  $default_value;?>">
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }?>
                            </table>
                        </div>
                    </div>
                </form>
            <?} ?>
        </div>
        <?php
    }
}



/////----------------------------------- 555 ---------------------------------///
