<?
/*
   # wtos version : 1.1
   # main ajax process page : otherpaymentAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='List otherpayment';
$ajaxFilePath= 'otherpaymentAjax.php';
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


    <div class="item with-header-footer" style="min-width: 300px; max-width: 300px">
        <div class="item-content p-left-l p-right-l p-m">
            <table class="uk-table uk-table-justify congested-table">
                <tr>
                    <td>User </td>
                    <td><input value="" type="text" name="user_id" id="user_id" class="uk-input uk-border-rounded congested-form"/> </td>
                </tr>
                <tr >
                    <td>Paid to </td>
                    <td><input value="" type="text" name="paid_to" id="paid_to" class="uk-input uk-border-rounded congested-form"/> </td>
                </tr>
                <tr >
                    <td>Paid amt </td>
                    <td><input value="" type="text" name="paid_amt" id="paid_amt" class="uk-input uk-border-rounded congested-form"/> </td>
                </tr>
                <tr >
                    <td>Paid date </td>
                    <td><input value="" type="text" name="paid_date" id="paid_date" class="wtDateClass uk-input uk-border-rounded congested-form"/></td>
                </tr>
                <tr >
                    <td>Payment note </td>
                    <td><input value="" type="text" name="payment_note" id="payment_note" class="uk-input uk-border-rounded congested-form"/> </td>
                </tr>
                <tr >
                    <td>Payment mode </td>
                    <td>

                        <select name="payment_mode" id="payment_mode" class="uk-select uk-border-rounded congested-form" ><option value="">Select Payment mode</option>	<?
                            $os->onlyOption($os->paymentethod);	?></select>	 </td>
                </tr>
                <tr >
                    <td>Payment details </td>
                    <td><input value="" type="text" name="payment_details" id="payment_details" class="uk-input uk-border-rounded congested-form"/> </td>
                </tr>
                <tr >
                    <td>Payment ref no </td>
                    <td><input value="" type="text" name="payment_ref_no" id="payment_ref_no" class="uk-input uk-border-rounded congested-form"/> </td>
                </tr>
                <tr >
                    <td>Payment type </td>
                    <td>

                        <select name="payment_type" id="payment_type" class="uk-select uk-border-rounded congested-form" ><option value="">Select Payment type</option>	<?
                            $os->onlyOption($os->othersPaymentType);	?></select>	 </td>
                </tr>
                <tr >
                    <td>Status </td>
                    <td>

                        <select name="active_status" id="active_status" class="uk-select uk-border-rounded congested-form" >
                            <option value="">Select Status</option>
                            <? $os->onlyOption($os->activeStatus);	?>
                        </select>
                    </td>
                </tr>


            </table>


            <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
            <input type="hidden"  id="otherpaymentId" value="0" />
            <input type="hidden"  id="WT_otherpaymentpagingPageno" value="1" />



            <div class="uk-margin-small">
                <? if($os->access('wtDelete')){ ?>
                    <button class="uk-button uk-border-rounded uk-button-danger congested-form " type="button" value="Delete" onclick="WT_otherpaymentDeleteRowById('');" >Delete</button>
                <? } ?>
                <button class="uk-button uk-border-rounded uk-button-default congested-form "  type="button" value="New" onclick="javascript:window.location='';" >New</button>
                <? if($os->access('wtEdit')){ ?>
                    <button class="uk-button uk-border-rounded uk-secondary-button congested-form "  type="button" value="Save" onclick="WT_otherpaymentEditAndSave();">Save</button>
                <? } ?>
            </div>
        </div>
    </div>
    <div class="item p-m">

        <div >
            <div class="uk-inline">
            <input class="uk-input uk-form-small uk-border-rounded" type="text" id="searchKey" />
            </div>
            <div style="display:none" id="advanceSearchDiv">

                User: <input type="text" class="wtTextClass" name="user_id_s" id="user_id_s" value="" />
                Paid to: <input type="text" class="wtTextClass" name="paid_to_s" id="paid_to_s" value="" /> &nbsp;  Paid amt: <input type="text" class="wtTextClass" name="paid_amt_s" id="paid_amt_s" value="" /> &nbsp; From Paid date: <input class="wtDateClass" type="text" name="f_paid_date_s" id="f_paid_date_s" value=""  /> &nbsp;   To Paid date: <input class="wtDateClass" type="text" name="t_paid_date_s" id="t_paid_date_s" value=""  /> &nbsp;
                Payment note: <input type="text" class="wtTextClass" name="payment_note_s" id="payment_note_s" value="" /> &nbsp;  Payment mode:

                <select name="payment_mode" id="payment_mode_s" class="uk-select uk-border-rounded congested-form" ><option value="">Select Payment mode</option>	<?
                    $os->onlyOption($os->paymentethod);	?></select>
                Payment details: <input type="text" class="wtTextClass" name="payment_details_s" id="payment_details_s" value="" /> &nbsp;  Payment ref no: <input type="text" class="wtTextClass" name="payment_ref_no_s" id="payment_ref_no_s" value="" /> &nbsp;  Payment type:

                <select name="payment_type" id="payment_type_s" class="uk-select uk-border-rounded congested-form" ><option value="">Select Payment type</option>	<?
                    $os->onlyOption($os->othersPaymentType);	?></select>
                Status:

                <select name="active_status" id="active_status_s" class="uk-select uk-border-rounded congested-form" ><option value="">Select Status</option>	<?
                    $os->onlyOption($os->activeStatus);	?></select>

            </div>


            <input class="uk-button uk-button-small uk-border-rounded uk-secondary-button" type="button" value="Search" onclick="WT_otherpaymentListing();" style="cursor:pointer;"/>
            <input class="uk-button uk-button-small uk-border-rounded uk-secondary-button" type="button" value="Reset" onclick="searchReset();" style="cursor:pointer;"/>

        </div>
        <div  class="uk-margin-small" id="WT_otherpaymentListDiv">&nbsp; </div>
    </div>

</div>





    <script>

        function WT_otherpaymentListing() // list table searched data get
        {
            var formdata = new FormData();


            var user_id_sVal= os.getVal('user_id_s');
            var paid_to_sVal= os.getVal('paid_to_s');
            var paid_amt_sVal= os.getVal('paid_amt_s');
            var f_paid_date_sVal= os.getVal('f_paid_date_s');
            var t_paid_date_sVal= os.getVal('t_paid_date_s');
            var payment_note_sVal= os.getVal('payment_note_s');
            var payment_mode_sVal= os.getVal('payment_mode_s');
            var payment_details_sVal= os.getVal('payment_details_s');
            var payment_ref_no_sVal= os.getVal('payment_ref_no_s');
            var payment_type_sVal= os.getVal('payment_type_s');
            var active_status_sVal= os.getVal('active_status_s');
            formdata.append('user_id_s',user_id_sVal );
            formdata.append('paid_to_s',paid_to_sVal );
            formdata.append('paid_amt_s',paid_amt_sVal );
            formdata.append('f_paid_date_s',f_paid_date_sVal );
            formdata.append('t_paid_date_s',t_paid_date_sVal );
            formdata.append('payment_note_s',payment_note_sVal );
            formdata.append('payment_mode_s',payment_mode_sVal );
            formdata.append('payment_details_s',payment_details_sVal );
            formdata.append('payment_ref_no_s',payment_ref_no_sVal );
            formdata.append('payment_type_s',payment_type_sVal );
            formdata.append('active_status_s',active_status_sVal );



            formdata.append('searchKey',os.getVal('searchKey') );
            formdata.append('showPerPage',os.getVal('showPerPage') );
            var WT_otherpaymentpagingPageno=os.getVal('WT_otherpaymentpagingPageno');
            var url='wtpage='+WT_otherpaymentpagingPageno;
            url='<? echo $ajaxFilePath ?>?WT_otherpaymentListing=OK&'+url;
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxHtml('WT_otherpaymentListDiv',url,formdata);

        }

        WT_otherpaymentListing();
        function  searchReset() // reset Search Fields
        {
            os.setVal('user_id_s','');
            os.setVal('paid_to_s','');
            os.setVal('paid_amt_s','');
            os.setVal('f_paid_date_s','');
            os.setVal('t_paid_date_s','');
            os.setVal('payment_note_s','');
            os.setVal('payment_mode_s','');
            os.setVal('payment_details_s','');
            os.setVal('payment_ref_no_s','');
            os.setVal('payment_type_s','');
            os.setVal('active_status_s','');

            os.setVal('searchKey','');
            WT_otherpaymentListing();

        }


        function WT_otherpaymentEditAndSave()  // collect data and send to save
        {

            var formdata = new FormData();
            var user_idVal= os.getVal('user_id');
            var paid_toVal= os.getVal('paid_to');
            var paid_amtVal= os.getVal('paid_amt');
            var paid_dateVal= os.getVal('paid_date');
            var payment_noteVal= os.getVal('payment_note');
            var payment_modeVal= os.getVal('payment_mode');
            var payment_detailsVal= os.getVal('payment_details');
            var payment_ref_noVal= os.getVal('payment_ref_no');
            var payment_typeVal= os.getVal('payment_type');
            var active_statusVal= os.getVal('active_status');


            formdata.append('user_id',user_idVal );
            formdata.append('paid_to',paid_toVal );
            formdata.append('paid_amt',paid_amtVal );
            formdata.append('paid_date',paid_dateVal );
            formdata.append('payment_note',payment_noteVal );
            formdata.append('payment_mode',payment_modeVal );
            formdata.append('payment_details',payment_detailsVal );
            formdata.append('payment_ref_no',payment_ref_noVal );
            formdata.append('payment_type',payment_typeVal );
            formdata.append('active_status',active_statusVal );



            var   otherpaymentId=os.getVal('otherpaymentId');
            formdata.append('otherpaymentId',otherpaymentId );
            var url='<? echo $ajaxFilePath ?>?WT_otherpaymentEditAndSave=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_otherpaymentReLoadList',url,formdata);

        }

        function WT_otherpaymentReLoadList(data) // after edit reload list
        {

            var d=data.split('#-#');
            var otherpaymentId=parseInt(d[0]);
            if(d[0]!='Error' && otherpaymentId>0)
            {
                os.setVal('otherpaymentId',otherpaymentId);
            }

            if(d[1]!=''){alert(d[1]);}
            WT_otherpaymentListing();
        }

        function WT_otherpaymentGetById(otherpaymentId) // get record by table primery id
        {
            var formdata = new FormData();
            formdata.append('otherpaymentId',otherpaymentId );
            var url='<? echo $ajaxFilePath ?>?WT_otherpaymentGetById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_otherpaymentFillData',url,formdata);

        }

        function WT_otherpaymentFillData(data)  // fill data form by JSON
        {

            var objJSON = JSON.parse(data);
            os.setVal('otherpaymentId',parseInt(objJSON.otherpaymentId));

            os.setVal('user_id',objJSON.user_id);
            os.setVal('paid_to',objJSON.paid_to);
            os.setVal('paid_amt',objJSON.paid_amt);
            os.setVal('paid_date',objJSON.paid_date);
            os.setVal('payment_note',objJSON.payment_note);
            os.setVal('payment_mode',objJSON.payment_mode);
            os.setVal('payment_details',objJSON.payment_details);
            os.setVal('payment_ref_no',objJSON.payment_ref_no);
            os.setVal('payment_type',objJSON.payment_type);
            os.setVal('active_status',objJSON.active_status);


        }

        function WT_otherpaymentDeleteRowById(otherpaymentId) // delete record by table id
        {
            var formdata = new FormData();
            if(parseInt(otherpaymentId)<1 || otherpaymentId==''){
                var  otherpaymentId =os.getVal('otherpaymentId');
            }

            if(parseInt(otherpaymentId)<1){ alert('No record Selected'); return;}

            var p =confirm('Are you Sure? You want to delete this record forever.')
            if(p){

                formdata.append('otherpaymentId',otherpaymentId );

                var url='<? echo $ajaxFilePath ?>?WT_otherpaymentDeleteRowById=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_otherpaymentDeleteRowByIdResults',url,formdata);
            }


        }
        function WT_otherpaymentDeleteRowByIdResults(data)
        {
            alert(data);
            WT_otherpaymentListing();
        }

        function wtAjaxPagination(pageId,pageNo)// pagination function
        {
            os.setVal('WT_otherpaymentpagingPageno',parseInt(pageNo));
            WT_otherpaymentListing();
        }






    </script>




<? include($site['root-wtos'].'bottom.php'); ?>
