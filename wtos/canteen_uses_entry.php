<?
/*
   # wtos version : 1.1
   # main ajax process page : construction_uses_entry_ajax.php
   #
*/
include('wtosConfigLocal.php');
global $site, $os;
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Canteen uses';
$ajaxFilePath= $site["url-wtos"].'canteen_uses_entry_ajax.php';
$os->loadPluginConstant($pluginName);
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$department = "Canteen";
$branches = $os->get_branches_by_access_name("Canteen uses Entry");
?>

<div class="content without-header with-both-side-bar uk-overflow-hidden uk-height-1-1">
    <!-----------
    Main contents
    --------------->

    <div class="item with-header medium-sidebar background-color-white"  id="left_container" style="max-width: 400px">
        <div class="item-header p-m uk-box-shadow-small">

            <select name="branch_code" class="select2"
                    id="branch_code_s"
                    onchange="WT_fetch_usesinfo_list()"
                    class="uk-select congested-form uk-border-rounded uk-margin-small-bottom">
                <option value="" selected>--</option>
                <? $os->onlyOption($branches, $os->val($usesinfo,"branch_code"))?>
            </select>

            <div class="bp3-control-group bp3-fill">
                <div class="bp3-input-group bp3-small">
                    <span class="bp3-icon bp3-icon-calendar"></span>
                    <input type="text" class="bp3-input  datepicker"
                           placeholder="From"
                           value="<?=date("Y-m-d")?>"
                           id="date_from_s"/>
                </div>
                <div class="bp3-input-group bp3-small">
                    <span class="bp3-icon bp3-icon-calendar"></span>
                    <input type="text" class="bp3-input datepicker"
                           placeholder="To"
                           value="<?=date("Y-m-d")?>"
                           id="date_to_s"/>
                </div>
                <div class="bp3-input-group bp3-small">
                    <input type="text" class="bp3-input" placeholder="Ref. No." id="ref_no_s" />
                </div>
                <div class="bp3-button-group bp3-fixed bp3-small">
                    <button type="button" class="bp3-button " onclick="WT_fetch_usesinfo_list()">
                        <span class="bp3-icon bp3-icon-search"></span>
                    </button>

                    <button type="button" class="bp3-button bp3-intent-primary" onclick="WT_open_usesinfo_form(0)">
                        <span class="bp3-icon bp3-icon-add"></span>
                    </button>
                </div>
            </div>
        </div>
        <div id="WT_fetch_usesinfo_list_DIV" class="item-content uk-overflow-auto"></div>
    </div>
    <div class="item with-header " id="WT_fetch_usesinfo_details_DIV">
        <div class="center p-xl">Please Select Purchae to view items</div>
    </div>
</div>


