<?
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
global $os, $site;
$pluginName='';
$listHeader='Book Issue Report';
$ajaxFilePath= 'library_book_issue_report_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';

$access_name = "Library Book Issue Report";
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
        <div class="uk-padding-small ">
            <div class="uk-grid uk-grid-small" uk-grid>
                <div uk-tooltip="Select Branch" style="min-width: 300px">
                    <select name="branch_code_s" id="branch_code_s"
                            onchange="wt_ajax_chain('html*library_id_s*library,library_id,name*branch_code=branch_code_s','','reInit();','reInit();');">
                        <option value="">--BRANCH--</option>
                        <? $os->onlyOption($branch_codes,'');	?>
                    </select>
                </div>
                <div uk-tooltip="Select Library" style="min-width: 150px">
                    <select name="library_id_s" id="library_id_s"
                            class="uk-select uk-border-rounded congested-form"
                            onchange="">
                        <option value="">--Library--</option>
                    </select>
                </div>
                <div uk-tooltip="Select Book" style="min-width: 200px">
                    <select type="text" id="book_search_s" ></select>
                </div>
                <div uk-tooltip="Date From">
                    <div class="uk-inline">
                        <input class="datepicker uk-input uk-border-rounded congested-form" id="date_from_s">
                    </div>
                </div>
                <div uk-tooltip="Date to">
                    <div class="uk-inline">
                        <input class="datepicker uk-input uk-border-rounded congested-form" id="date_to_s">
                    </div>
                </div>


                <div class="uk-hidden">
                    <div class="uk-inline">
                        <input name="registerNo_s"
                               id="registerNo_s"
                               class=" uk-input uk-border-rounded congested-form"
                               placeholder="Registration Number" />
                    </div>
                </div>
                <div>


                    <button type="button"
                            class="uk-button uk-border-rounded congested-form uk-secondary-button"
                            value="Search" onclick="WT_fetch_book_issue_report();">Search</button>

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
    $("#book_search_s").selectize({
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        create: false,
        sortField: 'text',
        render: {
            option: function(item, escape) {
                return `
                        <div>
                            <div class="uk-grid uk-grid-collapse">
                                <div>
                                    <img src="${escape(item.photo)}"
                                         style="height: 45px; width:30px; object-fit: cover"
                                         class="uk-border-rounded m-right-m"/>
                                </div>
                                <div class="uk-width-expand">
                                    <div class="name">${escape(item.text)}</div>
                                    <div class="text-xs uk-text-primary uk-margin-remove">${escape(item.meta.Author)}, ${escape(item.meta.Publisher)}</div>
                                    <div class="text-xs uk-text-primary uk-margin-remove">${escape(item.meta.Edition)}</div>
                                </div>
                            </div>
                        </div>`;
            }
        },
        onChange  : function (value){
            document.querySelector('#item_id').value = value;
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '<?=$ajaxFilePath?>?autocomplete_items=OK',
                type: 'GET',
                dataType: 'json',
                data: {
                    q: query,
                    page_limit: 10,
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res.results);
                }
            });
        }
    });
    $("#branch_code_s").selectize();
    //let select = $("#library_id_s").selectize();
    function reInit(){

    }
</script>
<script>

    function WT_fetch_book_issue_report() // list table searched data get
    {
        var formdata = new FormData();
        var branch_code_s = os.getVal('branch_code_s');
        var library_id_s = os.getVal('library_id_s');
        var book_search_s = os.getVal('book_search_s');
        var date_from_s = os.getVal('date_from_s');
        var date_to_s = os.getVal('date_to_s');
        var registerNo_s = os.getVal('registerNo_s');


        if(branch_code_s===''){ alert('Please Select branch code '); return false;}
        if(library_id_s===''){ alert('Please Select library '); return false;}
        //if(book_search_s===''){ alert('Please Select book'); return false;}
        if(date_from_s===''){ alert('Please Select date from'); return false;}
        if(date_to_s===''){ alert('Please Select date to '); return false;}

        formdata.append('branch_code_s',branch_code_s);
        formdata.append('library_id_s',library_id_s);
        formdata.append('book_search_s',book_search_s);
        formdata.append('date_from_s',date_from_s);
        formdata.append('date_to_s',date_to_s);
        formdata.append('registerNo_s',registerNo_s);
        formdata.append('WT_fetch_book_issue_report','OK');


        let url='<? echo $ajaxFilePath ?>?WT_fetch_book_issue_report=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('reoprtAdmissionReadmissionListDiv',url,formdata);
    }
</script>

<? include($site['root-wtos'].'bottom.php'); ?>
