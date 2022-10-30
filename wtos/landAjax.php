<?
/*
   # wtos version : 1.1
   # page called by ajax script in landDataView.php
   #
*/

include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');
$pluginName='';
$os->loadPluginConstant($pluginName);


if($os->get('WT_landListing')=='OK')

{
    $where='';
    $showPerPage= $os->post('showPerPage');


    $andowner_unit=  $os->postAndQuery('owner_unit_s','owner_unit','%');
    $andowner_organisation=  $os->postAndQuery('owner_organisation_s','owner_organisation','%');
    $andreg_pit_deed_no=  $os->postAndQuery('reg_pit_deed_no_s','reg_pit_deed_no','%');
    $andreg_registry_office=  $os->postAndQuery('reg_registry_office_s','reg_registry_office','%');

    $f_reg_date_s= $os->post('f_reg_date_s'); $t_reg_date_s= $os->post('t_reg_date_s');
    $andreg_date=$os->DateQ('reg_date',$f_reg_date_s,$t_reg_date_s,$sTime='00:00:00',$eTime='59:59:59');
    $andreg_deed_type=  $os->postAndQuery('reg_deed_type_s','reg_deed_type','%');
    $andreg_market_value=  $os->postAndQuery('reg_market_value_s','reg_market_value','%');
    $andreg_purchase_or_setforth_value=  $os->postAndQuery('reg_purchase_or_setforth_value_s','reg_purchase_or_setforth_value','%');
    $andreg_expense=  $os->postAndQuery('reg_expense_s','reg_expense','%');
    $andreg_total_expense=  $os->postAndQuery('reg_total_expense_s','reg_total_expense','%');
    $andreg_deed_status=  $os->postAndQuery('reg_deed_status_s','reg_deed_status','%');
    $anddeed_recieved_unit=  $os->postAndQuery('deed_recieved_unit_s','deed_recieved_unit','%');
    $anddeed_issued_to=  $os->postAndQuery('deed_issued_to_s','deed_issued_to','%');

    $f_deed_issued_date_s= $os->post('f_deed_issued_date_s'); $t_deed_issued_date_s= $os->post('t_deed_issued_date_s');
    $anddeed_issued_date=$os->DateQ('deed_issued_date',$f_deed_issued_date_s,$t_deed_issued_date_s,$sTime='00:00:00',$eTime='59:59:59');
    $anddeed_recieved_by=  $os->postAndQuery('deed_recieved_by_s','deed_recieved_by','%');

    $f_deed_recieved_date_s= $os->post('f_deed_recieved_date_s'); $t_deed_recieved_date_s= $os->post('t_deed_recieved_date_s');
    $anddeed_recieved_date=$os->DateQ('deed_recieved_date',$f_deed_recieved_date_s,$t_deed_recieved_date_s,$sTime='00:00:00',$eTime='59:59:59');
    $andland_deed_no=  $os->postAndQuery('land_deed_no_s','land_deed_no','%');
    $andland_vill=  $os->postAndQuery('land_vill_s','land_vill','%');
    $andland_po=  $os->postAndQuery('land_po_s','land_po','%');
    $andland_ps=  $os->postAndQuery('land_ps_s','land_ps','%');
    $andland_block=  $os->postAndQuery('land_block_s','land_block','%');
    $andland_state=  $os->postAndQuery('land_state_s','land_state','%');
    $andland_dist=  $os->postAndQuery('land_dist_s','land_dist','%');
    $andland_pin=  $os->postAndQuery('land_pin_s','land_pin','%');
    $andland_panchayat=  $os->postAndQuery('land_panchayat_s','land_panchayat','%');
    $andland_mouza=  $os->postAndQuery('land_mouza_s','land_mouza','%');
    $andland_jl_no=  $os->postAndQuery('land_jl_no_s','land_jl_no','%');
    $andland_khatian_no_rs=  $os->postAndQuery('land_khatian_no_rs_s','land_khatian_no_rs','%');
    $andland_khatian_no_lr=  $os->postAndQuery('land_khatian_no_lr_s','land_khatian_no_lr','%');
    $andland_dag_no_rs=  $os->postAndQuery('land_dag_no_rs_s','land_dag_no_rs','%');
    $andland_dag_no_lr=  $os->postAndQuery('land_dag_no_lr_s','land_dag_no_lr','%');
    $andland_total_volumn=  $os->postAndQuery('land_total_volumn_s','land_total_volumn','%');
    $andmeeting_no=  $os->postAndQuery('meeting_no_s','meeting_no','%');

    $f_meeting_resolution_date_s= $os->post('f_meeting_resolution_date_s'); $t_meeting_resolution_date_s= $os->post('t_meeting_resolution_date_s');
    $andmeeting_resolution_date=$os->DateQ('meeting_resolution_date',$f_meeting_resolution_date_s,$t_meeting_resolution_date_s,$sTime='00:00:00',$eTime='59:59:59');
    $andmutation_status=  $os->postAndQuery('mutation_status_s','mutation_status','%');
    $andmutation_khatian_no_rs=  $os->postAndQuery('mutation_khatian_no_rs_s','mutation_khatian_no_rs','%');
    $andmutation_khatian_no_lr=  $os->postAndQuery('mutation_khatian_no_lr_s','mutation_khatian_no_lr','%');
    $andmutation_dag_no_rs=  $os->postAndQuery('mutation_dag_no_rs_s','mutation_dag_no_rs','%');
    $andmutation_dag_no_lr=  $os->postAndQuery('mutation_dag_no_lr_s','mutation_dag_no_lr','%');
    $andconversion_status=  $os->postAndQuery('conversion_status_s','conversion_status','%');
    $andconversion_dag_no_rs=  $os->postAndQuery('conversion_dag_no_rs_s','conversion_dag_no_rs','%');
    $andconversion_dag_no_lr=  $os->postAndQuery('conversion_dag_no_lr_s','conversion_dag_no_lr','%');
    $andconversion_mission_khatian_no=  $os->postAndQuery('conversion_mission_khatian_no_s','conversion_mission_khatian_no','%');
    $andconversion_volume=  $os->postAndQuery('conversion_volume_s','conversion_volume','%');
    $andconversion_classification_as_per_ror=  $os->postAndQuery('conversion_classification_as_per_ror_s','conversion_classification_as_per_ror','%');
    $andconversion_classification_which_permission_accorded=  $os->postAndQuery('conversion_classification_which_permission_accorded_s','conversion_classification_which_permission_accorded','%');

    $f_conversion_memo_no_date_s= $os->post('f_conversion_memo_no_date_s'); $t_conversion_memo_no_date_s= $os->post('t_conversion_memo_no_date_s');
    $andconversion_memo_no_date=$os->DateQ('conversion_memo_no_date',$f_conversion_memo_no_date_s,$t_conversion_memo_no_date_s,$sTime='00:00:00',$eTime='59:59:59');


    $searchKey=$os->post('searchKey');
    if($searchKey!=''){
        $where ="and ( owner_unit like '%$searchKey%' Or owner_organisation like '%$searchKey%'  Or reg_pit_deed_no like '%$searchKey%' Or reg_registry_office like '%$searchKey%' Or reg_deed_type like '%$searchKey%' Or reg_market_value like '%$searchKey%' Or reg_purchase_or_setforth_value like '%$searchKey%' Or reg_expense like '%$searchKey%' Or reg_total_expense like '%$searchKey%' Or reg_deed_status like '%$searchKey%' Or deed_recieved_unit like '%$searchKey%' Or deed_issued_to like '%$searchKey%' Or deed_recieved_by like '%$searchKey%' Or land_deed_no like '%$searchKey%' Or land_vill like '%$searchKey%' Or land_po like '%$searchKey%' Or land_ps like '%$searchKey%' Or land_block like '%$searchKey%' Or land_dist like '%$searchKey%' Or land_state like '%$searchKey%' Or land_pin like '%$searchKey%' Or land_panchayat like '%$searchKey%' Or land_mouza like '%$searchKey%' Or land_jl_no like '%$searchKey%' Or land_khatian_no_rs like '%$searchKey%' Or land_khatian_no_lr like '%$searchKey%' Or land_dag_no_rs like '%$searchKey%' Or land_dag_no_lr like '%$searchKey%' Or land_total_volumn like '%$searchKey%' Or meeting_no like '%$searchKey%' Or mutation_status like '%$searchKey%' Or mutation_khatian_no_rs like '%$searchKey%' Or mutation_khatian_no_lr like '%$searchKey%' Or mutation_dag_no_rs like '%$searchKey%' Or mutation_dag_no_lr like '%$searchKey%' Or conversion_status like '%$searchKey%' Or conversion_dag_no_rs like '%$searchKey%' Or conversion_dag_no_lr like '%$searchKey%' Or conversion_mission_khatian_no like '%$searchKey%' Or conversion_volume like '%$searchKey%' Or conversion_classification_as_per_ror like '%$searchKey%' Or conversion_classification_which_permission_accorded like '%$searchKey%' )";

    }

    $listingQuery="  select * from land where land_id>0   $where   $andowner_unit  $andowner_organisation   $andreg_pit_deed_no  $andreg_registry_office  $andreg_date  $andreg_deed_type  $andreg_market_value  $andreg_purchase_or_setforth_value  $andreg_expense  $andreg_total_expense  $andreg_deed_status  $anddeed_recieved_unit  $anddeed_issued_to  $anddeed_issued_date  $anddeed_recieved_by  $anddeed_recieved_date  $andland_deed_no  $andland_vill  $andland_po  $andland_ps  $andland_block  $andland_dist $andland_state  $andland_pin  $andland_panchayat  $andland_mouza  $andland_jl_no  $andland_khatian_no_rs  $andland_khatian_no_lr  $andland_dag_no_rs  $andland_dag_no_lr  $andland_total_volumn  $andmeeting_no  $andmeeting_resolution_date  $andmutation_status  $andmutation_khatian_no_rs  $andmutation_khatian_no_lr  $andmutation_dag_no_rs  $andmutation_dag_no_lr  $andconversion_status  $andconversion_dag_no_rs  $andconversion_dag_no_lr  $andconversion_mission_khatian_no  $andconversion_volume  $andconversion_classification_as_per_ror  $andconversion_classification_which_permission_accorded  $andconversion_memo_no_date     order by land_id desc";

    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    ?>
    <div class="">
        <div class="uk-margin-small-top">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo
            $resource['links']; ?>
        </div>

        <table class="uk-table congested-table uk-table-striped"  style="background-color: white">
            <thead>
            <tr>
                <th>#</th>
                <th>Action </th>
                <th>Unit</th>
                <th>Organization</th>
                <th>Mouza</th>
                <th>Block</th>
                <th>Dist</th>
                <th>State</th>
                <th>Khatian No. R.S</th>
                <th>Khatian No. L.R</th>
                <th>Dag No. R.S</th>
                <th>Dag No. L.R</th>
                <th>Total Volume</th>
            </tr>
            </thead>
            <tbody>


            <?php

            $serial=$os->val($resource,'serial');

            while($record=$os->mfa( $rsRecords)){
                $serial++;
                ?>
                <tr>
                    <td><?php echo $serial; ?>     </td>
                    <td>
                        <? if($os->access('wtView')){ ?>
                            <span  class="actionLink" ><a href="javascript:void(0)"  onclick="WT_landGetById('<? echo $record['land_id'];?>')" >Edit</a></span>  <? } ?>  </td>

                    <td><?php echo $record['owner_unit']?> </td>
                    <td><?php echo $record['owner_organisation']?> </td>
                    <td><?php echo $record['land_mouza']?> </td>
                    <td><?php echo $record['land_block']?> </td>
                    <td><?php echo $record['land_dist']?> </td>
                    <td><?php echo $record['land_state']?> </td>
                    <td><?php echo $record['land_khatian_no_rs']?> </td>
                    <td><?php echo $record['land_khatian_no_lr']?> </td>
                    <td><?php echo $record['land_dag_no_rs']?> </td>
                    <td><?php echo $record['land_dag_no_lr']?> </td>
                    <td><?php echo $record['land_total_volumn']?> </td>
                </tr>
            <?} ?>
            </tbody>
        </table>
    </div>
    <?php
    exit();

}


