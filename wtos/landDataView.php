<?
/*
   # wtos version : 1.1
   # main ajax process page : landAjax.php
   #
*/
include('wtosConfigLocal.php');
include($site['root-wtos'].'top.php');
?><?
$pluginName='';
$listHeader='Manage Land';
$ajaxFilePath= 'landAjax.php';
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
                    onclick="WT_landFillData()"
                    class="uk-button uk-border-rounded   uk-button-small uk-secondary-button uk-flex-inline uk-flex-middle" >
                Add New
            </button>

        </div>
    </div>

</div>
<div class="content">
    <!-----------
    Main contents
    --------------->
    <div class="item">



        <div class="p-m">
        <div class=" text-m p-top-m" style="">
            <div class="uk-inline" uk-tooltip="Search Key">
                <input placeholder="Search Key" class="uk-input uk-border-rounded congested-form "
                       type="text" id="searchKey" />
            </div>
            <div class="uk-inline" uk-tooltip="State">

                <select type="text" class="uk-select uk-border-rounded congested-form"
                        style="padding-right: 25px !important;"
                        name="land_state_s"
                        id="land_state_s"
                        onchange="wt_ajax_chain('html*land_dist_s*land,land_dist,land_dist*land_state=land_state_s',
                        'GROUP BY land_dist','','');">
                    <option value="">SELECT STATE</option>
                    <option value="WB">WB</option>
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Distict">
                <select type="text" class="uk-select uk-border-rounded congested-form"
                        style="padding-right: 25px !important;"
                        name="land_dist_s" id="land_dist_s"
                        onchange="wt_ajax_chain(`html*land_block_s*land,land_block,land_block*land_dist=land_dist_s,land_state=land_state_s`,
                        `GROUP BY land_block`,'','');">
                    <option value="">SELECT DIST</option>
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Block">
                <select type="text" class="uk-select uk-border-rounded congested-form"
                        style="padding-right: 25px !important;"
                        name="land_block_s" id="land_block_s"
                        onchange="wt_ajax_chain(`html*land_mouza_s*land,land_mouza,land_mouza*land_dist=land_dist_s,land_state=land_state_s,land_block=land_block_s`,
                        `GROUP BY land_mouza`,'','');">
                    <option value="">SELECT BLOCK</option>
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Mouza">
                <select type="text" class="uk-select uk-border-rounded congested-form " name="land_mouza_s"
                        style="padding-right: 25px !important;"
                        id="land_mouza_s">
                    <option value="">SELECT MOUZA</option>
                </select>
            </div>
            <div class="uk-inline" uk-tooltip="Dag No R.S">
                <input type="text" class="uk-input uk-border-rounded congested-form "
                       placeholder="Dag No R.S"
                       name="land_dag_no_rs_s" id="land_dag_no_rs_s" value="" />
            </div>
            <div class="uk-inline" uk-tooltip="Dag No L.R">
                <input type="text" class="uk-input uk-border-rounded congested-form "
                       placeholder="Dag No L.R"
                       name="land_dag_no_lr_s" id="land_dag_no_lr_s" value="" />
            </div>


            <div style="display:none" id="advanceSearchDiv">

                owner_unit: <input type="text" class="wtTextClass" name="owner_unit_s" id="owner_unit_s" value="" />
                owner_organisation: <input type="text" class="wtTextClass" name="owner_organisation_s" id="owner_organisation_s" value="" />
                reg_pit_deed_no: <input type="text" class="wtTextClass" name="reg_pit_deed_no_s" id="reg_pit_deed_no_s" value="" />
                reg_registry_office: <input type="text" class="wtTextClass" name="reg_registry_office_s" id="reg_registry_office_s" value="" />
                From reg_date: <input class="wtDateClass" type="text" name="f_reg_date_s" id="f_reg_date_s" value=""  />
                To reg_date: <input class="wtDateClass" type="text" name="t_reg_date_s" id="t_reg_date_s" value=""  />
                reg_deed_type: <input type="text" class="wtTextClass" name="reg_deed_type_s" id="reg_deed_type_s" value="" />
                reg_market_value: <input type="text" class="wtTextClass" name="reg_market_value_s" id="reg_market_value_s" value="" />
                reg_purchase_or_setforth_value: <input type="text" class="wtTextClass" name="reg_purchase_or_setforth_value_s" id="reg_purchase_or_setforth_value_s" value="" />
                reg_expense: <input type="text" class="wtTextClass" name="reg_expense_s" id="reg_expense_s" value="" />
                reg_total_expense: <input type="text" class="wtTextClass" name="reg_total_expense_s" id="reg_total_expense_s" value="" />
                reg_deed_status: <input type="text" class="wtTextClass" name="reg_deed_status_s" id="reg_deed_status_s" value="" />
                deed_recieved_unit: <input type="text" class="wtTextClass" name="deed_recieved_unit_s" id="deed_recieved_unit_s" value="" />
                deed_issued_to: <input type="text" class="wtTextClass" name="deed_issued_to_s" id="deed_issued_to_s" value="" />
                From deed_issued_date: <input class="wtDateClass" type="text" name="f_deed_issued_date_s" id="f_deed_issued_date_s" value=""  />
                To deed_issued_date: <input class="wtDateClass" type="text" name="t_deed_issued_date_s" id="t_deed_issued_date_s" value=""  />
                deed_recieved_by: <input type="text" class="wtTextClass" name="deed_recieved_by_s" id="deed_recieved_by_s" value="" />
                From deed_recieved_date: <input class="wtDateClass" type="text" name="f_deed_recieved_date_s" id="f_deed_recieved_date_s" value=""  />
                To deed_recieved_date: <input class="wtDateClass" type="text" name="t_deed_recieved_date_s" id="t_deed_recieved_date_s" value=""  />
                land_deed_no: <input type="text" class="wtTextClass" name="land_deed_no_s" id="land_deed_no_s" value="" />
                land_vill: <input type="text" class="wtTextClass" name="land_vill_s" id="land_vill_s" value="" />
                land_po: <input type="text" class="wtTextClass" name="land_po_s" id="land_po_s" value="" />
                land_ps: <input type="text" class="wtTextClass" name="land_ps_s" id="land_ps_s" value="" />

                land_pin: <input type="text" class="wtTextClass" name="land_pin_s" id="land_pin_s" value="" />
                land_panchayat: <input type="text" class="wtTextClass" name="land_panchayat_s" id="land_panchayat_s" value="" />
                land_jl_no: <input type="text" class="wtTextClass" name="land_jl_no_s" id="land_jl_no_s" value="" />
                land_khatian_no_rs: <input type="text" class="wtTextClass" name="land_khatian_no_rs_s" id="land_khatian_no_rs_s" value="" />
                land_khatian_no_lr: <input type="text" class="wtTextClass" name="land_khatian_no_lr_s" id="land_khatian_no_lr_s" value="" />
                land_total_volumn: <input type="text" class="wtTextClass" name="land_total_volumn_s" id="land_total_volumn_s" value="" />
                meeting_no: <input type="text" class="wtTextClass" name="meeting_no_s" id="meeting_no_s" value="" />
                From meeting_resolution_date: <input class="wtDateClass" type="text" name="f_meeting_resolution_date_s" id="f_meeting_resolution_date_s" value=""  />
                To meeting_resolution_date: <input class="wtDateClass" type="text" name="t_meeting_resolution_date_s" id="t_meeting_resolution_date_s" value=""  />
                mutation_status: <input type="text" class="wtTextClass" name="mutation_status_s" id="mutation_status_s" value="" />
                mutation_khatian_no_rs: <input type="text" class="wtTextClass" name="mutation_khatian_no_rs_s" id="mutation_khatian_no_rs_s" value="" />
                mutation_khatian_no_lr: <input type="text" class="wtTextClass" name="mutation_khatian_no_lr_s" id="mutation_khatian_no_lr_s" value="" />
                mutation_dag_no_rs: <input type="text" class="wtTextClass" name="mutation_dag_no_rs_s" id="mutation_dag_no_rs_s" value="" />
                mutation_dag_no_lr: <input type="text" class="wtTextClass" name="mutation_dag_no_lr_s" id="mutation_dag_no_lr_s" value="" />
                conversion_status: <input type="text" class="wtTextClass" name="conversion_status_s" id="conversion_status_s" value="" />
                conversion_dag_no_rs: <input type="text" class="wtTextClass" name="conversion_dag_no_rs_s" id="conversion_dag_no_rs_s" value="" />
                conversion_dag_no_lr: <input type="text" class="wtTextClass" name="conversion_dag_no_lr_s" id="conversion_dag_no_lr_s" value="" />
                conversion_mission_khatian_no: <input type="text" class="wtTextClass" name="conversion_mission_khatian_no_s" id="conversion_mission_khatian_no_s" value="" />   conversion_volume: <input type="text" class="wtTextClass" name="conversion_volume_s" id="conversion_volume_s" value="" />   conversion_classification_as_per_ror: <input type="text" class="wtTextClass" name="conversion_classification_as_per_ror_s" id="conversion_classification_as_per_ror_s" value="" />   conversion_classification_which_permission_accorded: <input type="text" class="wtTextClass" name="conversion_classification_which_permission_accorded_s" id="conversion_classification_which_permission_accorded_s" value="" />  From conversion_memo_no_date: <input class="wtDateClass" type="text" name="f_conversion_memo_no_date_s" id="f_conversion_memo_no_date_s" value=""  />    To conversion_memo_no_date: <input class="wtDateClass" type="text" name="t_conversion_memo_no_date_s" id="t_conversion_memo_no_date_s" value=""  />

            </div>
            <button class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline
            uk-flex-middle" type="button" onclick="WT_landListing();">
                Search
            </button>

            <button class="uk-button uk-border-rounded   congested-form uk-secondary-button  uk-flex-inline uk-flex-middle"
                    type="button" onclick="searchReset();">
                Reset
            </button>
        </div>
        <div id="WT_landListDiv"></div>
        </div>
        <!--   ggggggggggggggg  -->


        <div class="uk-modal uk-modal-container" id="new_form_modal" uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-card uk-card-small uk-card-default">
                    <div class="uk-card-body">
                        <ul class="uk-text-bold" uk-tab>
                            <li><a href="#">General</a></li>
                            <li><a href="#">Sellers/Donors</a></li>
                            <li><a href="#">Files</a></li>
                        </ul>
                        <ul class="uk-switcher uk-margin">
                            <li>
                                <div class="uk-grid uk-grid-small uk-grid-divider uk-child-width-1-3@m
                                uk-child-width-1-4@l"
                                     uk-grid="masonry: true">
                                    <div>
                                        <h5 class="uk-margin-small">Owner</h5>
                                        <div class="">
                                            <table class="uk-table congested-table uk-table-justify uk-width-expand">

                                                <tr >
                                                    <td>Unit</td>
                                                    <td><input value="" type="text" name="owner_unit" id="owner_unit"
                                                               class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Organization</td>
                                                    <td><input value="" type="text" name="owner_organisation" id="owner_organisation"
                                                               class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="uk-margin-small">Registration Details</h5>
                                        <div class="">
                                            <table class="uk-table congested-table uk-table-justify uk-width-expand">
                                                <tr >
                                                    <td>Pit deed no</td>
                                                    <td><input value="" type="text" name="reg_pit_deed_no" id="reg_pit_deed_no" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Registry Office</td>
                                                    <td><input value="" type="text" name="reg_registry_office" id="reg_registry_office" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Registration date</td>
                                                    <td><input value="" type="text" name="reg_date" id="reg_date" class="wtDateClass uk-input uk-border-rounded congested-form "/></td>
                                                </tr>
                                                <tr >
                                                    <td>Deed Type</td>
                                                    <td><input value="" type="text" name="reg_deed_type" id="reg_deed_type" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Market Value</td>
                                                    <td><input value="" type="text" name="reg_market_value" id="reg_market_value" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Purchase/Setforth Value </td>
                                                    <td><input value="" type="text" name="reg_purchase_or_setforth_value" id="reg_purchase_or_setforth_value" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Registration Expense</td>
                                                    <td><input value="" type="text" name="reg_expense" id="reg_expense" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Total Expense </td>
                                                    <td><input value="" type="text" name="reg_total_expense" id="reg_total_expense" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Deed Status</td>
                                                    <td><input value="" type="text" name="reg_deed_status" id="reg_deed_status" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="uk-margin-small">Deed Details Remarks</h5>
                                        <div class="">
                                            <table class="uk-table congested-table uk-table-justify uk-width-expand">
                                                <tr >
                                                    <td>Received unit</td>
                                                    <td><input value="" type="text" name="deed_recieved_unit" id="deed_recieved_unit" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Issued to</td>
                                                    <td><input value="" type="text" name="deed_issued_to" id="deed_issued_to" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Issued date</td>
                                                    <td><input value="" type="text" name="deed_issued_date" id="deed_issued_date" class="wtDateClass uk-input uk-border-rounded congested-form "/></td>
                                                </tr>
                                                <tr >
                                                    <td>Received by</td>
                                                    <td><input value="" type="text" name="deed_recieved_by" id="deed_recieved_by" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Received date</td>
                                                    <td><input value="" type="text" name="deed_recieved_date" id="deed_recieved_date" class="wtDateClass uk-input uk-border-rounded congested-form "/></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="uk-margin-small">Land Details</h5>
                                        <div class="">
                                            <table class="uk-table congested-table uk-table-justify uk-width-expand">
                                                <tr >
                                                    <td>Deed no.</td>
                                                    <td><input value="" type="text" name="land_deed_no" id="land_deed_no" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>VILL</td>
                                                    <td><input value="" type="text" name="land_vill" id="land_vill" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>PO</td>
                                                    <td><input value="" type="text" name="land_po" id="land_po" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>PS</td>
                                                    <td><input value="" type="text" name="land_ps" id="land_ps" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Block</td>
                                                    <td><input value="" type="text" name="land_block" id="land_block" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Dist</td>
                                                    <td><input value="" type="text" name="land_dist" id="land_dist" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>State</td>
                                                    <td><input value="" type="text" name="land_state" id="land_state"
                                                               class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>

                                                <tr >
                                                    <td>PIN</td>
                                                    <td><input value="" type="text" name="land_pin" id="land_pin" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Panchayat</td>
                                                    <td><input value="" type="text" name="land_panchayat" id="land_panchayat" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Mouza</td>
                                                    <td><input value="" type="text" name="land_mouza" id="land_mouza" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>J.L No.</td>
                                                    <td><input value="" type="text" name="land_jl_no" id="land_jl_no" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Khatian no. R.S</td>
                                                    <td><input value="" type="text" name="land_khatian_no_rs" id="land_khatian_no_rs" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Khatian no. L.R</td>
                                                    <td><input value="" type="text" name="land_khatian_no_lr" id="land_khatian_no_lr" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Dag no. R.S</td>
                                                    <td><input value="" type="text" name="land_dag_no_rs" id="land_dag_no_rs" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Dag no. L.R</td>
                                                    <td><input value="" type="text" name="land_dag_no_lr" id="land_dag_no_lr" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Total Volume</td>
                                                    <td><input value="" type="text" name="land_total_volumn" id="land_total_volumn" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="uk-margin-small">Meeting Details</h5>
                                        <div class="">
                                            <table class="uk-table congested-table uk-table-justify uk-width-expand">
                                                <tr >
                                                    <td>Meeting no.</td>
                                                    <td><input value="" type="text" name="meeting_no" id="meeting_no" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>

                                                <tr >
                                                    <td>Resolution date </td>
                                                    <td><input value="" type="text" name="meeting_resolution_date" id="meeting_resolution_date" class="wtDateClass uk-input uk-border-rounded congested-form "/></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="uk-margin-small">Mutation Details</h5>
                                        <div class="">
                                            <table class="uk-table congested-table uk-table-justify uk-width-expand">
                                                <tr >
                                                    <td>Status</td>
                                                    <td><input value="" type="text" name="mutation_status" id="mutation_status" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Khatian no. R.S</td>
                                                    <td><input value="" type="text" name="mutation_khatian_no_rs" id="mutation_khatian_no_rs" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Khatian no. L.R</td>
                                                    <td><input value="" type="text" name="mutation_khatian_no_lr" id="mutation_khatian_no_lr" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Dag no. R.S</td>
                                                    <td><input value="" type="text" name="mutation_dag_no_rs" id="mutation_dag_no_rs" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Dag no. L.R</td>
                                                    <td><input value="" type="text" name="mutation_dag_no_lr" id="mutation_dag_no_lr" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="uk-margin-small">Conversion details</h5>
                                        <div class="">
                                            <table class="uk-table congested-table uk-table-justify uk-width-expand">
                                                <tr >
                                                    <td>Status</td>
                                                    <td><input value="" type="text" name="conversion_status" id="conversion_status" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Dag no. R.S </td>
                                                    <td><input value="" type="text" name="conversion_dag_no_rs" id="conversion_dag_no_rs" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Dag no. L.R</td>
                                                    <td><input value="" type="text" name="conversion_dag_no_lr" id="conversion_dag_no_lr" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Mission Khatian no </td>
                                                    <td><input value="" type="text" name="conversion_mission_khatian_no" id="conversion_mission_khatian_no" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Volume</td>
                                                    <td><input value="" type="text" name="conversion_volume" id="conversion_volume" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Classification as per ROR </td>
                                                    <td><input value="" type="text" name="conversion_classification_as_per_ror" id="conversion_classification_as_per_ror" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Classification which permission accorded </td>
                                                    <td><input value="" type="text" name="conversion_classification_which_permission_accorded" id="conversion_classification_which_permission_accorded" class="uk-input uk-border-rounded congested-form "/> </td>
                                                </tr>
                                                <tr >
                                                    <td>Memo no&date </td>
                                                    <td><input value="" type="text" name="conversion_memo_no_date" id="conversion_memo_no_date" class="wtDateClass uk-input uk-border-rounded congested-form "/></td>
                                                </tr>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="WT_land_seller_donor_listing_div">
                            </li>
                            <li id="WT_land_file_listing_div">
                                <div class="uk-grid">
                                    <div>
                                        <div class="border-xxs uk-border-rounded" style="border-color: #999;">
                                            <div class="" style="width: 150px">
                                               <table>
                                                    <tr>
                                                        <td>
                                                            <svg  version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                                  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                  viewBox="0 0 464 464" style="enable-background:new 0 0 464 464;
                                                     height: 50px; width: 50px;
