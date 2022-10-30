<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/



include('wtosConfigLocal.php');

include($site['root-wtos'].'top.php');


$pluginName='';

$listHeader='Exam Summery';

$ajaxFilePath= 'exam_setting_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$branchCode = $os->getSession($key1='selected_branch_code');
$all_branch_list=$os->get_branches_by_access_name("Exam Summery");
$access_name = "Exam Settings";
//access
$global_access = $os->get_global_access_by_name($access_name);
$has_global_view_access = in_array("View", $global_access)||$os->loggedUser()["adminType"]=="Super Admin";
$has_global_verification_access =  $os->loggedUser()["adminType"]=="Super Admin";
?>




<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <div class="uk-inline uk-margin-small-right">
                <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button "
                        onclick="open_exam_form(0)">
                    <span uk-icon="icon:  plus; ratio:0.7" class="m-right-s"></span>
                    Add New
                </button>
            </div>
        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <div class="uk-padding-small uk-padding-remove-bottom">
            <div class="uk-inline" uk-tooltip="Select Branch">
                <select id="branch_code_s"
                        class="uk-select uk-border-rounded congested-form p-left-xxxl select2">

                    <?if($os->loggedUser()["adminType"]=="Super Admin"){?>
                    <option value="all">Select Branch</option>
                    <?}?>
                    <?if($has_global_view_access){?>
                        <option value="">Global Exams</option>
                    <?}?>

                    <? $os->onlyOption($all_branch_list,'');	?>
                </select>
            </div>


            <div class="uk-inline" uk-tooltip="Select Board">
                <select name="asession"
                        id="asession_s"
                        class="uk-select uk-border-rounded congested-form p-left-xxxl" >

                    <?
                    // $os->onlyOption($os->asession,$setFeesSession);
                    $os->onlyOption($os->asession,$os->selectedSession());
                    ?>
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Select Board">
                <select name="board_s" id="board_s"
                        class="uk-select uk-border-rounded congested-form p-left-xxxl"
                        onchange="populate_class_by_board(this.value)">
                    <option value="">Board</option>
                    <? $os->onlyOption($os->board,'');	?>
                </select>
            </div>

            <div class="uk-inline" uk-tooltip="Select Class">
                <select name="classList" id="classList_s" class="uk-select uk-border-rounded congested-form p-left-xxxl">
                    <option value="">Class</option>
                </select>
            </div>

            <div class="uk-inline" uk-tooltip="Select Class">
                <input name="from_date_s" id="from_date_s"
                       class="uk-input uk-border-rounded congested-form p-left-xxxl datetimepicker"
                       value="<?= date("Y-m-d")?>"/>
            </div>

            <div class="uk-inline" uk-tooltip="Select Class">
                <input name="to_date_s" id="to_date_s"
                       class="uk-input uk-border-rounded congested-form p-left-xxxl datetimepicker"/>
            </div>

            <button onclick="manage_exam_setting('search');" class="uk-button uk-border-rounded congested-form
            uk-secondary-button  uk-flex-inline uk-flex-middle" type="button" >
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>
            <button class="uk-button uk-border-rounded congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"
                    type="button" onclick="searchReset();">
                <span uk-icon="icon:  refresh; ratio:0.7" class="m-right-s"></span>
                Reset
            </button>

        </div>

        <div id="WT_feesListDiv" class="uk-padding-small">&nbsp; </div>

    </div>
</div>
<script>
    /////
    function get_subjects_by_class() // get record by table primery id
    {
        var formdata = new FormData();

        var asession=os.getVal('asession_s');
        formdata.append('asession',asession );

        var classes=os.getVal('classes');
        formdata.append('classes',classes );

        formdata.append('get_subjects_by_class','OK' );


        var url='<? echo $ajaxFilePath ?>?get_subjects_by_class=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('get_subjects_by_class_results',url,formdata);

    }
    function get_subjects_by_class_results(data)  // fill data form by JSON
    {

        var content_data=	getData(data,'##--SUBJECT-BY-CLASS--##');
        os.setHtml('subject_by_class_div',content_data);

        //var objJSON = JSON.parse(data);
        // os.setVal('product_id',parseInt(objJSON.product_id));



    }
    function manage_exam_setting(button) // get record by table primery id
    {

        var formdata = new FormData();

        var classList_s=os.getVal('classList_s');
        formdata.append('classList_s',classList_s );

        var asession=os.getVal('asession_s');
        formdata.append('asession',asession );

        var branch_code_s =os.getVal('branch_code_s');
        formdata.append('branch_code_s',branch_code_s );

        var from_date_s=os.getVal('from_date_s');
        formdata.append('from_date_s',from_date_s );

        var to_date_s=os.getVal('to_date_s');
        formdata.append('to_date_s',to_date_s );

        formdata.append('question_verification_listing','OK' );
        var url='<? echo $ajaxFilePath ?>?question_verification_listing=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('manage_exam_setting_results',url,formdata);

    }
    manage_exam_setting('search');
    function manage_exam_setting_results(data)  // fill data form by JSON
    {
        var content_data=	getData(data,'##--EXAM-SETTING-DATA--##');
        os.setHtml('WT_feesListDiv',content_data);
    }
    function searchReset()
    {
        os.setVal('classList_s','');
        manage_exam_setting('search');
    }





</script>


<style>
    .exam_subject{ width:700px; height:250px;  border:1px dotted #409FFF; background-color:#FFFFFF; margin:10px;
        float:left; letter-spacing:1px; border-radius:8px; }
    .exam_subject_head{ padding:7px; border-radius:8px 8px 0px 0px; font-size:16px; font-weight:bold; color:#000066; margin-bottom:10px; border-bottom: 1px dotted #75BAFF;background-color:#CCE6FF;}
    .subject_table_class{ width:100%;}
    .subject_table_class td{padding:3px; line-height:14px; overflow:auto; border-bottom:#CAE4FF 1px dotted;}

    /* .subject_table_class tr:nth-child(odd) {background:#E8FFFF;}*/
    .subject_table_class_tr{   font-weight:bold;}
    .teacherArr{ border:0px solid #CCCCCC;}
</style>


<? include($site['root-wtos'].'bottom.php'); ?>
