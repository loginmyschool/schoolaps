<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
$ajaxFilePath= 'budget-page_ajax.php';
$loadingImage=$site['url-wtos'].'images/loadingwt.gif';
$listHeader = 'Budget List';
?>
<div class="title-bar border-color-grey">
    <div class="uk-grid uk-padding-small uk-height-1-1" uk-grid>
        <div class="uk-width-expand uk-height-1-1 uk-flex uk-flex-middle">
            <h4 class="uk-margin-remove "><?php  echo $listHeader; ?></h4>
        </div>
        <div class="uk-width-auto uk-height-1-1 uk-flex uk-flex-middle">
            <button class="uk-button uk-border-rounded uk-button-small uk-secondary-button "
                    onclick="showAddDataDiv();">Add New</button>
        </div>
    </div>

</div>
<div class="content">
    <div class="item">
        <div class="uk-grid uk-grid-collapse" uk-grid>
            <div class="uk-width-2-3@m">
                <div class="p-m" id="WT_budget_list_detailsListDiv">&nbsp;</div>
            </div>

            <div class="uk-width-1-3@m">
                <div class="p-m"  id="WT_payment_detailsListDiv"></div>
            </div>
        </div>
    </div>
</div>


<div id="add-form-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-width-large">
        <h3>New Record</h3>
        <input type="hidden"  id="budget_list_id" value="0" />
        <button id="add-form-modal-close-button" class="uk-modal-close-default" uk-close></button>
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
                <input
                        class="uk-button uk-button-small uk-border-rounded uk-secondary-button"
                        type="button" value="Save" onclick="WT_budget_list_detailsEditAndSave();" />
            <? } ?>
        </div>
    </div>
</div>
<div id="budget-details-modal" uk-modal>
    <div  class="uk-modal-dialog uk-modal-body">
        <button  class="uk-modal-close-default" uk-close></button>
        <div id="WT_budget_detailsListDiv">

        </div>
    </div>
</div>
<script>

    function showAddDataDiv(){
        os.setVal('budget_list_id',0);
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


        UIkit.modal("#add-form-modal").show();
    }
    WT_budget_listListing();
    function WT_budget_listListing(){
        var formdata = new FormData();
        var url='<? echo $ajaxFilePath ?>?WT_budget_list_Listing=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_budget_list_detailsListDiv',url,formdata);
    }
    function WT_budget_listGetById(budget_list_id) // get record by table primery id
    {
        var formdata = new FormData();
        formdata.append('budget_list_id',budget_list_id );
        var url='<? echo $ajaxFilePath ?>?WT_budget_listGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_budget_listFillData',url,formdata);
    }

    function WT_budget_listFillData(data)  // fill data form by JSON
    {
        var objJSON = JSON.parse(data);
        os.setVal('budget_list_id',parseInt(objJSON.budget_list_id));
        os.setVal('reference_no',objJSON.reference_no);
        os.setVal('parent_head_id',objJSON.parent_head_id);
        os.setVal('account_head_id',objJSON.account_head_id);
        os.setVal('dated',objJSON.dated);
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
        UIkit.modal("#add-form-modal").show();

        $("#add-form-modal-close-button").click(()=>{
            WT_budget_list_detailsListing(parseInt(objJSON.budget_list_id));
            $("#add-form-modal-close-button").unbind("click");
        })

    }

    function WT_budget_list_detailsListing(budget_list_id){
        os.show('WT_budget_detailsListDiv');
        var formdata = new FormData();
        formdata.append('budget_list_id',budget_list_id );
        var url='<? echo $ajaxFilePath ?>?WT_budget_list_detailsListing=OK';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_budget_detailsListingResult',url,formdata);
    }

    function WT_budget_detailsListingResult(data){

        os.setHtml("WT_budget_detailsListDiv",data);
        UIkit.modal("#budget-details-modal").show();

    }
    function WT_budget_list_detailsEditAndSave()  // collect data and send to save
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
        var budget_list_idVal= os.getVal('budget_list_id');
        formdata.append('budget_list_id',budget_list_idVal );
        var url='<? echo $ajaxFilePath ?>?WT_budget_listEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_budget_list_detailsReLoadList',url,formdata);

    }

    function WT_budget_list_detailsReLoadList(data) // after edit reload list
    {
        var d=data.split('#-#');
        var budget_list_id=parseInt(d[0]);
        if(d[0]!='Error' && budget_list_id>0)
        {
            os.setVal('budget_list_id',budget_list_id);
        }
        if(d[1]!=''){alert(d[1]);}
        $("#add-form-modal-close-button").unbind("click");
        WT_budget_list_detailsListing(budget_list_id);

        WT_budget_listListing();
    }

    function WT_budget_details_listDeleteRowById(budget_list_details_id) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(budget_list_details_id)<1 || budget_list_details_id==''){
            var  budget_list_details_id =os.getVal('budget_list_details_id');
        }

        if(parseInt(budget_list_details_id)<1){ alert('No record Selected'); return;}
        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){
            formdata.append('budget_list_details_id',budget_list_details_id );
            var url='<? echo $ajaxFilePath ?>?WT_budget_list_details_DeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_budget_list_details_DeleteResults',url,formdata);
        }
    }
    function WT_budget_list_details_DeleteResults(data)
    {
        var d=data.split('#-#');
        alert(d[0]);
        WT_budget_list_detailsListing(d[1]);
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


    UIkit.modal("#add-form-modal", {
        bgClose : false,
        escClose : false
    })

</script>

<? include($site['root-wtos'].'bottom.php'); ?>