" xml:space="preserve">
<path style="fill:#FCF05A;" d="M376,464H40V32h224l112,112V464z"/>
                                                                <path style="fill:#FDBD40;" d="M424,416H88V0h224l112,112V416z"/>
                                                                <path style="fill:#F49E21;" d="M312,112h112L312,0V112z"/>
                                                                <g>
                                                                    <path style="fill:#E9686A;" d="M152,352h-16c-4.418,0-8-3.582-8-8s3.582-8,8-8h16c4.418,0,8,3.582,8,8S156.418,352,152,352z"/>
                                                                    <path style="fill:#E9686A;" d="M376,352H184c-4.418,0-8-3.582-8-8s3.582-8,8-8h192c4.418,0,8,3.582,8,8S380.418,352,376,352z"/>
                                                                    <path style="fill:#E9686A;" d="M152,304h-16c-4.418,0-8-3.582-8-8s3.582-8,8-8h16c4.418,0,8,3.582,8,8S156.418,304,152,304z"/>
                                                                    <path style="fill:#E9686A;" d="M376,304H184c-4.418,0-8-3.582-8-8s3.582-8,8-8h192c4.418,0,8,3.582,8,8S380.418,304,376,304z"/>
                                                                    <path style="fill:#E9686A;" d="M152,256h-16c-4.418,0-8-3.582-8-8s3.582-8,8-8h16c4.418,0,8,3.582,8,8S156.418,256,152,256z"/>
                                                                    <path style="fill:#E9686A;" d="M376,256H184c-4.418,0-8-3.582-8-8s3.582-8,8-8h192c4.418,0,8,3.582,8,8S380.418,256,376,256z"/>
                                                                    <path style="fill:#E9686A;" d="M152,208h-16c-4.418,0-8-3.582-8-8s3.582-8,8-8h16c4.418,0,8,3.582,8,8S156.418,208,152,208z"/>
                                                                    <path style="fill:#E9686A;" d="M376,208H184c-4.418,0-8-3.582-8-8s3.582-8,8-8h192c4.418,0,8,3.582,8,8S380.418,208,376,208z"/>
                                                                    <path style="fill:#E9686A;" d="M152,160h-16c-4.418,0-8-3.582-8-8s3.582-8,8-8h16c4.418,0,8,3.582,8,8S156.418,160,152,160z"/>
                                                                    <path style="fill:#E9686A;" d="M376,160H184c-4.418,0-8-3.582-8-8s3.582-8,8-8h192c4.418,0,8,3.582,8,8S380.418,160,376,160z"/>
                                                                    <path style="fill:#E9686A;" d="M136,72h48v48h-48V72z"/>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