if($os->get('WT_landEditAndSave')=='OK')
{
    $land_id=$os->post('land_id');



    $dataToSave['owner_unit']=addslashes($os->post('owner_unit'));
    $dataToSave['owner_organisation']=addslashes($os->post('owner_organisation'));
    $dataToSave['reg_pit_deed_no']=addslashes($os->post('reg_pit_deed_no'));
    $dataToSave['reg_registry_office']=addslashes($os->post('reg_registry_office'));
    $dataToSave['reg_date']=$os->saveDate($os->post('reg_date'));
    $dataToSave['reg_deed_type']=addslashes($os->post('reg_deed_type'));
    $dataToSave['reg_market_value']=addslashes($os->post('reg_market_value'));
    $dataToSave['reg_purchase_or_setforth_value']=addslashes($os->post('reg_purchase_or_setforth_value'));
    $dataToSave['reg_expense']=addslashes($os->post('reg_expense'));
    $dataToSave['reg_total_expense']=addslashes($os->post('reg_total_expense'));
    $dataToSave['reg_deed_status']=addslashes($os->post('reg_deed_status'));
    $dataToSave['deed_recieved_unit']=addslashes($os->post('deed_recieved_unit'));
    $dataToSave['deed_issued_to']=addslashes($os->post('deed_issued_to'));
    $dataToSave['deed_issued_date']=$os->saveDate($os->post('deed_issued_date'));
    $dataToSave['deed_recieved_by']=addslashes($os->post('deed_recieved_by'));
    $dataToSave['deed_recieved_date']=$os->saveDate($os->post('deed_recieved_date'));
    $dataToSave['land_deed_no']=addslashes($os->post('land_deed_no'));
    $dataToSave['land_vill']=addslashes($os->post('land_vill'));
    $dataToSave['land_po']=addslashes($os->post('land_po'));
    $dataToSave['land_ps']=addslashes($os->post('land_ps'));
    $dataToSave['land_block']=addslashes($os->post('land_block'));
    $dataToSave['land_state']=addslashes($os->post('land_state'));
    $dataToSave['land_dist']=addslashes($os->post('land_dist'));
    $dataToSave['land_pin']=addslashes($os->post('land_pin'));
    $dataToSave['land_panchayat']=addslashes($os->post('land_panchayat'));
    $dataToSave['land_mouza']=addslashes($os->post('land_mouza'));
    $dataToSave['land_jl_no']=addslashes($os->post('land_jl_no'));
    $dataToSave['land_khatian_no_rs']=addslashes($os->post('land_khatian_no_rs'));
    $dataToSave['land_khatian_no_lr']=addslashes($os->post('land_khatian_no_lr'));
    $dataToSave['land_dag_no_rs']=addslashes($os->post('land_dag_no_rs'));
    $dataToSave['land_dag_no_lr']=addslashes($os->post('land_dag_no_lr'));
    $dataToSave['land_total_volumn']=addslashes($os->post('land_total_volumn'));
    $dataToSave['meeting_no']=addslashes($os->post('meeting_no'));
    $dataToSave['meeting_resolution_date']=$os->saveDate($os->post('meeting_resolution_date'));
    $dataToSave['mutation_status']=addslashes($os->post('mutation_status'));
    $dataToSave['mutation_khatian_no_rs']=addslashes($os->post('mutation_khatian_no_rs'));
    $dataToSave['mutation_khatian_no_lr']=addslashes($os->post('mutation_khatian_no_lr'));
    $dataToSave['mutation_dag_no_rs']=addslashes($os->post('mutation_dag_no_rs'));
    $dataToSave['mutation_dag_no_lr']=addslashes($os->post('mutation_dag_no_lr'));
    $dataToSave['conversion_status']=addslashes($os->post('conversion_status'));
    $dataToSave['conversion_dag_no_rs']=addslashes($os->post('conversion_dag_no_rs'));
    $dataToSave['conversion_dag_no_lr']=addslashes($os->post('conversion_dag_no_lr'));
    $dataToSave['conversion_mission_khatian_no']=addslashes($os->post('conversion_mission_khatian_no'));
    $dataToSave['conversion_volume']=addslashes($os->post('conversion_volume'));
    $dataToSave['conversion_classification_as_per_ror']=addslashes($os->post('conversion_classification_as_per_ror'));
    $dataToSave['conversion_classification_which_permission_accorded']=addslashes($os->post('conversion_classification_which_permission_accorded'));
    $dataToSave['conversion_memo_no_date']=$os->saveDate($os->post('conversion_memo_no_date'));




    $dataToSave['modifyDate']=$os->now();
    $dataToSave['modifyBy']=$os->userDetails['adminId'];

    if($land_id < 1){

        $dataToSave['addedDate']=$os->now();
        $dataToSave['addedBy']=$os->userDetails['adminId'];
    }


    $qResult=$os->save('land',$dataToSave,'land_id',$land_id);///    allowed char '\*#@/"~$^.,()|+_-=:��
    if($qResult)
    {
        if($land_id>0 ){ $mgs= " Data updated Successfully";}
        if($land_id<1 ){ $mgs= " Data Added Successfully"; $land_id=  $qResult;}

        $mgs=$land_id."#-#".$mgs;
    }
    else
    {
        $mgs="Error#-#Problem Saving Data.";

    }
    //_d($dataToSave);
    echo $mgs;

    exit();

}

