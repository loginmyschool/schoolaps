<?php
include('wtosConfigLocal.php');
include($site['root-wtos'].'wtosCommon.php');

$os->userDetails =$os->session($os->loginKey,'logedUser');


if($os->get('WT_budget_list_Listing')=='OK'){

    $userId=$os->userDetails['adminId'];
    $anduser_id="and user_id='$userId'";
    $listingQuery="  select * from budget_list where budget_list_id>0 $anduser_id order by budget_list_id desc";
    $resource=$os->pagingQuery($listingQuery,10000,false,true);
    $rsRecords=$resource['resource'];
    ?>

        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b></div>
        <table class="uk-table uk-table-small uk-table-striped background-color-white" >
            <thead>
            <tr >
                <th>Date</th>
                <th>Refference No</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php
            $serial=$os->val($resource,'serial');
            while($record=$os->mfa( $rsRecords)){
                $serial++;?>
                <tr>
                    <td><?php echo $os->showDate($record['dated']);?></td>
                    <td><?php echo $record['reference_no']?> </td>

                    <td><?php echo $os->val($record,'tit')+$os->val($record,'tet')?> </td>
                    <td> <? if(isset($os->approvedStatus[$record['approved_status']])){ echo  $os->approvedStatus[$record['approved_status']]; } ?></td>
                    <td class="uk-table-shrink">
                        <? if($os->access('wtView')){ ?>
                            <a href="javascript:void(0)"
                               class="uk-button uk-border-rounded congested-form uk-theme-button"
                               onclick="WT_budget_list_detailsListing('<? echo $record['budget_list_id'];?>')" >View</a>
                        <? } ?>
                    </td>
                </tr>
            <?}?>
        </table>
    <?exit();}
if($os->get('WT_budget_listGetById')=='OK'){
    $budget_list_id=$os->post('budget_list_id');
    if($budget_list_id>0)
    {
        $wheres=" where budget_list_id='$budget_list_id'";
    }
    $dataQuery=" select * from budget_list  $wheres ";
    $rsResults=$os->mq($dataQuery);
    $record=$os->mfa( $rsResults);
    $record['dated']=$os->showDate($record['dated']);
    echo  json_encode($record);
    exit();
}
if($os->get('WT_budget_list_detailsListing')=='OK'){
    $budget_list_id=$os->post('budget_list_id');
    $userId=$os->userDetails['adminId'];
    $anduser_id="and user_id='$userId'";

    $andbudget_list_id=  $os->postAndQuery('budget_list_id','budget_list_id','=');
    $listingQuery="  select * from budget_list_details where budget_list_details_id>0 $andbudget_list_id $anduser_id  order by budget_list_details_id desc";
    $resource=$os->pagingQuery($listingQuery,$os->showPerPage,false,true);
    $rsRecords=$resource['resource'];


    $refNoQ="select * from budget_list where budget_list_id='$budget_list_id'";
    $refNoMq=$os->mq($refNoQ);
    $refNoData=$os->mfa($refNoMq);
    ?>

        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b>  &nbsp;&nbsp; <? echo $resource['links']; ?>  &nbsp;&nbsp;Refference No: <b> <?echo $refNoData['reference_no']?></b></div>

    <table class="uk-table congested-table uk-table-justify uk-table-striped background-color-white" >
        <thead>
        <tr >
            <th >#</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th class="uk-hidden">Tax Percent</th>
            <th class="uk-hidden">Rate Excl Tax</th>
            <th>Rate Incl Tax</th>
            <th class="uk-hidden">Total Excl Tax</th>
            <th>Total Incl Tax</th>
            <th class="uk-hidden">Tax Amount</th>
            <td>Action </td>
            </tr>
        </thead>
            <?php
            $serial=$os->val($resource,'serial');
            $total_quantity=0;
            $total_rate_excl_tax = 0;
            $total_rate_incl_tax = 0;
            $total_excl_tax=0;
            $total_incl_tax=0;
            $total_tax_amount=0;
            while($record=$os->mfa( $rsRecords)){
                $serial++;
                $total_quantity=$total_quantity+$record['quantity'];
                $total_rate_excl_tax=$total_rate_excl_tax+$record['rate_excl_tax'];
                $total_rate_incl_tax=$total_rate_incl_tax+$record['rate_incl_tax'];
                $total_excl_tax=$total_excl_tax+$record['total_excl_tax'];
                $total_incl_tax=$total_incl_tax+$record['total_incl_tax'];
                $total_tax_amount=$total_tax_amount+$record['tax_amount'];
                ?>
                <tr class="trListing">
                    <td><?php echo $serial; ?></td>
                    <td><?php echo $record['description']?> </td>
                    <td><?php echo $record['quantity']?> </td>
                    <td> <? if(isset($os->unit[$record['unit']])){ echo  $os->unit[$record['unit']]; } ?></td>
                    <td class="uk-hidden"><?php echo $record['tax_percent']?> </td>
                    <td class="uk-hidden"><?php echo $record['rate_excl_tax']?> </td>
                    <td><?php echo $record['rate_incl_tax']?> </td>
                    <td class="uk-hidden"><?php echo $record['total_excl_tax']?> </td>
                    <td><?php echo $record['total_incl_tax']?> </td>
                    <td class="uk-hidden"><?php echo $record['tax_amount']?> </td>
                    <td>
                        <? if($os->access('wtView')){ ?>
                            <a
                                    class="uk-button congested-form uk-border-rounded uk-theme-button"
                                    href="javascript:void(0)"  onclick="WT_budget_details_listDeleteRowById('<? echo $record['budget_list_details_id'];?>')" >Delete</a>
                        <? } ?>
                    </td>
                </tr>

            <?}?>
            <tr>
                <td colspan="2">Total :</td>
                <td colspan="2" class="uk-text-success"><? echo $total_quantity?></td>
                <td  class="uk-hidden"><? echo $total_rate_excl_tax?></td>
                <td class="uk-text-success"><? echo $total_rate_incl_tax?></td>
                <td  class="uk-hidden"><? echo $total_excl_tax?></td>
                <td colspan="2" class="uk-text-success"><? echo $total_incl_tax?></td>
                <td  class="uk-hidden"><? echo $total_tax_amount?></td>
            </tr>
        </table>
    <button class="uk-button uk-button-small uk-border-rounded uk-secondary-button" onclick="WT_budget_listGetById(<?=$budget_list_id?>)">Add New</button>
    <?exit();}