</svg>
                                                        </td>
                                                        <td>
                                                            <a class="text-xs  uk-text-center m-top-m">RECORD FOR NEW PLOT AT TIME</a>
                                                        </td>
                                                        <td class="p-right-m uk-text-danger text-l">
                                                            <a uk-icon="icon:trash; ratio:1.5"></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="uk-card-footer">

                        <input type="hidden"  id="showPerPage" value="<? echo $os->showPerPage; ?>" />
                        <input type="hidden"  id="land_id" value="0" />
                        <input type="hidden"  id="WT_landpagingPageno" value="1" />
                        <div class="formDivButton">
                            <? if($os->access('wtDelete')){ ?>
                                <button class="uk-button uk-border-rounded  congested-form uk-button-danger"
                                        type="button"
                                        value="Delete"
                                        onclick="WT_landDeleteRowById('');">Delete</button>
                            <? } ?>
                            <button class="uk-button uk-border-rounded  congested-form uk-secondary-button"
                                   type="button"
                                   value="New"
                                    onclick="javascript:window.location='';" >New</button>
                            <? if($os->access('wtEdit')){ ?>
                                <button class="uk-button uk-border-rounded  congested-form uk-theme-button"
                                       type="button"
                                       value="Save"
                                        onclick="WT_landEditAndSave();">Save</button>
                            <? } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function WT_landListing() // list table searched data get
    {
        var formdata = new FormData();

        var owner_unit_sVal= os.getVal('owner_unit_s');
        var owner_organisation_sVal= os.getVal('owner_organisation_s');
        var reg_pit_deed_no_sVal= os.getVal('reg_pit_deed_no_s');
        var reg_registry_office_sVal= os.getVal('reg_registry_office_s');
        var f_reg_date_sVal= os.getVal('f_reg_date_s');
        var t_reg_date_sVal= os.getVal('t_reg_date_s');
        var reg_deed_type_sVal= os.getVal('reg_deed_type_s');
        var reg_market_value_sVal= os.getVal('reg_market_value_s');
        var reg_purchase_or_setforth_value_sVal= os.getVal('reg_purchase_or_setforth_value_s');
        var reg_expense_sVal= os.getVal('reg_expense_s');
        var reg_total_expense_sVal= os.getVal('reg_total_expense_s');
        var reg_deed_status_sVal= os.getVal('reg_deed_status_s');
        var deed_recieved_unit_sVal= os.getVal('deed_recieved_unit_s');
        var deed_issued_to_sVal= os.getVal('deed_issued_to_s');
        var f_deed_issued_date_sVal= os.getVal('f_deed_issued_date_s');
        var t_deed_issued_date_sVal= os.getVal('t_deed_issued_date_s');
        var deed_recieved_by_sVal= os.getVal('deed_recieved_by_s');
        var f_deed_recieved_date_sVal= os.getVal('f_deed_recieved_date_s');
        var t_deed_recieved_date_sVal= os.getVal('t_deed_recieved_date_s');
        var land_deed_no_sVal= os.getVal('land_deed_no_s');
        var land_vill_sVal= os.getVal('land_vill_s');
        var land_po_sVal= os.getVal('land_po_s');
        var land_ps_sVal= os.getVal('land_ps_s');
        var land_block_sVal= os.getVal('land_block_s');
        var land_state_sVal= os.getVal('land_state_s');
        var land_dist_sVal= os.getVal('land_dist_s');
        var land_pin_sVal= os.getVal('land_pin_s');
        var land_panchayat_sVal= os.getVal('land_panchayat_s');
        var land_mouza_sVal= os.getVal('land_mouza_s');
        var land_jl_no_sVal= os.getVal('land_jl_no_s');
        var land_khatian_no_rs_sVal= os.getVal('land_khatian_no_rs_s');
        var land_khatian_no_lr_sVal= os.getVal('land_khatian_no_lr_s');
        var land_dag_no_rs_sVal= os.getVal('land_dag_no_rs_s');
        var land_dag_no_lr_sVal= os.getVal('land_dag_no_lr_s');
        var land_total_volumn_sVal= os.getVal('land_total_volumn_s');
        var meeting_no_sVal= os.getVal('meeting_no_s');
        var f_meeting_resolution_date_sVal= os.getVal('f_meeting_resolution_date_s');
        var t_meeting_resolution_date_sVal= os.getVal('t_meeting_resolution_date_s');
        var mutation_status_sVal= os.getVal('mutation_status_s');
        var mutation_khatian_no_rs_sVal= os.getVal('mutation_khatian_no_rs_s');
        var mutation_khatian_no_lr_sVal= os.getVal('mutation_khatian_no_lr_s');
        var mutation_dag_no_rs_sVal= os.getVal('mutation_dag_no_rs_s');
        var mutation_dag_no_lr_sVal= os.getVal('mutation_dag_no_lr_s');
        var conversion_status_sVal= os.getVal('conversion_status_s');
        var conversion_dag_no_rs_sVal= os.getVal('conversion_dag_no_rs_s');
        var conversion_dag_no_lr_sVal= os.getVal('conversion_dag_no_lr_s');
        var conversion_mission_khatian_no_sVal= os.getVal('conversion_mission_khatian_no_s');
        var conversion_volume_sVal= os.getVal('conversion_volume_s');
        var conversion_classification_as_per_ror_sVal= os.getVal('conversion_classification_as_per_ror_s');
        var conversion_classification_which_permission_accorded_sVal= os.getVal('conversion_classification_which_permission_accorded_s');
        var f_conversion_memo_no_date_sVal= os.getVal('f_conversion_memo_no_date_s');
        var t_conversion_memo_no_date_sVal= os.getVal('t_conversion_memo_no_date_s');
        formdata.append('owner_unit_s',owner_unit_sVal );
        formdata.append('owner_organisation_s',owner_organisation_sVal );
        formdata.append('reg_pit_deed_no_s',reg_pit_deed_no_sVal );
        formdata.append('reg_registry_office_s',reg_registry_office_sVal );
        formdata.append('f_reg_date_s',f_reg_date_sVal );
        formdata.append('t_reg_date_s',t_reg_date_sVal );
        formdata.append('reg_deed_type_s',reg_deed_type_sVal );
        formdata.append('reg_market_value_s',reg_market_value_sVal );
        formdata.append('reg_purchase_or_setforth_value_s',reg_purchase_or_setforth_value_sVal );
        formdata.append('reg_expense_s',reg_expense_sVal );
        formdata.append('reg_total_expense_s',reg_total_expense_sVal );
        formdata.append('reg_deed_status_s',reg_deed_status_sVal );
        formdata.append('deed_recieved_unit_s',deed_recieved_unit_sVal );
        formdata.append('deed_issued_to_s',deed_issued_to_sVal );
        formdata.append('f_deed_issued_date_s',f_deed_issued_date_sVal );
        formdata.append('t_deed_issued_date_s',t_deed_issued_date_sVal );
        formdata.append('deed_recieved_by_s',deed_recieved_by_sVal );
        formdata.append('f_deed_recieved_date_s',f_deed_recieved_date_sVal );
        formdata.append('t_deed_recieved_date_s',t_deed_recieved_date_sVal );
        formdata.append('land_deed_no_s',land_deed_no_sVal );
        formdata.append('land_vill_s',land_vill_sVal );
        formdata.append('land_po_s',land_po_sVal );
        formdata.append('land_ps_s',land_ps_sVal );
        formdata.append('land_block_s',land_block_sVal );
        formdata.append('land_state_s',land_state_sVal );
        formdata.append('land_dist_s',land_dist_sVal );
        formdata.append('land_pin_s',land_pin_sVal );
        formdata.append('land_panchayat_s',land_panchayat_sVal );
        formdata.append('land_mouza_s',land_mouza_sVal );
        formdata.append('land_jl_no_s',land_jl_no_sVal );
        formdata.append('land_khatian_no_rs_s',land_khatian_no_rs_sVal );
        formdata.append('land_khatian_no_lr_s',land_khatian_no_lr_sVal );
        formdata.append('land_dag_no_rs_s',land_dag_no_rs_sVal );
        formdata.append('land_dag_no_lr_s',land_dag_no_lr_sVal );
        formdata.append('land_total_volumn_s',land_total_volumn_sVal );
        formdata.append('meeting_no_s',meeting_no_sVal );
        formdata.append('f_meeting_resolution_date_s',f_meeting_resolution_date_sVal );
        formdata.append('t_meeting_resolution_date_s',t_meeting_resolution_date_sVal );
        formdata.append('mutation_status_s',mutation_status_sVal );
        formdata.append('mutation_khatian_no_rs_s',mutation_khatian_no_rs_sVal );
        formdata.append('mutation_khatian_no_lr_s',mutation_khatian_no_lr_sVal );
        formdata.append('mutation_dag_no_rs_s',mutation_dag_no_rs_sVal );
        formdata.append('mutation_dag_no_lr_s',mutation_dag_no_lr_sVal );
        formdata.append('conversion_status_s',conversion_status_sVal );
        formdata.append('conversion_dag_no_rs_s',conversion_dag_no_rs_sVal );
        formdata.append('conversion_dag_no_lr_s',conversion_dag_no_lr_sVal );
        formdata.append('conversion_mission_khatian_no_s',conversion_mission_khatian_no_sVal );
        formdata.append('conversion_volume_s',conversion_volume_sVal );
        formdata.append('conversion_classification_as_per_ror_s',conversion_classification_as_per_ror_sVal );
        formdata.append('conversion_classification_which_permission_accorded_s',conversion_classification_which_permission_accorded_sVal );
        formdata.append('f_conversion_memo_no_date_s',f_conversion_memo_no_date_sVal );
        formdata.append('t_conversion_memo_no_date_s',t_conversion_memo_no_date_sVal );



        formdata.append('searchKey',os.getVal('searchKey') );
        formdata.append('showPerPage',os.getVal('showPerPage') );
        var WT_landpagingPageno=os.getVal('WT_landpagingPageno');
        var url='wtpage='+WT_landpagingPageno;
        url='<? echo $ajaxFilePath ?>?WT_landListing=OK&'+url;
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">;Please wait. Working...</div></div>';
        os.setAjaxHtml('WT_landListDiv',url,formdata);

    }

    WT_landListing();
    function  searchReset() // reset Search Fields
    {
        os.setVal('owner_unit_s','');
        os.setVal('owner_organisation_s','');
        os.setVal('reg_pit_deed_no_s','');
        os.setVal('reg_registry_office_s','');
        os.setVal('f_reg_date_s','');
        os.setVal('t_reg_date_s','');
        os.setVal('reg_deed_type_s','');
        os.setVal('reg_market_value_s','');
        os.setVal('reg_purchase_or_setforth_value_s','');
        os.setVal('reg_expense_s','');
        os.setVal('reg_total_expense_s','');
        os.setVal('reg_deed_status_s','');
        os.setVal('deed_recieved_unit_s','');
        os.setVal('deed_issued_to_s','');
        os.setVal('f_deed_issued_date_s','');
        os.setVal('t_deed_issued_date_s','');
        os.setVal('deed_recieved_by_s','');
        os.setVal('f_deed_recieved_date_s','');
        os.setVal('t_deed_recieved_date_s','');
        os.setVal('land_deed_no_s','');
        os.setVal('land_vill_s','');
        os.setVal('land_po_s','');
        os.setVal('land_ps_s','');
        os.setVal('land_block_s','');
        os.setVal('land_state_s','');
        os.setVal('land_dist_s','');
        os.setVal('land_pin_s','');
        os.setVal('land_panchayat_s','');
        os.setVal('land_mouza_s','');
        os.setVal('land_jl_no_s','');
        os.setVal('land_khatian_no_rs_s','');
        os.setVal('land_khatian_no_lr_s','');
        os.setVal('land_dag_no_rs_s','');
        os.setVal('land_dag_no_lr_s','');
        os.setVal('land_total_volumn_s','');
        os.setVal('meeting_no_s','');
        os.setVal('f_meeting_resolution_date_s','');
        os.setVal('t_meeting_resolution_date_s','');
        os.setVal('mutation_status_s','');
        os.setVal('mutation_khatian_no_rs_s','');
        os.setVal('mutation_khatian_no_lr_s','');
        os.setVal('mutation_dag_no_rs_s','');
        os.setVal('mutation_dag_no_lr_s','');
        os.setVal('conversion_status_s','');
        os.setVal('conversion_dag_no_rs_s','');
        os.setVal('conversion_dag_no_lr_s','');
        os.setVal('conversion_mission_khatian_no_s','');
        os.setVal('conversion_volume_s','');
        os.setVal('conversion_classification_as_per_ror_s','');
        os.setVal('conversion_classification_which_permission_accorded_s','');
        os.setVal('f_conversion_memo_no_date_s','');
        os.setVal('t_conversion_memo_no_date_s','');

        os.setVal('searchKey','');
        WT_landListing();

    }


    function WT_landEditAndSave()  // collect data and send to save
    {

        var formdata = new FormData();
        var owner_unitVal= os.getVal('owner_unit');
        var owner_organisationVal= os.getVal('owner_organisation');
        var reg_pit_deed_noVal= os.getVal('reg_pit_deed_no');
        var reg_registry_officeVal= os.getVal('reg_registry_office');
        var reg_dateVal= os.getVal('reg_date');
        var reg_deed_typeVal= os.getVal('reg_deed_type');
        var reg_market_valueVal= os.getVal('reg_market_value');
        var reg_purchase_or_setforth_valueVal= os.getVal('reg_purchase_or_setforth_value');
        var reg_expenseVal= os.getVal('reg_expense');
        var reg_total_expenseVal= os.getVal('reg_total_expense');
        var reg_deed_statusVal= os.getVal('reg_deed_status');
        var deed_recieved_unitVal= os.getVal('deed_recieved_unit');
        var deed_issued_toVal= os.getVal('deed_issued_to');
        var deed_issued_dateVal= os.getVal('deed_issued_date');
        var deed_recieved_byVal= os.getVal('deed_recieved_by');
        var deed_recieved_dateVal= os.getVal('deed_recieved_date');
        var land_deed_noVal= os.getVal('land_deed_no');
        var land_villVal= os.getVal('land_vill');
        var land_poVal= os.getVal('land_po');
        var land_psVal= os.getVal('land_ps');
        var land_blockVal= os.getVal('land_block');
        var land_stateVal= os.getVal('land_state');
        var land_distVal= os.getVal('land_dist');
        var land_pinVal= os.getVal('land_pin');
        var land_panchayatVal= os.getVal('land_panchayat');
        var land_mouzaVal= os.getVal('land_mouza');
        var land_jl_noVal= os.getVal('land_jl_no');
        var land_khatian_no_rsVal= os.getVal('land_khatian_no_rs');
        var land_khatian_no_lrVal= os.getVal('land_khatian_no_lr');
        var land_dag_no_rsVal= os.getVal('land_dag_no_rs');
        var land_dag_no_lrVal= os.getVal('land_dag_no_lr');
        var land_total_volumnVal= os.getVal('land_total_volumn');
        var meeting_noVal= os.getVal('meeting_no');
        var meeting_resolution_dateVal= os.getVal('meeting_resolution_date');
        var mutation_statusVal= os.getVal('mutation_status');
        var mutation_khatian_no_rsVal= os.getVal('mutation_khatian_no_rs');
        var mutation_khatian_no_lrVal= os.getVal('mutation_khatian_no_lr');
        var mutation_dag_no_rsVal= os.getVal('mutation_dag_no_rs');
        var mutation_dag_no_lrVal= os.getVal('mutation_dag_no_lr');
        var conversion_statusVal= os.getVal('conversion_status');
        var conversion_dag_no_rsVal= os.getVal('conversion_dag_no_rs');
        var conversion_dag_no_lrVal= os.getVal('conversion_dag_no_lr');
        var conversion_mission_khatian_noVal= os.getVal('conversion_mission_khatian_no');
        var conversion_volumeVal= os.getVal('conversion_volume');
        var conversion_classification_as_per_rorVal= os.getVal('conversion_classification_as_per_ror');
        var conversion_classification_which_permission_accordedVal= os.getVal('conversion_classification_which_permission_accorded');
        var conversion_memo_no_dateVal= os.getVal('conversion_memo_no_date');


        formdata.append('owner_unit',owner_unitVal );
        formdata.append('owner_organisation',owner_organisationVal );
        formdata.append('reg_pit_deed_no',reg_pit_deed_noVal );
        formdata.append('reg_registry_office',reg_registry_officeVal );
        formdata.append('reg_date',reg_dateVal );
        formdata.append('reg_deed_type',reg_deed_typeVal );
        formdata.append('reg_market_value',reg_market_valueVal );
        formdata.append('reg_purchase_or_setforth_value',reg_purchase_or_setforth_valueVal );
        formdata.append('reg_expense',reg_expenseVal );
        formdata.append('reg_total_expense',reg_total_expenseVal );
        formdata.append('reg_deed_status',reg_deed_statusVal );
        formdata.append('deed_recieved_unit',deed_recieved_unitVal );
        formdata.append('deed_issued_to',deed_issued_toVal );
        formdata.append('deed_issued_date',deed_issued_dateVal );
        formdata.append('deed_recieved_by',deed_recieved_byVal );
        formdata.append('deed_recieved_date',deed_recieved_dateVal );
        formdata.append('land_deed_no',land_deed_noVal );
        formdata.append('land_vill',land_villVal );
        formdata.append('land_po',land_poVal );
        formdata.append('land_ps',land_psVal );
        formdata.append('land_block',land_blockVal );
        formdata.append('land_state',land_stateVal );
        formdata.append('land_dist',land_distVal );
        formdata.append('land_pin',land_pinVal );
        formdata.append('land_panchayat',land_panchayatVal );
        formdata.append('land_mouza',land_mouzaVal );
        formdata.append('land_jl_no',land_jl_noVal );
        formdata.append('land_khatian_no_rs',land_khatian_no_rsVal );
        formdata.append('land_khatian_no_lr',land_khatian_no_lrVal );
        formdata.append('land_dag_no_rs',land_dag_no_rsVal );
        formdata.append('land_dag_no_lr',land_dag_no_lrVal );
        formdata.append('land_total_volumn',land_total_volumnVal );
        formdata.append('meeting_no',meeting_noVal );
        formdata.append('meeting_resolution_date',meeting_resolution_dateVal );
        formdata.append('mutation_status',mutation_statusVal );
        formdata.append('mutation_khatian_no_rs',mutation_khatian_no_rsVal );
        formdata.append('mutation_khatian_no_lr',mutation_khatian_no_lrVal );
        formdata.append('mutation_dag_no_rs',mutation_dag_no_rsVal );
        formdata.append('mutation_dag_no_lr',mutation_dag_no_lrVal );
        formdata.append('conversion_status',conversion_statusVal );
        formdata.append('conversion_dag_no_rs',conversion_dag_no_rsVal );
        formdata.append('conversion_dag_no_lr',conversion_dag_no_lrVal );
        formdata.append('conversion_mission_khatian_no',conversion_mission_khatian_noVal );
        formdata.append('conversion_volume',conversion_volumeVal );
        formdata.append('conversion_classification_as_per_ror',conversion_classification_as_per_rorVal );
        formdata.append('conversion_classification_which_permission_accorded',conversion_classification_which_permission_accordedVal );
        formdata.append('conversion_memo_no_date',conversion_memo_no_dateVal );



        var   land_id=os.getVal('land_id');
        formdata.append('land_id',land_id );
        var url='<? echo $ajaxFilePath ?>?WT_landEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_landReLoadList',url,formdata);

    }

    function WT_landReLoadList(data) // after edit reload list
    {

        var d=data.split('#-#');
        var land_id=parseInt(d[0]);
        if(d[0]!='Error' && land_id>0)
        {
            os.setVal('land_id',land_id);
        }

        if(d[1]!=''){alert(d[1]);}
        //extension
        WT_landSellerListing(land_id);
        WT_landFileListing(land_id);
        //
        WT_landListing();
    }

    function WT_landGetById(land_id) // get record by table primary id
    {
        var formdata = new FormData();
        formdata.append('land_id',land_id );
        var url='<? echo $ajaxFilePath ?>?WT_landGetById=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">;Please wait. Working...</div></div>';
        os.setAjaxFunc('WT_landFillData',url,formdata);

    }

    function WT_landFillData(data="")  // fill data form by JSON
    {
        UIkit.modal('#new_form_modal').show();
        if(data===""){
            data = `{"land_id":"0","owner_unit":"","owner_organisation":"","column_4":null,"reg_pit_deed_no":"",
"reg_registry_office":"","reg_date":"","reg_deed_type":"","reg_market_value":"","reg_purchase_or_setforth_value":"",
"reg_expense":"","reg_total_expense":"","reg_deed_status":"","deed_recieved_unit":"","deed_issued_to":"",
"deed_issued_date":"","deed_recieved_by":"","deed_recieved_date":"","land_deed_no":"","land_vill":"","land_po":"",
"land_ps":"","land_block":"","land_dist":"","land_state":"","land_pin":"","land_panchayat":"","land_mouza":"",
"land_jl_no":"","land_khatian_no_rs":"","land_khatian_no_lr":"","land_dag_no_rs":"","land_dag_no_lr":"","land_total_volumn":"","meeting_no":"","meeting_resolution_date":"","mutation_status":"","mutation_khatian_no_rs":"","mutation_khatian_no_lr":"","mutation_dag_no_rs":"","mutation_dag_no_lr":"","conversion_status":"","conversion_dag_no_rs":"","conversion_dag_no_lr":"","conversion_mission_khatian_no":"","conversion_volume":"","conversion_classification_as_per_ror":"","conversion_classification_which_permission_accorded":"","conversion_memo_no_date":"","addedBy":"","addedDate":"","modifyBy":"","modifyDate":""}
`;
        }
        var objJSON = JSON.parse(data);
        os.setVal('land_id',parseInt(objJSON.land_id));

        os.setVal('owner_unit',objJSON.owner_unit);
        os.setVal('owner_organisation',objJSON.owner_organisation);
        os.setVal('reg_pit_deed_no',objJSON.reg_pit_deed_no);
        os.setVal('reg_registry_office',objJSON.reg_registry_office);
        os.setVal('reg_date',objJSON.reg_date);
        os.setVal('reg_deed_type',objJSON.reg_deed_type);
        os.setVal('reg_market_value',objJSON.reg_market_value);
        os.setVal('reg_purchase_or_setforth_value',objJSON.reg_purchase_or_setforth_value);
        os.setVal('reg_expense',objJSON.reg_expense);
        os.setVal('reg_total_expense',objJSON.reg_total_expense);
        os.setVal('reg_deed_status',objJSON.reg_deed_status);
        os.setVal('deed_recieved_unit',objJSON.deed_recieved_unit);
        os.setVal('deed_issued_to',objJSON.deed_issued_to);
        os.setVal('deed_issued_date',objJSON.deed_issued_date);
        os.setVal('deed_recieved_by',objJSON.deed_recieved_by);
        os.setVal('deed_recieved_date',objJSON.deed_recieved_date);
        os.setVal('land_deed_no',objJSON.land_deed_no);
        os.setVal('land_vill',objJSON.land_vill);
        os.setVal('land_po',objJSON.land_po);
        os.setVal('land_ps',objJSON.land_ps);
        os.setVal('land_block',objJSON.land_block);
        os.setVal('land_state',objJSON.land_state);
        os.setVal('land_dist',objJSON.land_dist);
        os.setVal('land_pin',objJSON.land_pin);
        os.setVal('land_panchayat',objJSON.land_panchayat);
        os.setVal('land_mouza',objJSON.land_mouza);
        os.setVal('land_jl_no',objJSON.land_jl_no);
        os.setVal('land_khatian_no_rs',objJSON.land_khatian_no_rs);
        os.setVal('land_khatian_no_lr',objJSON.land_khatian_no_lr);
        os.setVal('land_dag_no_rs',objJSON.land_dag_no_rs);
        os.setVal('land_dag_no_lr',objJSON.land_dag_no_lr);
        os.setVal('land_total_volumn',objJSON.land_total_volumn);
        os.setVal('meeting_no',objJSON.meeting_no);
        os.setVal('meeting_resolution_date',objJSON.meeting_resolution_date);
        os.setVal('mutation_status',objJSON.mutation_status);
        os.setVal('mutation_khatian_no_rs',objJSON.mutation_khatian_no_rs);
        os.setVal('mutation_khatian_no_lr',objJSON.mutation_khatian_no_lr);
        os.setVal('mutation_dag_no_rs',objJSON.mutation_dag_no_rs);
        os.setVal('mutation_dag_no_lr',objJSON.mutation_dag_no_lr);
        os.setVal('conversion_status',objJSON.conversion_status);
        os.setVal('conversion_dag_no_rs',objJSON.conversion_dag_no_rs);
        os.setVal('conversion_dag_no_lr',objJSON.conversion_dag_no_lr);
        os.setVal('conversion_mission_khatian_no',objJSON.conversion_mission_khatian_no);
        os.setVal('conversion_volume',objJSON.conversion_volume);
        os.setVal('conversion_classification_as_per_ror',objJSON.conversion_classification_as_per_ror);
        os.setVal('conversion_classification_which_permission_accorded',objJSON.conversion_classification_which_permission_accorded);
        os.setVal('conversion_memo_no_date',objJSON.conversion_memo_no_date);

        WT_landSellerListing(parseInt(objJSON.land_id));
        WT_landFileListing(parseInt(objJSON.land_id));
    }


    function WT_landDeleteRowById(land_id) // delete record by table id
    {
        var formdata = new FormData();
        if(parseInt(land_id)<1 || land_id==''){
            var  land_id =os.getVal('land_id');
        }

        if(parseInt(land_id)<1){ alert('No record Selected'); return;}

        var p =confirm('Are you Sure? You want to delete this record forever.')
        if(p){

            formdata.append('land_id',land_id );

            var url='<? echo $ajaxFilePath ?>?WT_landDeleteRowById=OK&';
            os.animateMe.div='div_busy';
            os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">;Please wait. Working...</div></div>';
            os.setAjaxFunc('WT_landDeleteRowByIdResults',url,formdata);
        }


    }

    function WT_landDeleteRowByIdResults(data)
    {
        alert(data);
        WT_landListing();
        UIkit.modal('#new_form_modal').hide();
    }

    function wtAjaxPagination(pageId,pageNo)// pagination function
    {
        os.setVal('WT_landpagingPageno',parseInt(pageNo));
        WT_landListing();
    }
    //Seller
    function WT_landSellerListing(land_id){
        let formdata = new FormData();
        formdata.append('WT_landSellerListing', 'OK');
        formdata.append('land_id',land_id);

        let url='<? echo $ajaxFilePath ?>?WT_landSellerListing=OK&';
        os.animateMe.div='WT_land_seller_donor_listing_div';
        os.animateMe.html='Please wait. Working...';
        os.setAjaxHtml('WT_land_seller_donor_listing_div',url,formdata);
    }
    function WT_landSellerSave(land_id){
        let formdata = new FormData();
        let seller_name = os.getVal('seller_name');
        let seller_vill = os.getVal('seller_vill');
        let seller_po = os.getVal('seller_po');
        let seller_ps = os.getVal('seller_ps');
        let seller_dist = os.getVal('seller_dist');
        let seller_state = os.getVal('seller_state');
        formdata.append('land_id',land_id );

        //validation
        if(seller_name===""){alert('Please enter seller/donor name','danger');return ;}
        if(seller_dist===""){alert('Please enter seller/donor dist','danger');return ;}
        if(seller_state===""){alert('Please enter seller/donor state','danger');return ;}
        //append details
        formdata.append('land_id',land_id );
        formdata.append('name',seller_name);
        formdata.append('vill',seller_vill);
        formdata.append('po',seller_po);
        formdata.append('ps',seller_ps);
        formdata.append('dist',seller_dist);
        formdata.append('state',seller_state);


        let url='<? echo $ajaxFilePath ?>?WT_landSellerSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">;Please wait. Working...</div></div>';

        os.setAjaxFunc('WT_landSellerListing', url, formdata);

    }
    function WT_landSellerDelete(land_id, land_seller_donor_id){
        if(confirm('Are you sure?')) {
            let formdata = new FormData();
            formdata.append('WT_landSellerDelete', 'OK');
            formdata.append('land_id', land_id);
            formdata.append('land_seller_donor_id', land_seller_donor_id);

            let url = '<? echo $ajaxFilePath ?>?WT_landSellerDelete=OK&';
            os.animateMe.div = 'div_busy';
            os.animateMe.html = '<div class="loadImage">Please wait. Working...</div>';
            os.setAjaxFunc('WT_landSellerListing', url, formdata);
        }
    }

    //files
    function WT_landFileListing(land_id){
        let formdata = new FormData();
        formdata.append('WT_landFileListing', 'OK');
        formdata.append('land_id',land_id);

        let url='<? echo $ajaxFilePath ?>?WT_landFileListing=OK&';
        os.animateMe.div='WT_land_file_listing_div';
        os.animateMe.html='Please wait. Working...';
        os.setAjaxHtml('WT_land_file_listing_div',url,formdata);
    }
    function WT_landFileSave(land_id){
        let formdata = new FormData();
        let file_file = document.querySelector("#file_file").files[0];
        let file_title = os.getVal('file_title');
        let file_name = os.getVal('file_name');
        let file_ref_no = os.getVal('file_ref_no');

        //validation
        // append details
        formdata.append('land_id',land_id );
        formdata.append('title',file_title);
        formdata.append('name',file_name);
        formdata.append('ref_no',file_ref_no);
        formdata.append('file',file_file);


        let url='<? echo $ajaxFilePath ?>?WT_landFileSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='Please wait. Working...';

        os.setAjaxFunc('WT_landFileListing', url, formdata);

    }
    function WT_landFileDelete(land_id, land_file_id, file=""){
        if(confirm('Are you sure?')) {
            let formdata = new FormData();
            formdata.append('WT_landFileDelete', 'OK');
            formdata.append('land_id', land_id);
            formdata.append('land_file_id', land_file_id);
            formdata.append('file', file);

            let url = '<? echo $ajaxFilePath ?>?WT_landFileDelete=OK&';
            os.animateMe.div = 'div_busy';
            os.animateMe.html = '<div class="loadImage">Please wait. Working...</div>';
            os.setAjaxFunc('WT_landFileListing', url, formdata);
        }
    }

</script>




<? include($site['root-wtos'].'bottom.php'); ?>