if($os->get('WT_landGetById')=='OK')
{
    $land_id=$os->post('land_id');

    if($land_id>0)
    {
        $wheres=" where land_id='$land_id'";
    }
    $dataQuery=" select * from land  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);


    $record['owner_unit']=$record['owner_unit'];
    $record['owner_organisation']=$record['owner_organisation'];
    $record['reg_pit_deed_no']=$record['reg_pit_deed_no'];
    $record['reg_registry_office']=$record['reg_registry_office'];
    $record['reg_date']=$os->showDate($record['reg_date']);
    $record['reg_deed_type']=$record['reg_deed_type'];
    $record['reg_market_value']=$record['reg_market_value'];
    $record['reg_purchase_or_setforth_value']=$record['reg_purchase_or_setforth_value'];
    $record['reg_expense']=$record['reg_expense'];
    $record['reg_total_expense']=$record['reg_total_expense'];
    $record['reg_deed_status']=$record['reg_deed_status'];
    $record['deed_recieved_unit']=$record['deed_recieved_unit'];
    $record['deed_issued_to']=$record['deed_issued_to'];
    $record['deed_issued_date']=$os->showDate($record['deed_issued_date']);
    $record['deed_recieved_by']=$record['deed_recieved_by'];
    $record['deed_recieved_date']=$os->showDate($record['deed_recieved_date']);
    $record['land_deed_no']=$record['land_deed_no'];
    $record['land_vill']=$record['land_vill'];
    $record['land_po']=$record['land_po'];
    $record['land_ps']=$record['land_ps'];
    $record['land_block']=$record['land_block'];
    $record['land_state']=$record['land_state'];
    $record['land_dist']=$record['land_dist'];
    $record['land_pin']=$record['land_pin'];
    $record['land_panchayat']=$record['land_panchayat'];
    $record['land_mouza']=$record['land_mouza'];
    $record['land_jl_no']=$record['land_jl_no'];
    $record['land_khatian_no_rs']=$record['land_khatian_no_rs'];
    $record['land_khatian_no_lr']=$record['land_khatian_no_lr'];
    $record['land_dag_no_rs']=$record['land_dag_no_rs'];
    $record['land_dag_no_lr']=$record['land_dag_no_lr'];
    $record['land_total_volumn']=$record['land_total_volumn'];
    $record['meeting_no']=$record['meeting_no'];
    $record['meeting_resolution_date']=$os->showDate($record['meeting_resolution_date']);
    $record['mutation_status']=$record['mutation_status'];
    $record['mutation_khatian_no_rs']=$record['mutation_khatian_no_rs'];
    $record['mutation_khatian_no_lr']=$record['mutation_khatian_no_lr'];
    $record['mutation_dag_no_rs']=$record['mutation_dag_no_rs'];
    $record['mutation_dag_no_lr']=$record['mutation_dag_no_lr'];
    $record['conversion_status']=$record['conversion_status'];
    $record['conversion_dag_no_rs']=$record['conversion_dag_no_rs'];
    $record['conversion_dag_no_lr']=$record['conversion_dag_no_lr'];
    $record['conversion_mission_khatian_no']=$record['conversion_mission_khatian_no'];
    $record['conversion_volume']=$record['conversion_volume'];
    $record['conversion_classification_as_per_ror']=$record['conversion_classification_as_per_ror'];
    $record['conversion_classification_which_permission_accorded']=$record['conversion_classification_which_permission_accorded'];
    $record['conversion_memo_no_date']=$os->showDate($record['conversion_memo_no_date']);



    echo  json_encode($record);

    exit();

}

