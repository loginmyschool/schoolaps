<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/



include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');

?><?

$pluginName='';

$listHeader='Subject Setting';

$ajaxFilePath= 'subject_setting_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';


?>



<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <div class="uk-inline uk-margin-small-right">
                <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button " uk-toggle="target: #add-form-modal">
                    <span uk-icon="icon:  cloud-download; ratio:0.7" class="m-right-s"></span>
                    Add New
                </button>
            </div>
            <div class="uk-inline">
                <span class="uk-form-icon  uk-background-muted p-left-m p-right-m" style="width: auto; top: 1px; left: 1px; height: calc(100% - 2px)">SESSION</span>
                <select name="asession"
                        id="asession_s"
                        style="padding-left: 85px"
                        class="uk-select uk-border-rounded uk-form-small  p-right-xl text-m" >
                    <option value=""> </option>
                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select>
            </div>
        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <div class="uk-padding-small uk-padding-remove-bottom">
            <div class="uk-inline" uk-tooltip="Student Name">
                <span class="uk-form-icon" uk-icon="icon: user; ratio:0.7"></span>
                <select name="classList" id="classList_s" class="uk-select uk-border-rounded uk-form-small p-left-xxxl">
                    <option value="">Class</option>
                    <? $os->onlyOption($os->classList,'');	?>
                </select>
            </div>

            <button onclick="manage_subject_setting('search');" class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" >
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded   uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>

        </div>

        <div id="WT_feesListDiv" class="uk-padding-small">&nbsp; </div>

    </div>
</div>



<div id="add-form-modal" uk-modal>
    <div class="uk-modal-dialog uk-width-large uk-modal-body ">
        <div>

            <div class="uk-grid uk-grid-small uk-grid-divider uk-child-width-1-2" uk-grid>

                <div>
                    <h5 class="color-primary uk-margin-small">Class</h5>
                    <? foreach($os->classList as $class_id=>$val){?>
                        <div class="m-bottom-s">
                            <label class="uk-width-expand">
                                <input class="uk-checkbox" type="checkbox" name="classList[]" value="<? echo $class_id ?>" /> <? echo $val ?>
                            </label>
                        </div>
                    <?} ?>
                </div>
                <div>
                    <h5 class="color-primary uk-margin-small">Subject</h5>
                    <? for ($i=0; $i<9; $i++){?>
                        <div class="m-bottom-s">
                        <input  class=" uk-input uk-border-rounded congested-form" type="text" name="subject_list[]" value="" />
                        </div>
                    <?} ?>
                    <input class="uk-button uk-border-rounded   uk-button-small uk-secondary-button" name="button" type="button" onclick="manage_subject_setting('save')" value="SAVE"/>
                </div>
            </div>
        </div>
    </div>
</div>




<style>
    .class_subject{ width:200px; height:auto;  border:1px dotted #409FFF; background-color:#FFFFFF; margin:10px;
        float:left; letter-spacing:1px; border-radius:8px; }
    .class_subject_class{ padding:7px; border-radius:8px 8px 0px 0px; font-size:16px; font-weight:bold; color:#000066; margin-bottom:10px; border-bottom: 1px dotted #75BAFF;background-color:#CCE6FF;}
    .class_subject_list{padding:7px; line-height:18px; overflow:auto; height:240px;}
    .class_subject_subject{font-size:12px; color:#0055AA;}
    .subject_input{ border: 1px  dotted #007DFB; padding:2px 3px 2px 3px; margin:2px; width:130px;text-transform: capitalize;}
</style>
<script>



    function manage_subject_setting(button) // get record by table primery id
    {
        var formdata = new FormData();
        var subject_list= getValuesFromTextBoxArray('subject_list[]');
        var classList= getValuesFromCheckedBox('classList[]');



        formdata.append('subject_list',subject_list );
        formdata.append('classList',classList);




        formdata.append('button',button );

        var asession=os.getVal('asession_s');
        formdata.append('asession',asession );

        var classList_s=os.getVal('classList_s');
        formdata.append('classList_s',classList_s );


        formdata.append('subject_config','OK' );


        var url='<? echo $ajaxFilePath ?>?manage_subject_setting=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('manage_subject_setting_results',url,formdata);

    }

    function manage_subject_setting_results(data)  // fill data form by JSON
    {
        UIkit.modal("#add-form-modal").hide();
        var content_data=	getData(data,'##--SUBJECT-SETTING-DATA--##');
        os.setHtml('WT_feesListDiv',content_data);





    }


</script>
<script>
    manage_subject_setting('search');
</script>



<? include($site['root-wtos'].'bottom.php'); ?>