if($os->get('WT_budget_listEditAndSave')=='OK'){
    //Expense List//
    $budget_list_id=$os->post('budget_list_id');
    if($budget_list_id==0){
        $dataToSave['reference_no']=addslashes($os->post('reference_no'));
        $dataToSave['parent_head_id']=addslashes($os->post('parent_head_id'));
        $dataToSave['account_head_id']=addslashes($os->post('account_head_id'));
        $dataToSave['dated']=$os->saveDate($os->post('dated'));
        $dataToSave['user_id']=$os->userDetails['adminId'];
        $budget_list_id=$qResult=$os->save('budget_list',$dataToSave);
        if($os->post('reference_no')==''){
            $dataToSave3['reference_no']=$qResult;
            $os->save('budget_list',$dataToSave3,'budget_list_id',$qResult);
        }
        //Expense List//
    }
    //Expense Details//

    $dataToSave2['budget_list_id']=addslashes($budget_list_id);
    $dataToSave2['parent_head_id']=addslashes($os->post('parent_head_id'));
    $dataToSave2['account_head_id']=addslashes($os->post('account_head_id'));
    $dataToSave2['description']=addslashes($os->post('description'));
    $dataToSave2['quantity']=addslashes($os->post('quantity'));
    $dataToSave2['unit']=addslashes($os->post('unit'));
    $dataToSave2['tax_percent']=addslashes($os->post('tax_percent'));

    $dataToSave2['rate_excl_tax']=addslashes($os->post('rate_excl_tax'));
    $dataToSave2['rate_incl_tax']=addslashes($os->post('rate_incl_tax'));
    $dataToSave2['total_excl_tax']=addslashes($os->post('total_excl_tax'));
    $dataToSave2['total_incl_tax']=addslashes($os->post('total_incl_tax'));
    $dataToSave2['tax_amount']=addslashes($os->post('tax_amount'));
    $dataToSave2['type']=addslashes($os->post('type'));
    $dataToSave2['user_id']=$os->userDetails['adminId'];
    $qResult2= $os->save('budget_list_details',$dataToSave2);
    //Expense Details//
    if($qResult2){
        $mgs= " Data Added Successfully";
        $mgs=$budget_list_id."#-#".$mgs;
    }
    else{
        $mgs="Error#-#Problem Saving Data.";
    }
    echo $mgs;
    exit();
}


if($os->get('WT_budget_list_details_DeleteRowById')=='OK'){
    $budget_list_details_id=$os->post('budget_list_details_id');
    if($budget_list_details_id>0){
        $parentIdQuery="select * from budget_list_details where budget_list_details_id='$budget_list_details_id'";
        $parentIdMq=$os->mq($parentIdQuery);
        $row=$os->mfa($parentIdMq);
        $parentId=$row['budget_list_id'];
        $updateQuery="delete from budget_list_details where budget_list_details_id='$budget_list_details_id'";
        $os->mq($updateQuery);
        echo 'Record Deleted Successfully'.'#-#'.$parentId;
    }
    exit();
}


if($os->get('WT_others_payment_listing')=='OK'&&$os->post('WT_others_payment_listing_val')=='OKS'){

    $userId=$os->userDetails['adminId'];
    $anduser_id="and user_id='$userId'";
    $listingQuery="  select * from otherpayment where otherpaymentId>0 $anduser_id and payment_type='Budget' order by otherpaymentId desc";
    $resource=$os->pagingQuery($listingQuery,10000,false,true);
    $rsRecords=$resource['resource'];
    ?>

        <div class="pagingLinkCss">Total:<b><? echo $os->val($resource,'totalRec'); ?></b></div>
    <table class="uk-table uk-table-small uk-table-striped background-color-white" >
        <thead>
        <tr >
                <th>Paid To</th>
                <th>Paid Date</th>
                <th>Paid Amt</th>
                <th>Payment Note</th>
                <th>Payment Mode</th>
            </tr>
        </thead>
            <?php
            $serial=$os->val($resource,'serial');
            $paid_amt=0;
            while($record=$os->mfa( $rsRecords)){
                $serial++;
                $paid_amt=$paid_amt+$record['paid_amt'];
                ?>
                <tr>
                    <td><?php echo $record['paid_to']?> </td>
                    <td><?php echo $os->showDate($record['paid_date']);?></td>
                    <td><?php echo $record['paid_amt']?> </td>

                    <td><?php echo $record['payment_note']?> </td>
                    <td><?php echo $record['payment_mode']?> </td>
                </tr>
            <?}?>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="5"><?echo $paid_amt;?></td>
            </tr>
        </table>

    <?exit();}


?>