if($os->get('WT_landDeleteRowById')=='OK')
{

    $land_id=$os->post('land_id');
    if($land_id>0){
        $updateQuery="delete from land where land_id='$land_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully';
    }
    exit();
}

//land seller
if($os->get('WT_landSellerListing')=='OK')

{

    $land_id = $os->post('land_id');
    if($land_id==0){
        echo 'please save details first';
        exit();
    }
    $land_sellers = $os->mq("SELECT * FROM land_seller_donor WHERE land_id='$land_id'");
    ?>
    <div>
        <table class="uk-table congested-table uk-table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Vill</th>
                <th>PO</th>
                <th>PS</th>
                <th>Dist</th>
                <th>State</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <? while($seller = $os->mfa($land_sellers)){?>
                <tr>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form uk-form-blank"
                               value="<?=$seller['name']?>"
                               id="seller_name_<?=$seller['land_seller_donor_id']?>"
                               onchange="wtosInlineEdit(`seller_name_<?=$seller['land_seller_donor_id']?>`,
                                       'land_seller_donor','name','land_seller_donor_id',<?=$seller['land_seller_donor_id']?>,'','','')">
                    </td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form uk-form-blank"
                               value="<?=$seller['vill']?>"
                               id="seller_vill_<?=$seller['land_seller_donor_id']?>"
                               onchange="wtosInlineEdit(`seller_vill_<?=$seller['land_seller_donor_id']?>`,
                                       'land_seller_donor','vill','land_seller_donor_id',<?=$seller['land_seller_donor_id']?>,'','','')">
                    </td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form uk-form-blank"
                               value="<?=$seller['po']?>"
                               id="seller_po_<?=$seller['land_seller_donor_id']?>"
                               onchange="wtosInlineEdit(`seller_po_<?=$seller['land_seller_donor_id']?>`,
                                       'land_seller_donor','po','land_seller_donor_id',<?=$seller['land_seller_donor_id']?>,'','','')">
                    </td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form uk-form-blank"
                               value="<?=$seller['ps']?>"
                               id="seller_ps_<?=$seller['land_seller_donor_id']?>"
                               onchange="wtosInlineEdit(`seller_ps_<?=$seller['land_seller_donor_id']?>`,
                                       'land_seller_donor','ps','land_seller_donor_id',<?=$seller['land_seller_donor_id']?>,'','','')">
                    </td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form uk-form-blank"
                               value="<?=$seller['dist']?>"
                               id="seller_dist_<?=$seller['land_seller_donor_id']?>"
                               onchange="wtosInlineEdit(`seller_dist_<?=$seller['land_seller_donor_id']?>`,
                                       'land_seller_donor','dist','land_seller_donor_id',<?=$seller['land_seller_donor_id']?>,'','','')">
                    </td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form uk-form-blank"
                               value="<?=$seller['state']?>"
                               id="seller_state_<?=$seller['land_seller_donor_id']?>"
                               onchange="wtosInlineEdit(`seller_state_<?=$seller['land_seller_donor_id']?>`,
                                       'land_seller_donor','state','land_seller_donor_id',<?=$seller['land_seller_donor_id']?>,'','','')">
                    </td>
                    <td>
                        <button class="uk-button uk-border-rounded  congested-form
                                            uk-button-danger uk-flex-inline uk-flex-middle"
                                onclick="WT_landSellerDelete(<?=$land_id?>,<?=$seller['land_seller_donor_id']?>)
                                        ">x</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
            <tfoot>
            <tr>
                <td><input class="uk-input uk-border-rounded congested-form" id="seller_name"></td>
                <td><input class="uk-input uk-border-rounded congested-form" id="seller_vill"></td>
                <td><input class="uk-input uk-border-rounded congested-form" id="seller_po"></td>
                <td><input class="uk-input uk-border-rounded congested-form" id="seller_ps"></td>
                <td><input class="uk-input uk-border-rounded congested-form" id="seller_dist"></td>
                <td><input class="uk-input uk-border-rounded congested-form" id="seller_state"></td>
                <td>
                    <button class="uk-button uk-border-rounded  congested-form
                                            uk-secondary-button uk-flex-inline uk-flex-middle"
                            onclick="WT_landSellerSave(<?=$land_id?>)">+</button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <?php
    exit();
}
if($os->get('WT_landSellerSave')=='OK')

