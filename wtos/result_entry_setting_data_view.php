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

$listHeader='Result Entry  Setting';

$ajaxFilePath= 'result_entry_setting_ajax.php';

$os->loadPluginConstant($pluginName);

$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

//branch code
$access_name = "Result Entry Access";
$branch_codes = $os->get_branches_by_access_name($access_name);

?>


<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">

        </div>
    </div>

</div>


<div class="content">
    <div class="item with-header uk-height-1-1">
        <div class="item-header p-m">
            <div class="uk-inline" uk-tooltip="Select Branch">
                    <select name="branch_code_s" id="branch_code_s"
                            onchange="get_asession_by_branch_code()"
                            class="select2">
                        <option value="">--BRANCH--</option>
                        <? $os->onlyOption($branch_codes,'');	?>
                    </select>
                </div>
            <div class="uk-inline" uk-tooltip="Select Session">
                <select name="asession_s"
                        id="asession_s"
                        onchange="get_class_by_session()"
                        class="uk-select uk-border-rounded congested-form">
                    <option value="">session</option>

                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Select Class">
                <select name="class_s" id="class_s"
                        onchange="get_exam_by_class()"
                        class="uk-select uk-border-rounded congested-form">
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Select Exam">
                <select name="exam_s" id="exam_s" class="uk-select uk-border-rounded congested-form">
                </select>
            </div>

            <div class="uk-inline">
                <button class="uk-button uk-border-rounded   congested-form uk-secondary-button" type="button"
                        value="Search"
                        onclick="manage_exam_setting('search');" style="cursor:pointer;">Search</button>

                <!--<input type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>-->
            </div>
        </div>
        <div class="item-content uk-height-1-1 p-m" id="WT_feesListDiv" style="background-color: transparent">

        </div>
    </div>
</div>





<script>
    function get_asession_by_branch_code()
    {
        let formdata = new FormData();

        formdata.append("branch_code_s", os.getVal("branch_code_s"));
        formdata.append('get_asession_by_branch_code','OK' );

        let url='<? echo $ajaxFilePath ?>?get_asession_by_branch_code=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            os.setHtml('asession_s',data);
        },url,formdata);

    }
    function get_class_by_session()
    {
        let formdata = new FormData();

        formdata.append("branch_code_s", os.getVal("branch_code_s"));
        formdata.append("asession_s", os.getVal("asession_s"));
        formdata.append('get_class_by_session','OK' );

        let url='<? echo $ajaxFilePath ?>?get_class_by_session=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            os.setHtml('class_s',data);
        },url,formdata);

    }
    function get_exam_by_class()
    {
        let formdata = new FormData();

        formdata.append("branch_code_s", os.getVal("branch_code_s"));
        formdata.append("asession_s", os.getVal("asession_s"));
        formdata.append("class_s", os.getVal("class_s"));
        formdata.append('get_exam_by_class','OK' );

        let url='<? echo $ajaxFilePath ?>?get_exam_by_class=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc((data)=>{
            os.setHtml('exam_s',data);
        },url,formdata);

    }
    function manage_exam_setting(button="") // get record by table primery id
    {
        let formdata = new FormData();

        formdata.append("branch_code_s", os.getVal("branch_code_s"));
        formdata.append("asession_s", os.getVal("asession_s"));
        formdata.append("class_s", os.getVal("class_s"));
        formdata.append("exam_s", os.getVal("exam_s"));

        if(os.getVal("branch_code_s")===""||os.getVal("asession_s")===""||os.getVal("class_s")===""||os.getVal("exam_s")===""){
            alert("please select all details")
            return;
        }

        if(button=="save") {
            formdata.append('examdetailsId', os.getVal('examdetailsId'));
            formdata.append('teacherId', os.getVal('teacherId'));
            formdata.append('roll_from', os.getVal('roll_from'));
            formdata.append('roll_to', os.getVal('roll_to'));
            formdata.append('gender', os.getVal('gender'));
            formdata.append('date_from', os.getVal('date_from'));
            formdata.append('date_to', os.getVal('date_to'));
            formdata.append('section', os.getVal('section'));

            if(os.getVal('teacherId')===""|| os.getVal('examdetailsId')===""){
                alert("please select all details")
                return;
            }
        }



        formdata.append('button',button );
        formdata.append('manage_exam_setting','OK' );


        let url='<? echo $ajaxFilePath ?>?manage_exam_setting=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please wait....';
        os.setAjaxFunc((data)=>{
            let content_data=	getData(data,'##--EXAM-SETTING-DATA--##');
            os.setHtml('WT_feesListDiv',content_data);
        },url,formdata);

    }
    //manage_exam_setting('search');
</script>

<style>
    .exam_subject{ width:600px; height:auto;  border:1px dotted #409FFF; background-color:#FFFFFF; margin:10px;
        float:left; letter-spacing:1px; border-radius:8px; }
    .exam_subject_head{ padding:7px; border-radius:8px 8px 0px 0px; font-size:16px; font-weight:bold; color:#000066; margin-bottom:10px; border-bottom: 1px dotted #75BAFF;background-color:#CCE6FF;}
    .subject_table_class td{padding:3px; line-height:14px; overflow:auto;}
    .subject_table_class:hover{ background-color:#FBF2B7;}
    .subjectName{ font-size:16px; color:#005E8A;}
    .texttbox{ width:90px;}
</style>


<? include($site['root-wtos'].'bottom.php'); ?>
