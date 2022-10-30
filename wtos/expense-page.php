<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$ajaxFilePath= 'expense-page_ajax.php';
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$listHeader = 'Expense List';
?>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button "
                    onclick="WT_expense_listFillData(''); ">Add New</button>
        </div>
    </div>

</div>


<div class="content">
    <div class="item">
        <div class="uk-grid uk-grid-collapse" uk-grid>
            <div class="uk-width-2-3@m">
                <div class="p-m" id="WT_expense_list_detailsListDiv"></div>
            </div>
            <div class="uk-width-1-3@m">
                <div class="p-m" id="WT_payment_detailsListDiv"></div>
            </div>
        </div>
    </div>
</div>


<div id="expense-details-modal" class="uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div id="WT_expense_detailsListDiv"></div>
    </div>
</div>
<div id="add-expense-modal" class="uk-modal add-expense-modal" uk-modal>
    <div class="uk-modal-dialog uk-width-large uk-modal-body">
        <h3>New Record</h3>
        <input type="hidden"  id="expense_list_id" value="0" />
        <table class="uk-table uk-table-justify congested-table uk-margin-remove-bottom">
            <tr >
                <td>
                    <label>Reference no </label>
                    <input value="" type="text" name="reference_no" id="reference_no" class="uk-input uk-border-rounded congested-form "/>
                </td>
                <td>
                    <label>Dated </label>
                    <input value="" type="text" name="dated" id="dated" class="wtDateClass uk-input uk-border-rounded congested-form"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Account</label>
                    <select name="parent_head_id" id="parent_head_id" class="uk-select uk-border-rounded congested-form"
                            onchange="wt_ajax_chain('html*account_head_id*account_head,account_head_id,title*parent_head_id=parent_head_id','parent_head_id!=0','','');">
                        <option value="">Select Account</option>
                        <? $os->optionsHTML('','account_head_id','title','account_head','parent_head_id=0');?>
                    </select>
                </td>


                <td>
                    <label>Sub Account</label>
                    <select name="account_head_id" id="account_head_id" class="uk-select uk-border-rounded congested-form" >
                        <!-- <option value="">Select Expense Purpose</option>
                        <? $os->optionsHTML('','account_head_id','title','account_head','parent_head_id!=0');?> -->
                    </select>
                </td>
            </tr>
        </table>
        <table class="uk-table uk-table-justify congested-table uk-margin-remove">
            <tr>
                <td>
                    <label>Type </label>
                    <select name="type" id="type" class="uk-select uk-border-rounded congested-form" >
                        <option value="">Select Type</option>
                        <? $os->onlyOption($os->type);   ?>
                    </select>
                </td>
                <td>
                    <label>Quantity </label>
                    <input value="" type="text" name="quantity" id="quantity" class="uk-input uk-border-rounded congested-form "/>
                </td>

                <td>
                    <label>Unit </label>
                    <select name="unit" id="unit" class="uk-select uk-border-rounded congested-form" ><option value="">Select Unit</option> <? $os->onlyOption($os->unit);   ?></select>
                </td>

            </tr>
        </table>
        <table class="uk-table uk-table-justify congested-table uk-margin-remove">
            <tr >
                <td>
                    <label>Description </label>
                    <textarea value="" type="text" name="description" id="description" class="uk-input uk-border-rounded congested-form " style="max-height: inherit; height: 80px!important;"></textarea>
                </td>
            </tr>
        </table>
        <table class="uk-table uk-table-justify congested-table uk-margin-remove-top">
            <tr >

                <td>
                    <label>Tax Percent </label>
                    <input value="" type="text" name="tax_percent" id="tax_percent" class="uk-input uk-border-rounded congested-form "/>
                </td>

                <td>
                    <label>Rate excl tax </label>
                    <input value="" type="text" name="rate_excl_tax" id="rate_excl_tax" class="uk-input uk-border-rounded congested-form "/>
                </td>

                <td>
                    <label>Rate incl tax </label>
                    <input value="" type="text" name="rate_incl_tax" id="rate_incl_tax" class="uk-input uk-border-rounded congested-form "/>
                </td>
            </tr>

            <tr >
                <td>
                    <label>Total excl Tax </label>
                    <input value="" type="text" name="total_excl_tax" id="total_excl_tax" class="uk-input uk-border-rounded congested-form "/>
                </td>

                <td>
                    <label>Total Incl Tax </label>
                    <input value="" type="text" name="total_incl_tax" id="total_incl_tax" class="uk-input uk-border-rounded congested-form "/>
                </td>

                <td>
                    <label>Tax Amount</label>
                    <input value="" type="text" name="tax_amount" id="tax_amount" class="uk-input uk-border-rounded congested-form "/>
                </td>
            </tr>

        </table>

        <div class="uk-text-right">
        <? if($os->access('wtEdit')){ ?>
            <button
                    class="uk-button uk-button-small uk-border-rounded uk-secondary-button"
                    type="button" value="Save" onclick="WT_expense_list_detailsEditAndSave();">Save</button>
        <? } ?>
        </div>

    </div>