{
    $land_id = $os->post('land_id');
    $land_seller_donor_id = $os->post('land_seller_donor_id');
    $name = $os->post('name');
    $vill = $os->post('vill');
    $po = $os->post('po');
    $ps = $os->post('ps');
    $dist = $os->post('dist');
    $state = $os->post('state');

    $dataToSave=[];
    $dataToSave['land_id'] = $land_id;
    $dataToSave['name'] = $name;
    $dataToSave['vill'] = $vill;
    $dataToSave['po'] = $po;
    $dataToSave['ps'] = $ps;
    $dataToSave['dist'] = $dist;
    $dataToSave['state'] = $state;

    $save_query = $os->save('land_seller_donor', $dataToSave, 'land_seller_donor_id',$land_seller_donor_id);



    print $land_seller_donor_id>0?'Successfully updated':$land_id;

    ?>

    <?php
    exit();

}
if($os->get('WT_landSellerDelete')=='OK')

{
    $land_id = $os->post('land_id');
    $land_seller_donor_id = $os->post('land_seller_donor_id');


    $os->deleteRow('land_seller_donor','land_seller_donor_id', $land_seller_donor_id);


    print $land_id;

    ?>

    <?php
    exit();

}

//land file
if($os->get('WT_landFileListing')=='OK')
{
    $land_id = $os->post('land_id');
    if($land_id==0){
        echo 'please save details first';
        exit();
    }
    $land_files = $os->mq("SELECT * FROM land_file WHERE land_id='$land_id'");
    ?>
    <div>
        <table class="uk-table congested-table uk-table-striped">
            <thead>
            <tr>
                <th>File</th>
                <th class="uk-hidden">Title</th>
                <th>Name</th>
                <th>Ref No</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <? while($file = $os->mfa($land_files)){?>
                <tr>
                    <td>
                        <a target="_blank"
                           href="<?= $site['url']."wtos-images/land-files/".$file['file'] ?>"><?=$file['file']?></a>
                    </td>
                    <td class="uk-hidden">
                        <input class="uk-input uk-border-rounded congested-form"
                               value="<?=$file['title']?>"
                               id="file_title_<?=$file['land_file_id']?>"
                               onchange="wtosInlineEdit(`file_title_<?=$file['land_file_id']?>`,
                                       'land_file','title','land_file_id',<?=$file['land_file_id']?>,'','','')">
                    </td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form"
                               value="<?=$file['name']?>"
                               id="file_name_<?=$file['land_file_id']?>"
                               onchange="wtosInlineEdit(`file_name_<?=$file['land_file_id']?>`,
                                       'land_file','name','land_file_id',<?=$file['land_file_id']?>,'','','')">
                    </td>
                    <td>
                        <input class="uk-input uk-border-rounded congested-form"
                               value="<?=$file['ref_no']?>"
                               id="file_ref_no_<?=$file['land_file_id']?>"
                               onchange="wtosInlineEdit(`file_ref_no_<?=$file['land_file_id']?>`,
                                       'land_file','ref_no','land_file_id',<?=$file['land_file_id']?>,'','','')">
                    </td>
                    <td>
                        <button class="uk-button uk-border-rounded  congested-form
                                            uk-button-danger uk-flex-inline uk-flex-middle"
                                onclick="WT_landFileDelete(<?=$land_id?>,<?=$file['land_file_id']?>, '<?=$file['file']?>')
                                        ">x</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
            <tfoot>
            <tr>
                <td><input type="file" class="uk-input uk-border-rounded congested-form" id="file_file"></td>
                <td class="uk-hidden"><input class="uk-input uk-border-rounded congested-form" id="file_title"></td>
                <td><input class="uk-input uk-border-rounded congested-form" id="file_name"></td>
                <td><input class="uk-input uk-border-rounded congested-form" id="file_ref_no"></td>
                <td>
                    <button class="uk-button uk-border-rounded  congested-form
                                            uk-secondary-button uk-flex-inline uk-flex-middle"
                            onclick="WT_landFileSave(<?=$land_id?>)">+</button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <?php
    exit();

}
if($os->get('WT_landFileSave')=='OK')
{
    $land_id = $os->post('land_id');
    $title = $os->post('title');
    $name = $os->post('name');
    $ref_no = $os->post('ref_no');
    $file=$os->UploadPhoto('file',$site['root'].'wtos-images'.'/land-files');


    $dataToSave=[];
    $dataToSave['land_id'] = $land_id;
    $dataToSave['name'] = $name;
    $dataToSave['title'] = $title;
    $dataToSave['ref_no'] = $ref_no;
    $dataToSave['file'] = $file;


    $save_query = $os->save('land_file', $dataToSave, 'land_file_id',0);



    print $land_id;

    ?>

    <?php
    exit();

}
if($os->get('WT_landFileDelete')=='OK')
{
    $land_id = $os->post('land_id');
    $land_file_id = $os->post('land_file_id');
    $file = $site['root'].'wtos-images/land-files/'.$os->post('file');

    if (file_exists($file)){
        unlink($file);
    }

    $os->deleteRow('land_file','land_file_id', $land_file_id);

    print $land_id;

    ?>

    <?php
    exit();

}