<div modals>
    <!-- usesinfo form -->
    <div id="WT_usesinfo_form_modal" uk-modal="bg-close:false; cls-panel:bp3-dialog-container">
        <form id="insert_edit_usesinfo_form"
              class=""
              onsubmit="insert_edit_usesinfo(event)">
            <div class="bp3-dialog-container">
                <div class="bp3-dialog uk-width-small">
                    <div class="bp3-dialog-header">
                        <span class="bp3-icon-large bp3-icon-inbox"></span>
                        <h4 class="bp3-heading">usesinfo Entry</h4>
                        <button aria-label="Close"
                                class="bp3-dialog-close-button bp3-button bp3-minimal bp3-icon-cross uk-modal-close"></button>
                    </div>
                    <div class="bp3-dialog-body" id="WT_usesinfo_form">


                    </div>
                    <div class="bp3-dialog-footer">
                        <div class="bp3-dialog-footer-actions">
                            <button type="button" class="bp3-button bp3-intent-danger uk-modal-close">Cancel</button>
                            <button type="submit" class="bp3-button bp3-intent-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- usesinfo Details Form -->
    <div id="WT_usesinfo_details_form_modal" uk-modal="bg-close:false; cls-panel:bp3-dialog-container">
        <form id="insert_usesinfo_details_form" onsubmit="return insert_edit_usesinfo_details(event)">
            <div class="bp3-dialog-container">
                <div class="bp3-dialog">
                    <div class="bp3-dialog-header">
                        <span class="bp3-icon-large bp3-icon-inbox"></span>
                        <h4 class="bp3-heading">Item Entry</h4>
                        <button aria-label="Close"
                                class="bp3-dialog-close-button bp3-button bp3-minimal bp3-icon-cross uk-modal-close"></button>
                    </div>
                    <div class="bp3-dialog-body" id="WT_usesinfo_details_form">

                    </div>
                    <div class="bp3-dialog-footer">
                        <div class="bp3-dialog-footer-actions">
                            <button type="button" class="bp3-button bp3-intent-danger uk-modal-close">Cancel</button>
                            <button type="submit" class="bp3-button bp3-intent-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- usesinfo Details Transfer Form -->
    <div id="WT_usesinfo_details_transfer_form_modal" uk-modal="bg-close:false; cls-panel:bp3-dialog-container">
        <form id="insert_usesinfo_details_transfer_form" onsubmit="insert_edit_usesinfo_details_transfer(event)">
            <div class="bp3-dialog-container">
                <div class="bp3-dialog">
                    <div class="bp3-dialog-header">
                        <span class="bp3-icon-large bp3-icon-inbox"></span>
                        <h4 class="bp3-heading">Item Entry</h4>
                        <button aria-label="Close"
                                class="bp3-dialog-close-button bp3-button bp3-minimal bp3-icon-cross uk-modal-close"></button>
                    </div>
                    <div class="bp3-dialog-body" id="WT_usesinfo_details_transfer_form">

                    </div>
                    <div class="bp3-dialog-footer">
                        <div class="bp3-dialog-footer-actions">
                            <button type="button" class="bp3-button bp3-intent-danger uk-modal-close">Cancel</button>
                            <button type="submit" class="bp3-button bp3-intent-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<style>
    @media(max-width: 640px) {
        #left_container, #WT_fetch_usesinfo_details_DIV{
            display: none;
        }
        #left_container:target, #WT_fetch_usesinfo_details_DIV:target {
            display: block;
        }
    }
