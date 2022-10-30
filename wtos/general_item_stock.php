<?

/*

   # wtos version : 1.1

   # main ajax process page : feesAjax.php

   #

*/



include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'top.php');

?><?

$pluginName='';

$listHeader='General Item Stock';

$ajaxFilePath= 'general_item_stock_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$department = "General";
$access_name = "General Item Stock";
$branches = $os->get_branches_by_access_name($access_name);
$selected_branch    = $os->getSession($department."_branch");
$global_access      = $os->get_global_access_by_name($access_name);
//$secondary_access   = $os->get_secondary_access_by_branch_and_menu($selected_branch, $access_name);
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
    <div class="item">
        <div class="uk-padding-small uk-padding-remove-bottom">
            <div class="uk-inline" uk-tooltip="Select Branch">
                <div class="bp3-input-group ">
                    <div class="bp3-select">
                <select name="branch_code"
                        id="branch_code_s"
                        onchange="WT_fetch_item_stock_list()">
                    <option value="" selected>--</option>
                    <?$os->onlyOption($branches)?>
                </select>
                    </div>
                </div>
            </div>
            <div class="uk-inline uk-width-medium" uk-tooltip="Select Item">
                <input type="number" id="item_id" name="item_id" class="uk-hidden" value="<?=$os->val($item_entry_detail,'item_id')?>">
                <select type="text"
                        id="search_item_name" style="width: 100%">
                </select>
            </div>

            <div class="uk-inline " uk-tooltip="Select from date">
                <div class="bp3-input-group ">
                    <span class="bp3-icon bp3-icon-calendar"></span>
                    <input type="text" class="bp3-input  datepicker"
                           placeholder="From"
                           value="<?=date("Y-m-d")?>"
                           id="from_date_s"/>

                </div>
            </div>



            <div class="uk-inline " uk-tooltip="Select to date">
                <div class="bp3-input-group ">
                    <span class="bp3-icon bp3-icon-calendar"></span>
                    <input type="text" class="bp3-input  datepicker"
                           placeholder="From"
                           value="<?=date("Y-m-d")?>"
                           id="to_date_s"/>

                </div>
            </div>


            <button onclick="WT_fetch_item_stock_list();"
                    class="bp3-button bp3-intent-primary" type="button" >
                <span uk-icon="icon:  search; ratio:0.7" class="m-right-s"></span>
                Search
            </button>

        </div>

        <div id="WT_fetch_item_stock_list_DIV" class="uk-padding-small">&nbsp; </div>

    </div>
</div>


<script>
    function WT_fetch_item_stock_list(){
        let formdata = new FormData();

        formdata.append('branch_code_s',os.getVal("branch_code_s") );
        formdata.append('item_id',os.getVal("item_id") );
        formdata.append('from_date_s',os.getVal("from_date_s") );
        formdata.append('to_date_s',os.getVal("to_date_s") );
        formdata.append('WT_fetch_item_stock_list','OK' );
        let url='<? echo $ajaxFilePath ?>?WT_fetch_item_stock_list=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
            $("#WT_fetch_item_stock_list_DIV").html(data);
        }, url, formdata);
    }

    $("#search_item_name").selectize({
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
                                    <img src="https://loremflickr.com/100/100/${escape(item.text)}"
                                         style="height: 30px; width:30px; object-fit: cover"
                                         class="uk-border-rounded m-right-m"/>
                                </div>
                                <div class="uk-width-expand">
                                    <div class="name">${escape(item.text)}</div>
                                    <div class="text-xs uk-text-primary">${escape(item.type)}</div>
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

    WT_fetch_item_stock_list();

</script>

<? include($site['root-wtos'].'bottom.php'); ?>