</div>

<script>

    function showAddDataDiv(){
        os.setVal('expense_list_id',0);
        os.setVal('reference_no','');
        os.setVal('parent_head_id','');
        os.setVal('account_head_id','');
        os.setVal('dated','');
        os.setVal('description','');
        os.setVal('quantity','');
        os.setVal('unit','');
        os.setVal('tax_percent','');


        os.setVal('rate_excl_tax','');
        os.setVal('rate_incl_tax','');
        os.setVal('total_excl_tax','');
        os.setVal('tax_amount','');


        os.setVal('total_incl_tax','');
        os.setVal('type','');
        os.show('expenseDiv');
        os.hide('WT_expense_detailsListDiv');
    }
    WT_expense_listListing();
    function WT_expense_listListing(){
        var formdata = new FormData();
        var url='<? echo $ajaxFilePath ?>?WT_expense_list_Listing=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_expense_list_detailsListDiv',url,formdata);
    }
    function WT_expense_listGetById(expense_list_id) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('expense_list_id',expense_list_id );
        var url='<? echo $ajaxFilePath ?>?WT_expense_listGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_expense_listFillData',url,formdata);
    }
    let is_edit = false;
    function WT_expense_listFillData(data)  // fill data form by JSON
    {
        if(data === ""){
            is_edit = false;
            os.setVal('expense_list_id',"");
            os.setVal('reference_no',"");
            os.setVal('parent_head_id',"");
            os.setVal('account_head_id',"");
            os.setVal('dated',"");
            os.setVal('description','');
            os.setVal('quantity','');
            os.setVal('unit','');
            os.setVal('tax_percent','');
            os.setVal('rate_excl_tax','');
            os.setVal('rate_incl_tax','');
            os.setVal('total_excl_tax','');
            os.setVal('tax_amount','');
            os.setVal('total_incl_tax','');
            os.setVal('type','');

        } else {
            is_edit = true;
            var objJSON = JSON.parse(data);
            os.setVal('expense_list_id', parseInt(objJSON.expense_list_id));
            os.setVal('reference_no', objJSON.reference_no);
            os.setVal('parent_head_id', objJSON.parent_head_id);
            os.setVal('account_head_id', objJSON.account_head_id);
            os.setVal('dated', objJSON.dated);
            os.setVal('description', '');
            os.setVal('quantity', '');
            os.setVal('unit', '');
            os.setVal('tax_percent', '');
            os.setVal('rate_excl_tax', '');
            os.setVal('rate_incl_tax', '');
            os.setVal('total_excl_tax', '');
            os.setVal('tax_amount', '');
            os.setVal('total_incl_tax', '');
            os.setVal('type', '');
        }
        UIkit.modal('#add-expense-modal').show();

    }


    function openEditForm(expense_list_id){
        WT_expense_list_detailsListing(expense_list_id);
    }
    function WT_expense_list_detailsListing(expense_list_id){
        var formdata = new FormData();
        formdata.append('expense_list_id',expense_list_id );
        var url='<? echo $ajaxFilePath ?>?WT_expense_list_detailsListing=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_expense_list_detailsListingCallback',url,formdata);

    }
    function WT_expense_list_detailsListingCallback(data){
        os.setHtml('WT_expense_detailsListDiv', data);
        UIkit.modal("#expense-details-modal").show();
    }
    WT_others_payment_listing();
    function WT_others_payment_listing(){
        var formdata = new FormData();
        formdata.append('WT_others_payment_listing_val','OKS');
        var url='<? echo $ajaxFilePath ?>?WT_others_payment_listing=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_payment_detailsListDiv',url,formdata);
    }
    function WT_expense_list_detailsEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var reference_noVal= os.getVal('reference_no');
        var parent_head_idVal= os.getVal('parent_head_id');
        var account_head_idVal= os.getVal('account_head_id');
        var datedVal= os.getVal('dated');
        formdata.append('reference_no',reference_noVal );
        formdata.append('parent_head_id',parent_head_idVal );
        formdata.append('account_head_id',account_head_idVal );
        formdata.append('dated',datedVal);
        var descriptionVal= os.getVal('description');
        var quantityVal= os.getVal('quantity');
        var unitVal= os.getVal('unit');
        var tax_percentVal= os.getVal('tax_percent');
        var rate_excl_taxVal= os.getVal('rate_excl_tax');
        var rate_incl_taxVal= os.getVal('rate_incl_tax');
        var total_excl_taxVal= os.getVal('total_excl_tax');
        var total_incl_taxVal= os.getVal('total_incl_tax');
        var tax_amountVal= os.getVal('tax_amount');
        var typeVal= os.getVal('type');

        formdata.append('description',descriptionVal );
        formdata.append('quantity',quantityVal );
        formdata.append('unit',unitVal );
        formdata.append('tax_percent',tax_percentVal );

        formdata.append('rate_excl_tax',rate_excl_taxVal );
        formdata.append('rate_incl_tax',rate_incl_taxVal );
        formdata.append('total_excl_tax',total_excl_taxVal );


        formdata.append('total_incl_tax',total_incl_taxVal );
        formdata.append('tax_amount',tax_amountVal );
        formdata.append('type',typeVal );
        var expense_list_idVal= os.getVal('expense_list_id');
        formdata.append('expense_list_id',expense_list_idVal );
        var url='<? echo $ajaxFilePath ?>?WT_expense_listEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_expense_list_detailsReLoadList',url,formdata);

    }
    function WT_expense_list_detailsReLoadList(data) // after edit reload list
    {
        var d=data.split('#-#');
        var expense_list_id=parseInt(d[0]);
        if(d[0]!='Error' && expense_list_id>0)
        {
            os.setVal('expense_list_id',expense_list_id);
        }
        if(d[1]!=''){alert(d[1]);}
        WT_expense_listGetById(expense_list_id);
        WT_expense_listListing();
    }
    function WT_expense_details_listDeleteRowById(expense_list_details_id) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(expense_list_details_id)<1 || expense_list_details_id==''){
            var  expense_list_details_id =os.getVal('expense_list_details_id');
        }

        if(parseInt(expense_list_details_id)<1){ alert('No record Selected'); return;}
        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){
            formdata.append('expense_list_details_id',expense_list_details_id );
            var url='<? echo $ajaxFilePath ?>?WT_expense_list_details_DeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_expense_list_details_DeleteResults',url,formdata);
        }
    }
    function WT_expense_list_details_DeleteResults(data)
    {
        var d=data.split('#-#');
        alert(d[0]);
        WT_expense_list_detailsListing(d[1]);
    }


    UIkit.util.on(document, 'hidden', '#add-expense-modal', function () {
        if(is_edit) {
            WT_expense_list_detailsListing(parseInt(expense_list_id));
        }
    });

</script>

<? include($site['root-wtos'].'bottom.php'); ?>