</style>
<script>
    function fill_data(form_id, data={}){
        for (let [key, value] of Object.entries(data)) {
            $(`#${form_id} input[name=${key}], #${form_id} select[name=${key}], #${form_id} textarea[name=${key}]`).val(value);

        }
    }
    //fetch list
    function WT_fetch_usesinfo_list(){
        let formdata = new FormData();

        formdata.append('branch_code_s',os.getVal("branch_code_s") );
        formdata.append('date_from_s',os.getVal("date_from_s") );
        formdata.append('date_to_s',os.getVal("date_to_s") );
        formdata.append('ref_no_s',os.getVal("ref_no_s") );
        formdata.append('WT_fetch_usesinfo_list','OK' );
        let url='<? echo $ajaxFilePath ?>?WT_fetch_usesinfo_list=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
            $("#WT_fetch_usesinfo_list_DIV").html(data);
            toggle_details("close");
        }, url, formdata);
    }
    function WT_fetch_usesinfo_details(item_use_id='0'){
        let formdata = new FormData();

        formdata.append('item_use_id', item_use_id );
        formdata.append('WT_fetch_usesinfo_details','OK' );
        let url='<? echo $ajaxFilePath ?>?WT_fetch_usesinfo_details=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
            $("#WT_fetch_usesinfo_details_DIV").html(data);
            ////////
            document.querySelectorAll(".usesinfo_row").forEach((el)=>{
                el.classList.remove("active");
            });
            document.querySelector(".usesinfo_row_"+item_use_id).classList.add("active");
            ///////
            toggle_details();
        }, url, formdata);
    }
    //forms
    function WT_open_usesinfo_form(item_use_id=0){
        let formdata = new FormData();

        formdata.append('item_use_id',item_use_id );
        formdata.append('get_usesinfo_form','OK' );
        let url='<? echo $ajaxFilePath ?>?get_usesinfo_form=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
            $("#WT_usesinfo_form").html(data);
            UIkit.modal("#WT_usesinfo_form_modal").show();
        }, url, formdata);
    }
    function WT_open_usesinfo_details_form(item_use_id='0', item_uses_detail_id='0'){
        let url='<? echo $ajaxFilePath ?>?get_usesinfo_details_form=OK';
        $.ajax({
            url: url,
            data: {
                'item_use_id':item_use_id ,
                'item_uses_detail_id':item_uses_detail_id ,
                'get_usesinfo_details_form':'OK'
            },
            type: 'POST',
            success:(data)=>{
                $("#WT_usesinfo_details_form").html(data);
                UIkit.modal("#WT_usesinfo_details_form_modal").show();
            }

        });
    }
    function WT_open_usesinfo_details_transfer_form(item_use_id='0', item_uses_detail_id='0'){
        let url='<? echo $ajaxFilePath ?>?get_usesinfo_details_transfer_form=OK';
        $.ajax({
            url: url,
            data: {
                'item_use_id':item_use_id ,
                'item_uses_detail_id':item_uses_detail_id ,
                'get_usesinfo_details_transfer_form':'OK'
            },
            type: 'POST',
            success:(data)=>{
                $("#WT_usesinfo_details_transfer_form").html(data);
                UIkit.modal("#WT_usesinfo_details_transfer_form_modal").show();
            }

        });
    }


    //insert edit events
    function insert_edit_usesinfo(event){
        event.preventDefault();
        let formdata = new FormData(event.target);
        // validate
        for (const pair of formdata.entries()) {
            let key = pair[0];
            let val = pair[1];

            if(val===""){
                if (key==="dated"){
                    alert("please enter date no");
                    return ;
                }
            }
        }
        //
        fetch('<?=$ajaxFilePath?>?insert_edit_usesinfo=OK', {
            method: 'POST',
            body: formdata,
        }).then(function (response) {
            if (response.ok) {
                return response.json();
            }
            return Promise.reject(response);
        }).then(function (data) {
            if(!data.error){
                WT_fetch_usesinfo_list();
                if(data.redirect) {
                    WT_fetch_usesinfo_details(data.i_id);
                    WT_open_usesinfo_details_form(data.i_id, 0);
                }
            }

        }).catch(function (error) {
            console.error(error);
        });
        return false;
    }
    function insert_edit_usesinfo_details(event){
	
	      let quantity_entry=parseFloat(os.getVal('quantity_entry'));
		quantity_entry = isNaN(quantity_entry)?0: quantity_entry;
		 
		let item_stock_info_data=parseFloat(os.getVal('item_stock_info_data'));	
		item_stock_info_data = isNaN(item_stock_info_data)?0: item_stock_info_data;	
		//alert(item_stock_info_data);
		//alert(quantity_entry);
		
		if(quantity_entry<=0){ alert('Please enter valid quantity.'); return false; }
		if(quantity_entry > item_stock_info_data){ alert('Please check stock quantity.'); return false; }
		 
	  
        event.preventDefault();
        fetch('<?=$ajaxFilePath?>?insert_edit_usesinfo_details=OK', {
            method: 'POST',
            body: new FormData(event.target),
        }).then(function (response) {
            if (response.ok) {
                return response.json();
            }
            return Promise.reject(response);
        }).then(function (data) {
            if(!data.error){
                WT_fetch_usesinfo_list();
                WT_fetch_usesinfo_details(data.i_id);
                WT_open_usesinfo_details_form(data.i_id, data.i_d_id);
            }
        }).catch(function (error) {
            console.error(error);
        });
        return false;
    }

    //verification
    function WT_do_verification(item_use_id, verify_text){
        let formdata = new FormData();

        formdata.append('item_use_id',item_use_id );
        formdata.append('branch_code_s',os.getVal("branch_code_s"));
        formdata.append('verify_text',verify_text);
        formdata.append('WT_do_verification','OK' );
        let url='<? echo $ajaxFilePath ?>?WT_do_verification=OK&';

        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"/> <div class="loadText">&nbsp;Please wait. Working...</div></div>';

        os.setAjaxFunc(function (data){
            WT_fetch_usesinfo_list();
        }, url, formdata);
    }

    //functions
    function calculate_amount(form_id){
        let qtd = $("#"+form_id+" input[name=quantity]");
        let rate = $("#"+form_id+" input[name=rate]");
        let amount = $("#"+form_id+" input[name=amount]");

        let qtdval = qtd.val()>0?qtd.val():0;
        let rateval = rate.val()>0?rate.val():0;

        amount.val(qtdval*rateval);
    }
    function toggle_details(order='open'){
        switch (order) {
            case "open":
                window.location = "#WT_fetch_usesinfo_details_DIV";
                break;
            case "close":
                window.location = "#left_container";
                break;
        }
    }


    $(document).ready(()=>{
        WT_fetch_usesinfo_list();
    })

</script>
<style>
    .usesinfo_row.active{
        background-color: rgba(0,255,0, 0.14);
    }
</style>



<? include($site['root-wtos'].'bottom.php'); ?>
