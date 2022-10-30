<?
/*
   # wtos version : 1.1
   # main ajax process page : feesAjax.php
   #
*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');

$pluginName='';
$listHeader='Hostel Room Bed';
$ajaxFilePath= 'hostel_room_bed_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
?>

<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>

        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <button
                    class="uk-button uk-border-rounded uk-button-small  uk-secondary-button uk-hidden"
                    uk-toggle="target: #add-form-modal">
                ADD NEW
            </button>
        </div>
    </div>

</div>
<div class="content">
    <div class="item" style="min-width: 300px; max-width: 300px">
        <div class="p-m">

            <table>
                <tr>
                    <td style="width: 80px">Building</td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form" type="text" value="" name="building_name" id="building_name"/>
                    </td>
                </tr>
                <tr>
                    <td>Floor</td>
                    <td><input class="uk-input uk-border-rounded congested-form" type="text" value="" name="floor_name" id="floor_name"  /></td>
                </tr>
            </table>


            <table class="uk-margin">
                <tr>
                    <td>Room</td>
                    <td>Bed List
                        <label class="color-primary pointable uk-margin-small-left">
                            <span  uk-icon="icon:question; ratio:0.7" uk-tooltip="Please put like '1-2-3' "></span>
                        </label>
                    </td>
                </tr>



                <? for($i=0;$i<=10;$i++)
                {
                    ?>
                    <tr>
                        <td><input class="uk-input uk-border-rounded congested-form" type="text" value="" name="room_name[]" style="width: 80px" /></td>
                        <td><input class="uk-input uk-border-rounded congested-form" type="text" value="" name="bed_list[]"   /> </td>
                    </tr>
                <?  } ?>
            </table>
            <input class="uk-button uk-border-rounded uk-button-primary uk-theme-button uk-button-small" name="button" type="button" onclick="manage_hostel_room_bed('save')" value="SAVE"/>
        </div>

    </div>

    <div class="item">
        <div id="WT_feesListDiv"></div>
    </div>
</div>

    <script>



        function manage_hostel_room_bed(button) // get record by table primery id
        {
            var formdata = new FormData();
            var room_name= getValuesFromTextBoxArray('room_name[]');
            var bed_list= getValuesFromTextBoxArray('bed_list[]');

            var building_name= os.getVal('building_name');
            var floor_name= os.getVal('floor_name');





            formdata.append('room_name',room_name );
            formdata.append('bed_list',bed_list );
            formdata.append('floor_name',floor_name );
            formdata.append('building_name',building_name);





            formdata.append('button',button );



            formdata.append('manage_hostel_room_bed','OK' );


            var url='<? echo $ajaxFilePath ?>?manage_hostel_room_bed=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('manage_hostel_room_bed_results',url,formdata);

        }

        function manage_hostel_room_bed_results(data)  // fill data form by JSON
        {
            var content_data=	getData(data,'##--HOSTEL-ROOM--##');
            os.setHtml('WT_feesListDiv',content_data);
        }
        manage_hostel_room_bed('');

    </script>

    <style>
        .class_building_name{ background-color:#B0D8FF; color:#0000FF; font-size:24px; font-weight:400; padding:5px; border:1px solid #CCCCCC;}
        .floor_name_class{ background-color:#E1F0FF; color:#0093D9; font-size:18px; font-weight:400; padding:5px;border:1px solid #CCCCCC;}
        .rooms{  background-color:#F6F6F6; border:1px solid #CCCCCC; width:200px; height:200px; float:left; }
        .Room_bed{ padding:5px; font-size:14px; border-bottom: 2px groove #FFFFFF;}
        .Room_bed_graph{ width:130px; height:110px;  border:2px solid #003399; margin:2px;}
        .bed_no{ width:20px; height:35px; margin:5px; float:left; padding:5px;}
        .bed_no:hover div{ display:block;}

        .bed_no_student{   display:none; background-color:#FFFFCC; border:1px solid #999999; width:200px; height:210px;  position:relative; padding:5px; border:10px solid #0066CC;  }
        .bed_no:hover .bed_no_student{ display:block; }
        .bed_no:hover img{ border:1px solid  #FF6600;}
    </style>

<? include($site['root-wtos'].'bottom.php'); ?>
