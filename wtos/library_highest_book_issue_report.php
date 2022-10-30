<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
global $os, $site;
$pluginName='';
$listHeader='Library Highest Book Issue Report';
$ajaxFilePath= 'library_highest_book_issue_report_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$access_name = "Library Highest Book Issue Report";
$branch_codes = $os->get_branches_by_access_name($access_name);

?>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <div class="p-m ">
            <div class="uk-grid uk-grid-small" uk-grid>
                <div uk-tooltip="Select Branch" >
                    <select name="branch_code_s" id="branch_code_s"
                            class="select2"
                            onchange="wt_ajax_chain('html*library_id_s*library,library_id,name*branch_code=branch_code_s','','reInit();','reInit();');">
                        <option value="">--BRANCH--</option>
                        <? $os->onlyOption($branch_codes,'');	?>
                    </select>
                </div>
                <div uk-tooltip="Select Library" >
                    <select name="library_id_s" id="library_id_s" class="uk-select congested-form"
                            onchange="">
                        <option value="">--Library--</option>
                    </select>
                </div>
                <div uk-tooltip="Date From"  class="uk-inline">
                        <input id="date_from_s" class="datepicker uk-input congested-form">
                </div>
                <div uk-tooltip="Date to"  class="uk-inline">
                        <input id="date_to_s" class="datepicker uk-input congested-form">
                </div>
                <div>


                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Search" onclick="WT_fetch_book_issue_report();">Search</button>

                </div>
                <div>


                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Search" onclick="document.querySelector('#print_form').submit()">Print result</button>

                </div>


            </div>
        </div>
        <div class="uk-grid uk-grid-small">
            <div id="id_ajaxViewMainTableTDForm">
            </div>
            <div id="ajaxViewMainTableTDList_id" class="uk-width-1-1">
                <div id="reoprtAdmissionReadmissionListDiv"  class="uk-width-1-1">&nbsp; </div>
            </div>
            <div id="TD_ID_for_other_function"  class="uk-width-1-1" >
                <div id="TD_ID_for_other_function_DIV"  class="uk-width-1-1">
                </div>
            </div>
        </div>


        <div id="showStudent_details_DIV" style="background:#F0F0FF;"  >
            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
            <input type="hidden"  id="WT_admissionReadmissionPageno" value="1" />
        </div>
    </div>
</div>
<!----Statistics-modal-->
<script>


</script>
<script>

    function WT_fetch_book_issue_report() // list table searched data get
    {
        var formdata = new FormData();
        var branch_code_s = os.getVal('branch_code_s');
        var library_id_s = os.getVal('library_id_s');
        var date_from_s = os.getVal('date_from_s');
        var date_to_s = os.getVal('date_to_s');



        if(branch_code_s===''){ alert('Please Select branch code '); return false;}
        if(library_id_s===''){ alert('Please Select library '); return false;}
        //if(book_search_s===''){ alert('Please Select book'); return false;}
        if(date_from_s===''){ alert('Please Select date from'); return false;}
        if(date_to_s===''){ alert('Please Select date to '); return false;}

        formdata.append('branch_code_s',branch_code_s);
        formdata.append('library_id_s',library_id_s);
        formdata.append('date_from_s',date_from_s);
        formdata.append('date_to_s',date_to_s);
        formdata.append('WT_fetch_book_issue_report','OK');


        let url='<? echo $ajaxFilePath ?>?WT_fetch_book_issue_report=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('reoprtAdmissionReadmissionListDiv',url,formdata);
    }
</script>

<? include($site['root-wtos'].'bottom.php'); ?>
