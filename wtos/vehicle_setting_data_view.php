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

$listHeader='Vehicle Setting';

$ajaxFilePath= 'vehicle_setting_ajax.php';

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
                <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button " uk-toggle="target: #add-form-modal">
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

            <button onclick="manage_vehivle_setting('search');" class="uk-button uk-border-rounded uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" >
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>

        </div>

        <div id="WT_feesListDiv" class="uk-padding-small">&nbsp; </div>
    </div>
</div>

<div id="add-form-modal" uk-modal>
    <div class="uk-modal-dialog uk-width-large uk-modal-body ">

        <div class="uk-grid uk-grid-small uk-child-width-1-2 uk-grid-divider" uk-grid>

            <div>
                <h5 class="color-primary uk-margin-small">Class</h5>
                <? foreach($os->classList as $class_id=>$val){

                    ?>
                    <div class="m-bottom-s">
                        <label class="uk-width-expand">
                            <input class="uk-checkbox" type="checkbox" name="classList[]" value="<? echo $class_id ?>" /> <? echo $val ?>
                        </label>
                    </div>
                    <?


                } ?>
            </div>
            <div>

                <div class="uk-margin-small">
                    <h5 class="color-primary uk-margin-remove">Vehicle Type</h5>
                    <input class="uk-input uk-border-rounded uk-form-small" type="text" name="vehicle_type" id="vehicle_type"  value="" />
                </div>
                <div class="uk-margin-small">
                    <h5 class="color-primary uk-margin-remove">Distance</h5>
                    <input class="uk-input uk-border-rounded uk-form-small" type="text" name="vehicle_distance" id="vehicle_distance"  value="" />
                </div>
                <div class="uk-margin-small">
                    <h5 class="color-primary uk-margin-remove">Price</h5>
                    <input class="uk-input uk-border-rounded uk-form-small" type="text" name="vehicle_price" id="vehicle_price"  value="" />
                </div>


                <div class="uk-margin-small">
                    <input class="uk-button uk-border-rounded uk-button-small uk-secondary-button" name="button" type="button" onclick="manage_vehivle_setting('save')" value="SAVE"/>
                </div>


            </div>

        </div>

    </div>
</div>


<script>



    function manage_vehivle_setting(button) // get record by table primery id
    {
        var formdata = new FormData();
        var classList= getValuesFromCheckedBox('classList[]');

        var vehicle_type_val= os.getVal('vehicle_type');
        var vehicle_distance_val= os.getVal('vehicle_distance');
        var vehicle_price_val= os.getVal('vehicle_price');




        formdata.append('vehicle_type',vehicle_type_val );
        formdata.append('vehicle_distance',vehicle_distance_val );
        formdata.append('vehicle_price',vehicle_price_val );
        formdata.append('classList',classList);




        formdata.append('button',button );

        var asession=os.getVal('asession_s');
        formdata.append('asession',asession );

        var classList_s=os.getVal('classList_s');
        formdata.append('classList_s',classList_s );


        formdata.append('manage_vehivle_setting','OK' );


        var url='<? echo $ajaxFilePath ?>?manage_vehivle_setting=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('manage_vehivle_setting_results',url,formdata);

    }

    function manage_vehivle_setting_results(data)  // fill data form by JSON
    {

        UIkit.modal("#add-form-modal").hide();
        var content_data=	getData(data,'##--vehivle-SETTING-DATA--##');
        os.setHtml('WT_feesListDiv',content_data);





    }

    manage_vehivle_setting('');
</script>
<style>
    .class_subject{ margin:10px 0px 0px 0px; background-color:#FBFBFB;}
    .class_subject_class{ font-size:19px; background:#E6F2FF; color:#0033FF; margin:2px 0px 0px 0px}
    .class_subject_subject{ font-size:14px; color:#0080C0; padding:5px;}
    .vehicle_list{ margin:5px; 0px 2px 0px; padding: 2px; 0px 2px 0px;}
</style>





<? include($site['root-wtos'].'bottom.php'); ?>
